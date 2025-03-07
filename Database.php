<?php
class Database {
    private $host = "sql110.infinityfree.com";
    private $db_name = "if0_38465536_knihy_db";
    private $username = "if0_38465536";
    private $password = "tD2Jxz2zVaDIzE";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Chyba připojení: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
