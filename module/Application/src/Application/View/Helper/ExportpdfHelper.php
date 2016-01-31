<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class ExportpdfHelper extends AbstractHelper
{
	public function __invoke($baseUrl, $tabHtmlElementId, $filename = 'Statistiques_indicateurs', $titre = null, $etablissement = null, $pui = null, $otherFilters = null)
	{
		$js = 'this.parentNode.data.value=\'\';';
		foreach ($tabHtmlElementId as $id) {
			$js .= 'this.parentNode.data.value=this.parentNode.data.value+\'<p>\'+document.getElementById(\'' . $id .  '\').innerHTML+\'</p>\';';			
		}
		$js .= 'this.parentNode.submit();';
		
		$html = '
			<form method="post" action="' . $baseUrl . '/stats/stats/exportpdf" target="_blank">
				<input type="hidden" name="filename" value="' . $filename . '">
				<input type="hidden" name="etablissement" value="' . $etablissement . '">
				<input type="hidden" name="pui" value="' . $pui . '">
				<input type="hidden" name="titre" value="' . $titre . '">
				<input type="hidden" name="otherFilters" value="' . base64_encode(json_encode($otherFilters)) . '">
				<input type="hidden" name="data" value="">
				<a href="javascript:;" class="icon-pdf" title="Export PDF" onClick="' . $js . '"></a>
			</form>
		';
		
		return $html;
	}
}
