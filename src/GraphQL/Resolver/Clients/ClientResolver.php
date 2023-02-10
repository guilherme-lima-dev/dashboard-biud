<?php

namespace App\GraphQL\Resolver\Clients;

use App\Entity\Client;
use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class ClientResolver implements QueryInterface, AliasedInterface
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
        $clients = $this->em->getRepository(Client::class)->find($argument['id']);
        return $clients;
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'Client'
        ];
    }
}