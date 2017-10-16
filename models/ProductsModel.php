<?php

class ProductsModel
{
    private $id;
    private $name;
    private $description;
    private $price;

    //lists all products
    public function allProducts()
    {
        $sql = "SELECT * FROM products";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->fetchAll();
            return $res;
        } catch (PDOException $exception) {
            $exception->getMessage();
        }
    }

    //this function removes selected product from DB
    public function deleteProduct()
    {
        //todo implement method for deleting
    }

    //add product
    public function addProduct()
    {
        //todo implement function for insert new product
    }

    //fetches product info with id as argument
    public function getByID($id)
    {
        $sql = "SELECT * FROM products WHERE idproducts = :id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->fetch();
            $this->id = $id;
            $this->name = $res['name'];
            $this->description = $res['description'];
            $this->price = $res['price'];
            return $this;
        } catch (PDOException $exception) {
            $exception->getMessage();
        }
    }
}