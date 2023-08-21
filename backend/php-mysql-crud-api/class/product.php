<?php
    class Product{

        // conn
        private $conn;

        // table
        private $dbTable = "product";

        // col
        public $id;
        public $p_name;
        public $p_price;
        public $p_old_price;

        public $p_uom
      
         // db conn
         public function __construct($db){
            $this->conn = $db;
        }

        // GET Users
        public function getProducts(){
            $sqlQuery = "SELECT id, p_name, p_price, p_old_price, p_uom
               FROM " . $this->dbTable . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE User
        public function createUser(){
            $sqlQuery = "INSERT INTO
                        ". $this->dbTable ."
                    SET
                    p_name = :p_name, 
                    p_price = :p_price, 
                    p_uom = :p_uom, 
                    p_old_price = :p_old_price";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->p_name=htmlspecialchars(strip_tags($this->p_name));
            $this->p_price=htmlspecialchars(strip_tags($this->p_price));
            $this->p_uom=htmlspecialchars(strip_tags($this->p_uom));
                   
            // bind data
            $stmt->bindParam(":p_name", $this->p_name);
            $stmt->bindParam(":p_price", $this->p_price);
            $stmt->bindParam(":p_uom", $this->p_uom);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

       // GET User
       public function getSingleUser(){
        $sqlQuery = "SELECT
                    id, 
                    p_name, 
                    p_price, 
                    p_uom
                  FROM
                    ". $this->dbTable ."
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->p_name = $dataRow['p_name'];
        $this->p_price = $dataRow['p_price'];
        $this->p_uom = $dataRow['p_uom'];
      
    }      
        

        // UPDATE User
        public function updateUser(){
            $sqlQuery = "UPDATE
                        ". $this->dbTable ."
                    SET
                    p_name = :p_name, 
                    p_price = :p_price, 
                    p_uom = :p_uom
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->p_name=htmlspecialchars(strip_tags($this->p_name));
            $this->p_price=htmlspecialchars(strip_tags($this->p_price));
            $this->p_uom=htmlspecialchars(strip_tags($this->p_uom));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":p_name", $this->p_name);
            $stmt->bindParam(":p_price", $this->p_price);
            $stmt->bindParam(":p_uom", $this->p_uom);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE User
        function deleteUser(){
            $sqlQuery = "DELETE FROM " . $this->dbTable . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>