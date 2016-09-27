<?php

namespace AppBundle\Entity;

/**
 * DepartmentsProjects
 */
class DepartmentsProjects
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
    private $Department;

    /**
     * @var \AppBundle\Entity\Projects
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
     * @return DepartmentsProjects
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
     * @return DepartmentsProjects
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
     * @return DepartmentsProjects
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
     * Set department
     *
     * @param \AppBundle\Entity\Department $department
     *
     * @return DepartmentsProjects
     */
    public function setDepartment(\AppBundle\Entity\Department $department)
    {
        $this->Department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \AppBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->Department;
    }

    /**
     * Set projects
     *
     * @param \AppBundle\Entity\Projects $projects
     *
     * @return DepartmentsProjects
     */
    public function setProjects(\AppBundle\Entity\Projects $projects)
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
