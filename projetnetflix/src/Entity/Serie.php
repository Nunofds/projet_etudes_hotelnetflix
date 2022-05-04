<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $hotel;

    #[ORM\Column(type: 'string', length: 255)]
    private $adress;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_serie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_basic;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_immersive;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_deluxxe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_hotel;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: Booking::class, orphanRemoval: true)]
    private $bookings;

    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: Reviews::class)]
    private $reviews;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getHotel(): ?string
    {
        return $this->hotel;
    }

    public function setHotel(string $hotel): self
    {
        $this->hotel = $hotel;

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

    public function getImageSerie(): ?string
    {
        return $this->image_serie;
    }

    public function setImageSerie(string $image_serie): self
    {
        $this->image_serie = $image_serie;

        return $this;
    }

    public function getImageBasic(): ?string
    {
        return $this->image_basic;
    }

    public function setImageBasic(string $image_basic): self
    {
        $this->image_basic = $image_basic;

        return $this;
    }

    public function getImageImmersive(): ?string
    {
        return $this->image_immersive;
    }

    public function setImageImmersive(string $image_immersive): self
    {
        $this->image_immersive = $image_immersive;

        return $this;
    }

    public function getImageDeluxxe(): ?string
    {
        return $this->image_deluxxe;
    }

    public function setImageDeluxxe(string $image_deluxxe): self
    {
        $this->image_deluxxe = $image_deluxxe;

        return $this;
    }

    public function getImageHotel(): ?string
    {
        return $this->image_hotel;
    }

    public function setImageHotel(string $image_hotel): self
    {
        $this->image_hotel = $image_hotel;

        return $this;
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

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setSerie($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSerie() === $this) {
                $booking->setSerie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setSerie($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getSerie() === $this) {
                $review->setSerie(null);
            }
        }

        return $this;
    }

}
