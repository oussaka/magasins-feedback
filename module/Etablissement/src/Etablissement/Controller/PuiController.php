<?php

namespace Etablissement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Etablissement\Form\PuiForm;
use Indicateur\Entity\Etabs;
use Indicateur\Entity\Pui;
use Zend\Authentication\AuthenticationService;
use My\AuthUserPermissions;

class PuiController extends AbstractActionController
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

    public function editAction()
    {
    	$id = (int)$this->params('id');
    	$form = $etab = $pui = null;
    	
        $entityManager = $this->getEntityManager();
    	$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
    	$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
    	$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
    	$authService = new AuthenticationService();
    	$connectedUser = $authService->getStorage()->read();
		$userpermission = new AuthUserPermissions();

    	$alertmessages = array();
    	
    	if($id > 0) {
    		$pui = $entityPui->find($id);
    		if($pui) {
    			if($userpermission->canEditPui($pui)) {    			
			    	$etab = $pui->getEtabs();
			    	$etabId = $etab->getEtCodePk();
			    	
			    	// Formulaire
			    	$form = new PuiForm();	    	
			    	$request = $this->getRequest();
			    	 
			    	if ($request->isPost()) {
			    		$form->setData($request->getPost());
			    		if($form->isValid()) {
			    			$formData = $form->getData();
			    			$pui->setLibelle($formData['libelle']);
			    			$pui->setNblits($formData['nblits']);
			    			$pui->setDateUpdate(new \DateTime(date('Y-m-d H:i:s')));
			    			$entityManager->persist($pui);
			    			$entityManager->flush();
			    			$alertmessages['success'] = 'PUI modifiée';
			    		}
			    	} else {
			    		$form->populateValues(array(
			    				'id' => $id,
			    				'etab_id' => $etabId,
			    				'libelle' => $pui->getLibelle(),
			    				'nblits' => $pui->getNblits(),
			    		));
			    	}
    			} else {
    				return $this->redirect()->toUrl($this->getBaseUrl() . '/application/index/forbidden');
    			}
    		} else {
    			$alertmessages['error'] = 'Pui inexistante ou supprimée';
    		}
    	} elseif($connectedUser->pui_code_fk) {
    		return $this->redirect()->toUrl($this->getBaseUrl() . '/etablissement/pui/edit/' . $connectedUser->pui_code_fk);
    	} else {
    		return $this->redirect()->toUrl($this->getBaseUrl() . '/application/index/forbidden');
    	}
    	
    	// Permission supprimé pour superadmin et admin etab, seulement si aucun utilisateur dans cette PUI
    	$canDelete = (
    			$pui && $id > 0 &&
    			($connectedUser->type == 2 || $connectedUser->type == 1) &&
    			count($entityUsers->findBy(array('pui' => $id))) == 0
    	);
    	
    	// Vue
        return new ViewModel(array(
        		'form' => $form,
        		'etab' => $etab,
        		'pui' => $pui,
        		'alertmessages' => $alertmessages,
        		'canDelete' => $canDelete,
        		'connectedUser' => $connectedUser,
        ));
    }

    public function addAction()
    {
    	$entityManager = $this->getEntityManager();
    	$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
    	$authService = new AuthenticationService();
    	$connectedUser = $authService->getStorage()->read();

    	$alertmessages = array();
    	$success = false;
    	
    	if($connectedUser && $connectedUser->et_code_fk > 0) {
	    	$etabId = $connectedUser->et_code_fk;
	    	$etab = $entityEtabs->find($etabId);
	    	
	    	$form = new PuiForm();	    	
	    	$request = $this->getRequest();
	    	 
	    	if ($request->isPost()) {
	    		$form->setData($request->getPost());
	    		if($form->isValid()) {
	    			$formData = $form->getData();
	    			$pui = new Pui();
	    			$pui->setLibelle($formData['libelle']);
	    			$pui->setNblits($formData['nblits']);
	    			$pui->setEtabs($etab);
	    			$pui->setDateCreate(new \DateTime(date('Y-m-d H:i:s')));
	    			$pui->setDateUpdate(new \DateTime(date('Y-m-d H:i:s')));
	    			$entityManager->persist($pui);
	    			$entityManager->flush();
	    			$alertmessages['success'] = 'PUI créee';
	    			$success = true;
	    		}
	    	}
    	} else {
    		$alertmessages['error'] = 'Action interdite';
    		$form = $etab = null;
    	}
    	
        return new ViewModel(array(
        		'form' => $form,
        		'etab' => $etab,
        		'alertmessages' => $alertmessages,
        		'success' => $success,
        ));
    }

    public function listAction()
    {
    	$entityManager = $this->getEntityManager();
    	$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
    	$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
    	$authService = new AuthenticationService();
    	$connectedUser = $authService->getStorage()->read();
		$userpermission = new AuthUserPermissions();
    	
    	if($connectedUser && $connectedUser->type == 2 && $connectedUser->et_code_fk > 0) {
    		$etab = $entityEtabs->find($connectedUser->et_code_fk);
    		$tabPui = $entityPui->findBy(array('etabs' => $connectedUser->et_code_fk));
    	} else {
    		$etab = null;
    		$tabPui = $entityPui->findAll();
    	}
        
        return new ViewModel(array(
        		'etab' => $etab,
        		'tabPui' => $tabPui,
        		'connectedUser' => $connectedUser,
        ));
    }

    public function deleteAction()
    {
    	$entityManager = $this->getEntityManager();
    	$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
    	$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
    	$authService = new AuthenticationService();
    	$connectedUser = $authService->getStorage()->read();
		$userpermission = new AuthUserPermissions();
    	
    	$id = $this->params('id');
    	$alertmessages = $pui = null;
    	
    	if($id > 0) {
    		$pui = $entityPui->find($id);
    		
    		if($pui) {
	    		if($userpermission->canDeletePui($pui)) {	
			    	if(count($entityUsers->findBy(array('pui' => $id))) > 0) {
			    		$alertmessages['error'] = 'Vous ne pouvez plus supprimer cette PUI car elle contient des utilisateurs';
			    	} else {
			    		$entityPui->supprimerPui($id);
			    		return $this->redirect()->toUrl($this->getBaseUrl() . '/etablissement/pui/list');
			    	}
	    		}
    			return $this->redirect()->toUrl($this->getBaseUrl() . '/application/index/forbidden');
    		} else {
    			$alertmessages['error'] = 'Pui inexistante ou supprimée';
    		}
    	} else {
    		return $this->redirect()->toUrl($this->getBaseUrl() . '/etablissement/pui/list');
    	}

        return new ViewModel(array(
        		'alertmessages' => $alertmessages,
        		'pui' => $pui,
        ));
    }


}

