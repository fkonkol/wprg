<?php

class Cart
{
    private array $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }
    
    public function removeProduct(Product $product)
    {
        $this->products = array_filter(
            $this->products, 
            fn(Product $p) => !(
                $p->getName() === $product->getName() &&
                $p->getQuantity() === $product->getQuantity() &&
                $p->getPrice() === $product->getPrice()
            )
        );
    }

    public function getTotal()
    {
        $total = array_sum(
            array_map(fn(Product $p) => $p->getPrice() * $p->getQuantity(), $this->products)
        );

        return $total;
    }

    public function __toString()
    {
        $s = "Products in cart:\n";

        foreach ($this->products as $product) {
            $s .= "{$product}\n";
        }
        $s .= "Total price: {$this->getTotal()}";

        return $s;
    }
}
