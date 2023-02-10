<?php

namespace App\GraphQL\Resolver\Dashboard;

class Dashboard
{
    private $valueTotal;
    private $qtdClients;
    private $qtdProduct;
    private $qtdPurchases;
    private $valueTotalDiscounts;
    private $valueTotalProducts;

    /**
     * @return mixed
     */
    public function getValueTotalProducts()
    {
        return $this->valueTotalProducts;
    }

    /**
     * @param mixed $valueTotalProducts
     */
    public function setValueTotalProducts($valueTotalProducts): void
    {
        $this->valueTotalProducts = $valueTotalProducts;
    }

    /**
     * @param $valueTotal
     * @param $qtdClients
     * @param $qtdProduct
     * @param $qtdPurchases
     * @param $valueTotalDiscounts
     * @param $valueTotalProducts
     */
    public function __construct($valueTotal, $qtdClients, $qtdProduct, $qtdPurchases, $valueTotalDiscounts, $valueTotalProducts)
    {
        $this->valueTotal = $valueTotal;
        $this->qtdClients = $qtdClients;
        $this->qtdProduct = $qtdProduct;
        $this->qtdPurchases = $qtdPurchases;
        $this->valueTotalDiscounts = $valueTotalDiscounts;
        $this->valueTotalProducts = $valueTotalProducts;
    }

    /**
     * @return mixed
     */
    public function getValueTotal()
    {
        return $this->valueTotal;
    }

    /**
     * @param mixed $valueTotal
     */
    public function setValueTotal($valueTotal): void
    {
        $this->valueTotal = $valueTotal;
    }

    /**
     * @return mixed
     */
    public function getQtdClients()
    {
        return $this->qtdClients;
    }

    /**
     * @param mixed $qtdClients
     */
    public function setQtdClients($qtdClients): void
    {
        $this->qtdClients = $qtdClients;
    }

    /**
     * @return mixed
     */
    public function getQtdProduct()
    {
        return $this->qtdProduct;
    }

    /**
     * @param mixed $qtdProduct
     */
    public function setQtdProduct($qtdProduct): void
    {
        $this->qtdProduct = $qtdProduct;
    }

    /**
     * @return mixed
     */
    public function getQtdPurchases()
    {
        return $this->qtdPurchases;
    }

    /**
     * @param mixed $qtdPurchases
     */
    public function setQtdPurchases($qtdPurchases): void
    {
        $this->qtdPurchases = $qtdPurchases;
    }

    /**
     * @return mixed
     */
    public function getValueTotalDiscounts()
    {
        return $this->valueTotalDiscounts;
    }

    /**
     * @param mixed $valueTotalDiscounts
     */
    public function setValueTotalDiscounts($valueTotalDiscounts): void
    {
        $this->valueTotalDiscounts = $valueTotalDiscounts;
    }




}