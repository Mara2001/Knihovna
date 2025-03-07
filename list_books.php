<?php
require_once "Database.php";
require_once "Book.php";

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);
$books = $book->readAll();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam knih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Seznam knih</h2>
        <div class="row">
            <?php while ($row = $books->fetch(PDO::FETCH_ASSOC)) : ?>
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
                            <p class="card-text mt-2"> <?php echo nl2br(htmlspecialchars($row['description'])); ?> </p>
                            <p class="text-muted">ISBN: <?php echo htmlspecialchars($row['isbn']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
