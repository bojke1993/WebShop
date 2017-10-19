<?php

class ProductsModel
{
    private $id;
    private $name;
    private $description;
    private $price;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

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

    public function getByCategory($idCat)
    {
        $sql = "SELECT products.idproducts, products.name, products.price, products.description, belongs.idCategory 
                FROM products
                INNER JOIN belongs ON products.idproducts = belongs.idProduct
                WHERE belongs.idCategory = :idCat";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idCat', $idCat);
            $stmt->execute();
            $res = $stmt->fetchAll();
            return $res;
        } catch(PDOException $exception) {
            $exception->getMessage();
            return false;
        }
    }

    public function getAllProductPictures($idProd)
    {
        $sql = "SELECT * 
                FROM productImages
                WHERE idProd = :idProd";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idProd', $idProd);
            $stmt->execute();
            $res = $stmt->fetchAll();
            return $res;
        } catch(PDOException $exception) {
            $exception->getMessage();
            return false;
        }
    }
}