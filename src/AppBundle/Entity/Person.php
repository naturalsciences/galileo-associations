<?php

namespace AppBundle\Entity;

use Doctrine\DBAL\Types\SimpleArrayType;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Person
 */
class Person implements UserInterface
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
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var SimpleArrayType
     */
    private $roles = [];


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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $TeamsMembers;


    /**
     * Add teamsMember
     *
     * @param \AppBundle\Entity\TeamsMembers $teamsMember
     *
     * @return Person
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $PersonEntry;


    /**
     * Add personEntry
     *
     * @param \AppBundle\Entity\PersonEntry $personEntry
     *
     * @return Person
     */
    public function addPersonEntry(\AppBundle\Entity\PersonEntry $personEntry)
    {
        $this->PersonEntry[] = $personEntry;

        return $this;
    }

    /**
     * Remove personEntry
     *
     * @param \AppBundle\Entity\PersonEntry $personEntry
     */
    public function removePersonEntry(\AppBundle\Entity\PersonEntry $personEntry)
    {
        $this->PersonEntry->removeElement($personEntry);
    }

    /**
     * Get personEntry
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonEntry()
    {
        return $this->PersonEntry;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return SimpleArrayType The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getUid();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }


    /**
     * Set password
     *
     * @param string $password
     *
     * @return Person
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set roles
     *
     * @param mixed $roles
     *
     * @return Person
     */
    public function setRoles(Array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        // To guarantee that the password looks dirty too for the entity
        // we set the password to null
        // That will ensure the event listener to be called
        $this->password = null;
    }


}
