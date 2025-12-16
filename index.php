<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="img/books.png">
    <title>Bücher - Start</title>
</head>

<body>

    <h1 id="header" class="border">Bücher</h1>

    <div id="content" class="border">

        <div id="start-links">
            <a class="start-link" href="books.php">Liste</a>
            <a class="start-link" id="new-entry-link" href="../books_db/admin/index.php">Anmelden</a>
            <a class="start-link" id="new-entry-link" href="../books_db/admin/buchform.php?id=neu.php">Neuer
                Eintrag</a>
        </div>
    </div>

    <?php require 'footer.php'; ?>

</body>

</html>