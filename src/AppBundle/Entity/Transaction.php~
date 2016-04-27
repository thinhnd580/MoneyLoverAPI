<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 3/31/2016
 * Time: 11:16 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Transaction")
 */

class Transaction
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="transactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user;


    /** @ORM\Column(type="decimal", scale=2)
     */
    private $cost;

    /** @ORM\Column(length=225,nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="transactions")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $category;

    /** @ORM\Column(type="datetime")
     */
    private $createdDate;

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
     * Set cost
     *
     * @param string $cost
     *
     * @return Transaction
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Transaction
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Transaction
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */

    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Transaction
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Transaction
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
