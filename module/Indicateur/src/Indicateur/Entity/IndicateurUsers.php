<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * IndicateurUsers
 *
 * @ORM\Table(name="indicateur_users", indexes={@ORM\Index(name="fk_indicateur_has_users_users1", columns={"user_id"}), @ORM\Index(name="fk_indicateur_has_users_indicateur1", columns={"indicateur_id"}), @ORM\Index(name="fk_indicateur_users_PUI1", columns={"pui_id"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\IndicateurUsers")
 */
class IndicateurUsers
{

    const TYPE_ANNUEL  = 1;
    const TYPE_MENSUEL = 2;
    const TYPE_FILEAU  = 3;

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
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime $date
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;

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
     * Set type
     *
     * @param integer $type
     * @return IndicateurUsers
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return IndicateurUsers
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
     * Set actif
     *
     * @param boolean $actif
     * @return IndicateurUsers
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    
        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set indicateur
     *
     * @param \Indicateur\Entity\Indicateur $indicateur
     * @return IndicateurUsers
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
     * @return IndicateurUsers
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
     * @return IndicateurUsers
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
