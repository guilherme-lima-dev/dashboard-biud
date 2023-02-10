<?php

namespace App\Message;

use App\Entity\Client;
use App\Entity\PurchaseProduct;

class PurchaseMessage
{

    private array $arrayPurchaseProduct;
    private Client $client;

    public function __construct(array $arrayPurchaseProduct, Client $client)
    {
        $this->arrayPurchaseProduct = $arrayPurchaseProduct;
        $this->client = $client;
    }

    /**
     * @return PurchaseProduct[]
     */
    public function getArrayPurchaseProduct(): array
    {
        return $this->arrayPurchaseProduct;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }



}