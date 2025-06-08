

<?php
require_once 'UniversalDB.php';
class Products extends UniversalDB
{
    public function __construct()
    {
        parent::__construct('products');
    }

    public function getPage()
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * 10;
            $prep = $this->getConnection()->prepare("SELECT * FROM {$this->tableName} LIMIT 10 OFFSET :offset");
            $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
            $prep->execute();

            $prep->setFetchMode(PDO::FETCH_ASSOC);
            return $prep->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public function getCount()
    {
        try {
            $prep = $this->getConnection()->prepare("SELECT COUNT(*) FROM {$this->tableName}");
            $prep->execute();
            $prep->setFetchMode(PDO::FETCH_NUM);
            return $prep->fetch()[0];
        } catch (PDOException $e) {}
    }

    public function updateProduct($id, $name, $price, $description, $image = null)
    {
        try {
            $sql = "UPDATE {$this->tableName} 
                SET name = :name, price = :price, description = :description";

            if ($image === null) {
                $existingProduct = $this->readID($id);
                if (!empty($existingProduct) && isset($existingProduct[0]['blobIMG'])) {
                    $image = $existingProduct[0]['blobIMG'];
                }
            }

            if ($image !== null) {
                $sql .= ", blobIMG = :blobIMG";
            }

            $sql .= " WHERE id = :id";

            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);

            if ($image !== null) {
                $stmt->bindParam(':blobIMG', $image, PDO::PARAM_LOB);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update failed: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }


    public function deleteProduct($id)
    {
        try {
            $prep = $this->getConnection()->prepare("DELETE FROM {$this->tableName} WHERE id = :id");
            $prep->bindParam(':id', $id, PDO::PARAM_INT);
            return $prep->execute();
        } catch (PDOException $e) {
        }

    }
    
    public function createProduct($name, $description, $price, $image) {
        try {
            $stmt = $this->getConnection()->prepare("INSERT INTO {$this->tableName} (name, price, description, blobIMG) VALUES (:name, :price, :description, :blobIMG)");

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':blobIMG', $image, PDO::PARAM_LOB);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Creation failed: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

}

