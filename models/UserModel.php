<?php

/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 9.10.17.
 * Time: 10.25
 */
class UserModel
{
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $type;
    private $pictureUrl;

    public $allUsersList = array();

    /**
     * @return array
     */
    public function getAllUsersList()
    {
        return $this->allUsersList;
    }

    /**
     * @param array $allUsersList
     */
    public function setAllUsersList($allUsersList)
    {
        $this->allUsersList = $allUsersList;
    }

    /**
     * @return mixed
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * @param mixed $pictureUrl
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    //fetch user's by email address
    public function getByEmail($email)
    {
        $query = "select * from person WHERE email=:email";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch();
            $this->id = $result['idperson'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            $this->firstName = $result['firstName'];
            $this->lastName = $result['lastName'];
            $this->type = $result['type'];
            $this->pictureUrl = $result['picture'];
        } catch (Exception $exception) {
            $exception->getMessage();
        }
    }

    //fetch user's by idnumber address
    public function getByID($id)
    {
        $query = "select * from person WHERE idperson=:id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            $this->id = $result['idperson'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            $this->firstName = $result['firstName'];
            $this->lastName = $result['lastName'];
            $this->type = $result['type'];
            $this->pictureUrl = $result['picture'];
            if ($this == null) {
                return false;
            } else {
                return $this;
            }
        } catch (Exception $exception) {
            $exception->getMessage();
            return false;
        }
    }

    //add new user to database
    public function addUser($email, $password, $fname, $lname, $type)
    {
        $sql = "insert into person (email,password,firstName,lastName,type) 
                VALUES (:email, :password, :firstname, :lastname, :tip)";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':firstname', $fname);
            $stmt->bindParam(':lastname', $lname);
            $stmt->bindParam(':tip', $type);
            $stmt->execute();
            if ($stmt->rowCount() !== 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            $exception->getMessage();
            return false;
        }
    }

    //fetches all users from database
    public function allUsers()
    {
        $sql = "select * from person";
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $this->allUsersList = $stmt->fetchAll();

        return $this->allUsersList;
    }

    //if admin updates user
    public function updateUserByAdmin($id, $email, $fname, $lname, $password, $type)
    {
        $sql = 'UPDATE person SET email = :email, firstName = :fname, 
                lastName = :lname, password = :password, type = :tip WHERE idperson = :id';
        try{
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':tip', $type);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        }catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }

    //if user updates data by himself
    public function updateUserByHimself($id, $email, $fname, $lname, $currentPassword, $newPassword, $url)
    {
        $sql = 'UPDATE person SET email = :email, firstName = :fname, 
                lastName = :lname, password = :password, picture = :url WHERE idperson = :id';
        try{
            $this->getByID($id);
            if ($this->getPassword() !== $currentPassword ) {
                return false;
            }
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':url',$url);
            $stmt->execute();

            return $stmt->rowCount();
        }catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }

    public function checkPermission($req)
    {
        $sql = "SELECT * FROM privileges WHERE action = :req";
        try {
            if ($_SESSION != null) {
                $this->getByID($_SESSION['user']);
            }
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':req', $req);
            $stmt->execute();
            $res = $stmt->fetch();
            $minAccessLevel = $res['minAccessLevel'];
            if($minAccessLevel >= $this->getType()) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }

    //delete user with specific id
    public function delete($id)
    {
        $sql = "DELETE from person WHERE idperson = :id";
        try {
            $conn = DB::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->rowCount();
            return $res;
        } catch(PDOException $exception){
            $exception->getMessage();
            return false;
        }
    }
}