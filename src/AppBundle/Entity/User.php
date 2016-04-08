<?php

/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 3/27/2016
 * Time: 8:17 PM
 */
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $user_id;

    /** @ORM\Column(length=50,unique=true)
     */
    private $user_email;

    /** @ORM\Column(length=30)
     */
    private $user_pass;

    /** @ORM\Column(length=140)
     */
    private $user_fullName;
    /** @ORM\Column(length=30)
     */
    private $user_phone;

    /** @ORM\Column(type="datetime")
     */
    private $create_date;

    /**
     * @ORM\OneToMany(targetEntity="Indentities", mappedBy="user")
     */
    private $indentities;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="user")
     */
    private $transactions;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indentities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return User
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Set userPass
     *
     * @param string $userPass
     *
     * @return User
     */
    public function setUserPass($userPass)
    {
        $this->user_pass = $userPass;

        return $this;
    }

    /**
     * Get userPass
     *
     * @return string
     */
    public function getUserPass()
    {
        return $this->user_pass;
    }

    /**
     * Set userFullName
     *
     * @param string $userFullName
     *
     * @return User
     */
    public function setUserFullName($userFullName)
    {
        $this->user_fullName = $userFullName;

        return $this;
    }

    /**
     * Get userFullName
     *
     * @return string
     */
    public function getUserFullName()
    {
        return $this->user_fullName;
    }

    /**
     * Set userPhone
     *
     * @param string $userPhone
     *
     * @return User
     */
    public function setUserPhone($userPhone)
    {
        $this->user_phone = $userPhone;

        return $this;
    }

    /**
     * Get userPhone
     *
     * @return string
     */
    public function getUserPhone()
    {
        return $this->user_phone;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return User
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Add indentity
     *
     * @param \AppBundle\Entity\Identities $indentity
     *
     * @return User
     */
    public function addIndentity(\AppBundle\Entity\Identities $indentity)
    {
        $this->indentities[] = $indentity;

        return $this;
    }

    /**
     * Remove indentity
     *
     * @param \AppBundle\Entity\Identities $indentity
     */
    public function removeIndentity(\AppBundle\Entity\Identities $indentity)
    {
        $this->indentities->removeElement($indentity);
    }

    /**
     * Get indentities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndentities()
    {
        return $this->indentities;
    }

    /**
     * Add transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     *
     * @return User
     */
    public function addTransaction(\AppBundle\Entity\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     */
    public function removeTransaction(\AppBundle\Entity\Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}
