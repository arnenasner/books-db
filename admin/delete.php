<?php

# Funktionen
require '../funktionen.php';

# Session starten
session_start();

# Letzter Login
$last_login_date = date('d.m.Y', strtotime($_SESSION['last_login']));
$last_login_time = date('H:i:s', strtotime($_SESSION['last_login']));

# Wenn nicht angemeldet -> index.php
myCheckSession();

# DB
require '../dbconn.php';

# ID 
$id = @$_REQUEST['id'];

# Button
$btn = filter_input(INPUT_POST, 'btn_delete');

# Wenn Formulardaten empfangen
if ($btn == 'delete') {

    # Formulardaten verarbeiten
    $query = 'SELECT * FROM books WHERE `id` = ' . $id . '';
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    # SQL für löschen
    $query = "DELETE FROM books WHERE id=$id";

    #SQL ausführen
    mysqli_query($mysqli, $query);

    # Weiterleitung zur Liste
    header('Location: ../books.php');
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="../img/books.png">
    <title>Buch löschen</title>
</head>

<body>

    <h1 id="header" class="border"><a id="icon" href="../books_db/index.php">📚</a>Buch löschen</h1>

    <div id="content" class="border">

        <!-- Session-Infos anzeigen -->
        <?php require '../login-infos.php';

        # Buch aus DB holen
        $query = 'SELECT * FROM books WHERE `id` = ' . $id . '';
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        $titel = $row['german_title'];
        $originaltitel = $row['original_title'];

        # Nachfragen ob gelöscht werden soll
        echo '<div id="info-delete">';

        # Wenn deutscher Titel vorhanden ist
        if (!empty($titel)) {
            echo '"' . $titel . '"' . ' löschen?';
        }
        # Wenn nur englischer Titel vorhandens ist
        else {
            echo '"' . $originaltitel . '"' . ' löschen?';
        }

        echo '</div>';

        mysqli_close($mysqli);
        ?>

        <form class="book-form" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <section id="section_submit">
                <div class="btn-center">
                    <button class="form-btn" type="submit" name="btn_delete" value="delete">Löschen</button>
                    <button class="form-btn form-btn-cancel" type="button" name="btn_cancel" value="cancel"
                        onClick="window.location.href = '../books.php?';">Abbrechen</button>
                </div>
            </section>

        </form>

    </div>

    <?php require '../footer.php'; ?>

</body>

</html>