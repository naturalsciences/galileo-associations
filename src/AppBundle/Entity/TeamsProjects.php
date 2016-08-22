<?php

namespace AppBundle\Entity;

/**
 * TeamsProjects
 */
class TeamsProjects
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
     * @var \AppBundle\Entity\Teams
     */
    private $Team;

    /**
     * @var \AppBundle\Entity\Projects
     */
    private $Project;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return TeamsProjects
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return TeamsProjects
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
     * @return TeamsProjects
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
     * @return TeamsProjects
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
     * Set team
     *
     * @param \AppBundle\Entity\Teams $team
     *
     * @return TeamsProjects
     */
    public function setTeam(\AppBundle\Entity\Teams $team = null)
    {
        $this->Team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \AppBundle\Entity\Teams
     */
    public function getTeam()
    {
        return $this->Team;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Projects $project
     *
     * @return TeamsProjects
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
}
