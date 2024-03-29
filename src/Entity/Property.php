<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[Vich\Uploadable]

class Property
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Vich\UploadableField(mapping: 'property_image', fileNameProperty: 'imageName')]
    private File $imageFile;


    #[ORM\Column(length: 255, nullable: true)]
    private string|null $imageName;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column]
    #[Assert\Range(min: 10, max: 400)]
    private ?int $surface;

    #[ORM\Column]
    private ?int $rooms;

    #[ORM\Column]
    private ?int $bedrooms;

    #[ORM\Column]
    private ?int $floor;

    #[ORM\Column]
    private ?int $price;

    #[ORM\Column(length: 255)]
    private ?string $city;

    #[ORM\Column(length: 255)]
    private ?string $adress;

    #[ORM\Column(length: 255)]
    #[Assert\Regex('/^[0-9]{5}$/')]
    private ?string $zipcode;

    #[ORM\Column]
    private ?bool $sold = false;

    #[ORM\Column]
    private \DateTimeImmutable $created_at;

    #[ORM\Column]
    private \DateTime|null $start_at = null;

    #[ORM\OneToMany(mappedBy: 'idProperty', targetEntity: Proprietaire::class)]
    private Collection $proprietary;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->proprietary = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormatedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Property
     */
    public function setImageFile(?File $imageFile = null): Property
    {

        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile)
        {
            $this->start_at = new \DateTime('now');
        }

        return $this;
    }


    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }


    public function getUpdatedAt(): \DateTime
    {
        return $this->start_at;
    }

    public function setUpdatedAt(\DateTime $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }




    /**
     * @return Collection<int, Proprietaire>
     */
    public function getProprietary(): Collection
    {
        return $this->proprietary;
    }

    public function addProprietary(Proprietaire $proprietary): self
    {
        if (!$this->proprietary->contains($proprietary))
        {
            $this->proprietary->add($proprietary);
            $proprietary->setIdProperty($this);
        }

        return $this;
    }

    public function removeProprietary(Proprietaire $proprietary): self
    {
        if ($this->proprietary->removeElement($proprietary))
        {
            if ($proprietary->getIdProperty() === $this)
            {
                $proprietary->setIdProperty(null);
            }
        }

        return $this;
    }

}
