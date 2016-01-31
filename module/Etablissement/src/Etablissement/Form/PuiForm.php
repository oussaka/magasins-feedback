<?php

namespace Etablissement\Form;

use Zend\Form\Form;
use Indicateur\Entity\Categorie;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;


class PuiForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct($name);
	
		$this->setAttribute('class', 'standard_form');
		$this->setAttribute('method', 'post');
	
		
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		
		$this->add(array(
				'name' => 'etab_id',
				'type' => 'Hidden',
		));
	
		$this->add(array(
				'name' => 'libelle',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nom PUI',
				),
		));
		
		$this->add(array(
				'name' => 'nblits',
				'type' => 'Text',
				'options' => array(
						'label' => 'Nombre de lits',
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
		$this->setInputFilter($this->createInputFilter());
	}
	
	/**
	 * Définition des filtres et des validateurs
	 * @return \Zend\InputFilter\InputFilter
	 */
	private function createInputFilter()
	{
		$inputFilter = new InputFilter();
		
		$inputFilter->add(array(
				'name' => 'libelle',
				'required' => true,
				'filters' => array(
						array('name' => 'StringTrim'),
				),
				'validators' => array(
						array('name' => 'StringLength', 'options' => array('max' => 45)),
				),
		));
		
		$inputFilter->add(array(
				'name' => 'nblits',
				'required' => true,
				'filters' => array(
						array('name' => 'StringTrim'),
						array('name' => 'StripTags'),
				),
				'validators' => array(
						array('name' => 'Int'),
						array('name' => 'GreaterThan', 'options' => array('min' => 0)),
				),
		));
		
		
		
		return $inputFilter;
	}
}



