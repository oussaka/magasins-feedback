<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;


class HistoriqueIndicateurUsers extends EntityRepository
{
    public function findIndicateursByUsersAndAnnee($userId, $annee)
    {
    	$em = $this->getEntityManager();
    	$dbCnx = $em->getConnection();
    	
    	$sql = "
    			SELECT DISTINCT indicateur_id 
    			FROM historique_indicateur_users
    			WHERE 
    				user_id = " . $dbCnx->quote($userId, 'integer') . " 
    	";
    	
    	$stmt = $em->getConnection()->prepare($sql);
    	$stmt->execute();
    	$resultat = $stmt->fetchAll(\PDO::FETCH_COLUMN);
    	
    	return $resultat;
    }
}