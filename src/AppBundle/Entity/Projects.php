<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Projects
 */
class Projects
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $international_name;

    /**
     * @var string
     */
    private $international_description;

    /**
     * @var string
     * @Assert\Choice(callback={"AppBundle\Validator\Generic", "getAllowedLanguages"}, message="app.form.teamsAndProjects.edit.validation.internationalNameLanguage.choice")
     */
    private $international_name_language = 'en';

    /**
     * @var integer
     * @Assert\Choice(callback={"AppBundle\Validator\Generic", "getAllowedIntNameCascade"}, message="app.form.teamsAndProjects.edit.validation.internationalNameCascade.choice")
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
    private $ProjectsMembers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $TeamsProjects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ProjectsMembers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * @return Projects
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
     * Add projectsMember
     *
     * @param \AppBundle\Entity\ProjectsMembers $projectsMember
     *
     * @return Projects
     */
    public function addProjectsMember(\AppBundle\Entity\ProjectsMembers $projectsMember)
    {
        $this->ProjectsMembers[] = $projectsMember;

        return $this;
    }

    /**
     * Remove projectsMember
     *
     * @param \AppBundle\Entity\ProjectsMembers $projectsMember
     */
    public function removeProjectsMember(\AppBundle\Entity\ProjectsMembers $projectsMember)
    {
        $this->ProjectsMembers->removeElement($projectsMember);
    }

    /**
     * Get projectsMembers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectsMembers()
    {
        return $this->ProjectsMembers;
    }

    /**
     * Add teamsProject
     *
     * @param \AppBundle\Entity\TeamsProjects $teamsProject
     *
     * @return Projects
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
    private $DepartmentsProjects;


    /**
     * Add departmentsProject
     *
     * @param \AppBundle\Entity\DepartmentsProjects $departmentsProject
     *
     * @return Projects
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
}
