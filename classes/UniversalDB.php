<?php

class UniversalDB
{
    protected $servername = 'localhost';
    protected $name = "grill";
    protected $con;
    protected $tableName = null;    

    public function __construct(String $tableName)
    {
        try {
            $this->tableName = $tableName;
            $this->con = new PDO("mysql:host={$this->servername};dbname={$this->name}", "root", "");
            // set the PDO error mode to exception
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct(){
        $this->con = null;
    }

    public function getConnection()
    {
        return $this->con;
    }

    public function readAll(array $columns = ['*']) {
        try {
            $columnList = implode(", ", $columns);

            if (!$this->con) {
                throw new RuntimeException("Database connection not established");
            }

            $prep = $this->getConnection()->prepare("SELECT {$columnList} FROM {$this->tableName}");

            $prep->execute();
          
            // set the resulting array to associative
            $prep->setFetchMode(PDO::FETCH_ASSOC);
            $data = $prep->fetchAll();
            return $data;

          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
    }

    public function readID($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new InvalidArgumentException("Invalid ID provided.");
            }
            
            $prep = $this->getConnection()->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
            $prep->bindParam(':id', $id, PDO::PARAM_INT);
            $prep->execute();
            
            // set the resulting array to associative
            $prep->setFetchMode(PDO::FETCH_ASSOC);
            $data = $prep->fetchAll();
            return $data;
        } catch (InvalidArgumentException $e) {
            echo "Validation Error: " . $e->getMessage();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

    public function deleteID($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new InvalidArgumentException("Invalid ID provided.");
            }
            
            $prep = $this->getConnection()->prepare("DELETE FROM {$this->tableName} WHERE id = :id");
            $prep->bindParam(':id', $id, PDO::PARAM_INT);
            $prep->execute();

            if ($prep->rowCount() === 0) {
                throw new RuntimeException("No record found with the provided ID.");
            }
        } catch (InvalidArgumentException $e) {
            echo "Validation Error: " . $e->getMessage();
        } catch (RuntimeException $e) {
            echo "Runtime Error: " . $e->getMessage();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
    
    public function create($name, $email, $password, $description) {
        try {
            if (empty($name) || empty($email) || empty($password) || empty($description)) {
                throw new InvalidArgumentException("All fields are required.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("Invalid email format.");
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $prep = $this->getConnection()->prepare("INSERT INTO {$this->tableName} (name, email, password, description) VALUES (:name, :email, :password, :description)");
            $prep->bindParam(':name', $name);
            $prep->bindParam(':email', $email);
            $prep->bindParam(':password', $hashedPassword);
            $prep->bindParam(':description', $description);
            $prep->execute();
        } catch (InvalidArgumentException $e) {
            echo "Validation Error: " . $e->getMessage();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

    public function update($id, $name, $email, $password, $description) {
        try {
            $stmt = $this->getConnection()->prepare(
                "UPDATE {$this->tableName} 
                 SET name = :name, email = :email, password = :password, description = :description 
                 WHERE id = :id"
            );
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Update failed: " . $e->getMessage());
            throw new Exception("Failed to update record");
        }
    }
    
}

?>