<?php
require_once "Database.php";

class Book {
    private $conn;
    private $table_name = "books";

    public $id;
    public $isbn;
    public $author_firstname;
    public $author_lastname;
    public $title;
    public $description;
    public $cover_image_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (isbn, author_firstname, author_lastname, title, description, cover_image_url) 
                  VALUES (:isbn, :author_firstname, :author_lastname, :title, :description, :cover_image_url)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":author_firstname", $this->author_firstname);
        $stmt->bindParam(":author_lastname", $this->author_lastname);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":cover_image_url", $this->cover_image_url);

        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function search($criteria) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE 1=1";

        if (!empty($criteria["isbn"])) {
            $query .= " AND isbn LIKE :isbn";
        }
        if (!empty($criteria["author_firstname"])) {
            $query .= " AND author_firstname LIKE :author_firstname";
        }
        if (!empty($criteria["author_lastname"])) {
            $query .= " AND author_lastname LIKE :author_lastname";
        }
        if (!empty($criteria["title"])) {
            $query .= " AND title LIKE :title";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($criteria["isbn"])) {
            $stmt->bindValue(":isbn", "%" . $criteria["isbn"] . "%");
        }
        if (!empty($criteria["author_firstname"])) {
            $stmt->bindValue(":author_firstname", "%" . $criteria["author_firstname"] . "%");
        }
        if (!empty($criteria["author_lastname"])) {
            $stmt->bindValue(":author_lastname", "%" . $criteria["author_lastname"] . "%");
        }
        if (!empty($criteria["title"])) {
            $stmt->bindValue(":title", "%" . $criteria["title"] . "%");
        }

        $stmt->execute();
        return $stmt;
    }
}
?>
