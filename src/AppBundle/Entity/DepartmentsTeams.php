<?php

namespace AppBundle\Entity;

/**
 * DepartmentsTeams
 */
class DepartmentsTeams
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
     * @var \AppBundle\Entity\Department
     */
    private $Person;

    /**
     * @var \AppBundle\Entity\Teams
     */
    private $Projects;


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
     * @return DepartmentsTeams
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
     * @return DepartmentsTeams
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
     * @return DepartmentsTeams
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
     * @param \AppBundle\Entity\Department $person
     *
     * @return DepartmentsTeams
     */
    public function setPerson(\AppBundle\Entity\Department $person)
    {
        $this->Person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AppBundle\Entity\Department
     */
    public function getPerson()
    {
        return $this->Person;
    }

    /**
     * Set projects
     *
     * @param \AppBundle\Entity\Teams $projects
     *
     * @return DepartmentsTeams
     */
    public function setProjects(\AppBundle\Entity\Teams $projects)
    {
        $this->Projects = $projects;

        return $this;
    }

    /**
     * Get projects
     *
     * @return \AppBundle\Entity\Teams
     */
    public function getProjects()
    {
        return $this->Projects;
    }
}

