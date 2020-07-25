<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PurchaseUnity;
use App\Repository\PaymentModeRepository;
use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use App\Service\CartAmoutCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class PurchaseController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
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
        ProductRepository $productRepository,
        StockRepository $stockRepository
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

                $stock = $stockRepository->findOneBy(['product' => $product]);
                if($stock) {
                    $stock->decreaseStock($purchaseUnit['quantity']);
                    $entityManager->persist($stock);
                }
            }
        }

        $entityManager->flush();
        $response = new JsonResponse();
        $response->setStatusCode($response::HTTP_OK);
        return $response;

    }
}
