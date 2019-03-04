<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 04/03/2019
 * Time: 15:08
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="conversation")
 * @ORM\Entity
 */
class Conversation
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $creator;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator($creator): void
    {
        $this->creator = $creator;
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