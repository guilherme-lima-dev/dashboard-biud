<?php

namespace App\GraphQL\Mutation;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class ProductMutation implements MutationInterface, AliasedInterface
{
    private EntityManager $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createProduct(Argument $args)
    {

        $product = new Product();
        foreach($args['input'] as $key => $value){
            $methodName = "set".ucfirst($key);
            $product->$methodName($value);
        }

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
    public function editProduct(int $id, Argument $args)
    {
        $product = $this->em->getRepository('App\Entity\Product')->find($id);
        foreach($args['input'] as $key => $value){
            $methodName = "set".ucfirst($key);
            $product->$methodName($value);
        }

        $this->em->flush();

        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = $this->em->getRepository('App\Entity\Product')->find($id);

        $this->em->remove($product);
        $this->em->flush();

        return "Deletado com sucesso";
    }
    public static function getAliases():array
    {
        return [
           'createProduct' => 'create_product',
           'editProduct' => 'edit_product',
           'deleteProduct' => 'delete_product',
        ];
    }

}