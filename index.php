<?php

$host = 'localhost';
$db   = 'Books';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// var_dump($_GET);
$title = $_GET['title'];
$year = $_GET['year'];
$stmt = $pdo->prepare('SELECT * FROM books WHERE title LIKE :title AND release_date LIKE :year');
$stmt->execute(['title' => '%' . $title . '%', 'year' => '%' . $year . '%']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body style="background-color: #FFFFD2;">
<h1 style="color: #326060">Otsing</h1>

    <form action="index.php" method="GET">
        <input id="otsi" name="title" type="text" placeholder="Raamatu pealkiri" value="<?=$title;?>" style="background-color: #FAB282">
        <br>
        <br>
        <input id="otsi" name="year" type="text" placeholder="Raamatu aasta" value="<?=$year;?>" style="background-color: #FAB282">
        <br>
        <br>
        <input id="submit" type="submit" value="Otsi">
    </form>

    <ul>
<?php
while ($row = $stmt->fetch())
{
 echo '<li><a href="./book.php?id=' . $row['id'] . '">' . $row['title'] . "</a></li>";
}
?>
    </ul>
</body>
</html>