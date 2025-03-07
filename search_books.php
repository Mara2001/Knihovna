<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyhledávání knih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Vyhledávání knih</h2>
        <form method="get" class="border p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="author_firstname" class="form-label">Jméno autora</label>
                <input type="text" class="form-control" id="author_firstname" name="author_firstname">
            </div>
            <div class="mb-3">
                <label for="author_lastname" class="form-label">Příjmení autora</label>
                <input type="text" class="form-control" id="author_lastname" name="author_lastname">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Název knihy</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn">
            </div>
            <button type="submit" class="btn btn-primary">Vyhledat</button>
        </form>

        <div class="mt-5">
            <h3>Výsledky hledání</h3>
            <div class="row">
                <?php
                require_once "Database.php";
                require_once "Book.php";

                $database = new Database();
                $db = $database->getConnection();
                $book = new Book($db);

                if ($_GET) {
                    $criteria = [
                        "isbn" => $_GET["isbn"] ?? "",
                        "author_firstname" => $_GET["author_firstname"] ?? "",
                        "author_lastname" => $_GET["author_lastname"] ?? "",
                        "title" => $_GET["title"] ?? "",
                    ];

                    $books = $book->search($criteria);
                    while ($row = $books->fetch(PDO::FETCH_ASSOC)) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($row['cover_image_url'])) : ?>
                                    <img src="<?php echo htmlspecialchars($row['cover_image_url']); ?>" class="card-img-top" alt="Obálka knihy">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"> <?php echo htmlspecialchars($row['title']); ?> </h5>
                                    <h6 class="card-subtitle text-muted">
                                        <?php echo htmlspecialchars($row['author_firstname']) . " " . htmlspecialchars($row['author_lastname']); ?>
                                    </h6>
                                    <p class="text-muted">ISBN: <?php echo htmlspecialchars($row['isbn']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
