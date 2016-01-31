<?php

namespace UsersRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UsersRestController extends AbstractRestfulController
{

    private $em = null;

    public function getList()
    {

        // $em = $this->getEntityManager();

        $results= $em->createQuery('select a from Indicateur\Entity\Users as a')->getArrayResult();

        /** @var $entityManager \Doctrine\ORM\EntityManager */
        /* $entityManager  = $this->getServiceLocator()->get(
            'Doctrine\ORM\EntityManager'
        );
        $usersRepository = $entityManager->getRepository('Indicateur\Entity\Users');
        $results = $usersRepository->findAll();
*/
        return new JsonModel(
                // $results
            array(
                array("id" => 1, "nom" => "youssef", "prenom" => "kaabachi", "pui" => "puitest", "etab" => "etabtest"),
                array("id" => 2, "nom" => "mlrker", "prenom" => "dfgdfgi", "pui" => "puitest", "etab" => "etabtest"),
                array("id" => 3, "nom" => "perltmlet", "prenom" => "zerezrhi", "pui" => "puitest", "etab" => "etabtest"),
            )
        );
    }

    public function get($id)
    {

        $user = $this->em->find('Indicateur\Entity\Users', $id);

//        print_r($album->toArray());
//
        return new JsonModel(
            array("data" => $user->toArray())
        );
    }

    public function create($data)
    {
        $user = new Album();
//        $user->setArtist($data['artist']);
//        $user->setTitle($data['title']);

        $em->persist($user);
        $em->flush();

        return new JsonModel(array(
            'data' => $user->getId(),
        ));
    }

    public function update($id, $data)
    {
        $user = $em->find('Album\Model\Album', $id);
        $user->setArtist($data['artist']);
        $user->setTitle($data['title']);

        $user = $em->merge($user);
        $em->flush();

        return new JsonModel(array(
            'data' => $user->getId(),
        ));
    }

    public function delete($id)
    {
        $user = $em->find('Album\Model\Album', $id);
        $em->remove($user);
        $em->flush();

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if(null === $this->em)
        {
            $this->em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }

    public function toArray(){
        return get_object_vars($this);
    }

}

