<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 04/03/2019
 * Time: 15:09
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $sender;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

}