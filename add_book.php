<?php
require_once "Database.php";
require_once "Book.php";

$database = new Database();
$db = $database->getConnection();

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book = new Book($db);

    $book->isbn = $_POST["isbn"];
    $book->author_firstname = $_POST["author_firstname"];
    $book->author_lastname = $_POST["author_lastname"];
    $book->title = $_POST["title"];
    $book->description = $_POST["description"];
    $book->cover_image_url = $_POST["cover_image_url"];

    if ($book->create()) {
        $message = "<div class='alert alert-success'>Kniha byla úspěšně přidána!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Chyba při přidávání knihy.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat knihu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Přidání nové knihy</h2>
        <?php echo $message; ?>
        <form method="post" class="border p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="mb-3">
                <label for="author_firstname" class="form-label">Jméno autora</label>
                <input type="text" class="form-control" id="author_firstname" name="author_firstname" required>
            </div>
            <div class="mb-3">
                <label for="author_lastname" class="form-label">Příjmení autora</label>
                <input type="text" class="form-control" id="author_lastname" name="author_lastname" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Název knihy</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Popis</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="cover_image_url" class="form-label">URL obrázku obalu</label>
                <input type="text" class="form-control" id="cover_image_url" name="cover_image_url">
            </div>
            <button type="submit" class="btn btn-primary">Přidat knihu</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
