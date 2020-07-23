<?php


namespace App\Service;


class CartAmoutCalculator
{

    public static function calculateCartAmount($cart)
    {
        $total = 0;
        foreach ($cart as $key=>$purchase) {
            if (is_integer($key)) {
                $total += $purchase['total'];
            }
        }
        return $total;
    }

}
