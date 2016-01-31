<?php

namespace Indicateur\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Indicateur\Paginator\DoctrinePaginatorAdapter as PaginatorAdapter;
use Zend\Paginator\Paginator;


class ScoreAjaxController extends AbstractActionController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em = null;

    /**
     * @var integer
     */
    protected $etabId = null;

    /**
     * @var integer
     */
    protected $puiId = null;

    /**
     * @var integer
     */
    protected $userId = null;

    /**
     * @param int $etabId
     */
    public function setEtabId($etabId)
    {
        $this->etabId = $etabId;
    }

    /**
     * @return int
     */
    public function getEtabId()
    {
        return $this->etabId;
    }

    /**
     * @param int $puiId
     */
    public function setPuiId($puiId)
    {
        $this->puiId = $puiId;
    }

    /**
     * @return int
     */
    public function getPuiId()
    {
        return $this->puiId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function indexAction()
    {
    }

    /**
     * Retourne la liste des utilisateurs pour un indicateur et établissement donnés
     *
     * @return JsonModel
     * @throws \Exception
     */
    public function getUsersByIndicAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $indicateurId = $this->params()->fromRoute("indicId", null);
        if (empty($indicateurId)) {
            throw new \Exception("Erreur dans le paramètre : indicateur Id");
        }

        /** @var $indicateurUsersRepository \Indicateur\Entity\Repository\IndicateurUsers */
        $indicateurUsersRepository = $this->getEntityManager()->getRepository('Indicateur\Entity\IndicateurUsers');
        $indicsUsers = $indicateurUsersRepository->getUsersByIndicId($indicateurId, $this->etabId, $this->puiId);

        return new JsonModel(
            $indicsUsers
        );
    }

    public function postScoreAction()
    {
        $em = $this->getEntityManager();

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        /** @var $scoreRepository \Indicateur\Entity\Repository\Score */
        $scoreRepository = $em->getRepository('Indicateur\Entity\Score');
        /** @var $indicateurUsersRepository \Indicateur\Entity\Repository\IndicateurUsers */
        $indicateurUsersRepository = $em->getRepository('Indicateur\Entity\IndicateurUsers');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $data = $request->getPost();
            $indicId = $data->id;
            $scores = $data->scores;
            $scoreRepository->saveScore($indicId, $this->getUserId(), $this->getPuiId(), $scores);
        }

        return new JsonModel(array(
        ));
    }

    public function getScoreAction()
    {
        $em = $this->getEntityManager();

        $indicId  = $this->params()->fromRoute("indicId", null);

        /** @var $indicateurUsersRepository \Indicateur\Entity\Repository\IndicateurUsers */
        // $indicateurUsersRepository = $em->getRepository('Indicateur\Entity\IndicateurUsers');
        /** @var $scoreRepository \Indicateur\Entity\Repository\Score */
        $scoreRepository = $em->getRepository('Indicateur\Entity\Score');
        $result = $scoreRepository->findByIndicUserPui($indicId, $this->getUserId(), $this->getPuiId());

        $arrResult = array();
        /** @var $result \Indicateur\Entity\Score[] */
        foreach ($result as $curr) {
            $arrResult[] = array(
                "id"     => $curr->getId(),
                "date"   => $curr->getDate()->format("d/m/Y"),
                "valeur" => $curr->getValeur(),
                "theme"  => $curr->getTheme()
            );
        }

        return new JsonModel(array(
            "data" => $arrResult
        ));
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }

        return $this->em;
    }

}