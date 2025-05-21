<?php

class Product
{
    public function __construct(
        private string $name,
        private int $price,
        private int $quantity,
    ) {}

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setPrice(float $price) {
        $this->price = $price;
    }

    public function setQuantity(int $quantity) {
        $this->quantity = $quantity;
    }

    public function __toString(): string {
        return "Product: {$this->name}, Price: {$this->price}, Quantity: {$this->quantity}";
    }
}
