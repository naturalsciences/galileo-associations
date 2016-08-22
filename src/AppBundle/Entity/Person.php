<?php

namespace AppBundle\Entity;

/**
 * Person
 */
class Person
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $matricule;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $WorkingDuty;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ProjectsMembers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $TeamssMembers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->WorkingDuty = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ProjectsMembers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->TeamssMembers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Person
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Person
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set uid
     *
     * @param string $uid
     *
     * @return Person
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add workingDuty
     *
     * @param \AppBundle\Entity\WorkingDuty $workingDuty
     *
     * @return Person
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
     * Add projectsMember
     *
     * @param \AppBundle\Entity\ProjectsMembers $projectsMember
     *
     * @return Person
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
     * Add teamssMember
     *
     * @param \AppBundle\Entity\TeamsMembers $teamssMember
     *
     * @return Person
     */
    public function addTeamssMember(\AppBundle\Entity\TeamsMembers $teamssMember)
    {
        $this->TeamssMembers[] = $teamssMember;

        return $this;
    }

    /**
     * Remove teamssMember
     *
     * @param \AppBundle\Entity\TeamsMembers $teamssMember
     */
    public function removeTeamssMember(\AppBundle\Entity\TeamsMembers $teamssMember)
    {
        $this->TeamssMembers->removeElement($teamssMember);
    }

    /**
     * Get teamssMembers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamssMembers()
    {
        return $this->TeamssMembers;
    }
}
