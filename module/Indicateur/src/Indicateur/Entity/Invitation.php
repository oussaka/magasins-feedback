<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\Invitation")
 */
class Invitation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="invit_code_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $invitCodePk;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat = '1';

    /**
     * @var \Indicateur\Entity\Etabs
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Etabs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="et_code_fk", referencedColumnName="et_code_pk")
     * })
     */
    private $etabs;

     /**
     * @var \Indicateur\Entity\Pui
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Pui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pui_code_fk", referencedColumnName="pui_code_pk")
     * })
     */
    private $pui;

    /**
     * @var \DateTime
     *
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(name="date_create", type="datetime", nullable=true)
     */
    private $dateCreate;

    /**
     * @var integer
     *
     * @ORM\Column(name="profil", type="integer", nullable=true)
     */
    private $profil;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=32, nullable=true)
     */
    private $token;



    /**
     * Get invitCodePk
     *
     * @return integer 
     */
    public function getInvitCodePk()
    {
        return $this->invitCodePk;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Invitation
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Invitation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set etabs
     *
     * @param \Indicateur\Entity\Etabs  $etabs
     * @return Invitation
     */
    public function setEtabs($etabs)
    {
        $this->etabs = $etabs;
    
        return $this;
    }

    /**
     * Get etabs
     *
     * @return \Indicateur\Entity\Etabs 
     */
    public function getEtabs()
    {
        return $this->etabs;
    }

    /**
     * Set pui
     *
     * @param \Indicateur\Entity\Pui $pui
     * @return Invitation
     */
    public function setPui($pui)
    {
        $this->pui = $pui;
    
        return $this;
    }

    /**
     * Get puiCodeFk
     *
     * @return \Indicateur\Entity\Pui 
     */
    public function getPui()
    {
        return $this->pui;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Invitation
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    
        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set profil
     *
     * @param boolean $profil
     * @return Invitation
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;
    
        return $this;
    }

    /**
     * Get profil
     *
     * @return boolean 
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Invitation
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
}
