<?php

namespace AppBundle\Entity;

/**
 * ADSync
 */
class ADSync
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $samaccountname;

    /**
     * @var string
     */
    private $givenname;

    /**
     * @var string
     */
    private $sn;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $othermail;

    /**
     * @var string
     */
    private $userprincipalname;


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
     * Set samaccountname
     *
     * @param string $samaccountname
     *
     * @return ADSync
     */
    public function setSamaccountname($samaccountname)
    {
        $this->samaccountname = $samaccountname;

        return $this;
    }

    /**
     * Get samaccountname
     *
     * @return string
     */
    public function getSamaccountname()
    {
        return $this->samaccountname;
    }

    /**
     * Set givenname
     *
     * @param string $givenname
     *
     * @return ADSync
     */
    public function setGivenname($givenname)
    {
        $this->givenname = $givenname;

        return $this;
    }

    /**
     * Get givenname
     *
     * @return string
     */
    public function getGivenname()
    {
        return $this->givenname;
    }

    /**
     * Set sn
     *
     * @param string $sn
     *
     * @return ADSync
     */
    public function setSn($sn)
    {
        $this->sn = $sn;

        return $this;
    }

    /**
     * Get sn
     *
     * @return string
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return ADSync
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set othermail
     *
     * @param string $othermail
     *
     * @return ADSync
     */
    public function setOthermail($othermail)
    {
        $this->othermail = $othermail;

        return $this;
    }

    /**
     * Get othermail
     *
     * @return string
     */
    public function getOthermail()
    {
        return $this->othermail;
    }

    /**
     * Set userprincipalname
     *
     * @param string $userprincipalname
     *
     * @return ADSync
     */
    public function setUserprincipalname($userprincipalname)
    {
        $this->userprincipalname = $userprincipalname;

        return $this;
    }

    /**
     * Get userprincipalname
     *
     * @return string
     */
    public function getUserprincipalname()
    {
        return $this->userprincipalname;
    }
}
