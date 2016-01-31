<?php

namespace Utilisateur\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Utilisateur\Form\LoginForm;
use Utilisateur\Form\LoginFilter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use My\Mailer;
use My\AuthUserPermissions;
use Etablissement\Form\InvitationForm;
use Utilisateur\Form\UserForm;
use Utilisateur\Form\InscriptioninviteForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Indicateur\Entity\Invitation;
use Indicateur\Entity\Users;
use Indicateur\Entity\Etabs;
use Indicateur\Entity\Pui;


class UtilisateurController extends AbstractActionController
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
	
	/**
	 * Renvoi l'identité de l'utilisateur connecté
	 * @return \Zend\Authentication\Storage\mixed
	 */
	private function getAuthentification()
	{
		$authService = new AuthenticationService();
		return $authService->getStorage()->read();
	}
	
	/**
	 * Supprime l'identité de l'utilisateur connecté de la session PHP
	 */
	private function clearAuthentification()
	{
		$authService = new AuthenticationService();
		return $authService->clearIdentity();
	}	
	
    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
    	$entityManager = $this->getEntityManager();
    	$form = new LoginForm($entityManager);
    	$error = null;
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$formInputFilter = new LoginFilter($entityManager);
    		$form->setInputFilter($formInputFilter->getInputFilter());
    		$form->setData($request->getPost());
    		if($form->isValid()) {
    			$formData = $form->getData();
    			
    			$authAdapter = new AuthAdapter(
    					$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
    					'users',
    					'login',
    					'password',
    					"MD5(?)"
    			);    			
    			$authAdapter	->setIdentity($formData["loginutilisateur"])
    							->setCredential($formData["passwordutilisateur"]);
    			$authResultat = $authAdapter->authenticate();
    			
    			if($authResultat->isValid()) {
    				$userData = $authAdapter->getResultRowObject();
    				if($userData->acces == '4') {
    					$error = 'Votre compte a été supprimé';
    				} elseif($userData->acces == '3') {
		    			$authService = new AuthenticationService();
    					$authService->getStorage()->write($userData);
    					
    					// TODO Redirections selon profil utilisateur
    					switch ($userData->type) {
    						default:
    							// $this->redirect()->toUrl($this->getBaseUrl());
                                $this->redirect()->toRoute("home");
    					}
    				} else {
    					$error = 'Votre compte est désactivé';
    				}
    			} else {
    				$error = 'Identifiants incorrects';
    			}
    		} else {
    			$error = 'Identifiants incorrects';
    		}
    	}
    	
        return new ViewModel(array(
				'form' => $form,
        		'alertmessages' => array('error' => $error),
        ));
    }

    public function logoutAction()
    {
    	$authService = new AuthenticationService();
    	$authService->clearIdentity();
    	$this->redirect()->toUrl($this->getBaseUrl() . '/utilisateur/utilisateur/login');
    	
        return new ViewModel();
    }

    public function oublimdpAction()
    {
    	$entityManager = $this->getEntityManager();
    	$alertmessages = null;
    	
    	$request = $this->getRequest();
    	if($request->isPost()) {
    		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
    		$user = $entityUsers->getUserByLoginOrMail($_POST['loginormail']);    		
    		if($user) {
    			// Enregistre clé secrete
    			$token =  md5($user->getPassword() . time());
    			$user->setToken($token);
    			$entityManager->persist($user);
    			$entityManager->flush();
    			// Envoi de mail
    			$mailer = new Mailer();
    			$resultatEnvoiMail = $mailer->sendMailResetPassword($user, $token, $this->getFullBaseUrl());
    			if($resultatEnvoiMail) {
    				// Succes envoi mail réinitialisation
    				$alertmessages['success'] = 
    					'Un mail vous a été destiné à cette adresse ' . $user->getEmail() . '<br>' .
    					'Veuillez suivre les instructions pour réinitialiser votre mot de passe. <br>' .
    					'Pensez à vérifier votre dossier SPAM si nécessaire.';
    				// MAJ utilisateur
    				$user->setEmail($user->getEmail());
    			} else {
    				$alertmessages['error'] = 'Une erreur s\'est produite pendant l\'envoi du mail. Veuillez réessayer.';
    			}
    		} else {
    			$alertmessages['error'] = 'Utilisateur inexistant';
    		}
    	}
    	
        return new ViewModel(
        	array(
        		'alertmessages' => $alertmessages,   	
	        )
        );
    }

    public function resetmdpAction()
    {
    	$alertmessages = null;
    	$entityManager = $this->getEntityManager();
    	
    	$userId = $this->params('id');
    	$token = $this->params('secret');
    	
    	$request = $this->getRequest();
    	$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
    	$user = $entityUsers->find($userId);
    	
    	if($user && $user->getAcces() != '4') {
    		if($token != $user->getToken()) {
    			$alertmessages['error'] = 
    				'<p>Lien invalide ou déjà utilisé</p><br>' . 
    				'<input type="button" value="Mot de passe perdu ?" 
    							onClick="document.location=\'' . $this->getFullBaseUrl() . '/utilisateur/utilisateur/oublimdp\';"/>';
    			$user = false;
    		} else {
	    		if($request->isPost()) {
	    			$pwd1 = $_POST['mdp'];
	    			$pwd2 = $_POST['confirm_mdp'];
	    			if(strlen($pwd1) < 6 || strlen($pwd2) < 6) {
	    				$alertmessages['error'] = 'Le mot de passe doit contenir au moins 6 caractères.';    				    			
	    			} elseif($pwd1 != $pwd2) {
	    				$alertmessages['error'] = 'Les mots de passe ne concordent pas.';    				
	    			} else {
	    				$user->setPassword(md5($pwd1));
	    				$user->setToken(null);
	    				$entityManager->persist($user);
	    				$entityManager->flush();
	    				$alertmessages['success'] = 'Votre mot de passe a été modifié.';
	    			}
	    		}
    		}
    	} else {
    		$alertmessages['error'] = 'Requête invalide car ce compte utilisateur est inexistant ou supprimé';
    	}
    	
        return new ViewModel(
        		array(
        				'user' => $user,
		        		'alertmessages' => $alertmessages,
        		)
        );
    }

	public function invitationAction()
	{
		$alertmessages = null;
		$entityManager = $this->getEntityManager();
		$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
		$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
		$auth = $this->getAuthentification();
		$etabId = $auth->et_code_fk;
		
		$form = new InvitationForm($entityManager, $etabId);
		
		$request = $this->getRequest();
		$changementPui = false;
		 
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if($form->isValid()) {
				$formData = $form->getData();
				$token =  md5(time());
				// vérifie existance et profil utilisateur
				$utilisateurExistant = $entityUsers->findOneBy(array('email' => $formData['mail']));
				if($utilisateurExistant && $utilisateurExistant->getAcces() != '4') {
					if($utilisateurExistant->getPui() == $formData['pui']) {
						$typeInvitation = false;
						$alertmessages['error'] = 'Cet utilisateur est déjà inscrit dans cette même PUI.';
					} elseif($utilisateurExistant->getType() == 3 || $utilisateurExistant->getType() == 4) {
						$typeInvitation = 'changement_pui';
						$changementPui = true;
					} else {
						$typeInvitation = false;
						$alertmessages['error'] = 'Le profil de cet utilisateur ne permet pas son invitation.';
					}
				} else {	
					$typeInvitation = 'inscription';
				}
				
				// Si envoi autorisé
				if($typeInvitation) {
					// Envoi mail
					$mailer = new Mailer();
					$resultatEnvoiMail = false;
					if($typeInvitation == 'changement_pui') {
						$resultatEnvoiMail = $mailer->envoiInvitationChangementPui($formData['mail'], $token, $auth->email, $this->getFullBaseUrl());							
					} elseif($typeInvitation == 'inscription') {
						$resultatEnvoiMail = $mailer->envoiInvitation($formData['mail'], $token, $auth->email, $this->getFullBaseUrl());	
					}
					// Enregistrement invitation dans BDD
					if($resultatEnvoiMail) {
						$hydrationData = array(
								'email' 	=> $formData['mail'],
								'etat' 		=> 1,
								'etabs'		=> $etabId,
								'pui'		=> $formData['pui'],
								'profil'	=> $formData['profil'],
								'token'		=> $token,
						);
						$hydrator = new DoctrineHydrator($entityManager);
						$invitation = new Invitation();
						$invitation = $hydrator->hydrate($hydrationData, $invitation);				
						$entityManager->persist($invitation);
						$entityManager->flush();
						
						$alertmessages['success'] = 'L\'invitation a été envoyée';
						if($changementPui) {
							$alertmessages['success'] .= '<br>Utilisateur existant. Une demande de chagement de PUI est envoyée';
						}
					} else {
						unset($alertmessages['warning']);
						$alertmessages['error'] = 'Echec envoi du mail d\'invitation. Veuillez réessayer';
					}
				}
			} else {
				$alertmessages['error'] = 'Veuillez corriger la saisie';
			}
		} else {
			if(isset($_GET['mail'])) {
				$_GET['mail'] = trim($_GET['mail']);
				if(filter_var($_GET['mail'], FILTER_VALIDATE_EMAIL)) {
					$form->get('mail')->setValue($_GET['mail']);
				}
			}
		}
		
		return new ViewModel(
				array(
						'form' => $form,
						'alertmessages' => $alertmessages,
				)
		);
	}

	public function inscriptioninviteAction()
	{
		$alertmessages = $form = null;
		
		$entityManager = $this->getEntityManager();
		$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
		$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
		$entityInvitation = $entityManager->getRepository('Indicateur\Entity\Invitation');
		
		$mail = $_GET['mail'];
		$token = $_GET['secret'];
		$invitations = $entityInvitation->getInvitations($mail, $token);
		//var_dump($invitations);exit;
		
		if($invitations) {
			$invitation = $invitations[0];
			if($invitation->getEtat() == 1) {			
				$form = new InscriptioninviteForm($entityManager);
				$form->get('mail')	->setValue($invitation->getEmail());
				$form->get('mail')	->setAttribute('readonly', 'readonly')
									->setAttribute('disabled', 'disabled');
				$form->getInputFilter()->get('mail')->setRequired(false);
				$request = $this->getRequest();
				
				if ($request->isPost()) {
					$form->setData($request->getPost());
					if($form->isValid()) {
						$formData = $form->getData();
						// Ajout utilisateur
						$hydrationData = array(
								'nom' 		=> $formData['nom'],
								'prenom'	=> $formData['prenom'],
								'sexe'		=> $formData['sexe'],
								'email'		=> $invitation->getEmail(),
								'login'		=> $formData['login'],
								'password'	=> md5($formData['pwd1']),
								'pui'		=> $invitation->getPui(),
								'etabs' 	=> $invitation->getEtabs(),
								'acces'		=> 3,
								'type'	 	=> $invitation->getProfil(),
								'dateCreated' 	=> new \DateTime(date('Y-m-d H:i:s')),
								'dateUpdated' 	=> new \DateTime(date('Y-m-d H:i:s')),
						);
						$hydrator = new DoctrineHydrator($entityManager);
						$user = new Users();
						$user = $hydrator->hydrate($hydrationData, $user);
						$entityManager->persist($user);
						$entityManager->flush();
						// MAJ etat invitation
						$invitation->setEtat(3);
						$entityManager->persist($invitation);
						$entityManager->flush();
							
						$alertmessages['success'] = 
							'Inscription terminée, un administrateur du site se chargera de valider votre compte utilisateur.<br>' .
							'Un email vous sera envoyé dès que votre compte est activé.';														
					} else {
						$alertmessages['error'] = 'Veuillez corriger la saisie';
					}
				}
			} elseif($invitation->getEtat() == 2) {
				$alertmessages['error'] = 'Vous êtes déjà inscrit, mais votre compte n\'est pas encore activé par un administrateur.';
			} elseif($invitation->getEtat() == 3) {
				$urlMdpPerdu = $this->getFullBaseUrl() . "/utilisateur/utilisateur/oublimdp";
				$alertmessages['error'] = 
					'<p>Vous êtes déjà inscrit. Si vous avez perdu votre identifiant ou votre mot de passe, veuillez cliquez sur le lien suivant</p>' .
					'<p><input type="button" class="btn btn-success" value="Renvoyer mon mot de passe perdu" onClick="document.location=\'' . $urlMdpPerdu . '\';"></p>';
			} else {
				$alertmessages['error'] = 'Lien d\'inscription invalide.';
			}
		} else {
			$alertmessages['error'] = 'Lien d\'inscription invalide. Votre invitation a été probablement annulée.';
		}
	
		return new ViewModel(
				array(
						'form' => $form,
						'alertmessages' => $alertmessages,
				)
		);
	}

	public function changementpuiAction()
	{
		$alertmessages = $form = $user = null;
		
		$entityManager = $this->getEntityManager();
		$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
		$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
		$entityInvitation = $entityManager->getRepository('Indicateur\Entity\Invitation');
		
		$mail = $_GET['mail'];
		$token = $_GET['secret'];
		$invitations = $entityInvitation->getInvitations($mail, $token);
		$invitation = null;

		if($invitations) {
			$invitation = $invitations[0];
			$auth = $this->getAuthentification();
			if($invitation->getEmail() != $auth->email) {
				$alertmessages['error'] = 'Cette invitation de changement de PUI est associée à l\'adresse mail ' . $invitation->getEmail();
			} elseif($invitation->getEtat() == 1) {
				$user = $entityUsers->findOneBy(array('email' => $invitation->getEmail()));
				$form = true;
				if($user && $user->getAcces() != '4') {
					if(isset($_POST['validation']) && $_POST['validation'] == 1) {
						$user->setEtabs($invitation->getEtabs());
						$user->setPui($invitation->getPui());
						$entityManager->persist($user);
						$invitation->setEtat(3);
						$entityManager->persist($invitation);
						$entityManager->flush();
						$form = false;
						$alertmessages['success'] = 'Modification de la PUI validée';
					}
				} else {
					$user = $form = $invitation = null;
					$this->redirect()->toUrl($this->getBaseUrl() . '/utilisateur/utilisateur/logout');
				}
			} else {
				$alertmessages['error'] = 'Changement de PUI déjà validé';
				$user = $form = $invitation = null;
			}
		} else {
			$alertmessages['error'] = 'Lien invalide ou déjà utilisé';
		}
		
		return new ViewModel(
				array(
						'form' => $form,
						'invitation' => $invitation,
						'user' => $user,
						'alertmessages' => $alertmessages,
				)
		);
	}

	public function listAction()
	{
		$entityManager = $this->getEntityManager();
		$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
		$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
		$auth = $this->getAuthentification();
		$userpermission = new AuthUserPermissions();
		
		// Paramètres d'entrée en fonction profil utilisateur connecté et paramètres $_GET
		if($auth && $auth->et_code_fk) {
			$etabId = $auth->et_code_fk;
		} else {
			$etabId = (isset($_GET['etab'])) ? ((int)$_GET['etab']) : null;
		}
		if($auth && $auth->pui_code_fk) {
			$puiId = $auth->pui_code_fk;
		} else {
			$puiId = (isset($_GET['pui'])) ? ((int)$_GET['pui']) : null;
		}
		
		// Filtre des utilisateurs
		$filter = array();
		$complementTitre = '';
		$affichageEtab = $affichagePui = true;
		if($etabId > 0 && $entityEtabs->find($etabId)) {
			$etab = $entityEtabs->find($etabId);
			if($etab) {
				$complementTitre .= ' \\ ' . $etab->getEtLibelle();
				$affichageEtab = false;
			}
		}
		if($puiId > 0 && $entityPui->find($puiId)) {
			$pui = $entityPui->find($puiId);
			if($pui) {
				$complementTitre .= ' \\ ' . $pui->getLibelle();
				$affichagePui = false;
			}
		}
		
		// Récupère liste des utilisateurs
		$tabUsers = $entityUsers->getUsers($etabId, $puiId);
		return new ViewModel(
				array(
						'tabUsers' => $tabUsers,
						'complementTitre' => $complementTitre,
						'affichageEtab' => $affichageEtab,
						'affichagePui' => $affichagePui,
						'userpermission' => $userpermission,
						'connectedUser' => $auth,
				)
		);
	}

	public function editAction()
	{
		$alertmessages = $form = null;
		
		$entityManager = $this->getEntityManager();
		$entityEtabs = $entityManager->getRepository('Indicateur\Entity\Etabs');
		$entityPui = $entityManager->getRepository('Indicateur\Entity\Pui');
		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
		$userpermission = new AuthUserPermissions();
		$connectedUser = $this->getAuthentification();
		
		$id = (int)$this->params('id');
		$user = $entityUsers->find($id);
		
		if($id > 0 && $user && $user->getAcces() != '4') {
			if($userpermission->canEditUser($user)) {
				$form = new UserForm($entityManager);
				if($user->getType() != 3 && $user->getType() != 4) {
					$form->remove('type');
				}
				$request = $this->getRequest();
		
				if ($request->isPost()) {
					$form->setData($request->getPost());
					$form->getInputFilter()->get('pwd1')->setRequired(false);
					$form->getInputFilter()->get('pwd2')->setRequired(false);
					if($form->isValid()) {
						$formData = $form->getData();
						if(($formData['pwd1'] != '' || $formData['pwd2'] != '') && $formData['pwd1'] != $formData['pwd2']) {
							$alertmessages['error'] = 'Les mots de passes ne correspondent pas.';
						} else {
							// Enregistremet utilisateur
							$hydrationData = array(
									'nom' 		=> $formData['nom'],
									'prenom'	=> $formData['prenom'],
									'sexe'		=> $formData['sexe'],
									'email'		=> $formData['mail'],
									'login'		=> $formData['login'],
									'dateUpdated' 	=> new \DateTime(date('Y-m-d H:i:s')),
							);
							if($formData['pwd1'] != '') {
								$hydrationData['password'] = md5($formData['pwd1']);
							}
							if($form->has('type')) {
								$hydrationData['type'] = $formData['type'];
							}
							if($form->has('statut')) {
								$hydrationData['acces'] = $formData['statut'];
							}
							$hydrator = new DoctrineHydrator($entityManager);
							$user = $entityUsers->find($id);
							$user = $hydrator->hydrate($hydrationData, $user);
							$entityManager->persist($user);
							$entityManager->flush();
							// Envoi de mail
							$mailer = new Mailer();
							$mailer->envoiNotificationChangementProfil($user, $this->getFullBaseUrl());
							
							$alertmessages['success'] = 'Enregistrement terminé';						
						}
					} else {
						$alertmessages['error'] = 'Veuillez corriger la saisie';
					}
				} else {
					$form->populateValues(array(
							'userCodePk'=> $id,
							'nom'		=> $user->getNom(),
							'prenom'	=> $user->getPrenom(),
							'sexe'		=> $user->getSexe(),
							'type'		=> $user->getType(),
							'statut'	=> $user->getAcces(),
							'login'		=> $user->getLogin(),
							'mail'		=> $user->getEmail(),
							'pwd1'		=> '',
							'pwd2'		=> '',
					));
				}
			} else {
				return $this->redirect()->toUrl($this->getBaseUrl() . '/application/index/forbidden');
			}
		} else {
			$alertmessages['error'] = 'Utilisateur inexistant ou supprimé.';
		}
		
		return new ViewModel(
				array(
						'user' => $user,
						'form' => $form,
						'alertmessages' => $alertmessages,
						'userpermission' => $userpermission,
						'connectedUser' => $connectedUser,
				)
		);
	}

	public function deleteAction()
	{
		$entityManager = $this->getEntityManager();
		$entityUsers = $entityManager->getRepository('Indicateur\Entity\Users');
		$auth = $this->getAuthentification();
		$userpermission = new AuthUserPermissions();

		$id = (int)$this->params('id');
		$user = $entityUsers->find($id);
		$alertmessages = array();
		$succes = false;
		
		if($user) {
			$userEtabId = ($user->getEtabs()) ?  $user->getEtabs()->getEtCodePk() : null;
			if($userpermission->canDeleteUser($user)) {
				$user->setAcces(4);
				$user->setEmail('\\DELETED_' . $user->getEmail());
				$user->setLogin('\\DELETED_' . $user->getLogin());
				$entityManager->persist($user);
				$entityManager->flush();
				$succes = true;
			} else {
				$alertmessages['error'] = 'Vous n\'avez pas le droit de supprimer cet utilisateur';
			}
		} else {
			$alertmessages['error'] = 'Utilisateur inexistant';
		}
		
		return new ViewModel(
				array(
						'succes' => $succes,
						'alertmessages' => $alertmessages,
				)
		);
	}
}

