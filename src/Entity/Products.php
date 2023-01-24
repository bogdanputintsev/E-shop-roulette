<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $image_key;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $popularity;

    /**
     * @ORM\Column(type="integer")
     */
    private $drop_chance;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $system;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $price_sell;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $platforms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $release_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $game_mode;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $OS;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $CPU;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $RAM;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $disk_space;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $videocard;

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

    public function getImageKey(): ?string
    {
        return $this->image_key;
    }

    public function setImageKey(string $image_key): self
    {
        $this->image_key = $image_key;

        return $this;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function setPopularity(?int $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getDropChance(): ?int
    {
        return $this->drop_chance;
    }

    public function setDropChance(int $drop_chance): self
    {
        $this->drop_chance = $drop_chance;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getSystem(): ?bool
    {
        return $this->system;
    }

    public function setSystem(bool $system): self
    {
        $this->system = $system;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function getPriceSell(): ?int
    {
        return $this->price_sell;
    }

    public function setPriceSell(int $price_sell): self
    {
        $this->price_sell = $price_sell;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPlatforms(): ?string
    {
        return $this->platforms;
    }

    public function setPlatforms(?string $platforms): self
    {
        $this->platforms = $platforms;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getGameMode(): ?string
    {
        return $this->game_mode;
    }

    public function setGameMode(?string $game_mode): self
    {
        $this->game_mode = $game_mode;

        return $this;
    }

    public function getOS(): ?string
    {
        return $this->OS;
    }

    public function setOS(?string $OS): self
    {
        $this->OS = $OS;

        return $this;
    }

    public function getCPU(): ?string
    {
        return $this->CPU;
    }

    public function setCPU(?string $CPU): self
    {
        $this->CPU = $CPU;

        return $this;
    }

    public function getRAM(): ?string
    {
        return $this->RAM;
    }

    public function setRAM(?string $RAM): self
    {
        $this->RAM = $RAM;

        return $this;
    }

    public function getDiskSpace(): ?string
    {
        return $this->disk_space;
    }

    public function setDiskSpace(?string $disk_space): self
    {
        $this->disk_space = $disk_space;

        return $this;
    }

    public function getVideocard(): ?string
    {
        return $this->videocard;
    }

    public function setVideocard(?string $videocard): self
    {
        $this->videocard = $videocard;

        return $this;
    }

}
