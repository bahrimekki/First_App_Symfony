<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string",length=200)
     */
    private $FirstName;

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }
    public function setFirstName($FirstName):void{
        $this->FirstName=$FirstName;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $LastName;

    public function getLastName(): ?string
    {
        return $this->LastName;
    }
    public function setLastName($LastName):void{
        $this->LastName=$LastName;
    }
}
