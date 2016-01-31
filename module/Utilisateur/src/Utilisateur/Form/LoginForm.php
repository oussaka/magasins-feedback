<?php

namespace Utilisateur\Form;

use Zend\Form\Form;
use Indicateur\Entity\Categorie;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use DoctrineModule\Validator\ObjectExists;

class LoginForm extends Form
{
	protected $entityManager;

	public function __construct($entityManager, $name = null)
	{
		parent::__construct($name);
		$this->entityManager = $entityManager;
	
		$this->setAttribute('class', 'standard__form');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
				'name' => 'loginutilisateur',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nom d\'utilisateur',
				),
		));
		
		$this->add(array(
				'name' => 'passwordutilisateur',
				'type' => 'Password',
				'options' => array(
						'label' => 'Mot de passe',
				),
		));		

		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Connectez-vous',
						'id' => 'submitbutton',
				),
		));
		
	}
}

