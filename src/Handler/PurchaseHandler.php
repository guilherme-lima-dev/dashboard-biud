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
        echo "Executando fila...\n";

        //verificação existencia do cliente
        $client = $this->entityManager->getRepository(Client::class)->findOneBy(['email' => $message->getClient()->getEmail()]);
        if(!$client){
            $this->entityManager->persist($message->getClient());
            $this->entityManager->flush($message->getClient());
            //atualizando cliente para as outras classes
            $client = $this->entityManager->getRepository(Client::class)->findOneBy(['email' => $message->getClient()->getEmail()]);
        }

        //a purchase é igual então eu só resgato 1 e já verifico se ela existe em nossa base
        $purchase = $message->getArrayPurchaseProduct()[0]->getPurchase();
        $existPurchase = $this->entityManager->getRepository(Purchase::class)->findOneBy(['codReference' => $purchase->getCodReference()]);

        //caso exista uma ordem igual nós já cancelamos toda a solicitação e saimos do processamento
        if($existPurchase) {
            echo "Ordem existente! \n";
            return;
        }
        $purchase->setClient($client);
        $this->entityManager->persist($purchase);
        $this->entityManager->flush($purchase);


        $this->savePurchaseProduct($message, $purchase);

        echo "Deu bom! \n";
    }

    /**
     * @param PurchaseMessage $message
     * @param Purchase|null $purchase
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function savePurchaseProduct(PurchaseMessage $message, ?Purchase $purchase): void
    {
        foreach ($message->getArrayPurchaseProduct() as $purchaseProduct) {
            $product = $purchaseProduct->getProduct();

            $existProduct = $this->entityManager->getRepository(Product::class)->findOneBy(['key' => $product->getKey()]);

            //verifico se o produto já existe e caso não exista eu crio um
            if (!$existProduct) {
                $this->entityManager->persist($product);
                $this->entityManager->flush($product);
                $existProduct = $this->entityManager->getRepository(Product::class)->findOneBy(['key' => $product->getKey()]);
            }
            $purchaseProduct->setProduct($existProduct);
            $purchaseProduct->setPurchase($purchase);

            $this->entityManager->persist($purchaseProduct);
            $this->entityManager->flush($purchaseProduct);
        }
    }
}