<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class LabeltypeuserHelper extends AbstractHelper
{
	public function __invoke($type)
	{
		switch ($type) {
			case 1:
				return 'Super utilisateur';
				break;
			case 2:
				return 'Administrateur établissement';
				break;
			case 3:
				return 'Administrateur PUI';
				break;
			case 4:
				return 'Commercant';
				break;
			default:
				return false;
				break;
		}
	}
}
