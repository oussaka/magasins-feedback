<?php

namespace Etablissement\Form;

use Zend\Form\Form;
use Indicateur\Entity\Categorie;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use DoctrineModule\Validator\NoObjectExists;

class InvitationForm extends Form
{
	
	public function __construct($entityManager, $etabId, $name = null)
	{
		parent::__construct($name);
		
		$this->setAttribute('class', 'standard_form');
		$this->setAttribute('role', 'form');
		$this->setAttribute('method', 'post');


		$this->add(array(
				'name' => 'mail',
				'type' => 'Text',
				'options' => array(
						'label' => 'Mail utilisateur',
				),
		));
		
		$this->add(array(
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'pui',
				'options' => array(
						'label' => 'PUI',
						'object_manager' => $entityManager,
						'target_class'   => '\Indicateur\Entity\Pui',
						'property'       => 'libelle',
						'empty_option'   => '',
						'is_method'      => true,
						'find_method'    => array(
								'name'   => 'findBy',
								'params' => array(
										'criteria' => array('etabs' => $etabId),
										'orderBy'  => array('libelle' => 'ASC'),
								),
						),
				),
		));
		
		$this->add(array(
				'name' => 'profil',
				'type' => 'Select',
				'options' => array(
						'label' => 'Profil utilisateur',
						'options' => array(
								'4' => 'Commercant',
								'3' => 'Administrateur',
						),
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Envoyer une invitation',
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
		
		$inputFilter->add(array(
				'name' => 'mail',
				'filters' => array(
						array('name' => 'StringTrim'),
						array('name' => 'StripTags'),
				),
				'validators' => array(
						array('name' => 'EmailAddress'),
				)
		));
		
		$inputFilter->add(array(
				'name' => 'pui',
				'required' => true,
		));
		
		$inputFilter->add(array(
				'name' => 'profil',
				'required' => true,
		));
		
		return $inputFilter;
	}
}





