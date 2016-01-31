<?php

namespace Utilisateur\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;
use DoctrineModule\Validator\ObjectExists;

class LoginFilter implements InputFilterAwareInterface 
{
	private $entityManager;	
	private $_inputFilter;

	
	public function __construct($entityManager) 
	{
		$this->entityManager = $entityManager;
	}	


	/**
	 * Définit les filtres
	 * Non utilisé
	 * @param InputFilterInterface $inputFilter
	 * @throws \Exception
	 */
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	
	/**
	 * Obtient les filtres de contenu
	 * @return \Zend\InputFilter\InputFilter
	 */
	public function getInputFilter()
	{
		if (!$this->_inputFilter) {
			$inputFilter = new InputFilter();				
				
			$inputFilter->add(array(
					'name' => 'loginutilisateur',
					'required' => true,
					'validators' => array(
						array(
								'name' => 'DoctrineModule\Validator\ObjectExists',
								'options' => array(
										'object_repository' => $this->entityManager->getRepository('Indicateur\Entity\Users'),
										'fields' => 'login',
										'messages' => array( ObjectExists::ERROR_NO_OBJECT_FOUND => "Utilisateur inexistant." )
								),
						),
				)
			));
			
			$inputFilter->add(array(
					'name' => 'passwordutilisateur',
					'required' => true,
			));
	
			$this->_inputFilter = $inputFilter;
		}
			
		return $this->_inputFilter;
	
	}
	
}
	
	