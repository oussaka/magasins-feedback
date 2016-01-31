<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class TitrepageHelper extends AbstractHelper
{
	public function __invoke($titre, $complement = null, $urlRetour = null)
	{
		$link = ($urlRetour) ? '<span class="pull-right"><a href="' . $urlRetour . '">Retour</a></span>' : '';
		
		$html = 
			'<section class="content-header"> 
    			<h1>' . $titre . '&nbsp;&nbsp;<small>' . $complement . '</small>' . $link . '</h1>
    		</section>
    		<p>&nbsp;</p>';
		
		return $html;
	}
}
