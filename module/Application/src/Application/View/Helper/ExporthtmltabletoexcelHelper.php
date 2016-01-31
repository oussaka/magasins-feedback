<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class ExporthtmltabletoexcelHelper extends AbstractHelper
{
	public function __invoke($baseUrl, $htmlTableId, $fileName)
	{
		$js = 
			'this.parentNode.data.value=document.getElementById(\'' . $htmlTableId .  '\').innerHTML;' .
			'this.parentNode.submit();';
		
		$html = '
			<form method="post" action="' . $baseUrl . '/stats/stats/exportexcel" target="_blank">
				<input type="hidden" name="filename" value="' . $fileName . '">
				<input type="hidden" name="data" value="">
				<a href="javascript:;" class="icon-excel" title="Export Excel" onClick="' . $js . '"></a>
			</form>
		';
		
		return $html;
	}
}
