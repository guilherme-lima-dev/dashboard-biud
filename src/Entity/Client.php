<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $codeUnique = null;

    public static function fromERP(array $arrayClient):self
    {
        $client = new Client();

        $fullname = $arrayClient['first_name']." ".$arrayClient['last_name'];
        $client->setName($fullname);
        $client->setEmail($arrayClient['email']);
        $client->setCodeUnique((string)$arrayClient['id']);

        return $client;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCodeUnique(): ?string
    {
        return $this->codeUnique;
    }

    public function setCodeUnique(string $codeUnique): self
    {
        $this->codeUnique = $codeUnique;

        return $this;
    }
}
