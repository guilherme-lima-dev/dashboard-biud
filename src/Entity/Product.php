<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $key = null;

    /**
     * @param array $lineProducts
     * @return array
     */
    public static function fromERP(array $lineProducts):array
    {
        $arrayProducts = [];
        $vars = array_keys(get_class_vars('App\Entity\Product')); //array com as variaveis da classe Products
        unset($vars[0]);
        $fieldsLine = array_keys($lineProducts[0]);
        $fieldsProduct = array_intersect($vars, $fieldsLine);
        foreach ($lineProducts as $key => $line){
            $product = new Product();

            foreach ($fieldsProduct as $field){

                $methodName = "set".ucfirst($field);
                $product->$methodName($line[$field]);

            }
            if($product->getKey() == null){
                $product->setKey((string)$line['id']);
            }
            $arrayProducts[] = [$product, $line['quantity'], $line['price']];
        }

        return $arrayProducts;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
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


}
