<?php

require_once "Product.php";

class ProductManager {

    public function __construct(private PDO $db) {}

    
    public function getAllProducts() {

        $stmt = $this->db->query("SELECT * FROM produits");
        return $this->mapProducts($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

  
    public function findByCategory($cat) {

        $stmt = $this->db->prepare("SELECT * FROM produits WHERE category = ?");
        $stmt->execute([$cat]);

        return $this->mapProducts($stmt->fetchAll(PDO::FETCH_ASSOC));
    }


    public function findByName($name) {

        $stmt = $this->db->prepare("SELECT * FROM produits WHERE name LIKE ?");
        $stmt->execute(["%$name%"]);

        return $this->mapProducts($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

   
    public function search($name, $category) {

        $sql = "SELECT * FROM produits WHERE 1=1";
        $params = [];

        if (!empty($name)) {
            $sql .= " AND name LIKE ?";
            $params[] = "%$name%";
        }

        if (!empty($category)) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $this->mapProducts($stmt->fetchAll(PDO::FETCH_ASSOC));
    }


    public function getProduct($code) {

        $stmt = $this->db->prepare("SELECT * FROM produits WHERE code = ?");
        $stmt->execute([$code]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return $this->mapOne($data);
    }

   
    public function findAllCategories() {

        $stmt = $this->db->query("SELECT DISTINCT category FROM produits");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

   
    public function insert(Product $p) {

        $stmt = $this->db->prepare("
            INSERT INTO produits 
            (code, name, price, category, stock, image, on_sale, old_price)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $p->getCode(),
            $p->getName(),
            $p->getPrice(),
            $p->getCategory(),
            $p->getStock(),
            $p->getImage(),
            $p->getOnSale(),
            $p->getOldPrice()
        ]);
    }

  
    public function update(Product $p) {

        $stmt = $this->db->prepare("
            UPDATE produits 
            SET name=?, price=?, category=?, stock=?, image=?, on_sale=?, old_price=?
            WHERE code=?
        ");

        return $stmt->execute([
            $p->getName(),
            $p->getPrice(),
            $p->getCategory(),
            $p->getStock(),
            $p->getImage(),
            $p->getOnSale(),
            $p->getOldPrice(),
            $p->getCode()
        ]);
    }

  
    public function delete($code) {

        $stmt = $this->db->prepare("DELETE FROM produits WHERE code = ?");
        return $stmt->execute([$code]);
    }

    private function mapProducts($data) {

        $products = [];

        foreach ($data as $row) {
            $products[] = $this->mapOne($row);
        }

        return $products;
    }

    private function mapOne($row) {

        return new Product(
            $row['code'],
            $row['name'],
            $row['price'],
            $row['category'],
            $row['stock'],
            $row['image'],
            $row['on_sale'],
            $row['old_price']
        );
    }
}