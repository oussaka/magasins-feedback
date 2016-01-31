<?php

namespace Etablissement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;
use Etablissement\Form\EtabsForm;
use Etablissement\Form\EtablissementForm;
use Etablissement\Form\EtablissementFilter;
use Indicateur\Entity\Etabs;
use Indicateur\Entity\Etabstatut;
use Indicateur\Entity\Users;
use My\AuthUserPermissions;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Service\ApplicationFactory;
use My\Mailer;

class EtablissementController extends AbstractActionController
{
	/**
	 * Renvoie l'entity manger par défaut
	 * @return Ambigous <object, multitype:, \Doctrine\ORM\EntityManager>
	 */
	private function getEntityManager()
	{
		$serviceManager = $this->getServiceLocator();
		$entityManager  = $serviceManager->get(
			'Doctrine\ORM\EntityManager'
		);
		return $entityManager;
	}
	
	/**
	 * Renovie l'url de base de l'application
	 */
	private function getBaseUrl()
	{
		return $this->getEvent()->getRouter()->getBaseUrl();
	}
	
	/**
	 * Renovie l'url de base de l'application avec la partie protocol et host
	 */
	private function getFullBaseUrl()
	{
		$requestUri = $this->getEvent()->getRouter()->getRequestUri();
	
		return
		$requestUri->getScheme() . '://' .
		$requestUri->getHost() .
		$this->getEvent()->getRouter()->getBaseUrl();
	}
	
	
    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
	{
		error_reporting(E_ALL);
		$entityManager = $this->getEntityManager();
		$entityUsers = $entityManager->getRepository('\Indicateur\Entity\Users');
		$request = $this->getRequest();
		$form = new EtablissementForm($entityManager, 'ajout-etablissement', $this->getBaseUrl());

		$alertmessages = array();
		$success = false;

		if ($request->isPost()) {
			$formInputFilter = new EtablissementFilter($entityManager);
    		$form->setInputFilter($formInputFilter->getInputFilter());
    		$form->setData($request->getPost());
			var_dump($request->getPost());
    		
    		if($form->isValid()) {
    			// Applique le filtre et récupère les données filtrées
    			$formData = $form->getData();
    			$form->populateValues($formData);
    			// Debug::dump($form->getData());
    			
    			if($formData['pwd1admin'] != $formData['pwd2admin']) {
    				// Mot de passe non concordants
    				$alertmessages['error'] = 'Les deux mots de passes ne sont pas identiques';
    			} else {
	    			// Ajout Etablissement    			
	    			$objEtabs = new Etabs();
	    			$objEtabs->setEtLibelle($formData['libelle']);
	    			$objEtabs->setEtRue($formData['adresse']);
	    			$objEtabs->setEtVille($formData['ville']);
	    			$objEtabs->setEtCp($formData['cp']);
	    			$objEtabs->setEtPays($formData['pays']);
	    			$objEtabs->setEtNbsellers($formData['nb_sellers']);
	    			$objEtabs->setEtType(0);
	    			$objEtabs->setCaCodeFk($entityManager->find('Indicateur\Entity\Categorie', $formData['categorie']));
	    			$objEtabs->setEtStatut($entityManager->find('Indicateur\Entity\Etabstatut', $formData['statut']));
	    			$objEtabs->setEtCreation(new \DateTime(date('Y-m-d H:i:s')));
	    			$objEtabs->setEtMaj(new \DateTime(date('Y-m-d H:i:s')));
	    			$entityManager->persist($objEtabs);
	    			$entityManager->flush();
	    			
	    			// Ajout administrateur magasin
	    			if($objEtabs->getEtCodePk() > 0) {
		    			$objUsers = new Users();
		    			$objUsers->setNom($formData['nomadmin']);
		    			$objUsers->setPrenom($formData['prenomadmin']);
		    			$objUsers->setSexe($formData['sexeadmin']);
		    			$objUsers->setEmail($formData['mailadmin']);
		    			$objUsers->setLogin($formData['loginadmin']);
		    			$objUsers->setPassword(md5($formData['pwd1admin']));
		    			$objUsers->setEtabs($objEtabs);
		    			$objUsers->setDateCreated(new \DateTime(date('Y-m-d H:i:s')));
		    			$objUsers->setType(2);
		    			$objUsers->setAcces(3);
		    			$entityManager->persist($objUsers);
		    			$entityManager->flush();
		    			// Debug::dump($objUsers->getUserCodePk());
		    			if($objUsers->getUserCodePk() > 0) {
		    				// Succès
		    				$alertmessages['success'] = 'Etablissement crée';
		    				//$mailer = new Mailer();
		    				//$to = $entityUsers->getTabMailAdmin();
		    				//$mailer->envoiNotificationAjoutEtablissement($objEtabs, $objUsers, $to);
		    				$success = true;
		    			} else {
		    				// Echec création superadmin
		    				$alertmessages['warning'] = 'Magasin crée mais le échec de la création du compte administrateur';
		    			}
	    			} else {
	    				// Echec creation magasin
	    				$alertmessages['error'] = 'L\'magasin n\'a pu être crée';
	    			}
    			}
    		} else {
    			$alertmessages['error'] = 'Veuillez corriger la saisie';
    		}
    	}
    	   	
        return new ViewModel(
        	array(
					'form' => $form,
        			'alertmessages' => $alertmessages,
        			'success' => $success,
		    )
        );
    }
    
    public function listAction()
    {
    	$entityManager = $this->getEntityManager();
    	$entityEtabs = $entityManager->getRepository('\Indicateur\Entity\Etabs');
    	
    	$tabEtabs = $entityEtabs->findAll();
    	
    	return new ViewModel(
        	array(
    				'tabEtabs' => $tabEtabs,
    		)
    	);
    }
    
    public function editAction()
    {
    	$entityManager = $this->getEntityManager();
    	$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
    	$entityCategorie = $entityManager->getRepository('Indicateur\Entity\Categorie');
    	$entityEtabstatut = $entityManager->getRepository('Indicateur\Entity\Etabstatut');
    	$authService = new AuthenticationService();
    	$connectedUser = $authService->getStorage()->read();
    	$userpermission = new AuthUserPermissions();
    	
    	$id = $this->params('id');

    	if($id > 0) {
    		$etab = $entityEtabs->find($id);
    		if($userpermission->canEditEtabs($etab)) {  		
		    	$request = $this->getRequest();
		    	$form = new EtabsForm($entityManager);
		    	
		    	$alertmessages = array();
		    	$success = false;
	    	 
	    	
		    	if ($request->isPost()) {
		    		$form->setData($request->getPost());
		    	
		    		if($form->isValid()) {
		    			// Applique le filtre et récupère les données filtrées
		    			$formData = $form->getData();
		    			$form->populateValues($formData);
		    			// MAJ BDD
		    			$etab = $entityEtabs->find($id);
		    			$etab->setEtLibelle($formData['libelle']);
		    			$etab->setEtRue($formData['adresse']);
		    			$etab->setEtVille($formData['ville']);
		    			$etab->setEtCp($formData['cp']);
		    			$etab->setEtPays($formData['pays']);
		    			$etab->setEtnbsellers($formData['nb_sellers']);
		    			$etab->setCaCodeFk($entityCategorie->find($formData['categorie']));
		    			$etab->setEtStatut($entityEtabstatut->find($formData['statut']));
		    			$etab->setEtMaj(new \DateTime(date('Y-m-d H:i:s')));
		    			$entityManager->persist($etab);
		    			$entityManager->flush();
		    			$alertmessages['success'] = 'Enregistrement terminé';
		    		} else {
		    			$alertmessages['error'] = 'Veuillez corriger la saisie';
		    		}
		    	} else {
		    		$form->populateValues(array(
		    				'id'		=> $id,
		    				'libelle'	=> $etab->getEtLibelle(),
		    				'adresse'	=> $etab->getEtRue(),
		    				'ville'		=> $etab->getEtVille(),
		    				'cp'		=> $etab->getEtCp(),
		    				'pays'		=> $etab->getEtPays(),
		    				'nb_sellers'=> $etab->getEtNbsellers(),
		    				'categorie'	=> $etab->getCaCodeFk(),
		    				'statut'	=> $etab->getEtStatut(),
		    		));    		
		    	}
    		} else {
    			return $this->redirect()->toUrl($this->getBaseUrl() . '/application/index/forbidden');
    		}
    	} elseif($connectedUser->et_code_fk > 0) {
    		return $this->redirect()->toUrl($this->getBaseUrl() . '/etablissement/etablissement/edit/' . $connectedUser->et_code_fk);
    	}    	
    	
    	
    	return new ViewModel(
    			array(
    					'form' => $form,
    					'alertmessages' => $alertmessages,
    			)
    	);
    }


}

