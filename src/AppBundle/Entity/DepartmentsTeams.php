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
    private $Department;

    /**
     * @var \AppBundle\Entity\Teams
     */
    private $Teams;


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
     * Set department
     *
     * @param \AppBundle\Entity\Department $department
     *
     * @return DepartmentsTeams
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
     * Set teams
     *
     * @param \AppBundle\Entity\Teams $teams
     *
     * @return DepartmentsTeams
     */
    public function setTeams(\AppBundle\Entity\Teams $teams)
    {
        $this->Teams = $teams;

        return $this;
    }

    /**
     * Get teams
     *
     * @return \AppBundle\Entity\Teams
     */
    public function getTeams()
    {
        return $this->Teams;
    }
}

