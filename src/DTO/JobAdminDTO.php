<?php

namespace App\DTO;

use App\Entity\Product;

class JobAdminDTO
{
    public Product $product;
    public int $subtotal;
    public string $quantity;
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->subtotal = $product->getPrice()*$quantity;
    }

}


