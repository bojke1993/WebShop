<?php

class CategoriesModel
{
    private $id;
    private $name;
    private $description;
    private $parent;

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

    public function getParent()
    {
        $sql = "SELECT subcategories.parentID, subcategories.childID, categories.idCategory, categories.name 
                FROM subcategories INNER JOIN categories ON categories.idCategory = subcategories.parentID
                WHERE subcategories.childID= :id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $res = $stmt->fetch();
            $this->parent = $res['name'];
            return $this->parent;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function getChildren($idCat)
    {
        $sql = "SELECT subcategories.childID, subcategories.parentID, categories.name 
                FROM categories 
                JOIN subcategories ON categories.idCategory = subcategories.childID 
                WHERE subcategories.parentID  = :idCat";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idCat', $idCat);
            $stmt->execute();
            $res = $stmt->fetchAll();
            return $res;
        } catch (PDOException $exception) {
            $exception->getMessage();
        }
    }

    public function allCategories()
    {
        $sql = "SELECT * FROM categories";
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

    public function getByID($id)
    {
        $sql = "SELECT * FROM categories WHERE idCategory = :id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->fetch();
            $this->id = $id;
            $this->name = $res['name'];
            $this->description = $res['description'];
            return $this;
        } catch (PDOException $exception) {
            $exception->getMessage();
        }
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE from categories WHERE idCategory = :id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }

    public function updateCategory($id, $name, $desc, $parent)
    {
        $sql = 'UPDATE categories, subcategories SET categories.name = :name, categories.description = :description, 
                subcategories.parentID = :parent WHERE categories.idCategory = :id and subcategories.childID = :id';
        try{
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $desc);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':parent', $parent);
            $ret = $stmt->execute();

            return $ret;
        }catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }

    public function addCategory($name, $desc, $parent)
    {
        $sql = "insert into categories (name, description)
                VALUES (:name, :description)";
        $sql2 = "insert into subcategories (childID, parentID)
                VALUES (:childID, :parentID)";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $desc);
            $inserted = $stmt->execute();
            if ($inserted) {
                $newID = $conn->lastInsertId();
            }
            if ($parent !== 0) {
                $conn2 = DB::getInstance()->getConnection();
                $stmt2 = $conn2->prepare($sql2);
                $stmt2->bindParam(':childID', $newID);
                $stmt2->bindParam(':parentID', $parent);
                $stmt2->execute();
            }

            return true;
        } catch (Exception $exception){
            $exception->getMessage();
            return false;
        }
    }

    public function getByProduct($idProd)
    {
        $sql = "SELECT categories.name, belongs.idProduct, belongs.idCategory
                FROM belongs
                INNER JOIN categories ON categories.idCategory = belongs.idCategory
                WHERE belongs.idProduct = :idProd";
        try{
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idProd', $idProd);
            $stmt->execute();
            $res = $stmt->fetchAll();

            return $res;
        }catch(PDOException $exception){
            $exception->getMessage();

            return false;
        }
    }
}
