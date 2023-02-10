<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $codReference;

    #[ORM\Column]
    private float $discounts;

    #[ORM\Column]
    private float $value;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date;

    #[ORM\ManyToOne]
    private ?Client $client = null;

    public function __construct()
    {
        $this->purchaseProducts = new ArrayCollection();
    }

    /**
     * @param array $content
     * @return Purchase
     */
    public static function fromERP(array $content):self
    {
        $referenceCode = $content["id"];
        $discounts = $content['total_discounts'];
        $value = $content['total_price'];
        $client = Client::fromERP($content['customer']);
        $date = $content['created_at'];
        $purchase = new Purchase();
        $purchase->setCodReference($referenceCode);
        $purchase->setDiscounts($discounts);
        $purchase->setValue($value);
        $purchase->setDate(new \DateTime($date));
        $purchase->setClient($client);

        return $purchase;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodReference(): string
    {
        return $this->codReference;
    }

    public function setCodReference(string $codReference): self
    {
        $this->codReference = $codReference;

        return $this;
    }

    public function getDiscounts(): float
    {
        return $this->discounts;
    }

    public function setDiscounts(float $discounts): self
    {
        $this->discounts = $discounts;

        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

}
