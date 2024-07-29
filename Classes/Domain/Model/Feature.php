<?php

namespace Crazy252\Typo3Features\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Feature extends AbstractEntity
{
    /**
     * @var string
     */
    protected $key = '';
    
    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * @var string
     */
    protected $description = '';
    
    /**
     * @var string
     */
    protected $classString = '';

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getClassString()
    {
        return $this->classString;
    }

    /**
     * @param string $classString
     */
    public function setClassString($classString)
    {
        $this->classString = $classString;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
