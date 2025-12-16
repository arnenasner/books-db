<?php

session_start();

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <title>Eingetragen</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/books.png">
</head>

<body>

    <h1 id="header" class="border headline"><a id="icon" href="../index.php">📚</a>Eingetragen</h1>

    <div id="content" class="border">

        <div class=loggedout-loggedin-info>

            <a id="login-link" href="../books.php">Bücher</a>
            <div>Eingetragen</div>
            <a id="login-link" href="buchform.php?id=neu">Neuer Eintrag</a>

        </div>

    </div>

    <?php require '../footer.php'; ?>

</body>

</html>