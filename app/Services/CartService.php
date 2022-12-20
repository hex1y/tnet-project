<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Auth;
use Illuminate\Database\Eloquent\Builder;

class CartService
{

    public function addCartProduct(Product $product): void
    {
        $existingProduct = Auth::user()
            ->carts()
            ->where('product_id', '=', $product->id)
            ->first();

        if ($existingProduct) {
            $existingProduct->increment('quantity');
        } else {
            Auth::user()
                ->carts()
                ->create([
                    'product_id' => $product->id,
                ]);
        }
    }

    public function updateQuantity(Product $product, int $quantity): void
    {
        Auth::user()
            ->carts()
            ->where('product_id', '=', $product->id)
            ->update([
                'quantity' => $quantity
            ]);
    }

    public function removeCartProduct(Product $product): void
    {
        Auth::user()
            ->carts()
            ->where('product_id', '=', $product->id)
            ->delete();
    }

    public function getUserCart(): array
    {
        $products = Auth::user()->carts->pluck('product');

        return [
            'products' => ProductResource::collection($products),
            'discount' => $this->calculateDiscount(),
        ];
    }

    private function calculateDiscount(): float
    {
        $sale = $this->getSaleProductsWithQuantity();

        if (!$sale) {
            return 0;
        }

        $minQuantity = $sale['quantity'];
        $prices = $sale['prices'];

        $priceSum = 0;

        foreach ($prices as $price) {
            $priceSum += $price * $minQuantity;
        }

        $discount = Auth::user()->userGroup->discount;

        return $priceSum * $discount / 100;
    }

    private function getSaleProductsWithQuantity(): ?array
    {
        $userGroupId = Auth::user()->userGroup?->id ?? 0;

        $sales = Auth::user()
            ->carts()
            ->whereHas('product', function (Builder $pQuery) use ($userGroupId) {
                $pQuery->whereHas('productGroupItem', function (Builder $pgQuery) use ($userGroupId) {
                    $pgQuery->where('user_group_id', '=', $userGroupId);
                });
            })
            ->get();

        if ($sales->isEmpty()) {
            return null;
        }

        return [
            'prices' => $sales->pluck('product.price'),
            'quantity' => $sales->pluck('quantity')->min(),
        ];
    }

}
