<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Indicateur\Entity\Etabs;

class LabeletablissementHelper extends AbstractHelper implements ServiceLocatorAwareInterface 
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
	 * @param integer $etabId
	 * @return string
	 */
	public function __invoke($etabId)
	{
		$html = '';
		
		if($etabId > 0) {
			$serviceManager = $this->getServiceLocator()->getServiceLocator();
			$entityManager  = $serviceManager->get(
					'doctrine.entitymanager.orm_default'
			);
			$entityEtabs = $entityManager->getRepository('\Indicateur\Entity\Etabs');
			$etab = $entityEtabs->find($etabId);
			
			if($etab) {
				$html = $etab->getEtLibelle();
			}
		}
		
		return $html;
	}
}
