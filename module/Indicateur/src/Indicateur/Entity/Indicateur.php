<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicateur
 *
 * @ORM\Table(name="indicateur", indexes={@ORM\Index(name="fk_indicateur_chapitre1", columns={"chapitre_id"}), @ORM\Index(name="fk_indicateur_qualification1", columns={"qualification_id"}), @ORM\Index(name="fk_indicateur_domaine1", columns={"domaine_id"}), @ORM\Index(name="fk_indicateur_priorite1", columns={"priorite_id"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\Indicateur")
 */
class Indicateur
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
     * @var boolean
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="text", nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="inclut_y", type="text", nullable=true)
     */
    private $inclutY;

    /**
     * @var string
     *
     * @ORM\Column(name="inclut_n", type="text", nullable=true)
     */
    private $inclutN;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="tache", type="text", nullable=true)
     */
    private $tache;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=1, nullable=true)
     */
    private $categorie;

    /**
     * @var \Indicateur\Entity\Chapitre
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Chapitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chapitre_id", referencedColumnName="id")
     * })
     */
    private $chapitre;

    /**
     * @var \Indicateur\Entity\Domaine
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Domaine")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domaine_id", referencedColumnName="id")
     * })
     */
    private $domaine;

    /**
     * @var \Indicateur\Entity\Priorite
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Priorite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="priorite_id", referencedColumnName="id")
     * })
     */
    private $priorite;

    /**
     * @var \Indicateur\Entity\Qualification
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Qualification")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qualification_id", referencedColumnName="id")
     * })
     */
    private $qualification;



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
     * @param boolean $type
     * @return Indicateur
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Indicateur
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set inclutY
     *
     * @param string $inclutY
     * @return Indicateur
     */
    public function setInclutY($inclutY)
    {
        $this->inclutY = $inclutY;
    
        return $this;
    }

    /**
     * Get inclutY
     *
     * @return string 
     */
    public function getInclutY()
    {
        return $this->inclutY;
    }

    /**
     * Set inclutN
     *
     * @param string $inclutN
     * @return Indicateur
     */
    public function setInclutN($inclutN)
    {
        $this->inclutN = $inclutN;
    
        return $this;
    }

    /**
     * Get inclutN
     *
     * @return string 
     */
    public function getInclutN()
    {
        return $this->inclutN;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Indicateur
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    
        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set tache
     *
     * @param string $tache
     * @return Indicateur
     */
    public function setTache($tache)
    {
        $this->tache = $tache;
    
        return $this;
    }

    /**
     * Get tache
     *
     * @return string 
     */
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return Indicateur
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set chapitre
     *
     * @param \Indicateur\Entity\Chapitre $chapitre
     * @return Indicateur
     */
    public function setChapitre(\Indicateur\Entity\Chapitre $chapitre = null)
    {
        $this->chapitre = $chapitre;
    
        return $this;
    }

    /**
     * Get chapitre
     *
     * @return \Indicateur\Entity\Chapitre 
     */
    public function getChapitre()
    {
        return $this->chapitre;
    }

    /**
     * Set domaine
     *
     * @param \Indicateur\Entity\Domaine $domaine
     * @return Indicateur
     */
    public function setDomaine(\Indicateur\Entity\Domaine $domaine = null)
    {
        $this->domaine = $domaine;
    
        return $this;
    }

    /**
     * Get domaine
     *
     * @return \Indicateur\Entity\Domaine 
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set priorite
     *
     * @param \Indicateur\Entity\Priorite $priorite
     * @return Indicateur
     */
    public function setPriorite(\Indicateur\Entity\Priorite $priorite = null)
    {
        $this->priorite = $priorite;
    
        return $this;
    }

    /**
     * Get priorite
     *
     * @return \Indicateur\Entity\Priorite 
     */
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * Set qualification
     *
     * @param \Indicateur\Entity\Qualification $qualification
     * @return Indicateur
     */
    public function setQualification(\Indicateur\Entity\Qualification $qualification = null)
    {
        $this->qualification = $qualification;
    
        return $this;
    }

    /**
     * Get qualification
     *
     * @return \Indicateur\Entity\Qualification 
     */
    public function getQualification()
    {
        return $this->qualification;
    }
}
