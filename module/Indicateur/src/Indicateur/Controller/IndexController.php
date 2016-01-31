<?php

namespace Indicateur\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Indicateur\Paginator\DoctrinePaginatorAdapter as PaginatorAdapter;
use Zend\Paginator\Paginator;
use My\AuthUserPermissions;

class IndexController extends AbstractActionController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em = null;

    CONST MAX_VIEW_SCORE = 5;


    // TODO : refactoring fusionner les deux methode index, et mesindics en une seule
    public function indexAction()
    {
        $this->headTitle("liste indicateurs");

        $serviceManager = $this->getServiceLocator();
        $config = $serviceManager->get('Configuration');

        // TODO: corriger le filter, quand je change de page dans la tableau le filter disparait
        $search_by = $this->getRequest()->getPost('filter', null);
        if (is_null($search_by)) {
            $search_by = $this->params()->fromRoute('search_by', null);
        }

        /*$search_by = $this->params()->fromRoute('search_by') ?
            $this->params()->fromRoute('search_by') : '';*/

        $currentPage = $this->params()->fromRoute('page', 1);
        $max_per_page = $config['pagination']['per_page_size'];

        /** @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceManager->get(
            'Doctrine\ORM\EntityManager'
        );

        /** @var $indicateurRepository \Indicateur\Entity\Repository\Indicateur */
        $indicateurRepository = $entityManager->getRepository('Indicateur\Entity\Indicateur');
        $offset = ($currentPage - 1) * $max_per_page;
        if($currentPage == 1) {
            $offset = null;
        }
        $results = $indicateurRepository->getPaginator($offset, $max_per_page, $search_by);

        $adapter = new PaginatorAdapter($results);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage($max_per_page);
        $indics = $paginator->getCurrentItems();

        // see: http://ocramius.github.io/presentations/doctrine2-zf2-introduction/#/48
        /*$Criteria = new Criteria();
        $Criteria->andWhere(
          $Criteria->expr()->contains(
              "chapitre",
              "lorem"
          )
        );
        $filtredcollection = $collection->matching($Criteria);*/

        /* $this->flashMessenger()
            ->setNamespace('error')
            ->addMessage('User not found');
        */


        return new ViewModel(array(
            "indics"    => $indics,
            "paginator" => $paginator,
            'search_by' => $search_by
        ));
    }

    public function mesIndicsAction()
    {
        $this->headTitle("liste de mes indicateurs");

        $serviceManager = $this->getServiceLocator();
        $config = $serviceManager->get('Configuration');

        $currentPage = $this->params()->fromRoute('page', null);
        $max_per_page = $config['pagination']['per_page_size'];

        $authService = new AuthenticationService();
        if ($authService->hasIdentity()) {
            // Identity exists; get it
            $etabId = $authService->getIdentity()->et_code_fk;
            $puiId = $authService->getIdentity()->pui_code_fk;
            $userId = $authService->getIdentity()->user_code_pk;
        }

        /** @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceManager->get(
            'Doctrine\ORM\EntityManager'
        );
        $indicateurRepository = $entityManager->getRepository('Indicateur\Entity\Indicateur');
        $offset = ($currentPage - 1) * $max_per_page;
        if($currentPage == 1) {
            $offset = null;
        }
        /** @var $indicateurRepository \Indicateur\Entity\Repository\Indicateur */
        $indicateurRepository = $entityManager->getRepository('Indicateur\Entity\Indicateur');
        $results = $indicateurRepository->getPaginatorIndicAttrib($offset, $max_per_page, $userId);

        $adapter = new PaginatorAdapter($results);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage($max_per_page);
        $indics = $paginator->getCurrentItems();

        return new ViewModel(array(
            "indics"    => $indics,
            "paginator" => $paginator,
        ));
    }


    /**
     * Attribution par indicateur
     *
     * @return ViewModel
     */
    public function attribIndicateurAction()
    {
        $this->headTitle("Attribution indicateur par liste d'utilisateurs");

        $indicateurId = $this->params()->fromRoute("indicId", 1);
        $etabId = null;
        $authService = new AuthenticationService();
        if ($authService->hasIdentity()) {
            // Identity exists; get it
            $etabId = $authService->getIdentity()->et_code_fk;
        }


        /** @var $indicateurRepository \Indicateur\Entity\Repository\Indicateur */
        $indicateurRepository = $this->getEntityManager()->getRepository('Indicateur\Entity\Indicateur');
        $Indic = $indicateurRepository->find($indicateurId);

        /** @var $indicateurUsersRepository \Indicateur\Entity\Repository\IndicateurUsers */
        // $indicateurUsersRepository = $this->getEntityManager()->getRepository('Indicateur\Entity\IndicateurUsers');
        // $indicsUsers = $indicateurUsersRepository->getUsersByIndicId($indicateurId, $etabId);

        return new ViewModel(array(
            'indic' => $Indic,
            'indicId' => $indicateurId,
            // 'indicsUsers' => $indicsUsers,
        ));
    }

    /**
     * Attribution d'un indicateur par utilisateur
     *
     * @throws \Exception
     * @return ViewModel
     */
    public function attribUserAction()
    {
        $this->headTitle("Attribution indicateurs par utilisateur");
        $userId = $this->params()->fromRoute("userId", null);
        $user = $this->getEntityManager()->find("\Indicateur\Entity\Users", $userId);

        $authService = new AuthenticationService();
        $connectedUser = $authService->getIdentity();
        if ($authService->hasIdentity()) {
            // Identity exists; get it
            $puiId = $connectedUser->pui_code_fk;
            $etabId = $connectedUser->et_code_fk;
            $profil = $connectedUser->type;
        }
		
        if($connectedUser->type == AuthUserPermissions::ADMIN_ETABS) {
	        if (empty($user) || $user->getEtabs()->getEtCodePk() != $etabId) {
	            throw new \Exception("Vous n'êtes pas autorisé à attribuer des indicateurs à cet utilisateur.");
	        }        	
        } else {
	        if (empty($user) || $user->getPui()->getPuiCodePk() != $puiId) {
	            throw new \Exception("Vous n'êtes pas autorisé à attribuer des indicateurs à cet utilisateur.");
	        }
        }

        return new ViewModel(array(
            "userId" => $userId,
            "user"   => $user
        ));
    }

    public function saisieScoreAction()
    {
        $this->headTitle("Saisie de score");

        // retrieve param from route match
        // $routeMatch = $this->getEvent()->getRouteMatch();
        // $paramValue = $routeMatch->getParam('a_param');
        $indicId = $this->params()->fromRoute("indicId", null);

        $authService = new AuthenticationService();
        if ($authService->hasIdentity()) {
            // Identity exists; get it
            $etabId = $authService->getIdentity()->et_code_fk;
            $puiId = $authService->getIdentity()->pui_code_fk;
            $userId = $authService->getIdentity()->user_code_pk;
        }


        if (empty($indicId) || empty($puiId) || empty($userId)) {
            throw new \Exception("Erreur dans le paramètre : indicateur Id");
        }

        $em = $this->getEntityManager();
        /** @var $indicateurUsersRepository \Indicateur\Entity\Repository\IndicateurUsers */
        $indicateurUsersRepository = $em->getRepository('Indicateur\Entity\IndicateurUsers');

        $manyuser = count($indicateurUsersRepository->getUsersByIndicId($indicId, $etabId, $puiId)) > 1;

        /** @var $indic \Indicateur\Entity\Indicateur */
        $indic = $em->find('Indicateur\Entity\Indicateur', $indicId);
        // === $indic = $em->getRepository('Indicateur\Entity\Indicateur')->find($indicId);

        /** @var $scoreRepository \Indicateur\Entity\Repository\Score */
        $scoreRepository = $em->getRepository('Indicateur\Entity\Score');

        // $indicUser = $indicateurUsersRepository->findByIndicateurUserPui($indicId, $userId, $puiId);
        $indicUser = $indicateurUsersRepository->findOneBy(array(
            "indicateur" => $indicId,
            "user"       => $userId,
            "pui"        => $puiId
        ));

        if(empty($indicUser) || !$indicUser->getActif()) {
            throw new \Exception("Cet indicateur ne vous est pas attribué!");
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            // $this->params()->fromPost() return an Array
            $data = (array) $request->getPost();

            if ($indicUser->getType() === \Indicateur\Entity\IndicateurUsers::TYPE_ANNUEL) {
                $scoreRepository->saveScore($indicId, $userId, $puiId, (array) $data);
            }
        }

        $scores = $scoreRepository->findByIndicUserPui($indicId, $userId, $puiId);

        $data = array();
        $formdata = null;
        $date = new \DateTime();
        // echo $date->modify("-1 year")->format(\DateTime::ISO8601);
        $currentYear = $date->format("Y");
        $currentMonth = $date->format("m");

        if ($indicUser->getType() === \Indicateur\Entity\IndicateurUsers::TYPE_ANNUEL) {

            for ($i = $this::MAX_VIEW_SCORE; $i > 0; $i--, $currentYear--) {

                $value = null;
                $id = null;
                foreach ($scores as $score) {
                    if ($score->getAnnee() == $currentYear) {
                        $id = $score->getId();
                        $value = $score->getValeur();
                    }
                }

                $formdata[] = array("annee"  => $currentYear,
                                    "valeur" => $value,
                                    "id"     => $id);
            }
        } elseif ($indicUser->getType() === \Indicateur\Entity\IndicateurUsers::TYPE_MENSUEL) {

            for ($i = $this::MAX_VIEW_SCORE; $i > 0; $i--, $currentYear--) {

                for ($currentMonth = 12; $currentMonth > 0; $currentMonth--) {

                    $value = null;
                    $id = null;
                    foreach ($scores as $score) {

                        if ($score->getMois() == $currentMonth && $score->getAnnee() == $currentYear) {
                            $id = $score->getId();
                            $value = $score->getValeur();
                        }
                    }

                    $formdata[] = array("annee"  => (int) $currentYear,
                                        "mois"   => $currentMonth,
                                        "valeur" => $value,
                                        "id"     => $id);
                }
            }

            $formdata = json_encode($formdata);
        }

        // Use a different view script
        $viewModel = new ViewModel();
        /*$viewModel->setVariable("formdata", $formdata);
        $viewModel->setVariable("indic", $indic);
        $viewModel->setVariable("manyuser", $manyuser);*/
        $viewModel->setVariables(array(
            "formdata" => $formdata,
            "indic"    => $indic,
            "manyuser" => $manyuser
        ));
        
        switch($indicUser->getType()) {
            case \Indicateur\Entity\IndicateurUsers::TYPE_ANNUEL:
                $viewModel->setTemplate('indicateur/index/saisie-annuel');
            break;
            case \Indicateur\Entity\IndicateurUsers::TYPE_MENSUEL:
                $viewModel->setTemplate('indicateur/index/saisie-mensuel');
            break;
            case \Indicateur\Entity\IndicateurUsers::TYPE_FILEAU:
                $viewModel->setTemplate('indicateur/index/saisie-fileau');
            break;
            default:
                $response = $this->getResponse();
                $response->setStatusCode(404);
                return $response;
        }

        return $viewModel;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }

        return $this->em;
    }

}

