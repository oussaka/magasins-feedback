<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Indicateur\Entity\Pui;

class LabelpuiHelper extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	/**
	 * Set the service locator.
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return CustomHelper
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}
	/**
	 * Get the service locator.
	 *
	 * @return \Zend\ServiceManager\ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	/**
	 *
	 * @param integer $puiId
	 * @return string
	 */
	public function __invoke($puiId)
	{
		$html = '';
		
		if($puiId > 0) {
			$serviceManager = $this->getServiceLocator()->getServiceLocator();
			$entityManager  = $serviceManager->get(
					'doctrine.entitymanager.orm_default'
			);
			$entityPui = $entityManager->getRepository('\Indicateur\Entity\Pui');
			$pui = $entityPui->find($puiId);
			
			if($pui) {
				$html = $pui->getLibelle();
			}
		}
		
		return $html;
	}
}
