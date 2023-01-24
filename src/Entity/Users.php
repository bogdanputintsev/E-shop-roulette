<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $vk_id = -1;

    /**
     * @ORM\Column(type="integer")
     */
    private $steam_id = -1;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_ant = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance_real = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $daily_gift = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $joined_group = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $wrote_feedback = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $last_IP;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBanned = 0;

    /**
     * @ORM\Column(type="date")
     */
    private $registration_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVkId(): ?int
    {
        return $this->vk_id;
    }

    public function setVkId(int $vk_id): self
    {
        $this->vk_id = $vk_id;

        return $this;
    }

    public function getSteamId(): ?int
    {
        return $this->steam_id;
    }

    public function setSteamId(int $steam_id): self
    {
        $this->steam_id = $steam_id;

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

    public function getIsAnt(): ?bool
    {
        return $this->is_ant;
    }

    public function setIsAnt(bool $is_ant): self
    {
        $this->is_ant = $is_ant;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getBalanceReal(): ?int
    {
        return $this->balance_real;
    }

    public function setBalanceReal(int $balance_real): self
    {
        $this->balance_real = $balance_real;

        return $this;
    }

    public function getDailyGift(): ?bool
    {
        return $this->daily_gift;
    }

    public function setDailyGift(bool $daily_gift): self
    {
        $this->daily_gift = $daily_gift;

        return $this;
    }

    public function getJoinedGroup(): ?bool
    {
        return $this->joined_group;
    }

    public function setJoinedGroup(bool $joined_group): self
    {
        $this->joined_group = $joined_group;

        return $this;
    }

    public function getWroteFeedback(): ?bool
    {
        return $this->wrote_feedback;
    }

    public function setWroteFeedback(bool $wrote_feedback): self
    {
        $this->wrote_feedback = $wrote_feedback;

        return $this;
    }

    public function getLastIP(): ?int
    {
        return $this->last_IP;
    }

    public function setLastIP(int $last_IP): self
    {
        $this->last_IP = $last_IP;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(\DateTimeInterface $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }
}
