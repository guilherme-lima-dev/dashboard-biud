<?php

namespace App\Controller\Message;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseProduct;
use App\Message\PurchaseMessage;
use App\Repository\ClientRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{

    #[Route('/api/webhook', name: 'webhook')]
    public function webhook(LoggerInterface $logger, MessageBusInterface $bus, Request $request):JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $purchase = Purchase::fromERP($content);
        $products = Product::fromERP($content['line_items']);
        $client = $purchase->getClient();

        $arrayPurchaseProduct = PurchaseProduct::fromERP($products, $purchase);



        $logger->info(json_encode($content));
        $bus->dispatch(new PurchaseMessage($arrayPurchaseProduct, $client));

        return new JsonResponse();
    }


}