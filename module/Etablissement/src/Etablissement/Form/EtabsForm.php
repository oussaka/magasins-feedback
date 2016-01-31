<?php

namespace Etablissement\Form;

use Zend\Form\Form;
use Indicateur\Entity\Categorie;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class EtabsForm extends Form
{
	protected $entityManager;
	
	public function __construct($entityManager, $name = null)
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
		
		$this->addTrimRequired($inputFilter, 'libelle');
		$this->addTrimRequired($inputFilter, 'adresse');
		$this->addTrimRequired($inputFilter, 'cp');
		$this->addTrimRequired($inputFilter, 'ville');
		$this->addTrimRequired($inputFilter, 'pays');
		$this->addTrim($inputFilter, 'nb_lits');
		
		$inputFilter->add(array(
				'name' => 'nb_lits',
				'validators' => array(
						array('name' => 'Int'),
						array('name' => 'GreaterThan', 'options' => array('min' => 0)),
				)
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
}





