<?php

class CategoriesModel
{
    private $id;
    private $name;
    private $description;
    private $parent;

    public function getParent($id)
    {
        $sql = "SELECT subcategories.parentID, categories.idCategory, categories.name 
                FROM subcategories INNER JOIN categories ON categories.idCategory = subcategories.childID
                WHERE categories.idCategory = :id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res['name'];
        } catch (PDOException $e) {
            $e->getMessage();
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
        $sql = "SELECT * FROM categories WHERE idproducts = :id";
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


}
