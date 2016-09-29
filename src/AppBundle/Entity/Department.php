<?php

namespace AppBundle\Entity;

/**
 * Department
 */
class Department
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $level;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name_fr;

    /**
     * @var string
     */
    private $name_en;

    /**
     * @var string
     */
    private $name_nl;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $WorkingDuty;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->WorkingDuty = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set level
     *
     * @param string $level
     *
     * @return Department
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Department
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return Department
     */
    public function setNameFr($nameFr)
    {
        $this->name_fr = $nameFr;

        return $this;
    }

    /**
     * Get nameFr
     *
     * @return string
     */
    public function getNameFr()
    {
        return $this->name_fr;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Department
     */
    public function setNameEn($nameEn)
    {
        $this->name_en = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * Set nameNl
     *
     * @param string $nameNl
     *
     * @return Department
     */
    public function setNameNl($nameNl)
    {
        $this->name_nl = $nameNl;

        return $this;
    }

    /**
     * Get nameNl
     *
     * @return string
     */
    public function getNameNl()
    {
        return $this->name_nl;
    }

    /**
     * Add workingDuty
     *
     * @param \AppBundle\Entity\WorkingDuty $workingDuty
     *
     * @return Department
     */
    public function addWorkingDuty(\AppBundle\Entity\WorkingDuty $workingDuty)
    {
        $this->WorkingDuty[] = $workingDuty;

        return $this;
    }

    /**
     * Remove workingDuty
     *
     * @param \AppBundle\Entity\WorkingDuty $workingDuty
     */
    public function removeWorkingDuty(\AppBundle\Entity\WorkingDuty $workingDuty)
    {
        $this->WorkingDuty->removeElement($workingDuty);
    }

    /**
     * Get workingDuty
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkingDuty()
    {
        return $this->WorkingDuty;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $DepartmentsProjects;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $DepartmentsTeams;


    /**
     * Add departmentsProject
     *
     * @param \AppBundle\Entity\DepartmentsProjects $departmentsProject
     *
     * @return Department
     */
    public function addDepartmentsProject(\AppBundle\Entity\DepartmentsProjects $departmentsProject)
    {
        $this->DepartmentsProjects[] = $departmentsProject;

        return $this;
    }

    /**
     * Remove departmentsProject
     *
     * @param \AppBundle\Entity\DepartmentsProjects $departmentsProject
     */
    public function removeDepartmentsProject(\AppBundle\Entity\DepartmentsProjects $departmentsProject)
    {
        $this->DepartmentsProjects->removeElement($departmentsProject);
    }

    /**
     * Get departmentsProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartmentsProjects()
    {
        return $this->DepartmentsProjects;
    }

    /**
     * Add departmentsTeam
     *
     * @param \AppBundle\Entity\DepartmentsTeams $departmentsTeam
     *
     * @return Department
     */
    public function addDepartmentsTeam(\AppBundle\Entity\DepartmentsTeams $departmentsTeam)
    {
        $this->DepartmentsTeams[] = $departmentsTeam;

        return $this;
    }

    /**
     * Remove departmentsTeam
     *
     * @param \AppBundle\Entity\DepartmentsTeams $departmentsTeam
     */
    public function removeDepartmentsTeam(\AppBundle\Entity\DepartmentsTeams $departmentsTeam)
    {
        $this->DepartmentsTeams->removeElement($departmentsTeam);
    }

    /**
     * Get departmentsTeams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartmentsTeams()
    {
        return $this->DepartmentsTeams;
    }
    /**
     * @var boolean
     */
    private $is_active = true;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Children;

    /**
     * @var \AppBundle\Entity\Department
     */
    private $Parent;


    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Department
     */
    public function setActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Department $child
     *
     * @return Department
     */
    public function addChild(\AppBundle\Entity\Department $child)
    {
        $this->Children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Department $child
     */
    public function removeChild(\AppBundle\Entity\Department $child)
    {
        $this->Children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->Children;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Department $parent
     *
     * @return Department
     */
    public function setParent(\AppBundle\Entity\Department $parent = null)
    {
        $this->Parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Department
     */
    public function getParent()
    {
        return $this->Parent;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Department
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
    /**
     * @var string
     */
    private $code;


    /**
     * Set code
     *
     * @param string $code
     *
     * @return Department
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
