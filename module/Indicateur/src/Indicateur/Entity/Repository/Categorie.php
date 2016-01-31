<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Categorie extends EntityRepository
{
    public function lister()
    {
    	/*
    	$query = $this->getEntityManager()->createQueryBuilder();
    	$query	->select(array('u.caCodePk'))
    			->from('Indicateur\Entity\Categorie', 'u');
    	$data = $query->getQuery()->getResult();
    	*/
    	
    	$data = $this->findAll();
    	$resultat = array();
    	foreach($data as $row) {
    		$resultat[$row->getCaCodePk()] = $row->getLibelle();
    	}
    
    
    	return $resultat;
    }

}