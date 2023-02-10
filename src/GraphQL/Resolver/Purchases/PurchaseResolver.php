<?php

namespace App\GraphQL\Resolver\Purchases;

use App\Entity\Purchase;
use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class PurchaseResolver implements QueryInterface, AliasedInterface
{

    /**
     * @var EntityManager
     */
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {

        $this->em = $em;
    }

    public function resolve(Argument $argument)
    {
        $purchase = $this->em->getRepository(Purchase::class)->find($argument['id']);
        return $purchase;
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'Purchase'
        ];
    }
}