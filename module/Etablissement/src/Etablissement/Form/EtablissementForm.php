<?php

namespace Etablissement\Form;

use Zend\Form\Form;
use Indicateur\Entity\Categorie;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class EtablissementForm extends Form
{
	protected $entityManager;
	
	public function __construct($entityManager, $name = null, $baseUrl = '/')
	{
		parent::__construct($name);
		$this->entityManager = $entityManager;
		
		$this->setAttribute('class', 'standard_form');
		$this->setAttribute('role', 'form');
		$this->setAttribute('method', 'post');


		// Etablissement
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		
		$this->add(array(
				'name' => 'libelle',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nom',
				),
		));
		
		$this->add(array(
				'name' => 'adresse',
				'type' => 'Text',
				'options' => array(
						'label' => 'Adresse',
				),
		));
		
		$this->add(array(
				'name' => 'cp',
				'type' => 'Text',
				'options' => array(
						'label' => 'Code postal',
				),
		));
		
		$this->add(array(
				'name' => 'ville',
				'type' => 'Text',
				'options' => array(
						'label' => 'Ville',
				),
		));
		
		$this->add(array(
				'name' => 'pays',
				'type' => 'Text',
				'options' => array(
						'label' => 'Pays',
				),
		));
		
		$this->add(array(
				'name' => 'nb_lits',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nombre de lits',
				),
		));
		
		$this->add(array(
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'categorie',
				'options' => array(
						'label' => 'Catégorie',
						'object_manager' => $entityManager,
						'target_class'   => '\Indicateur\Entity\Categorie',
						'property'       => 'libelle',
						'empty_option'   => '',
						'is_method'      => true,
						'find_method'    => array(
								'name'   => 'findBy',
								'params' => array(
										'criteria' => array(),
										'orderBy'  => array('libelle' => 'ASC'),
								),
						),
				),
		));
		
		$this->add(array(
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'statut',
				'options' => array(
						'label' => 'Statut',
						'object_manager' => $entityManager,
						'target_class'   => '\Indicateur\Entity\Etabstatut',
						'property'       => 'libelle',
						'empty_option'   => '',
						'is_method'      => true,
						'find_method'    => array(
								'name'   => 'findBy',
								'params' => array(
										'criteria' => array(),
										'orderBy'  => array('libelle' => 'ASC'),
								),
						),
				),
		));
		
		$this->add(array(
				'name' => 'captcha',
				'type' => 'Captcha',
						'messages' => array('badCaptcha' => 'Code de sécurité invalide'),
				'attributes' => array(
						'id'    => 'captcha',
						'autocomplete' => 'off',
						'required'     => 'required'
				),
				'options'    => array(
						'label' => 'Code de sécurité',
						'captcha' => new \Zend\Captcha\Image(array(
								'font' => 'public/fonts/arial.ttf',
								'imgDir' => 'public/img/captcha',
								'imgUrl' => $baseUrl . '/img/captcha',
								'fontSize' => 32,
								'width' => 320,
								'height' => 125,
				                'wordlen' => 6, 
				                'dotNoiseLevel' => 30,
						)),
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
		
		// Admin établissement
		$this->add(array(
				'name' => 'idadmin',
				'type' => 'Hidden',
		));
		
		$this->add(array(
				'name' => 'nomadmin',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nom',
				),
		));
		
		$this->add(array(
				'name' => 'prenomadmin',
				'type' => 'Text',
				'options' => array(
						'label' => 'Prénom',
				),
		));
		
		$this->add(array(
				'name' => 'sexeadmin',
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
				'name' => 'mailadmin',
				'type' => 'Text',
				'options' => array(
						'label' => 'Email',
				),
		));
		
		$this->add(array(
				'name' => 'loginadmin',
				'type' => 'Text',
				'options' => array(
						'label' => 'Login',
				),
		));
		
		$this->add(array(
				'name' => 'pwd1admin',
				'type' => 'Password',
				'required' => true,
				'options' => array(
						'label' => 'Mot de passe',
				),
		));
		
		$this->add(array(
				'name' => 'pwd2admin',
				'type' => 'Password',
				'required' => true,
				'options' => array(
						'label' => 'Confirmer mot de passe',
				),
		));
		
		//$this->setInputFilter(new EtablissementFilter());

	}
	
}

