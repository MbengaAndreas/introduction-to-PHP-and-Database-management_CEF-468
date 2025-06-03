<?php
class Product {
    protected $product_name;
    protected $product_price;

    public function __construct($name, $price) {
        $this->product_name = $name;
        $this->product_price = $price;
    }

    public function displayProduct() {
        echo "Product: {$this->product_name}<br>";
        echo "Price: {$this->product_price}<br>";
    }

    public function getName() {
        return $this->product_name;
    }

    public function getPrice() {
        return $this->product_price;
    }
}
?>