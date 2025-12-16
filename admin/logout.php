<?php

session_start();

# Variablen löschen
session_destroy();

# Cookie löschen
setcookie(session_name(), "", 0, "/");

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/books.png">
</head>

<body>

    <h1 id="header" class="border headline"><a id="icon" href="../index.php">📚</a>Bücher</h1>

    <div id="content" class="border">

        <div class=loggedout-loggedin-info>

            <a id="login-link" href="../index.php">Startseite</a>
            <div>Abgemeldet</div>
            <a id="login-link" href="index.php">Anmelden</a>

        </div>

    </div>

    <?php require '../footer.php'; ?>

</body>

</html>