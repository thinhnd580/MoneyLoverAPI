<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 3/28/2016
 * Time: 9:43 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Indentites")
 */
class Indentities
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

        /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="indentities")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user;

    /** @ORM\Column(length=50,unique=true)
     */
    private $token;

    /** @ORM\Column(length=30)
     */
    private $device ;

    /** @ORM\Column(type="datetime")
     */
    private $token_createdDate;



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
     * Set token
     *
     * @param string $token
     *
     * @return Indentities
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set device
     *
     * @param string $device
     *
     * @return Indentities
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set tokenCreatedDate
     *
     * @param \DateTime $tokenCreatedDate
     *
     * @return Indentities
     */
    public function setTokenCreatedDate($tokenCreatedDate)
    {
        $this->token_createdDate = $tokenCreatedDate;

        return $this;
    }

    /**
     * Get tokenCreatedDate
     *
     * @return \DateTime
     */
    public function getTokenCreatedDate()
    {
        return $this->token_createdDate;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Indentities
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
