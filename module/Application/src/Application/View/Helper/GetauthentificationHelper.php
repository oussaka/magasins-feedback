<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;
use Zend\Authentication\AuthenticationService;

class GetauthentificationHelper extends AbstractHelper
{
	public function __invoke()
	{
		$authService = new AuthenticationService();
		return $authService->getStorage()->read();
	}
}
