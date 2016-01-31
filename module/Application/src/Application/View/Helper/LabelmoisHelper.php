<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class LabelMoisHelper extends AbstractHelper
{
	public function __invoke($num)
	{
		$tabLabelMois = array(
				'',
				'Janvier',
				'Février',
				'Mars',
				'Avril',
				'Mai',
				'Juin',
				'Juillet',
				'Août',
				'Septembre',
				'Octobre',
				'Novembre',
				'Décembre',
		);
		
		if(isset($tabLabelMois[$num])) {
			return $tabLabelMois[$num];
		} else {
			return '';
		}
	}
}
