<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;


class Invitation extends EntityRepository
{
	/**
	 * Renvoie une invitation si trouvée, sinon renvoie false
	 * @param string $mail
	 * @param string $token
	 * @return \Indicateur\Entity\Invitation|boolean
	 */
	public function getInvitations($mail, $token)
	{
		$invitations = $this->findBy(array(
				'email' => $mail,
				'token' => $token,
		));
		
		if($invitations) {
			return $invitations;
		} else {
			return false;
		}
	}   

}