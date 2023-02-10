<?php

namespace App\GraphQL\Resolver\Purchases;

use App\Entity\Purchase;
use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class PurchasesCollectionResolver implements QueryInterface, AliasedInterface
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
        $qb = $this->em->getRepository(Purchase::class)
            ->createQueryBuilder('pur')
            ->join('pur.client', 'cl');
            if(!is_null($argument['codReference']) && $argument['codReference'] != "null"){
                $qb->where('pur.codReference = :codReference')
                ->setParameter('codReference', $argument['codReference']);
            }
            if(!is_null($argument['client']) && $argument['client'] != "null"){
                $qb->orWhere('cl.name LIKE :client')
                    ->orWhere('cl.email LIKE :client')
                    ->orWhere('cl.codeUnique LIKE :client')
                    ->setParameter('client', "%".$argument['client']."%");
            }
            if(!is_null($argument['value']) && $argument['value'] != 0){
                $qb->orWhere('pur.value = :value')
                ->setParameter('value', $argument['value']);
            }
            if(!is_null($argument['date']) && $argument['date'] != "null"){
                $qb->orWhere('pur.date >= :date')
                ->setParameter('date', $argument['date']);
            }
        $purchases = $qb->getQuery()->execute();

        return ['purchases' => $purchases];
    }

    public static function getAliases(): array
    {
        return [
            'resolve' => 'PurchasesCollection'
        ];
    }
}