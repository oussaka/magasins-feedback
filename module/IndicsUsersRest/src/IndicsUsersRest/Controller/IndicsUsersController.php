<?php

namespace IndicsUsersRest\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 *
 */
class IndicsUsersController extends AbstractRestfulController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;



    /**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{
        $this->methodNotAllowed();

		$data = array(
		);

        return new JsonModel(array(
            $data
        ));
	}

	/**
	 * Return single resource
	 *
	 * @param mixed $id
     *
	 * @return mixed
	 */
	public function get($id)
    {
        $indicateurRepository = $this->getIndicsUsersRepository();
        $result = $indicateurRepository->findByUser($id);

        return new JsonModel(array(
            "data" => $result
        ));
    }

	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function create($data) {

        if (!isset($data["type"])) {
            $data["type"] = $this->getEntityManager()->find('\Indicateur\Entity\Indicateur', $data['indicateur'])->getType();
        }
        if (!isset($data["pui"])) {
            $data["pui"] = $this->getEntityManager()->find('\Indicateur\Entity\Users', $data['user'])->getPui();
        }

        $indicUser = new \Indicateur\Entity\IndicateurUsers();

        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $indicUser = $hydrator->hydrate($data, $indicUser);

        $this->entityManager->persist($indicUser);
        $this->entityManager->flush();

        return new JsonModel(array(
            "id" => $indicUser->getId()
        ));
    }

    /**
     * Update an existing resource
     *
     * @param mixed $id
     * @param mixed $data
     * @throws \Exception
     * @return mixed
     */
	public function update($id, $data)
    {
        $indicateurRepository = $this->getIndicsUsersRepository();
        $indicUser = $indicateurRepository->find($id);

        if (empty($indicUser)) {
            throw new \Exception('Aucun enregistrement trouvé pour cet id : '.$id);
        }

        $hydrator = new DoctrineHydrator($this->entityManager);
        $indicUser = $hydrator->hydrate($data, $indicUser);

        $this->entityManager->flush();

        return new JsonModel(array(
            "data" => $data
        ));
    }

	/**
	 * Delete an existing resource
	 *
	 * @param  mixed $id
	 * @return mixed
	 */
	public function delete($id)
    {
        $this->methodNotAllowed();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        if( null === $this->entityManager) {

            $serviceManager = $this->getServiceLocator();
            /** @var $entityManager \Doctrine\ORM\EntityManager */
            $this->entityManager = $serviceManager->get(
                'Doctrine\ORM\EntityManager'
            );
        }

        return $this->entityManager;
    }

    /**
     * @internal param $entityManager
     *
     * @return \Indicateur\Entity\Repository\IndicateurUsers
     */
    private function getIndicsUsersRepository()
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->getRepository('Indicateur\Entity\IndicateurUsers');
    }

    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(
            \Zend\Http\PhpEnvironment\Response::STATUS_CODE_405
        );
    }
}
