<?php
require_once "Database.php";
require_once "Book.php";

$database = new Database();
$db = $database->getConnection();
$book = new Book($db);
$books = $book->readAll();
$booksArray = [];
while ($row = $books->fetch(PDO::FETCH_ASSOC)) {
    $booksArray[] = $row;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .nav { margin-bottom: 20px; }
        .nav a { margin: 10px; text-decoration: none; font-size: 18px; }
        canvas { display: block; margin: auto; }
    </style>
</head>
<body>
    <h1>Moje knihovna</h1>
    <div class="nav">
        <a href="add_book.php">Přidat knihu</a>
        <a href="list_books.php">Seznam knih</a>
        <a href="search_books.php">Vyhledávání</a>
    </div>
    <canvas id="bookshelf"></canvas>
    
    <script>
        const books = <?php echo json_encode($booksArray); ?>;
        const canvas = document.getElementById("bookshelf");
        const ctx = canvas.getContext("2d");
        
        function adjustCanvasSize() {
            let bookCount = books.length;
            let columns = Math.ceil(Math.sqrt(bookCount));
            let rows = Math.ceil(bookCount / columns);
            let bookWidth = Math.max(30, Math.min(80, canvas.width / columns - 10));
            let bookHeight = bookWidth * 1.5;
            canvas.width = columns * (bookWidth + 10);
            canvas.height = rows * (bookHeight + 20) + 50;
        }
        
        function drawShelf(y, maxX) {
            ctx.fillStyle = "#8B4513";
            ctx.fillRect(0, y, maxX + 20, 10);
        }
        
        function drawBook(x, y, title, width, height) {
            ctx.fillStyle = "#4682B4";
            ctx.fillRect(x, y - height, width, height);
            ctx.save();
            ctx.translate(x + width / 2, y - height / 2);
            ctx.rotate(-Math.PI / 2);
            ctx.fillStyle = "white";
            ctx.font = "12px Arial";
            ctx.textAlign = "center";
            ctx.fillText(title.substring(0, 20), 0, 5);
            ctx.restore();
        }
        
        function drawLibrary() {
            adjustCanvasSize();
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            let bookCount = books.length;
            let columns = Math.ceil(Math.sqrt(bookCount));
            let rows = Math.ceil(bookCount / columns);
            let bookWidth = Math.max(30, Math.min(80, canvas.width / columns - 10));
            let bookHeight = bookWidth * 1.5;
            
            let x = 10;
            let y = bookHeight + 10;
            let maxX = 0;
            
            books.forEach((book, index) => {
                drawBook(x, y, book.title, bookWidth, bookHeight);
                maxX = Math.max(maxX, x + bookWidth);
                x += bookWidth + 10;
                if ((index + 1) % columns === 0) {
                    drawShelf(y, maxX);
                    x = 10;
                    y += bookHeight + 20;
                }
            });
            drawShelf(y, maxX);
        }
        
        drawLibrary();
    </script>
</body>
</html>