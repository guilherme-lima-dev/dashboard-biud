<?php

namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class ProductResolver implements QueryInterface, AliasedInterface
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
        $product = $this->em->getRepository('App\Entity\Product')->find($argument['id']);
        return $product;
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'Product'
        ];
    }
}