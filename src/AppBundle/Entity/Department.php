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
}
