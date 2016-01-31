<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class AlertmessagesHelper extends AbstractHelper
{
	public function __invoke($alerts, $type = null)
	{
		if(is_array($alerts)) {
			if($alerts) {
				$html = '<div style="padding-left:50px;padding-right:50px;">';
				if(isset($alerts['success']) && trim($alerts['success']) != '') {
					$html .= '<div class="alert alert-success" role="alert">' .  $alerts['success'] . '</div>';
				}
				if(isset($alerts['warning']) && trim($alerts['warning']) != '') {
					$html .= '<div class="alert alert-warning" role="alert">' .  $alerts['warning'] . '</div>';
				}
				if(isset($alerts['error']) && trim($alerts['error']) != '') {
					$html .= '<div class="alert alert-danger" role="alert">' .  $alerts['error'] . '</div>';
				}
				if(isset($alerts['info']) && trim($alerts['info']) != '') {
					$html .= '<div class="alert alert-info" role="alert">' .  $alerts['info'] . '</div>';
				}
				$html .= '</div>';
			} else {
				$html = '';
			}
		} elseif(strlen(trim($alerts)) > 0) {
			$html = '<div style="width:90%;">';
			$type = strtolower($type);
			if($type != 'success' && $type != 'warning' && $type != 'error' && $type != 'info') {
				$type = 'info';
			} elseif($type == 'error') {
				$type = 'danger';
			}
			$html .= '<div class="alert alert-' . $type . '" role="alert">' .  $alerts . '</div>';
			$html .= '</div>';
		} else {
			$html = '';
		}
		
		return $html;
	}
}
