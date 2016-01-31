<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etabs
 *
 * @ORM\Table(name="etabs", indexes={@ORM\Index(name="fk_etabs_Categorie", columns={"ca_code_fk"}), @ORM\Index(name="fk_etabs_etabstatut", columns={"et_statut"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\Etabs")
 */
class Etabs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="et_code_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $etCodePk;

    /**
     * @var string
     *
     * @ORM\Column(name="et_libelle", type="string", length=45, nullable=false)
     */
    private $etLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="et_rue", type="string", length=45, nullable=false)
     */
    private $etRue;

    /**
     * @var string
     *
     * @ORM\Column(name="et_cp", type="string", length=45, nullable=true)
     */
    private $etCp;

    /**
     * @var string
     *
     * @ORM\Column(name="et_ville", type="string", length=45, nullable=true)
     */
    private $etVille;

    /**
     * @var boolean
     *
     * @ORM\Column(name="et_type", type="boolean", nullable=false)
     */
    private $etType;

    /**
     * @var string
     *
     * @ORM\Column(name="et_type_autre", type="string", length=45, nullable=true)
     */
    private $etTypeAutre;

    /**
     * @var integer
     *
     * @ORM\Column(name="et_nblits", type="smallint", nullable=true)
     */
    private $etNblits;

    /**
     * @var integer
     *
     * @ORM\Column(name="et_intergration", type="smallint", nullable=true)
     */
    private $etIntergration;

    /**
     * @var integer
     *
     * @ORM\Column(name="et_badspace", type="smallint", nullable=true)
     */
    private $etBadspace;

    /**
     * @var string
     *
     * @ORM\Column(name="et_pays", type="string", length=45, nullable=false)
     */
    private $etPays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="et_creation", type="datetime", nullable=false)
     */
    private $etCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="et_maj", type="datetime", nullable=false)
     */
    private $etMaj;

    /**
     * @var \Indicateur\Entity\Categorie
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ca_code_fk", referencedColumnName="ca_code_pk")
     * })
     */
    private $caCodeFk;

    /**
     * @var \Indicateur\Entity\Etabstatut
     *
     * @ORM\ManyToOne(targetEntity="Indicateur\Entity\Etabstatut")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="et_statut", referencedColumnName="id_statut")
     * })
     */
    private $etStatut;



    /**
     * Get etCodePk
     *
     * @return integer 
     */
    public function getEtCodePk()
    {
        return $this->etCodePk;
    }

    /**
     * Set etLibelle
     *
     * @param string $etLibelle
     * @return Etabs
     */
    public function setEtLibelle($etLibelle)
    {
        $this->etLibelle = $etLibelle;
    
        return $this;
    }

    /**
     * Get etLibelle
     *
     * @return string 
     */
    public function getEtLibelle()
    {
        return $this->etLibelle;
    }

    /**
     * Set etRue
     *
     * @param string $etRue
     * @return Etabs
     */
    public function setEtRue($etRue)
    {
        $this->etRue = $etRue;
    
        return $this;
    }

    /**
     * Get etRue
     *
     * @return string 
     */
    public function getEtRue()
    {
        return $this->etRue;
    }

    /**
     * Set etCp
     *
     * @param string $etCp
     * @return Etabs
     */
    public function setEtCp($etCp)
    {
        $this->etCp = $etCp;
    
        return $this;
    }

    /**
     * Get etCp
     *
     * @return string 
     */
    public function getEtCp()
    {
        return $this->etCp;
    }

    /**
     * Set etVille
     *
     * @param string $etVille
     * @return Etabs
     */
    public function setEtVille($etVille)
    {
        $this->etVille = $etVille;
    
        return $this;
    }

    /**
     * Get etVille
     *
     * @return string 
     */
    public function getEtVille()
    {
        return $this->etVille;
    }

    /**
     * Set etType
     *
     * @param boolean $etType
     * @return Etabs
     */
    public function setEtType($etType)
    {
        $this->etType = $etType;
    
        return $this;
    }

    /**
     * Get etType
     *
     * @return boolean 
     */
    public function getEtType()
    {
        return $this->etType;
    }

    /**
     * Set etTypeAutre
     *
     * @param string $etTypeAutre
     * @return Etabs
     */
    public function setEtTypeAutre($etTypeAutre)
    {
        $this->etTypeAutre = $etTypeAutre;
    
        return $this;
    }

    /**
     * Get etTypeAutre
     *
     * @return string 
     */
    public function getEtTypeAutre()
    {
        return $this->etTypeAutre;
    }

    /**
     * Set etNblits
     *
     * @param integer $etNblits
     * @return Etabs
     */
    public function setEtNblits($etNblits)
    {
        $this->etNblits = $etNblits;
    
        return $this;
    }

    /**
     * Get etNblits
     *
     * @return integer 
     */
    public function getEtNblits()
    {
        return $this->etNblits;
    }

    /**
     * Set etIntergration
     *
     * @param integer $etIntergration
     * @return Etabs
     */
    public function setEtIntergration($etIntergration)
    {
        $this->etIntergration = $etIntergration;
    
        return $this;
    }

    /**
     * Get etIntergration
     *
     * @return integer 
     */
    public function getEtIntergration()
    {
        return $this->etIntergration;
    }

    /**
     * Set etBadspace
     *
     * @param integer $etBadspace
     * @return Etabs
     */
    public function setEtBadspace($etBadspace)
    {
        $this->etBadspace = $etBadspace;
    
        return $this;
    }

    /**
     * Get etBadspace
     *
     * @return integer 
     */
    public function getEtBadspace()
    {
        return $this->etBadspace;
    }

    /**
     * Set etPays
     *
     * @param string $etPays
     * @return Etabs
     */
    public function setEtPays($etPays)
    {
        $this->etPays = $etPays;
    
        return $this;
    }

    /**
     * Get etPays
     *
     * @return string 
     */
    public function getEtPays()
    {
        return $this->etPays;
    }

    /**
     * Set etCreation
     *
     * @param \DateTime $etCreation
     * @return Etabs
     */
    public function setEtCreation($etCreation)
    {
        $this->etCreation = $etCreation;
    
        return $this;
    }

    /**
     * Get etCreation
     *
     * @return \DateTime 
     */
    public function getEtCreation()
    {
        return $this->etCreation;
    }

    /**
     * Set etMaj
     *
     * @param \DateTime $etMaj
     * @return Etabs
     */
    public function setEtMaj($etMaj)
    {
        $this->etMaj = $etMaj;
    
        return $this;
    }

    /**
     * Get etMaj
     *
     * @return \DateTime 
     */
    public function getEtMaj()
    {
        return $this->etMaj;
    }

    /**
     * Set caCodeFk
     *
     * @param \Indicateur\Entity\Categorie $caCodeFk
     * @return Etabs
     */
    public function setCaCodeFk(\Indicateur\Entity\Categorie $caCodeFk = null)
    {
        $this->caCodeFk = $caCodeFk;
    
        return $this;
    }

    /**
     * Get caCodeFk
     *
     * @return \Indicateur\Entity\Categorie 
     */
    public function getCaCodeFk()
    {
        return $this->caCodeFk;
    }

    /**
     * Set etStatut
     *
     * @param \Indicateur\Entity\Etabstatut $etStatut
     * @return Etabs
     */
    public function setEtStatut(\Indicateur\Entity\Etabstatut $etStatut = null)
    {
        $this->etStatut = $etStatut;
    
        return $this;
    }

    /**
     * Get etStatut
     *
     * @return \Indicateur\Entity\Etabstatut 
     */
    public function getEtStatut()
    {
        return $this->etStatut;
    }
}
