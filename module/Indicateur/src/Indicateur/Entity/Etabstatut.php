<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etabstatut
 *
 * @ORM\Table(name="etabstatut")
 * @ORM\Entity
 */
class Etabstatut
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_statut", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStatut;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=45, nullable=true)
     */
    private $libelle;



    /**
     * Get idStatut
     *
     * @return integer 
     */
    public function getIdStatut()
    {
        return $this->idStatut;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Etabstatut
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
}
