<?php

namespace AppBundle\Entity;

/**
 * ProjectsMembers
 */
class ProjectsMembers
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var \AppBundle\Entity\Person
     */
    private $Person;

    /**
     * @var \AppBundle\Entity\Projects
     */
    private $Project;


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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return ProjectsMembers
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
     * @return ProjectsMembers
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
     * Set comment
     *
     * @param string $comment
     *
     * @return ProjectsMembers
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return ProjectsMembers
     */
    public function setPerson(\AppBundle\Entity\Person $person = null)
    {
        $this->Person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AppBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->Person;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Projects $project
     *
     * @return ProjectsMembers
     */
    public function setProject(\AppBundle\Entity\Projects $project = null)
    {
        $this->Project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Projects
     */
    public function getProject()
    {
        return $this->Project;
    }
    /**
     * @var \AppBundle\Entity\Projects
     */
    private $Projects;


    /**
     * Set projects
     *
     * @param \AppBundle\Entity\Projects $projects
     *
     * @return ProjectsMembers
     */
    public function setProjects(\AppBundle\Entity\Projects $projects = null)
    {
        $this->Projects = $projects;

        return $this;
    }

    /**
     * Get projects
     *
     * @return \AppBundle\Entity\Projects
     */
    public function getProjects()
    {
        return $this->Projects;
    }
}
