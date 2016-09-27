<?php

namespace AppBundle\Entity;

/**
 * PersonEntry
 */
class PersonEntry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $entry_date = 'now()';

    /**
     * @var \DateTime
     */
    private $exit_date;

    /**
     * @var \AppBundle\Entity\Person
     */
    private $Person;


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
     * Set entryDate
     *
     * @param \DateTime $entryDate
     *
     * @return PersonEntry
     */
    public function setEntryDate($entryDate)
    {
        $this->entry_date = $entryDate;

        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entry_date;
    }

    /**
     * Set exitDate
     *
     * @param \DateTime $exitDate
     *
     * @return PersonEntry
     */
    public function setExitDate($exitDate)
    {
        $this->exit_date = $exitDate;

        return $this;
    }

    /**
     * Get exitDate
     *
     * @return \DateTime
     */
    public function getExitDate()
    {
        return $this->exit_date;
    }

    /**
     * Set person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return PersonEntry
     */
    public function setPerson(\AppBundle\Entity\Person $person)
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
}

