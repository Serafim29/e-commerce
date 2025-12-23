<?php

class Product{
    public static function getAllProducts($pdo): mixed {
    $sql = "SELECT * FROM products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductById($id, $pdo): mixed {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createProduct($data, $pdo): mixed {
        $sql = "INSERT INTO products (title, image, brand, description, price, qty) 
                VALUES (:title, :image, :brand, :description, :price, :qty)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':brand', $data['brand']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':qty', $data['qty']);
        return $stmt->execute();
    }

    public static function updateProduct($id, $data, $pdo): mixed {
        $sql = "UPDATE products SET title = :title, image = :image, brand = :brand, 
                description = :description, price = :price, qty = :qty WHERE id = :id";
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
    public static function deleteProduct($id, $pdo): mixed {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public static function count($pdo): mixed {
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public static function totalInventoryValue($pdo): float {
        $sql = "SELECT SUM(price * qty) as total_value FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['total_value'] !== null ? (float)$result['total_value'] : 0.0;
    }
}
?>