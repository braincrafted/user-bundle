<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Entity;

/**
 * InviteRequest
 *
 * @package    BcUserBundle
 * @subpackage Entity
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class InviteRequest
{
    /** @var integer */
    private $id;

    /** @var string */
    private $email;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var \DateTime */
    private $deletedAt;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Sets the ID.
     *
     * @param integer $id The ID
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the ID.
     *
     * @return integer The ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the email address of the invite request.
     *
     * @param string $email The email address
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the email of the invite request.
     *
     * @return string The email address
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the date the invite request was created at.
     *
     * @param \DateTime $createdAt The date the invite request was created at
     *
     * @return void
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns the date the invite request was created at.
     *
     * @return \DateTime The date the invite request was created at
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the date the invite request was updated at.
     *
     * @param \DateTime $updatedAt The date the invite request was updated at
     *
     * @return void
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns the date the invite request was updated at.
     *
     * @return \DateTime The date the invite request was updated at
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function delete()
    {
        $this->deletedAt = new \DateTime();

        return $this;
    }

    public function undelete()
    {
        $this->deleteAt = null;

        return $this;
    }
}
