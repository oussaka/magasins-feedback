<?php

namespace Utilisateur\Form;

use Zend\Form\Form;
use Indicateur\Entity\Categorie;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use DoctrineModule\Validator\NoObjectExists;
use DoctrineModule\Validator\UniqueObject;

class InscriptioninviteForm extends Form
{
	protected $entityManager;

	public function __construct($entityManager, $name = null)
	{
		parent::__construct($name);
		$this->entityManager = $entityManager;
	
		$this->setAttribute('class', 'standard__form');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
				'name' => 'nom',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nom',
				),
		));
		
		$this->add(array(
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array(
						'label' => 'Prénom',
				),
		));
		
		$this->add(array(
				'name' => 'sexe',
				'type' => 'Select',
				'options' => array(
						'label' => 'Sexe',
				),
				'attributes' => array(
						'options' => array(
								'' => '',
								'H' => 'Homme',
								'F' => 'Femme',
						)
				)
		));
		
		$this->add(array(
				'name' => 'mail',
				'type' => 'Text',
				'options' => array(
						'label' => 'Email',
						'attributes' => array(
								'readonly' => 'readonly',
								'disabled' => 'disabled',
						)
				),
		));
		
		$this->add(array(
				'name' => 'login',
				'type' => 'Text',
				'options' => array(
						'label' => 'Login',
				),
		));
		
		$this->add(array(
				'name' => 'pwd1',
				'type' => 'Password',
				'required' => true,
				'options' => array(
						'label' => 'Mot de passe',
				),
		));
		
		$this->add(array(
				'name' => 'pwd2',
				'type' => 'Password',
				'required' => true,
				'options' => array(
						'label' => 'Confirmer mot de passe',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Enregistrer',
						'id' => 'submitbutton',
				),
		));
		
		// Filtres et validateurs
		$this->setInputFilter($this->createInputFilter($entityManager));
		
	}	
	
	
	/**
	 * Définition des filtres et des validateurs
	 * @return \Zend\InputFilter\InputFilter
	 */
	private function createInputFilter($entityManager)
	{
		$inputFilter = new InputFilter();
		
		$this->addTrimRequired($inputFilter, 'nom');
		$this->addTrimRequired($inputFilter, 'prenom');
		$this->addTrimRequired($inputFilter, 'sexe');
		$this->addTrimRequired($inputFilter, 'login');
			
		$inputFilter->add(array(
				'name' => 'login',
				'validators' => array(
						array(
								'name' => 'DoctrineModule\Validator\NoObjectExists',
								'options' => array(
										'object_repository' => $this->entityManager->getRepository('Indicateur\Entity\Users'),
										'fields' => array('login'),
										'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Login déjà utilisé." ),
								),
						),
				)
		));		
		
		$inputFilter->add(array(
				'name' => 'pwd1',
				'required' => true,
				'validators' => array(
						array('name' => 'StringLength', 'options' => array('min' => 6)),
				),
		));
			
		$inputFilter->add(array(
				'name' => 'pwd2',
				'required' => true,
				'validators' => array(
						array('name' => 'StringLength', 'options' => array('min' => 6)),
						array(
								'name' => 'Identical', 
								'options' => array(
										'token' => 'pwd1',
										'messages' => array(\Zend\Validator\Identical::NOT_SAME => 'Les deux mots de passe ne correspondent pas.'),
								),
						),
				),
		));
		
		
		return $inputFilter;
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
}

