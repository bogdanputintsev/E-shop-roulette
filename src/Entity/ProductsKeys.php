<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsKeysRepository")
 */
class ProductsKeys
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
    private $product_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\Column(type="boolean")
     */
    private $daily_gift = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $distribution = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_used = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getDistribution(): ?bool
    {
        return $this->distribution;
    }

    public function setDistribution(bool $distribution): self
    {
        $this->distribution = $distribution;

        return $this;
    }

    public function getIsUsed(): ?bool
    {
        return $this->is_used;
    }

    public function setIsUsed(bool $is_used): self
    {
        $this->is_used = $is_used;

        return $this;
    }
}
