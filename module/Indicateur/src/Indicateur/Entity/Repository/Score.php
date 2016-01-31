<?php

namespace Indicateur\Entity\Repository;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class Score
 *
 * @package Indicateur\Entity\Repository
 */
class Score extends EntityRepository
{

    /**
     *
     * @param $indicId
     * @param $userId
     * @param $puiId
     * @return mixed
     * @throws \Exception
     */
    public function findByIndicUserPui($indicId, $userId, $puiId)
    {
        if( empty($indicId) ||
            empty($puiId) ||
            empty($userId)) {
            throw new \Exception("params must be not empty", 501);
        }

        $qb = $this->_em->createQueryBuilder();
        $qb->select(array(
            'score'
        ))
            ->from('Indicateur\Entity\Score', 'score')
            ->where("score.user = ?1")
            ->andWhere("score.pui = ?2")
            ->andWhere("score.indicateur = ?3")
            ->orderBy(new Query\Expr\OrderBy('score.annee', 'DESC'))
            ->setParameters(array(1 => $userId,
                                  2 => $puiId,
                                  3 => $indicId,
            ));

        $result = $qb->getQuery()->getResult(Query::HYDRATE_OBJECT);

        return $result;

    }

    /**
     * insert the new score or update it, if it already exists
     *
     * @param $indId
     * @param $userId integer
     * @param $puiId integer
     * @param $data array
     * @internal param int $indicId
     */
    public function saveScore($indId, $userId, $puiId, array $data)
    {

        /** @var $score \Indicateur\Entity\Score */
        $score = new \Indicateur\Entity\Score;

        $hydrator = new DoctrineHydrator($this->_em);
        $score = $hydrator->hydrate(array("indicateur"  => (int) $indId,
                                          "user" => $userId,
                                          "pui"  => $puiId), $score);

        if(array_key_exists("annee", $data)) { // Annual indicateur kind

            try {
                for ($i = 0; $i < count($data["annee"]); $i++) {

                    if (!empty($data["id"][$i])) {

                        $score = $this->_em->find('\Indicateur\Entity\Score', $data['id'][$i]);
                        $score->setValeur($data['valeur'][$i]);
                    } else {

                        /** @var $score \Indicateur\Entity\Score */
                        $score = new \Indicateur\Entity\Score;

                        $hydrator = new DoctrineHydrator($this->_em);
                        $score = $hydrator->hydrate(array("indicateur" => (int)$indId,
                                                          "user"       => $userId,
                                                          "pui"        => $puiId), $score);
                        $score->setAnnee($data["annee"][$i]);
                        $score->setValeur($data["valeur"][$i]);
                        // insert new score
                        $this->_em->persist($score);
                    }
                }
            } catch (Exception $e) {}
            $this->_em->flush();
            $this->_em->clear();
        } elseif(array_key_exists("annee", $data[0])
            && array_key_exists("mois", $data[0])) { // Monthly indicateur kind

            foreach ($data as $currScore) {
                try {
                    if (!empty($currScore["id"])) {

                        $score = $this->_em->find('\Indicateur\Entity\Score', $currScore['id']);
                        $score->setValeur($currScore['valeur']);
                    } else {
                        /** @var $score \Indicateur\Entity\Score */
                        $score = new \Indicateur\Entity\Score;

                        $hydrator = new DoctrineHydrator($this->_em);
                        $score = $hydrator->hydrate(array("indicateur"  => (int) $indId,
                                                          "user" => $userId,
                                                          "pui"  => $puiId), $score);
                        $score->setAnnee($currScore["annee"]);
                        $score->setMois($currScore["mois"]);
                        $score->setValeur($currScore["valeur"]);
                        // insert new score
                        $this->_em->persist($score);
                    }

                } catch(\Exception $e) {}
            }
            $this->_em->flush();
            $this->_em->clear();
        } elseif(array_key_exists("date", $data[0])
            && array_key_exists("theme", $data[0])) { // File de Eau indicateur kind

            foreach ($data as $currScore) {
                try {
                    if (!empty($currScore["id"])) {

                        $score = $this->_em->find('\Indicateur\Entity\Score', $currScore['id']);

                        if(preg_match("/\\d{1,2}\\/\\d{1,2}\\/\\d{4}/", $currScore["date"])) {
                            $date = \DateTime::createFromFormat("d/m/Y", $currScore["date"]);
                        } else {
                            $date = new \DateTime($currScore["date"]);
                        }
                        // if( \DateTime::getLastErrors()['warning_count'] == 0){
                        // if ($date->getLastErrors()['warning_count'] == 0) { Only in PHP 5.4
                        $tmp = $date->getLastErrors();
                        if ($tmp['warning_count'] == 0) {
                            // correct date
                            $score->setDate($date);
                            $score->setAnnee($date->format("Y"));
                            $score->setMois($date->format("m"));
                        }

                        // $date = new \DateTime(strtotime($currScore["date"]));
                        /*echo $date->format("Y");
                        echo $date->format("m");
                        echo $date->format("d");*/
                        /*$score->setDate($date);
                        $score->setAnnee($date->format("Y"));
                        $score->setMois($date->format("m"));*/

                        $score->setValeur($currScore['valeur']);
                        $score->setTheme($currScore["theme"]);
                    } else {
                        /** @var $score \Indicateur\Entity\Score */
                        $score = new \Indicateur\Entity\Score;

                        $hydrator = new DoctrineHydrator($this->_em);
                        $score = $hydrator->hydrate(array("indicateur"  => (int) $indId,
                                                          "user" => $userId,
                                                          "pui"  => $puiId), $score);
                        $score->setValeur($currScore["valeur"]);
                        $score->setTheme($currScore["theme"]);

                        $date = new \DateTime($currScore["date"]["date"]);
                        $score->setDate($date);
                        $score->setAnnee($date->format("Y"));
                        $score->setMois($date->format("m"));
                        // insert new score
                        $this->_em->persist($score);
                    }

                } catch(\Exception $e) {echo $e->getMessage();}
            }
            $this->_em->flush();
            $this->_em->clear();
        }

    }

    private function insertIfnotExists(\Indicateur\Entity\Score $score)
    {

        $qb = $this->_em->createQueryBuilder();
        $qb->select("s")
            ->from('Indicateur\Entity\Score', 's')
            ->where("s.user = ?1")
            ->andWhere("s.pui = ?2")
            ->andWhere("s.indicateur = ?3")
            ->setParameters(array(1 => $score->getUser(),
                                  2 => $score->getPui(),
                                  3 => $score->getIndicateur()));

        $annee = $score->getAnnee();
        if(!empty($annee)) {
            $qb->andWhere("s.annee = " . $annee);
        }

        $scoreFound = $qb->getQuery()->getOneOrNullResult();

        if( $scoreFound !== null && is_numeric($scoreFound->getId())) {
            // update score
            $qb = $this->_em->createQueryBuilder();
            $q = $qb->update('Indicateur\Entity\Score', 's')
                ->set('s.valeur', '?1')
                ->where('s.id = ?2')
                ->setParameter(1, $score->getValeur())
                ->setParameter(2, $scoreFound->getId())
                ->getQuery();
            $p = $q->execute();
        } else {
            // insert new score
            $this->_em->persist($score);
        }

    }

    public function getStatsParIndicateur($annee, $mois = null, $userId = null, $puiId = null, $etabsId = null, $chapitreId = null, $indicateurId = null, $indicateurLike = null, $tabIndicateurs = null)
    {
    	$em = $this->getEntityManager();
    	$dbCnx = $em->getConnection();
    	
    	$whereMois = ($mois > 0) ? "score.mois = " . $dbCnx->quote($mois, 'integer') : "1";
    	$whereIndicateur = ($indicateurId > 0) ? "score.ind_code_fk = " . $dbCnx->quote($indicateurId, 'integer') : "1";
    	$whereIndicateurLike = (trim($indicateurLike) != '') ? "ind.titre LIKE " . $dbCnx->quote('%' . $indicateurLike . '%', 'string') : "1";
    	$whereChapitre = ($chapitreId > 0) ? "ind.chapitre_id = " . $dbCnx->quote($chapitreId, 'integer') : "1";
    	$whereUser = ($userId > 0) ? "score.user_code_fk = " . $dbCnx->quote($userId, 'integer') : "1";
    	$wherePui = ($puiId > 0) ? "score.pui_code_fk = " . $dbCnx->quote($puiId, 'integer') : "1";
    	$whereEtabs = ($etabsId > 0) ? "pui.et_code_fk = " . $dbCnx->quote($etabsId, 'integer') : "1";
    	if(is_array($tabIndicateurs) && count($tabIndicateurs) > 0) {
    		$whereIndicateur = "score.ind_code_fk IN (" . implode(',', $tabIndicateurs) . ")";
    	} else {
    		$whereIndicateur = "1";
    	}
    	
    	$where = "
    		score.annee = " . $dbCnx->quote($annee, 'integer') . " AND
    		$whereMois AND
    		$whereIndicateur AND
    		$whereIndicateurLike AND
    		$whereChapitre AND
    		$whereUser AND
    		$wherePui AND
    		$whereEtabs AND
    	    $whereIndicateur
    	";
    	 
    	$sql = "
    			SELECT 
    				ind.id AS id_indicateur, SUM(score.valeur) AS cumul
    			FROM score
    			JOIN pui ON pui_code_pk = score.pui_code_fk
    			JOIN indicateur ind ON ind.id = score.ind_code_fk
    			JOIN chapitre chap ON chap.id = ind.chapitre_id
    			WHERE 
					$where
				GROUP BY score.ind_code_fk
				ORDER BY ind.chapitre_id, ind.titre
    	";
    	 
    	$stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    	$stmt->execute();
    	$resultat = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    
    	return $resultat;
    }

	public function getStatsParAn($etabsId, $puiId, $userId, $nbAnnee = 3, $chapitreId = null, $indicateurLike = null, $tabIndicateurs = null)
	{
		$em = $this->getEntityManager();
		$dbCnx = $em->getConnection();
		$anneeCourante = date('Y');
		
		$whereIndicateurLike = (trim($indicateurLike) != '') ? "ind.titre LIKE " . $dbCnx->quote('%' . $indicateurLike . '%', 'string') : "1";
    	$whereChapitre = ($chapitreId > 0) ? "ind.chapitre_id = " . $dbCnx->quote($chapitreId, 'integer') : "1";
    	$wherePui = ($puiId > 0) ? "score.pui_code_fk = " . $dbCnx->quote($puiId, 'integer') : "1";
    	$whereEtabs = ($etabsId > 0) ? "pui.et_code_fk = " . $dbCnx->quote($etabsId, 'integer') : "1";
    	$whereUsers = ($userId > 0) ? "score.user_code_fk = " . $dbCnx->quote($userId, 'integer') : "1";
    	if(is_array($tabIndicateurs) && count($tabIndicateurs) > 0) {
    		$whereIndicateur = "score.ind_code_fk IN (" . implode(',', $tabIndicateurs) . ")";
    	} else {
    		$whereIndicateur = "1";
    	}
    	
    	$where = "
    			score.annee <= " . $dbCnx->quote($anneeCourante, 'integer') . " AND
    			score.annee > " . $dbCnx->quote($anneeCourante - $nbAnnee, 'integer') . " AND
    	    	$whereIndicateurLike AND
	    		$whereChapitre AND
	    		$whereEtabs AND
    	    	$wherePui AND
	    		$whereUsers AND
    	    	$whereIndicateur
    	";
		
		$sql = "
				SELECT 
					score.annee, SUM(score.valeur) AS cumul
				FROM score
				JOIN pui ON pui_code_pk = score.pui_code_fk
				JOIN indicateur ind ON ind.id = score.ind_code_fk
				WHERE
					$where
				GROUP BY score.annee
				ORDER BY annee ASC
		";
		
		$stmt = $this->getEntityManager()->getConnection()->prepare($sql);
		$stmt->execute();
		$resultat = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
		
		return $resultat;
	}

	public function getSaisieCommercants($annee, $etabsId, $puiId = null, $chapitreId = null, $indicateurLike = null)
	{
		$em = $this->getEntityManager();
		$dbCnx = $em->getConnection();
		$resultat = array();
		
		// Filtrage et validation entrées
		$etabsId = (int)$etabsId;
		if($etabsId <= 0) {
			throw new Exception("getSaisieCommercant() : le paramètre etabsId est obligatoire");
		}
		$puiId = (int)$puiId;
		$annee = (int)$annee;
		if($annee <= 0) {
			throw new Exception("getSaisieCommercant() : le paramètre annee est obligatoire");
		}
		$chapitreId = (int)$chapitreId;
		
		// Filtrage par PUI, pour toutes les requêtes suivantes
		$wherePui = ($puiId > 0) ? "pui.pui_code_pk = " . $dbCnx->quote($puiId, 'integer') : "1";

		// Liste des indicateurs
		$sqlIndicateurs = "SELECT id AS id_indicateur FROM indicateur WHERE 1";
		if($chapitreId > 0) {
			$sqlIndicateurs .= " AND chapitre_id = " . $dbCnx->quote($chapitreId, 'integer');
		}
		if($indicateurLike) {
			$sqlIndicateurs .= " AND titre LIKE " . $dbCnx->quote('%' . $indicateurLike . '%', 'string');
		}
		$stmt = $dbCnx->prepare($sqlIndicateurs);
		$stmt->execute();
		$tabIndicateurs = $stmt->fetchAll(\PDO::FETCH_COLUMN);
		
		// Liste (utilisateurs attribué + utilisateurs ayant fait une saisie) pour au moins un indicateur
		$sqlUsers = "
				SELECT DISTINCT user_id AS id_user
				FROM historique_indicateur_users hist
				JOIN pui ON pui.pui_code_pk = hist.pui_id
				WHERE 
						hist.annee = " . $dbCnx->quote($annee, 'integer') . " AND
						pui.et_code_fk = " . $dbCnx->quote($etabsId, 'integer') . " AND
						$wherePui
								
				UNION
				
				SELECT DISTINCT user_code_fk AS id_user
				FROM score 
				JOIN pui ON pui.pui_code_pk = score.pui_code_fk
				WHERE
						score.annee = " . $dbCnx->quote($annee, 'integer') . " AND
						pui.et_code_fk = " . $dbCnx->quote($etabsId, 'integer') . " AND
						$wherePui
		";
		$stmt = $dbCnx->prepare($sqlUsers);
		$stmt->execute();
		$tabUsers = $stmt->fetchAll(\PDO::FETCH_COLUMN);
		
		// Attributions et scores
		$resultat = array();			
		if($tabIndicateurs && $tabUsers) {
			$sqlScores = "
					SELECT DISTINCT score.ind_code_fk AS id_indicateur, score.user_code_fk AS id_user, SUM(valeur) AS cumul
					FROM score
					JOIN pui ON pui.pui_code_pk = score.pui_code_fk
					WHERE
							1 AND
							pui.et_code_fk = " . $dbCnx->quote($etabsId, 'integer') . " AND
							score.annee = " . $dbCnx->quote($annee, 'integer') . " AND
							score.ind_code_fk IN (" . implode(',', $tabIndicateurs) . ") AND
							score.user_code_fk IN (" . implode(',', $tabUsers) . ") AND
							$wherePui
					GROUP BY score.ind_code_fk,  score.user_code_fk
			";
			$stmt = $dbCnx->prepare($sqlScores);
			$stmt->execute();
			$tabScores = $stmt->fetchAll(\PDO::FETCH_OBJ);
			
			$sqlIndicateursAttribues = "
					SELECT DISTINCT hist.indicateur_id AS id_indicateur, hist.user_id As id_user
					FROM historique_indicateur_users hist
					JOIN pui ON pui.pui_code_pk = hist.pui_id
					WHERE
							1 AND
							pui.et_code_fk = " . $dbCnx->quote($etabsId, 'integer') . " AND
							hist.annee = " . $dbCnx->quote($annee, 'integer') . " AND
							hist.indicateur_id IN (" . implode(',', $tabIndicateurs) . ") AND
							hist.user_id IN (" . implode(',', $tabUsers) . ") AND
							$wherePui
					GROUP BY hist.indicateur_id,  hist.user_id
			";
			$stmt = $dbCnx->prepare($sqlIndicateursAttribues);
			$stmt->execute();
			$tabIndicateursAttribues = $stmt->fetchAll(\PDO::FETCH_OBJ);

			// Reorganisation des données
			foreach ($tabIndicateurs as $id_indicateur) {
				foreach ($tabUsers AS $id_user) {
					$resultat[$id_indicateur][$id_user] = 'NA';
				}
			}
			foreach($tabIndicateursAttribues as $row) {
				$resultat[$row->id_indicateur][$row->id_user] = '';
			}
			foreach ($tabScores as $row) {
				$resultat[$row->id_indicateur][$row->id_user] = $row->cumul;
			}
		}
		
		return $resultat;
	}
	
	public function getValeursByIndicateurUsingEtabsCategorie($tabIndicateurs, $categorieId = null, $separator = '|')
	{
		$em = $this->getEntityManager();
		$dbCnx = $em->getConnection();
		$resultat = array();
		
		$whereIndicateurs = '1';
		if($tabIndicateurs) {
			$tabIndicateursIdQuoted = array();
			foreach ($tabIndicateurs as $indicateur) {
				$tabIndicateursIdQuoted[] = $dbCnx->quote($indicateur->getId(), 'integer');
			}
			$whereIndicateurs = 'score.ind_code_fk IN (' . implode(',', $tabIndicateursIdQuoted) . ')';
		}
		
		$categorieId = (int)$categorieId;
		$whereCategorie = ($categorieId > 0) ? 'etabs.ca_code_fk = ' . $dbCnx->quote($categorieId, 'integer') : '1';
		
		$sql = "
				SELECT 
					score.ind_code_fk AS id_indicateur, 
					GROUP_CONCAT(score.valeur SEPARATOR " . $dbCnx->quote($separator, 'string') . ") AS group_valeurs
				FROM score
				JOIN pui ON pui.pui_code_pk = score.pui_code_fk
				JOIN etabs ON etabs.et_code_pk = pui.et_code_fk
				WHERE
					1 AND
					$whereIndicateurs AND
					$whereCategorie
				GROUP BY score.ind_code_fk
		";
		
		$stmt = $this->getEntityManager()->getConnection()->prepare($sql);
		$stmt->execute();
		$resultat = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
		
		return $resultat;
	}

	public function getValeursAnneeUsingEtabsCategorie($annee, $categorieId = null, $separator = '|', $tabIndicateurs= null)
	{
		$em = $this->getEntityManager();
		$dbCnx = $em->getConnection();
		$resultat = array();
	
		$whereIndicateurs = '1';
		if($tabIndicateurs) {
			$tabIndicateursIdQuoted = array();
			foreach ($tabIndicateurs as $indicateur) {
				$tabIndicateursIdQuoted[] = $dbCnx->quote($indicateur->getId(), 'integer');
			}
			$whereIndicateurs = 'score.ind_code_fk IN (' . implode(',', $tabIndicateursIdQuoted) . ')';
		}
	
		$categorieId = (int)$categorieId;
		$whereCategorie = ($categorieId > 0) ? 'etabs.ca_code_fk = ' . $dbCnx->quote($categorieId, 'integer') : '1';
	
		$sql = "
			SELECT
				GROUP_CONCAT(score.valeur SEPARATOR " . $dbCnx->quote($separator, 'string') . ") AS group_valeurs
				FROM score
				JOIN pui ON pui.pui_code_pk = score.pui_code_fk
				JOIN etabs ON etabs.et_code_pk = pui.et_code_fk
				WHERE
				score.annee = " . $dbCnx->quote($annee, 'integer') . " AND
				$whereIndicateurs AND
				$whereCategorie
				GROUP BY score.annee
			";

			$stmt = $this->getEntityManager()->getConnection()->prepare($sql);
			$stmt->execute();
			$data = $stmt->fetchAll(\PDO::FETCH_NUM);
			
			if($data) {
				return $data[0][0];
			} else {
				return '';
			}
		}
	
	
} 