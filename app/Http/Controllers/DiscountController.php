<?php
/**
 * Created by PhpStorm.
 * User: vanea
 * Date: 31.07.2018
 * Time: 16:55
 */

namespace App\Http\Controllers;


use App\Domain\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function discount(Request $request, DiscountService $discountService)
    {
        if($request->isJson()) {
            $orderData = $request->json()->all();
            return $discountService->applyDiscount($orderData);
        }

        return [];
    }
}