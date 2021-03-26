<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $Address;

    /**
     * @ORM\OneToOne(targetEntity=Compagnies::class, cascade={"persist", "remove"})
     */
    private $Compagnies;

    /**
     * @ORM\OneToOne(targetEntity=Geolocation::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $geo;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(Address $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getCompagnies(): ?Compagnies
    {
        return $this->Compagnies;
    }

    public function setCompagnies(?Compagnies $Compagnies): self
    {
        $this->Compagnies = $Compagnies;

        return $this;
    }

    public function getGeo(): ?Geolocation
    {
        return $this->geo;
    }

    public function setGeo(Geolocation $geo): self
    {
        $this->geo = $geo;

        return $this;
    }
}
