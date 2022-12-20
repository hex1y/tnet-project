<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    )
    {
    }

    public function getUserCart()
    {
        $cart = $this->cartService->getUserCart();

        return $this->success(data: $cart);
    }

    public function addProduct(Product $product)
    {
        $this->cartService->addCartProduct($product);

        return $this->success();
    }

    public function setQuantity(Product $product, int $quantity)
    {
        $this->cartService->updateQuantity($product, $quantity);

        return $this->success();
    }

    public function removeProduct(Product $product)
    {
        $this->cartService->removeCartProduct($product);

        return $this->success();
    }
}
