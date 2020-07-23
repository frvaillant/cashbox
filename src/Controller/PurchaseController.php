<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PurchaseUnity;
use App\Repository\PaymentModeRepository;
use App\Repository\ProductRepository;
use App\Service\CartAmoutCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;

class PurchaseController extends AbstractController
{
    /**
     * @Route("/purchase/add", name="add_purchase", methods={"POST"})
     */
    public function addPurchase(
        Request $request,
        CartAmoutCalculator $amoutCalculator,
        PaymentModeRepository $paymentModeRepository,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    ) {
        $data = $request->getContent();
        $cart = json_decode($data, true);
        $total = $amoutCalculator::calculateCartAmount($cart);
        $paymentMode = $paymentModeRepository->findOneById((int)$cart['pm']['payment_mode']);
        $purchase = new Purchase();
        $purchase->setPaymentMode($paymentMode);
        $purchase->setCreatedAt(new DateTime('now'));
        $purchase->setTotalAmount($total);
        $entityManager->persist($purchase);
        foreach ($cart as $key=>$purchaseUnit) {
            if(is_integer($key)) {
                $product = $productRepository->findOneById((int)$purchaseUnit['id']);
                $purchaseUnity = new PurchaseUnity();
                $purchaseUnity->setProduct($product);
                $purchaseUnity->setProductPrice($purchaseUnit['price']);
                $purchaseUnity->setQuantity($purchaseUnit['quantity']);
                $purchaseUnity->setPurchase($purchase);
                $entityManager->persist($purchaseUnity);
            }
        }

        $entityManager->flush();
        $response = new JsonResponse();
        $response->setStatusCode($response::HTTP_OK);
        return $response;

    }
}
