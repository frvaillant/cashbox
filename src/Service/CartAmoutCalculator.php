<?php


namespace App\Service;


class CartAmoutCalculator
{

    public static function calculateCartAmount($cart)
    {
        $total = 0;
        foreach ($cart as $purchase) {
            $total += $purchase['total'];
        }
        return $total;
    }

}
