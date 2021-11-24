<?php

namespace App\Entity;

use App\Repository\CAgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CAgenceRepository::class)
 */
class CAgence
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Lenght(min=2, max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Lenght(min=2, max=100)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{10}/")
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Lenght(min=10)
     */
    private $message;

    /**
     * @var Property|null
     */
    private $property;

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
     * @ORM\ManyToMany(targetEntity=Agence::class, inversedBy="cAgences")
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
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

    /**
     * @return Collection|Agence[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Agence $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
        }

        return $this;
    }

    public function removeProperty(Agence $property): self
    {
        $this->properties->removeElement($property);

        return $this;
    }












    /**
     * @return null|string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return Contact
     */
    public function setFirstname(string $firstname)
    {
    $this->firstname = $firstname;
    return $this;
    }

    /**
     * @return null|string
     */

    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return Contact
     */
    public function setLastname(string $lastname)
    {
    $this->lastname = $lastname;
    return $this;
    }

    /**
     * @return null|string
     */

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return Contact
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return null|string
     */

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Contact
     */
    public function setEmail(string $email)
    {
    $this->email = $email;
    return $this;
    }

    /**
     * @return null|string
    */

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contact
     */
    public function setMessage(string $message)
    {
    $this->message = $message;
    return $this;
    }

    /**
     * @return Property|null
     */
    public function getProperty(Property $property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @param Property|null $property
     * @return Contact
     */
    public function setProperty(Property $property)
    {
        $this->property = $property;
        return $this;
    }
}
