<?php

//get all products
function getAllProducts($db)
{
    $sql = 'Select p.name, p.description, p.price, c.name as category from products p ';
    $sql .='Inner Join categories c on p.category_id = c.id';
    $stmt = $db->prepare ($sql);
    $stmt ->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //get product by id
    function getProduct($db, $productId)
    {
    $sql = 'Select p.name, p.description, p.price, c.name as category from products p ';
    $sql .= 'Inner Join categories c on p.category_id = c.id ';
    $sql .= 'Where p.id = :id'; 
    $stmt = $db->prepare ($sql);
    $id = (int) $productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //insert new product
    function createProduct($db, $form_data){
        $sql = 'Insert into products (name, description, price, category_id, created)';
        $sql .= 'values (:name, :description, :price, :category_id, :created)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $form_data['name']);
        $stmt->bindParam(':description', $form_data['description']);
        $stmt->bindParam(':price', floatval($form_data['price']));
        $stmt->bindParam(':category_id', intval($form_data['category_id']));
        $stmt->bindParam(':created', $form_data['created']);
        $stmt->execute();
        return $db->lastInsertID();//insert last number
    }

    //update product
    function updateProduct($db, $form_data, $productId){
        $sql = ' UPDATE products SET name=:name, description=:description, price=:price, category_id=:category_id, created=:created WHERE id=:id';

        $stmt = $db->prepare($sql);
        $id = (int) $productId;
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $form_data['name']);
        $stmt->bindParam(':description', $form_data['description']);
        $stmt->bindParam(':price', floatval($form_data['price']));
        $stmt->bindParam(':category_id', intval($form_data['category_id']));
        $stmt->bindParam(':created', $form_data['created']);
        $stmt->execute();

    }

    //delete product
    function deleteProduct($db, $form_data, $productId){
        $sql = ' DELETE from products WHERE id = :id ';
        $stmt = $db->prepare($sql);
        $id = (int) $productId;
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }