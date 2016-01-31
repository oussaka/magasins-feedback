<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Indicateur extends EntityRepository
{

    /**
     * Counts how many users there are in the database
     *
     * @return int
     */
    public function count()
    {
        /* $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array('u.id'))
              ->from('Indicateur\Entity\Indicateur', 'u')
              ->leftJoin('u.chapitre', 'c', 'WITH');

        $result = $query->getQuery()->getResult();

        return count($result); */
    }

    /**
     * Returns a list of users
     *
     * @param int $offset           Offset
     * @param int $itemCountPerPage Max results
     * @param string|null $filter   Filter string
     *
     * @return Paginator
     */
    public function getPaginator($offset = 0, $itemCountPerPage = 10, $filter = null)
    {
        /** @var  $entityManager \Doctrine\ORM\EntityManager */
        $query = $this->getEntityManager()->createQueryBuilder()
            //$query->select(array('u.id', 'u.name', 'u.email'))
            ->select("u")
            ->from('Indicateur\Entity\Indicateur', 'u')
            ->leftJoin('u.chapitre', 'c', 'WITH')
            ->setFirstResult($offset)
            ->setMaxResults($itemCountPerPage);

        if(!is_null($filter)) {

            $query->where($query->expr()->orX(
                $query->expr()->like('c.titre', '?1'),
                $query->expr()->like('u.titre', '?1')
            ))->setParameter(1, '%'.$filter.'%');

        }
        // $result = $query->getQuery()->getResult(Query::HYDRATE_OBJECT);
        $paginator = new Paginator($query);

        return $paginator;
    }

    /**
     * Retourne la liste des indicateurs seuelemtn attribués
     *
     * @param int $offset Offset
     * @param int $itemCountPerPage Max results
     * @param int $userId
     *
     * @return Paginator
     */
    public function getPaginatorIndicAttrib($offset = 0, $itemCountPerPage = 10, $userId)
    {
        /** @var  $entityManager \Doctrine\ORM\EntityManager */
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select("iu")
            ->from('Indicateur\Entity\IndicateurUsers', 'iu')
            ->leftJoin('iu.indicateur', 'i', 'WITH')
            ->leftJoin('i.chapitre', 'c', 'WITH')
            ->setFirstResult($offset)
            ->setMaxResults($itemCountPerPage)
            ->where("iu.actif = 1")
            ->andwhere("iu.user = ?1")
            ->setParameter(1, $userId);

        // $result = $query->getQuery()->getResult(Query::HYDRATE_OBJECT);
        $paginator = new Paginator($query);

        return $paginator;
    }

    /**
     * retrieve list of indicateur by userId
     *
     * @param int $userId
     * @return array
     */
    public function findByUser($userId)
    {

        $em = $this->getEntityManager();
        // $query = $em->createQuery("SELECT ind.id, ind.titre, ind.chapitre_id, chap.titre, ind.type, induser.* FROM Indicateur\Entity\Indicateur ind JOIN ind.Indicateur\Entity\IndicateurUsers induser JOIN ind.Indicateur\Entity\Chapitre chap WHERE userid = ?1 LIMIT 4");
        // $query->setParameter(1, $userId);
        // $users = $query->getResult();
        // return $users;

        $dql = $this->getEntityManager()->createQueryBuilder();
        $dql->select(array('ind', 'chap', 'induser'))
            // $dql->select(array('ind.id', 'ind.titre', 'chap.id'))
            ->from('Indicateur\Entity\Indicateur', 'ind')
            ->leftJoin('ind.chapitre', 'chap')
            ->leftJoin('Indicateur\Entity\IndicateurUsers', 'induser',Query\Expr\Join::WITH, "ind.id = induser.indicateur")
            // ->leftJoin('ind.chapitre', 'chap', Query\Expr\Join::ON, "ind.chapitre_id = chap.id");
        // ->innerJoin('c.phones', 'p', 'WITH', 'p.phone = :phone')
            ->orderBy(new Query\Expr\OrderBy('chap.id', 'ASC'))
            // ->where("induser.user = ?1")
            // ->setParameter(1, $userId)
            ->setMaxResults(4);

        $result = $dql->getQuery()->getResult(Query::HYDRATE_ARRAY); //getArrayResult(Query::HYDRATE_ARRAY);
        return $result;


    }
    
    
    public function findByChapitreIdAndTitreLike($chapitreId, $indicateurLike)
    {
    	$em = $this->getEntityManager();
    	$chapitreId = (int)$chapitreId;
    	$indicateurLike = trim($indicateurLike);
    	
    	$where = 'ind.id > 0';
    	if($chapitreId > 0) {
    		$where .= ' AND ind.chapitre = ?1';
    	}
    	if($indicateurLike != '') {
    		$where .= ' AND ind.titre LIKE ?2';
    	}
    	
    	$dql = $this->getEntityManager()->createQuery("
    			SELECT ind
    			FROM \Indicateur\Entity\Indicateur ind
    			WHERE $where
    			ORDER BY ind.titre ASC	
    	");
    	

    	if($chapitreId) {
    		$dql->setParameter('1', $chapitreId, 'integer');
    	}
    	if($indicateurLike != '') {
    		$dql->setParameter('2', '%' . $indicateurLike . '%', 'string');
    	}
    	
    	
    	$result = $dql->getResult(Query::HYDRATE_OBJECT);
    	return $result;
    }


    /**
     * Renvoi un tableau de la forme id => titre pour une liste d'indicateurs
     * @param array $tabUsersId
     * @return array:
     */
    public function listIndicateurUsingIdList($tabId)
    {
    	$em = $this->getEntityManager();
    	$dbCnx = $em->getConnection();
    
    	$sql = "SELECT id, titre FROM indicateur WHERE id IN (" . implode(',', $tabId) . ")";
    
    	$stmt = $dbCnx->prepare($sql);
    	$stmt->execute();
    	$resultat = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    
    	return $resultat;
    
    }
}