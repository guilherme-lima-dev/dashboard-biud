<?php

namespace App\GraphQL\Resolver\Dashboard;

use App\Entity\Client;
use App\Entity\Purchase;
use App\Entity\PurchaseProduct;
use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class ChartsResolver implements QueryInterface, AliasedInterface
{

    /**
     * @var EntityManager
     */
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function resolve(): array
    {
        $purchasesClient = $this->em->getRepository(Purchase::class)
        ->createQueryBuilder('pur')
        ->select("cli.name, SUM(pur.value) as Total, (SUM(pur.value)/COUNT(pur.id)) as Media")
        ->innerJoin('pur.client', 'cli')
        ->groupBy('pur.client')
        ->addGroupBy('cli.name')
        ->getQuery()->execute();

        $purchasesProduct= $this->em->getRepository(PurchaseProduct::class)
            ->createQueryBuilder('pp')
            ->select("p.title as name, SUM(pp.value) as Total, (SUM(pp.value)/COUNT(pp.purchase)) as Media")
            ->innerJoin('pp.product', 'p')
            ->groupBy('pp.product')
            ->addGroupBy('p.title')
            ->getQuery()->execute();

        return ["purchasesClient" => $purchasesClient, "purchaseProduct" => $purchasesProduct];
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'Charts'
        ];
    }
}