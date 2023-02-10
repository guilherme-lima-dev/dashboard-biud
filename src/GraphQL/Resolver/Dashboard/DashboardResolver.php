<?php

namespace App\GraphQL\Resolver\Dashboard;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseProduct;
use Doctrine\ORM\EntityManager;
use GraphQL\Language\AST\ListValueNode;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;
use phpDocumentor\Reflection\Types\Object_;

class DashboardResolver implements QueryInterface, AliasedInterface
{

    /**
     * @var EntityManager
     */
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {

        $this->em = $em;
    }

    public function resolve(): Dashboard
    {
        $purchases = $this->em->getRepository(Purchase::class)
            ->createQueryBuilder('pur')
            ->select("SUM(pur.value) as valueTotal, SUM(pur.discounts) as valueTotalDiscounts, COUNT(pur.id) as qtdPurchases")
            ->getQuery()->execute();

        $products = $this->em->getRepository(Product::class)
            ->createQueryBuilder('prd')
            ->select("COUNT(prd.id) as qtdProduct")
            ->getQuery()->execute();

        $clients = $this->em->getRepository(Client::class)
            ->createQueryBuilder('cli')
            ->select("COUNT(cli.id) as qtdClients")
            ->getQuery()->execute();

        $value = $this->em->getRepository(PurchaseProduct::class)
            ->createQueryBuilder('pp')
            ->select("pp.value")
            ->groupBy('pp.product, pp.value')
            ->getQuery()->execute();
        $valueTotalProducts = 0;
        foreach ($value as $v) {
            $valueTotalProducts += $v['value'];
        }
        $arrayFinal = array_merge($purchases[0], $products[0], $clients[0], [$valueTotalProducts]);

        $dashboard = new Dashboard(
            valueTotal: (float)$arrayFinal['valueTotal'],
            qtdClients: $arrayFinal['qtdClients'],
            qtdProduct: $arrayFinal['qtdProduct'],
            qtdPurchases: $arrayFinal['qtdPurchases'],
            valueTotalDiscounts: (float)$arrayFinal['valueTotalDiscounts'],
            valueTotalProducts: (float)round($arrayFinal[0], 2)
        );
//        var_dump($dashboard);
//        die;

        return $dashboard;
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'Dashboard'
        ];
    }
}