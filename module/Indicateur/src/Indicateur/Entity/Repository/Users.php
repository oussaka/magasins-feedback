<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;


class Users extends EntityRepository
{
    public function getUserByLoginOrMail($loginormail)
    {
    	$user = $this->findOneBy(array('login' => $loginormail));
    	if(! $user) {
    		$user = $this->findOneBy(array('email' => $loginormail));
    	}
    	
    	if($user && $user->getAcces() != 4) {
    		return $user;
    	} else {
    		return false;
    	}
    }

    
    /**
     * 
     * @param integer $etabId
     * @param integer $puiId
     * @return array
     */
    public function getUsers($etabId = null, $puiId = null, $anneeCreation = null)
    {
    	$em = $this->getEntityManager();
    	
    	$dql = $em->createQueryBuilder();
    	$dql	->select('u')
    			->from('Indicateur\Entity\Users', 'u')
    			->andWhere('u.acces != \'4\'');
    	if($etabId) {
    		$dql->andWhere('u.etabs = ?1')->setParameter(1, $etabId, 'integer');
    	}
    	if($puiId) {
    		$dql->andWhere('u.pui = ?2')->setParameter(2, $puiId, 'integer');
    	}
    	if($anneeCreation) {
    		$dql->andWhere('u.dateCreated LIKE ?3')->setParameter(3, $anneeCreation . '-%', 'string');
    	}

    	$resultat = $dql->getQuery()->getResult(Query::HYDRATE_OBJECT);
    	return $resultat;
    }
    
    /**
     * 
     * @param integer $etabId
     * @param integer $puiId
     * @return array
     */
    public function countUsersBefore($etabId = null, $puiId = null, $anneeCreation)
    {
    	$em = $this->getEntityManager();
    	
    	$dql = $em->createQueryBuilder();
    	$dql	->select('count(u)')
    			->from('Indicateur\Entity\Users', 'u')
    			->andWhere('u.acces != \'4\'');
    	if($etabId) {
    		$dql->andWhere('u.etabs = ?1')->setParameter(1, $etabId, 'integer');
    	}
    	if($puiId) {
    		$dql->andWhere('u.pui = ?2')->setParameter(2, $puiId, 'integer');
    	}
    	if($anneeCreation) {
    		$dql->andWhere('u.dateCreated < ?3')->setParameter(3, $anneeCreation . '-01-01');
    	}

    	$resultat = $dql->getQuery()->getOneOrNullResult();

    	return $resultat[1];
    }
    
    /**
     * Renvoi le nombre d'utilisateurs crées pour chaque année
     * @return array
     */
    public function countCreationParAn()
    {
    	$em = $this->getEntityManager();
    	
    	$sql = "
    			SELECT YEAR(date_created) AS year, count(user_code_pk) as nb
    			FROM users
    			WHERE acces != '4'
    			GROUP BY YEAR(date_created)
    			ORDER BY 1 ASC
    	";
    	
    	$stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    	$stmt->execute();
    	$data = $stmt->fetchAll();
    	
    	$resultat = array();
    	foreach($data as $row) {
    		$resultat[$row["year"]] = $row["nb"];
    	}

    	return $resultat;
    }
    
    /**
     * Renvoi le cumul d'utilisateurs crées pour chaque année
     * @return array
     */
    public function countCreationParAnCumule()
    {
    	$data = $this->countCreationParAn();
    	ksort($data);
    	$minYear = min(array_keys($data));
    	$maxYear = max(array_keys($data));
    	
    	$resultat = array();
    	$cumul = 0;
    	for($year = $minYear; $year <= $maxYear; $year++) {
    		if(isset($data[$year])) {
	    		$cumul += $data[$year];
    		}
    		$resultat[$year] = $cumul;
    	}
    	
    	return $resultat;
    }

	/**
	 * Renvoi un tableau de la forme id => nom+' '+prenom pour une liste d'utilisateurs
	 * @param array $tabUsersId
	 * @return array:
	 */
	public function listUsersUsingIdList($tabUsersId)
	{
		$em = $this->getEntityManager();
		$dbCnx = $em->getConnection();
		
		$sql = "
				SELECT user_code_pk, CONCAT(nom, ' ', prenom) 
				FROM users 
				WHERE 
					user_code_pk IN (" . implode(',', $tabUsersId) . ") AND
					acces != '4'
						
		";
		
		$stmt = $dbCnx->prepare($sql);
		$stmt->execute();
		$resultat = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
		
		return $resultat;
		
	}

	/**
	 * Renvoi les meails de tous les emailsdes superadministrateurs
	 * @return array
	 */
	public function getTabMailAdmin()
	{
		$em = $this->getEntityManager();
		$dbCnx = $em->getConnection();
		
		$sql = "SELECT email FROM users WHERE type = '1' AND acces != '4'";
		
		$stmt = $dbCnx->prepare($sql);
		$stmt->execute();
		$resultat = $stmt->fetchAll(\PDO::FETCH_COLUMN);
		
		return $resultat;
	}
}