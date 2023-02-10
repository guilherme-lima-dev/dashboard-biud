<?php

namespace App\Handler;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Message\PurchaseMessage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class PurchaseHandler
{

    private MessageBusInterface $bus;
    private EntityManager $entityManager;

    public function __construct(MessageBusInterface $bus, EntityManager $entityManager)
    {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function __invoke(PurchaseMessage $message)
    {
        echo "inicio \n";
        $client = $this->entityManager->getRepository(Client::class)->findOneBy(['email' => $message->getClient()->getEmail()]);
        if(!$client){
            echo "ENTROU CLIENTE \n";
            $this->entityManager->persist($message->getClient());
            $this->entityManager->flush($message->getClient());
            $client = $this->entityManager->getRepository(Client::class)->findOneBy(['email' => $message->getClient()->getEmail()]);
        }
        echo "passou cliente \n";

        $purchase = $message->getArrayPurchaseProduct()[0]->getPurchase();
        $existPurchase = $this->entityManager->getRepository(Purchase::class)->findOneBy(['codReference' => $purchase->getCodReference()]);
        echo "Veio aqui";
        if($existPurchase) {
            echo"TCHAAAAAU \n";
            return;
        }
        $purchase->setClient($client);
        $this->entityManager->persist($purchase);
        $this->entityManager->flush($purchase);

        echo "passou purchase \n";
        foreach ($message->getArrayPurchaseProduct() as $purchaseProduct){
            echo "inicio FOR \n";
            $product = $purchaseProduct->getProduct();

            $existProduct = $this->entityManager->getRepository(Product::class)->findOneBy(['key' => $product->getKey()]);
            var_dump($existProduct);
            if(!$existProduct){
                echo "init product: \n";
                $this->entityManager->persist($product);
                $this->entityManager->flush($product);
                $existProduct = $this->entityManager->getRepository(Product::class)->findOneBy(['key' => $product->getKey()]);
                echo "end product: \n";
            }
            $purchaseProduct->setProduct($existProduct);
            $purchaseProduct->setPurchase($purchase);
            var_dump($purchaseProduct);

            $this->entityManager->persist($purchaseProduct);
            $this->entityManager->flush($purchaseProduct);
            echo "final FOR \n";
        }
        echo "CORRE PRO ABRAÇO \n";
    }
}