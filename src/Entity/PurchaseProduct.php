<?php

namespace App\Entity;

use App\Repository\PurchaseProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseProductRepository::class)]
class PurchaseProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Purchase $purchase = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $value = null;

    /**
     * @return PurchaseProduct[]
     */
    public static function fromERP($products, Purchase $purchase):array
    {
        $arrayPurchaseProducts = [];
        foreach ($products as $arrayProduct){//arrayProduct returns [$product, $quantity, $value]

            $purchaseProducts = new PurchaseProduct();
            [$product, $quantity, $value] = $arrayProduct;
            $purchaseProducts->setProduct($product);
            $purchaseProducts->setQuantity($quantity);
            $purchaseProducts->setValue($value);
            $purchaseProducts->setPurchase($purchase);
            $arrayPurchaseProducts[] = $purchaseProducts;
        }

        return $arrayPurchaseProducts;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
