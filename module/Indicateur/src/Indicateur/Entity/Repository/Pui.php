<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;


class Pui extends EntityRepository
{
	public function supprimerPui($id)
	{
		$id = (int)$id;
		if($id > 0) {
			$em = $this->getEntityManager();
			$em->remove($this->find($id));
			$em->flush();
		}
	}   

}