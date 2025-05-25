

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

}

