<?php

require 'Product.php';
require 'Cart.php';

$laptop = new Product("Laptop", 1500, 1);
$book = new Product("Book", 120, 1);
$pen = new Product("Pen", 60, 3);

$cart = new Cart();

$cart->addProduct($laptop);
$cart->addProduct($book);
$cart->addProduct($pen);

echo "{$cart}\n";

echo "--------------------------------------\n";

$cart->removeProduct($laptop);

echo "{$cart}\n";
