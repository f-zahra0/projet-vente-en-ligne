<?php

class Product {

    public function __construct(
        private ?string $code = null,
        private string $name = "",
        private float $price = 0.0,
        private ?string $category = null,
        private int $stock = 0,
        private string $image = "product.jpg",
        private bool $on_sale = false,
        private ?float $old_price = null
    ) {}

   
    public function getCode() { return $this->code; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getCategory() { return $this->category; }
    public function getStock() { return $this->stock; }
    public function getImage() { return $this->image; }
    public function getOnSale() { return $this->on_sale; }
    public function getOldPrice() { return $this->old_price; }

    public function setName($name) { $this->name = $name; }
    public function setPrice($price) { $this->price = $price; }
    public function setCategory($category) { $this->category = $category; }
    public function setStock($stock) { $this->stock = $stock; }
    public function setImage($image) { $this->image = $image; }
    public function setOnSale($on_sale) { $this->on_sale = $on_sale; }
    public function setOldPrice($old_price) { $this->old_price = $old_price; }

  
    public function __toString(): string {
        return $this->code . " - " . $this->name . " (" . $this->price . ")";
    }
}