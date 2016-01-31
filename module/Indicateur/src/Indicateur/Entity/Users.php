<?php

namespace Indicateur\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="FK_pui_code_fk", columns={"pui_code_fk"}), @ORM\Index(name="FK2_et_code_fk", columns={"et_code_fk"})})
 * @ORM\Entity(repositoryClass="Indicateur\Entity\Repository\Users")
 */
class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_code_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userCodePk;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=150, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=150, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=false)
     */
    private $sexe = 'm';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="acces", type="integer", nullable=false)
     */
    private $acces = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_validation", type="datetime", nullable=true)
     */
    private $dateValidation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_bloc", type="datetime", nullable=true)
     */
    private $dateBloc;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=32, nullable=true)
     */
    private $token;

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
     * Get userCodePk
     *
     * @return integer 
     */
    public function getUserCodePk()
    {
        return $this->userCodePk;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Users
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Users
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Users
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Users
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
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
     * Set acces
     *
     * @param integer $acces
     * @return Users
     */
    public function setAcces($acces)
    {
        $this->acces = $acces;
    
        return $this;
    }

    /**
     * Get acces
     *
     * @return integer 
     */
    public function getAcces()
    {
        return $this->acces;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Users
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
     * Set dateValidation
     *
     * @param \DateTime $dateValidation
     * @return Users
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;
    
        return $this;
    }

    /**
     * Get dateValidation
     *
     * @return \DateTime 
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set dateBloc
     *
     * @param \DateTime $dateBloc
     * @return Users
     */
    public function setDateBloc($dateBloc)
    {
        $this->dateBloc = $dateBloc;
    
        return $this;
    }

    /**
     * Get dateBloc
     *
     * @return \DateTime 
     */
    public function getDateBloc()
    {
        return $this->dateBloc;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Users
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Users
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Users
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

    /**
     * Set etabs
     *
     * @param \Indicateur\Entity\Etabs $etabs
     * @return Users
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

    /**
     * Set pui
     *
     * @param \Indicateur\Entity\Pui $pui
     * @return Users
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
