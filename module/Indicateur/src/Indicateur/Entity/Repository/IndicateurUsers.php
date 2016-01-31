<?php

namespace Indicateur\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class IndicateurUsers extends EntityRepository
{

    /**
     * Counts how many users there are in the database
     *
     * @return int
     */
    public function count()
    {
    }


    /**
     * retrieve list of indicateur by userId
     *
     * @param int $userId
     * @return array
     */
    public function findByUser($userId)
    {

        /* $query = $this->_em->createQuery("SELECT ind FROM Indicateur\Entity\Indicateur ind");
        $result = $query->getArrayResult(Query::HYDRATE_ARRAY);
        //var_dump($result);
        return $result;
        */

        // TODO : un massacre pour le SGBD et les performances : voir le SELECT EXPLAIN
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array(
                'ind',
                'induser',
                'chap',
                'user'
            ))
            // $dql->select(array('ind.id', 'ind.titre', 'chap.id'))
            ->from('Indicateur\Entity\Indicateur', 'ind')
            ->leftJoin('Indicateur\Entity\IndicateurUsers', 'induser', Query\Expr\Join::LEFT_JOIN, 'ind.id = induser.indicateur AND induser.user = ?1')

            ->leftJoin('ind.chapitre', 'chap')
            ->leftJoin('induser.user', 'user')
            ->addOrderBy(new Query\Expr\OrderBy('ind.id', 'ASC'))
            ->addOrderBy(new Query\Expr\OrderBy('chap.id', 'ASC'))
            // $qb = $this->whereCurrentYear($qb);
            ->setParameter(1, $userId);
        // ->setMaxResults(20);

        /*
         * getArrayResult()
         * Exécute la requête et retourne un tableau contenant les résultats sous forme de tableaux.
         * Comme avec getResult(), vous récupérez un tableau même s'il n'y a qu'un seul résultat.
         * Mais dans ce tableau, vous n'avez pas vos objets d'origine, vous avez des simples tableaux.
         * Cette méthode est utilisée lorsque vous ne voulez que lire vos résultats, sans y apporter de modification.
         * Elle est dans ce cas plus rapide que son homologue getResult().
         */
        // $result = $dql->getQuery()->getResult(Query::HYDRATE_ARRAY); // getArrayResult(Query::HYDRATE_ARRAY);
        $result = $qb->getQuery()->getArrayResult();
        // TODO : cherche solution pour ce vicieux problème !
        $resultTransform = array();
        for($index = 0 ; $index < count($result); $index++) {
            $resultTransform[] = array_merge(array("indicateur" => $result[$index]), empty($result[$index+1])? array() :$result[$index+1]);
            $index++;
        }

        return $resultTransform;
    }

    public function getUsersByIndicId($indicId, $etabId = null, $puiId = null) {

        /* $dql = $this->_em->createNativeQuery("SELECT  user_code_pk, nom, prenom, sexe, et_code_fk, pui_code_fk, type_ref, id, indicateur_id
FROM users LEFT JOIN indicateur_users AS ind_usr ON(ind_usr.user_id = users.user_code_pk)
WHERE users.et_code_fk = 1 AND ind_usr.indicateur_id = 1 OR ind_usr.indicateur_id IS NULL");
*/
/*         $dql = $this->_em->createQuery("
            SELECT u
            FROM Indicateur\Entity\IndicateurUsers iu
            JOIN  iu.Users u
        ");
*/

        /* $qb->innerJoin('You\YourBundle\Entity\Goal', 'g', Expr\Join::WITH, 's.id = g.session')
            ->where('g.name = :goalName')->andWhere('s.gsiteId = :gsiteId')
            ->setParameter('goalName', 'Background Dx')->setParameter('gsiteId', '66361836');
        */
//        $result = $dql->getResult();
//        return $result;
        /** @var $qb \Doctrine\ORM\QueryBuilder */
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array(  // 'ind',
                            'iu as indic',
                            'p.libelle as pui',
                            'p.puiCodePk',
                            'u.userCodePk', 'u.nom', 'u.prenom', 'u.sexe', 'u.login', 'u.email', 'u.dateCreated'
                    ))
            ->from('Indicateur\Entity\Users', 'u')
            ->leftjoin('Indicateur\Entity\IndicateurUsers', 'iu', Query\Expr\Join::WITH, 'iu.user = u.userCodePk AND iu.indicateur = ?1')
            ->leftJoin('iu.indicateur', 'i')
            ->leftJoin('u.pui', 'p')
            ->leftJoin('u.etabs', 'e')
            ->orderBy(new Query\Expr\OrderBy('p.puiCodePk', 'ASC'))
            // ->where("i.id = ?1 OR iu.id IS NULL")
            // ->andWhere("e.etCodePk = ?2")
            ->where("e.etCodePk = ?2")
            ->andWhere("u.acces != 4")
            ->setParameters(array( 1 => $indicId,
                                   2 => $etabId,
                                ));

            if (!empty($puiId)) {
                $qb->andWhere("p.puiCodePk = :puiId")
                   ->setParameter("puiId", $puiId);
            }
        // echo $qb->getQuery()->getSQL();
        $resutl = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

        return $resutl;

    }

    public function whereCurrentYear(\Doctrine\ORM\QueryBuilder $qb)
    {
        $qb->andWhere('a.date BETWEEN :debut AND :fin')
            ->setParameter('debut', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année
            ->setParameter('fin',   new \Datetime(date('Y').'-12-31')); // Et le 31 décembre de cette année

        return $qb;
    }

}