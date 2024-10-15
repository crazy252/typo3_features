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
     * @var string
     */
    protected $feUsers = '';

    /**
     * @var string
     */
    protected $feGroups = '';

    /**
     * @var string
     */
    protected $beUsers = '';

    /**
     * @var string
     */
    protected $beGroups = '';

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

    /**
     * @return string
     */
    public function getFeUsers()
    {
        return $this->feUsers;
    }

    /**
     * @param string $feUsers
     */
    public function setFeUsers($feUsers)
    {
        $this->feUsers = $feUsers;
    }

    /**
     * @return string
     */
    public function getFeGroups()
    {
        return $this->feGroups;
    }

    /**
     * @param string $feGroups
     */
    public function setFeGroups($feGroups)
    {
        $this->feGroups = $feGroups;
    }

    /**
     * @return string
     */
    public function getBeUsers()
    {
        return $this->beUsers;
    }

    /**
     * @param string $beUsers
     */
    public function setBeUsers($beUsers)
    {
        $this->beUsers = $beUsers;
    }

    /**
     * @return string
     */
    public function getBeGroups()
    {
        return $this->beGroups;
    }

    /**
     * @param string $beGroups
     */
    public function setBeGroups($beGroups)
    {
        $this->beGroups = $beGroups;
    }
}
