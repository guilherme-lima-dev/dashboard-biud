<?php

namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class ProductCollectionResolver implements QueryInterface, AliasedInterface
{

    /**
     * @var EntityManager
     */
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {

        $this->em = $em;
    }

    public function resolve(Argument $argument): array
    {
        $products = $this->em->getRepository('App\Entity\Product')->findBy([], [], $argument['limit'], 0);
        return ['products' => $products];
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'ProductCollection'
        ];
    }
}