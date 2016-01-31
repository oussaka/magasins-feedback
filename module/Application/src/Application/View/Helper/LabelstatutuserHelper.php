<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class LabelstatutuserHelper extends AbstractHelper
{
	public function __invoke($statut)
	{
		switch ($statut) {
			case 0:
				return 'Pas d\'accès';
				break;
			case 1:
				return 'En attente de validation';
				break;
			case 2:
				return 'Bloqué';
				break;
			case 3:
				return 'Actif';
				break;
			default:
				return false;
				break;
		}
	}
}
