<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pui
 *
 * @ORM\Table(name="pui", indexes={@ORM\Index(name="et_code_fk", columns={"et_code_fk"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\Pui")
 * @ORM\HasLifecycleCallbacks()
 */
class Pui
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pui_code_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $puiCodePk;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=45, nullable=true)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="nblits", type="smallint", nullable=true)
     */
    private $nblits;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=true)
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="datetime", nullable=true)
     */
    private $dateUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="block_yn", type="boolean", nullable=true)
     */
    private $blockYn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="block_date", type="datetime", nullable=true)
     */
    private $blockDate;

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
     * Get puiCodePk
     *
     * @return integer 
     */
    public function getPuiCodePk()
    {
        return $this->puiCodePk;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Pui
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
    
    /**
     * Set NbLits
     *
     * @param integer $nblits
     * @return Pui
     */
    public function setNblits($nblits)
    {
    	$this->nblits = $nblits;
    
    	return $this;
    }
    
    /**
     * Get NbLits
     *
     * @return integer
     */
    public function getNblits()
    {
    	return $this->nblits;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Pui
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
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return Pui
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    
        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set blockYn
     *
     * @param boolean $blockYn
     * @return Pui
     */
    public function setBlockYn($blockYn)
    {
        $this->blockYn = $blockYn;
    
        return $this;
    }

    /**
     * Get blockYn
     *
     * @return boolean 
     */
    public function getBlockYn()
    {
        return $this->blockYn;
    }

    /**
     * Set blockDate
     *
     * @param \DateTime $blockDate
     * @return Pui
     */
    public function setBlockDate($blockDate)
    {
        $this->blockDate = $blockDate;
    
        return $this;
    }

    /**
     * Get blockDate
     *
     * @return \DateTime 
     */
    public function getBlockDate()
    {
        return $this->blockDate;
    }

    /**
     * Set etabs
     *
     * @param \Indicateur\Entity\Etabs $etabs
     * @return Pui
     */
    public function setEtabs(\Indicateur\Entity\Etabs $etabs = null)
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
}
