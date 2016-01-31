<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriqueIndicateurUsers
 *
 * @ORM\Table(name="historique_indicateur_users", indexes={@ORM\Index(name="fk_historique_indicateur_has_users_indicateur1", columns={"indicateur_id"}), @ORM\Index(name="fk_historique_indicateur_has_users_users1", columns={"user_id"}), @ORM\Index(name="fk_historique_indicateur_users_PUI1", columns={"pui_id"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\HistoriqueIndicateurUsers")
 */
class HistoriqueIndicateurUsers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer", nullable=false)
     */
    private $annee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \Indicateur\Entity\Indicateur
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Indicateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="indicateur_id", referencedColumnName="id")
     * })
     */
    private $indicateur;

    /**
     * @var \Indicateur\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_code_pk")
     * })
     */
    private $user;

    /**
     * @var \Indicateur\Entity\Pui
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Pui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pui_id", referencedColumnName="pui_code_pk")
     * })
     */
    private $pui;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return HistoriqueIndicateurUsers
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    
        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return HistoriqueIndicateurUsers
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set indicateur
     *
     * @param \Indicateur\Entity\Indicateur $indicateur
     * @return HistoriqueIndicateurUsers
     */
    public function setIndicateur(\Indicateur\Entity\Indicateur $indicateur = null)
    {
        $this->indicateur = $indicateur;
    
        return $this;
    }

    /**
     * Get indicateur
     *
     * @return \Indicateur\Entity\Indicateur 
     */
    public function getIndicateur()
    {
        return $this->indicateur;
    }

    /**
     * Set user
     *
     * @param \Indicateur\Entity\Users $user
     * @return HistoriqueIndicateurUsers
     */
    public function setUser(\Indicateur\Entity\Users $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Indicateur\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set pui
     *
     * @param \Indicateur\Entity\Pui $pui
     * @return HistoriqueIndicateurUsers
     */
    public function setPui(\Indicateur\Entity\Pui $pui = null)
    {
        $this->pui = $pui;
    
        return $this;
    }

    /**
     * Get pui
     *
     * @return \Indicateur\Entity\Pui 
     */
    public function getPui()
    {
        return $this->pui;
    }
}
