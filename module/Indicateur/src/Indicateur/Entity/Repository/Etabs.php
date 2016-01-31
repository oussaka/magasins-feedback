<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;


class Etabs extends EntityRepository
{
	/**
	 * Renvoi le nombre d'établissement pour chaque pays
	 * @return array
	 */
    public function countEtabsParPays()
    {
    	$em = $this->getEntityManager();
    	 
    	$dql = $em->createQueryBuilder();
    	$dql	->select('e.etPays, count(e.etCodePk) AS nb')
		    	->from('Indicateur\Entity\Etabs', 'e')
		    	->groupBy('e.etPays')
    			->orderBy('nb', 'desc');
    	
    	$data = $dql->getQuery()->getResult();
    	
    	$resultat = array();
    	foreach ($data as $row) {
    		$resultat[$row['etPays']] = $row['nb'];
    	}
    	
    	return $resultat;
    }
    
    /**
     * Renvoi le nombre d'établissement pour chaque catégorie
     * @return array
     */
    public function countEtabsParCategorie()
    {
    	$em = $this->getEntityManager();
    	
    	$sql = "
    			SELECT c.libelle AS categorie, count(e.et_code_pk) AS nb
    			FROM categorie c
    			LEFT JOIN etabs e ON c.ca_code_pk = e.ca_code_fk
    			GROUP BY c.ca_code_pk
    			ORDER BY categorie DESC
    	";
    	
    	$stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    	$stmt->execute();
    	$data = $stmt->fetchAll();
    	
    	$resultat = array();
    	foreach($data as $row) {
    		$resultat[$row["categorie"]] = $row["nb"];
    	}

    	return $resultat;
    }

}