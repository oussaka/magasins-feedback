<?php

namespace Etablissement\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\Db\RecordExists;
use DoctrineModule\Validator\NoObjectExists;

class EtablissementFilter implements InputFilterAwareInterface 
{
	private $entityManager;	
	private $_inputFilter;

	
	public function __construct($entityManager) 
	{
		$this->entityManager = $entityManager;
	}
	
	
	/**
	 * Add Trim filter to form element and set it to required
	 * @param string $fieldName
	 */
	private function addTrimRequired(& $inputFilter, $fieldName)
	{
		$inputFilter->add(array(
				'name' => $fieldName,
				'required' => true,
				'filters' => array(
						array('name' => 'StringTrim'),
				),
		));
	}
	
	/**
	 * Add Trim filter to form element
	 * @param string $fieldName
	 */
	private function addTrim(& $inputFilter, $fieldName)
	{
		$inputFilter->add(array(
				'name' => $fieldName,
				'filters' => array(
						array('name' => 'StringTrim'),
				),
		));
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
			$factory     = new InputFactory();
			 
			$this->addTrimRequired($inputFilter, 'libelle');
			$this->addTrimRequired($inputFilter, 'adresse');
			$this->addTrimRequired($inputFilter, 'cp');
			$this->addTrimRequired($inputFilter, 'ville');
			$this->addTrimRequired($inputFilter, 'pays');
			$this->addTrim($inputFilter, 'nb_sellers');
			$this->addTrimRequired($inputFilter, 'nomadmin');
			$this->addTrimRequired($inputFilter, 'prenomadmin');
			$this->addTrimRequired($inputFilter, 'sexeadmin');
			$this->addTrimRequired($inputFilter, 'mailadmin');
			$this->addTrimRequired($inputFilter, 'loginadmin');
			
			
			$inputFilter->add(array(
			 		'name' => 'loginadmin',
			 		'validators' => array(
			 				//array('name' => 'RecordExists', 'options' => array('table' => 'users', 'field' => 'login', 'adapter'=>$this->entityManager)),
			 				array(
									'name' => 'DoctrineModule\Validator\NoObjectExists',
									'options' => array(
											'object_repository' => $this->entityManager->getRepository('Indicateur\Entity\Users'),
											'fields' => 'login',
											'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Login déjà utilisé." )
									),
							),
					)
			));
			 
			$inputFilter->add(array(
			 		'name' => 'mailadmin',
			 		'validators' => array(
			 				//array('name' => 'RecordExists', 'options' => array('table' => 'users', 'field' => 'login', 'adapter'=>$this->entityManager)),
			 				array('name' => 'EmailAddress'),
			 				array(
									'name' => 'DoctrineModule\Validator\NoObjectExists',
									'options' => array(
											'object_repository' => $this->entityManager->getRepository('Indicateur\Entity\Users'),
											'fields' => 'email',
											'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Email déjà utilisé." )
									),
							),
					)
			));
			
			$inputFilter->add(array(
					'name' => 'nb_sellers',
					'validators' => array(
							array('name' => 'Int'),
							array('name' => 'GreaterThan', 'options' => array('min' => 0)),
					)
			));
			
			
			$inputFilter->add(array(
					'name' => 'pwd1admin',
					'required' => true,
					'validators' => array(
							array('name' => 'StringLength', 'options' => array('min' => 6)),
					),
			));
			
			$inputFilter->add(array(
					'name' => 'pwd2admin',
					'required' => true,
					'validators' => array(
							array('name' => 'StringLength', 'options' => array('min' => 6)),
							//array('name' => 'Identical', 'options' => array('value' => $_POST['pwd1admin'])),
					),
			));
			 
			$this->_inputFilter = $inputFilter;
		}
		 
		return $this->_inputFilter;
		
	}
	
}

