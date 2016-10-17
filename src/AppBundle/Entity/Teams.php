<?php

namespace AppBundle\Entity;

/**
 * Teams
 */
class Teams
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $international_name;

    /**
     * @var string
     */
    private $international_description;

    /**
     * @var string
     */
    private $international_name_language = 'en';

    /**
     * @var integer
     */
    private $international_cascade = 0;

    /**
     * @var string
     */
    private $name_en;

    /**
     * @var string
     */
    private $description_en;

    /**
     * @var string
     */
    private $name_fr;

    /**
     * @var string
     */
    private $description_fr;

    /**
     * @var string
     */
    private $name_nl;

    /**
     * @var string
     */
    private $description_nl;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $TeamsMembers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $TeamsProjects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->TeamsMembers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->TeamsProjects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set internationalName
     *
     * @param string $internationalName
     *
     * @return Teams
     */
    public function setInternationalName($internationalName)
    {
        $this->international_name = $internationalName;

        return $this;
    }

    /**
     * Get internationalName
     *
     * @return string
     */
    public function getInternationalName()
    {
        return $this->international_name;
    }

    /**
     * Set internationalDescription
     *
     * @param string $internationalDescription
     *
     * @return Teams
     */
    public function setInternationalDescription($internationalDescription)
    {
        $this->international_description = $internationalDescription;

        return $this;
    }

    /**
     * Get internationalDescription
     *
     * @return string
     */
    public function getInternationalDescription()
    {
        return $this->international_description;
    }

    /**
     * Set internationalNameLanguage
     *
     * @param string $internationalNameLanguage
     *
     * @return Teams
     */
    public function setInternationalNameLanguage($internationalNameLanguage)
    {
        $this->international_name_language = $internationalNameLanguage;

        return $this;
    }

    /**
     * Get internationalNameLanguage
     *
     * @return string
     */
    public function getInternationalNameLanguage()
    {
        return $this->international_name_language;
    }

    /**
     * Set internationalCascade
     *
     * @param boolean $internationalCascade
     *
     * @return Teams
     */
    public function setInternationalCascade($internationalCascade)
    {
        $this->international_cascade = $internationalCascade;

        return $this;
    }

    /**
     * Get internationalCascade
     *
     * @return boolean
     */
    public function getInternationalCascade()
    {
        return $this->international_cascade;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Teams
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
     * Set descriptionEn
     *
     * @param string $descriptionEn
     *
     * @return Teams
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->description_en = $descriptionEn;

        return $this;
    }

    /**
     * Get descriptionEn
     *
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->description_en;
    }

    /**
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return Teams
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
     * Set descriptionFr
     *
     * @param string $descriptionFr
     *
     * @return Teams
     */
    public function setDescriptionFr($descriptionFr)
    {
        $this->description_fr = $descriptionFr;

        return $this;
    }

    /**
     * Get descriptionFr
     *
     * @return string
     */
    public function getDescriptionFr()
    {
        return $this->description_fr;
    }

    /**
     * Set nameNl
     *
     * @param string $nameNl
     *
     * @return Teams
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
     * Set descriptionNl
     *
     * @param string $descriptionNl
     *
     * @return Teams
     */
    public function setDescriptionNl($descriptionNl)
    {
        $this->description_nl = $descriptionNl;

        return $this;
    }

    /**
     * Get descriptionNl
     *
     * @return string
     */
    public function getDescriptionNl()
    {
        return $this->description_nl;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Teams
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Teams
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Add teamsMember
     *
     * @param \AppBundle\Entity\TeamsMembers $teamsMember
     *
     * @return Teams
     */
    public function addTeamsMember(\AppBundle\Entity\TeamsMembers $teamsMember)
    {
        $this->TeamsMembers[] = $teamsMember;

        return $this;
    }

    /**
     * Remove teamsMember
     *
     * @param \AppBundle\Entity\TeamsMembers $teamsMember
     */
    public function removeTeamsMember(\AppBundle\Entity\TeamsMembers $teamsMember)
    {
        $this->TeamsMembers->removeElement($teamsMember);
    }

    /**
     * Get teamsMembers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamsMembers()
    {
        return $this->TeamsMembers;
    }

    /**
     * Add teamsProject
     *
     * @param \AppBundle\Entity\TeamsProjects $teamsProject
     *
     * @return Teams
     */
    public function addTeamsProject(\AppBundle\Entity\TeamsProjects $teamsProject)
    {
        $this->TeamsProjects[] = $teamsProject;

        return $this;
    }

    /**
     * Remove teamsProject
     *
     * @param \AppBundle\Entity\TeamsProjects $teamsProject
     */
    public function removeTeamsProject(\AppBundle\Entity\TeamsProjects $teamsProject)
    {
        $this->TeamsProjects->removeElement($teamsProject);
    }

    /**
     * Get teamsProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamsProjects()
    {
        return $this->TeamsProjects;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $DepartmentsTeams;


    /**
     * Add departmentsTeam
     *
     * @param \AppBundle\Entity\DepartmentsTeams $departmentsTeam
     *
     * @return Teams
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
}
