<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score", indexes={@ORM\Index(name="FK_ind_code_fk", columns={"ind_code_fk"}), @ORM\Index(name="FK_user_code_fk", columns={"user_code_fk"}), @ORM\Index(name="FK_pui_code_fk", columns={"pui_code_fk"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\Score")
 */
class Score
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
     * @var integer
     *
     * @ORM\Column(name="mois", type="integer", nullable=true)
     */
    private $mois;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="valeur", type="integer", nullable=true)
     */
    private $valeur;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @var \Indicateur\Entity\Indicateur
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Indicateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ind_code_fk", referencedColumnName="id", nullable=false)
     * })
     */
    private $indicateur;

    /**
     * @var \Indicateur\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_code_fk", referencedColumnName="user_code_pk", nullable=false)
     * })
     */
    private $user;

    /**
     * @var \Indicateur\Entity\Pui
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Pui")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pui_code_fk", referencedColumnName="pui_code_pk", nullable=false)
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
     * @return Score
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
     * Set mois
     *
     * @param integer $mois
     * @return Score
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    
        return $this;
    }

    /**
     * Get mois
     *
     * @return integer 
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Score
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
     * Set valeur
     *
     * @param integer $valeur
     * @return Score
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    
        return $this;
    }

    /**
     * Get valeur
     *
     * @return integer 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Score
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    
        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set indicateur
     *
     * @param \Indicateur\Entity\Indicateur $indicateur
     * @return Score
     */
    public function setIndicateur(\Indicateur\Entity\Indicateur $indicateur)
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
     * @return Score
     */
    public function setUser(\Indicateur\Entity\Users $user)
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
     * @return Score
     */
    public function setPui(\Indicateur\Entity\Pui $pui)
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
