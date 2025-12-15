<?php
 
class Product {
    public static function getAllProducts($pdo) {
        $sql = "SELECT * FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
    public static function getProductById($id, $pdo) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    public static function createProduct($data, $pdo) {
        $sql = "INSERT INTO products (title, image,brand,description,price,qty) VALUES (:title, :image, :brand, :description, :price, :qty)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':brand', $data['brand']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':qty', $data['qty']);
        return $stmt->execute();
    }

    public static function updateProduct($id, $data, $pdo) {
        $sql = "UPDATE products SET title = :title, image = :image, brand = :brand, description = :description, price = :price, qty = :qty WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':brand', $data['brand']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':qty', $data['qty']);
        return $stmt->execute();
    }
    public static function deleteProduct($id, $pdo) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function count($pdo) {
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}


?>