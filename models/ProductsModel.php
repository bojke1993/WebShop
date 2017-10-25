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
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE idproducts = :id";
        try {
            $this->deleteFromBelongs($id);
            $this->deleteProductPicture($id);
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $deleted = $stmt->execute();
            return true;
        } catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }

    //add product
    public function addProduct($name, $desc, $price, $categories, $pictureURL)
    {
        $sql = "INSERT INTO products (name, description, price)
                VALUES (:name, :description, :price)";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $desc);
            $stmt->bindParam(':price', $price);
            $inserted = $stmt->execute();
            $newID = null;
            if ($inserted) {
                //if transaction is successful, we will use id of the last inserted row as argument for
                //adding categories and picture to recently added product
                $newID = $conn->lastInsertId();
            } else {
                throw new ProductErrorException('Product not added!!!');
            }
            $this->addAllCategoriesToProduct($categories, $newID);
            $this->addProductPicture($pictureURL, $newID);
            return true;
        } catch (Exception $exception) {
            $exception->getMessage();
            return false;
        }
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

    //returns all products which belongs to selected category
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

    //returns all product pictures from database
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

    //returns all products that matches with passed filter
    public function searchProducts($filter)
    {
        $param = '%' . $filter . '%';
        $sql = "SELECT * FROM products WHERE name LIKE :param";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':param', $param);
            $stmt->execute();
            $res = $stmt->fetchAll();
            if ($res !== null) {
                return $res;
            }
        } catch (PDOException $exception) {
            $exception->getMessage();
            return false;
        }
    }

    //adding all categories (array) to selected product
    public function addAllCategoriesToProduct($categories, $prodID)
    {
        foreach ($categories as $category) {
            $sql2 = "INSERT INTO belongs (idProduct, idCategory) VALUES (:prodID, :categoryID)";
            $conn2 = DB::getInstance()->getConnection();
            $stmt2 = $conn2->prepare($sql2);
            $stmt2->bindParam(':prodID', $prodID);
            $stmt2->bindParam(':categoryID', $category);
            $inserted = $stmt2->execute();
            if ($inserted == false) {
                throw new ProductErrorException('Categories not added');
            }
        }
    }

    public function addProductPicture($pictureURL, $prodID)
    {
        if ($pictureURL == null) {
            return false;
        }
        $sql = "INSERT INTO productImages (imageUrl, idProd) VALUES (:pictureURL, :productID)";
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pictureURL', $pictureURL);
        $stmt->bindParam(':productID', $prodID);
        $inserted = $stmt->execute();
        if ($inserted == false) {
            throw new PictureException('Picture not uploaded');
        }
    }

    public function deleteProductPicture($id)
    {
        $sql = "DELETE FROM productImages WHERE idProd = :id";
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $deleted = $stmt->execute();
    }

    public function deleteFromBelongs($id)
    {
        $sql = "DELETE FROM belongs WHERE idProduct = :id";
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $deleted = $stmt->execute();
    }

    public function updateProduct($name, $description, $price, $id)
    {
        $sql = 'UPDATE products SET products.name = :name, products.description = :description, products.price = :price
                WHERE products.idproducts = :id';
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':id', $id);
            $ret = $stmt->execute();
            if ($ret == false) {
                throw new ProductErrorException('product not updated!!!');
            }
            return $ret;
        } catch (PDOException $exception) {
            $exception->getMessage();
            return false;
        }
    }

}