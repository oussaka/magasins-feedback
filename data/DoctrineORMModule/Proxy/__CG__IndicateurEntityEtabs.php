<?php

namespace DoctrineORMModule\Proxy\__CG__\Indicateur\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Etabs extends \Indicateur\Entity\Etabs implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etCodePk', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etLibelle', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etRue', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etCp', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etVille', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etType', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etTypeAutre', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etNblits', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etIntergration', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etBadspace', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etPays', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etCreation', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etMaj', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'caCodeFk', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etStatut');
        }

        return array('__isInitialized__', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etCodePk', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etLibelle', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etRue', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etCp', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etVille', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etType', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etTypeAutre', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etNblits', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etIntergration', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etBadspace', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etPays', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etCreation', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etMaj', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'caCodeFk', '' . "\0" . 'Indicateur\\Entity\\Etabs' . "\0" . 'etStatut');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Etabs $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getEtCodePk()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEtCodePk();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtCodePk', array());

        return parent::getEtCodePk();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtLibelle($etLibelle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtLibelle', array($etLibelle));

        return parent::setEtLibelle($etLibelle);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtLibelle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtLibelle', array());

        return parent::getEtLibelle();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtRue($etRue)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtRue', array($etRue));

        return parent::setEtRue($etRue);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtRue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtRue', array());

        return parent::getEtRue();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtCp($etCp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtCp', array($etCp));

        return parent::setEtCp($etCp);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtCp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtCp', array());

        return parent::getEtCp();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtVille($etVille)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtVille', array($etVille));

        return parent::setEtVille($etVille);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtVille()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtVille', array());

        return parent::getEtVille();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtType($etType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtType', array($etType));

        return parent::setEtType($etType);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtType', array());

        return parent::getEtType();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtTypeAutre($etTypeAutre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtTypeAutre', array($etTypeAutre));

        return parent::setEtTypeAutre($etTypeAutre);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtTypeAutre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtTypeAutre', array());

        return parent::getEtTypeAutre();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtNblits($etNblits)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtNblits', array($etNblits));

        return parent::setEtNblits($etNblits);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtNblits()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtNblits', array());

        return parent::getEtNblits();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtIntergration($etIntergration)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtIntergration', array($etIntergration));

        return parent::setEtIntergration($etIntergration);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtIntergration()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtIntergration', array());

        return parent::getEtIntergration();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtBadspace($etBadspace)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtBadspace', array($etBadspace));

        return parent::setEtBadspace($etBadspace);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtBadspace()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtBadspace', array());

        return parent::getEtBadspace();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtPays($etPays)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtPays', array($etPays));

        return parent::setEtPays($etPays);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtPays()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtPays', array());

        return parent::getEtPays();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtCreation($etCreation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtCreation', array($etCreation));

        return parent::setEtCreation($etCreation);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtCreation()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtCreation', array());

        return parent::getEtCreation();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtMaj($etMaj)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtMaj', array($etMaj));

        return parent::setEtMaj($etMaj);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtMaj()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtMaj', array());

        return parent::getEtMaj();
    }

    /**
     * {@inheritDoc}
     */
    public function setCaCodeFk(\Indicateur\Entity\Categorie $caCodeFk = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCaCodeFk', array($caCodeFk));

        return parent::setCaCodeFk($caCodeFk);
    }

    /**
     * {@inheritDoc}
     */
    public function getCaCodeFk()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCaCodeFk', array());

        return parent::getCaCodeFk();
    }

    /**
     * {@inheritDoc}
     */
    public function setEtStatut(\Indicateur\Entity\Etabstatut $etStatut = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEtStatut', array($etStatut));

        return parent::setEtStatut($etStatut);
    }

    /**
     * {@inheritDoc}
     */
    public function getEtStatut()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEtStatut', array());

        return parent::getEtStatut();
    }

}
