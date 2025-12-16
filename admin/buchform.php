<?php

# Funktionen einbinden
require '../funktionen.php';

# Session starten
session_start();

# Letzter Login
$last_login_date = date('d.m.Y', strtotime($_SESSION['last_login']));
$last_login_time = date('H:i:s', strtotime($_SESSION['last_login']));

# Wenn nicht angemeldet -> index.php
myCheckSession();

# DB einbinden
require '../dbconn.php';

# Formulardaten enpfangen und in Variablen speichern
$id = @$_REQUEST['id'];
$title = myPostEmpfang('title', 40);
$originaltitle = myPostEmpfang('originaltitle', 30);
$series_id = myPostEmpfang('series', 10);
$genre = myPostEmpfang('genre', 15);
$author_id = myPostEmpfang('author', 50);
$translator_id = myPostEmpfang('translator', 50);
$publisher_id = myPostEmpfang('publisher', 50);
$edition = myPostEmpfang('edition', 70);
$page_number = myPostEmpfang('page_number', 4);
$publishing_year = myPostEmpfang('publishing_year', 4);
$place_of_publication_id = myPostEmpfang('place_of_publication', 50);
$isbn = myPostEmpfang('isbn', 50);
$rating = myPostEmpfang('rating', 30);
$btn_save = myPostEmpfang('btn_save', 10);

################ Prüfung und Verarbeitung der Formulardaten ###############
# Wurden Formulardaten empfangen?
if ($btn_save == 'save') {

    ########## Formulardaten prüfen ########## 

    if (empty($genre)) {
        $info[] = 'Bitte Genre auswählen.';
    }

    if (empty($author_id)) {
        $info[] = 'Bitte Autor auswählen.';
    }

    if (empty($translator_id)) {
        $info[] = 'Bitte Übersetzer auswählen.';
    }

    if (empty($publisher_id)) {
        $info[] = 'Bitte Verlag eingeben.';
    }

    # Seitenzahl (1 - 2000) 
    $regex = '/^(1\d{3}|1[0-9]\d{2}|1[0-9]{2}|[2-9]\d{2}|[1-9]\d|[1-9]|2000)$/';

    if (empty($page_number || !is_int($page_number))) {
        $info[] = 'Bitte (korrekte) Seitenzahl eingeben.';
    } elseif (preg_match($regex, $page_number) === 0) {
        $info[] = 'Seitenzahl ausserhalb des erlaubten Bereichs.';
    }

    # Jahreszahl (1454 - 2024) 
    $regex = '/\b(145[4-9]|14[6-9]\d|1[5-9]\d{2}|20[01]\d{2}|202[0-4])\b/';

    if (empty($publishing_year)) {
        $info[] = 'Bitte Jahreszahl für die Veröffentlichung eingeben.';
    } elseif (preg_match($regex, $publishing_year) === 0) {
        $info[] = 'Jahrezahl ausserhalb des erlaubten Bereichs.';
    }

    if (empty($place_of_publication_id)) {
        $info[] = 'Bitte Land auswählen.';
    }

    # ISBN 10 / ISBN 13
    $regex = '/^(?:ISBN(?:-1[03])?:? )?(?=[0-9X]{10}$|(?=(?:[0-9]+[-  ]){3})[-  0-9X]{13}$|97[89][0-9]{10}$|(?=(?:[0-9]+[-  ]){4})[-  0-9]{17}$)(?:97[89][- ]?)?[0-9]{1,5}[- ]?[0-9]+[- ]?[0-9]+[- ]?[0-9X]$/';

    if (empty($isbn)) {
        $info[] = 'Bitte ISBN eingeben.';
    } elseif (preg_match($regex, $isbn) === 0) {
        $info[] = $isbn . ' ist keine korrekte ISBN.';
    }

    if (empty($rating)) {
        $info[] = 'Bitte Bewertung auswählen.';
    }

    ########## Formulardaten verarbeiten ########## 
    if (!isset($info)) {

        # Daten für SQL aufbereiten
        if (empty($originaltitle)) {
            $series_id = "NULL";
        }

        if ($series_id == 0) {
            $series_id = 'NULL';
        }

        if ($translator_id == 0) {
            $translator_id = 'NULL';
        }

        if ($place_of_publication_id == 0) {
            $place_of_publication_id = 'NULL';
        }

        if ($rating == 0) {
            $rating = 'NULL';
        }

        # Hochkommas für SQL entschärfen
        $sql_title = mysqli_escape_string($mysqli, $title);
        $sql_originaltitle = mysqli_escape_string($mysqli, $originaltitle);


        # Neues Buch in die DB eintragen
        if ($id == 'neu') {

            # SQL Buch eintragen
            $query = "INSERT INTO books(
                `german_title`,
                `original_title`,
                `series_id`,
                `genre`,
                `author_id`,
                `translator_id`,
                `publisher_id`,
                `edition`,
                `page_number`,
                `publishing_year`,
                `place_of_publication_id`,
                `isbn`,
                `rating`
                )
            VALUES (
                '$sql_title',
                '$sql_originaltitle',
                $series_id,
                '$genre',
                $author_id,
                $translator_id,
                $publisher_id,
                '$edition',
                $page_number,
                '$publishing_year',
                $place_of_publication_id,
                '$isbn',
                '$rating'
            )";

            # Testausgabe
            echo $query;

            # SQL ausführen
            mysqli_query($mysqli, $query);

            # Weiterleitung
            header('Location: registered.php');
            // header('Refresh: 3; url=registered.php');



            # Wenn Buch vorhanden
        } elseif (is_numeric($id)) {

            # SQL Buch aktualisieren
            $query = "UPDATE books SET
                        `german_title`             = '$sql_title ',
                        `original_title`           = '$sql_originaltitle',
                        `series_id`                = $series_id,
                        `genre`                    = '$genre',
                        `author_id`                = $author_id,
                        `translator_id`            = $translator_id,
                        `publisher_id`             = $publisher_id,
                        `edition`                  = '$edition',
                        `page_number`              = $page_number,
                        `publishing_year`          = '$publishing_year',
                        `place_of_publication_id`  = $place_of_publication_id,
                        `isbn`                     = '$isbn',
                        `rating`                   = '$rating'
                WHERE id = $id";

            # Testausgabe
            // echo $query;

            # SQL ausführen
            mysqli_query($mysqli, $query);
        }

        # Weiterleitung
        header('Location: registered.php');
        // header('Refresh: 3; url=registered.php');
    }
}
############ Buch aus DB holen ###########
elseif ($id != 'neu' && is_numeric($id) > 0) {

    # Buch aus DB laden und im Formular darstellen
    $query = "SELECT b.id,
                b.german_title      AS `Titel`, 
                b.original_title    AS `Originaltitel`,
                s.series_german     AS `Reihe`,
                b.genre             AS `Genre`,
                a.lastname          AS `Nachname Autor`,
                a.firstname         AS `Vorname Autor`,
                t.lastname          AS `Nachname Übersetzer`,
                t.firstname         AS `Vorname Übersetzer`,
                p.name              AS `Verlag`,
                b.edition           AS `Auflage`, 
                b.page_number       AS `Seitenzahl`, 
                b.publishing_year   AS `Veröffentlichung`, 
                c.country           AS `Land der Veröffentlichung`, 
                b.isbn              AS `ISBN`, 
                b.rating            AS `Bewertung`
            FROM books b
                JOIN author a ON (b.author_id = a.id)   
                LEFT JOIN translator t ON (b.translator_id = t.id)
                LEFT JOIN series s ON (b.series_id = s.id)
                JOIN publisher p ON (b.publisher_id = p.id)
                JOIN countries c ON (b.place_of_publication_id = c.id)
            WHERE b.id=$id";

    # SQL
    $result = mysqli_query($mysqli, $query);

    # Ergebnis
    $row = mysqli_fetch_assoc($result);

    # $row in die Variablen für das Formular speichern 
    $title = $row['Titel'];
    $originaltitle = $row['Originaltitel'];
    $series_german = $row['Reihe'];
    $genre = $row['Genre'];
    $lastname_author = $row['Nachname Autor'];
    $firstname_author = $row['Vorname Autor'];
    $lastname_translator = $row['Nachname Übersetzer'];
    $firstname_translator = $row['Vorname Übersetzer'];
    $publisher = $row['Verlag'];
    $edition = $row['Auflage'];
    $page_number = $row['Seitenzahl'];
    $publishing_year = $row['Veröffentlichung'];
    $publishing_land = $row['Land der Veröffentlichung'];
    $isbn = $row['ISBN'];
    $rating = $row['Bewertung'];
    $id = $row['id'];

    # Ergebnis löschen
    mysqli_free_result($result);
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="../img/books.png">
    <title>Buch - Bearbeiten/Speichern</title>
</head>

<body>

    <h1 id="header" class="border"><a id="icon" href="../index.php">📚</a>Buch - Bearbeiten/Speichern</h1>

    <div id="content" class="border">

        <!-- Session-Infos anzeigen -->
        <?php require '../login-infos.php';

        if (isset($info)) {
            # Drei Sekunden nach Info Formular mit id neu laden
            header('Refresh: 3; url=buchform.php?id=' . $id . '');

            echo '<p class="info">';
            if (isset($info)) {
                echo implode('<br>', $info);
            }
            echo '</p>';
        }
        ;

        # Wenn Titel vorhanden anzeigen
        if ($title) {
            echo '<div id="links">';
            echo '<h2 class="title-form">' . $title . '</h2>';
            echo '</div>';
        }

        ?>

        <form class="book-form" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
            <fieldset>

                <p>
                    <label for="title">Buchtitel</label>
                    <input type="text" name="title" id="title" maxlength="150" value="<?php if ($title) {
                        echo htmlspecialchars($title);
                    }
                    ; ?>">
                </p>

                <p>
                    <label for="title">Originaltitel</label>
                    <input type="text" name="originaltitle" id="originaltitle" maxlength="150" value="<?php if ($originaltitle) {
                        echo htmlspecialchars($originaltitle);
                    }
                    ; ?>">
                </p>

                <p>
                    <label for="title">Reihe</label>
                    <select name="series" id="series">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php
                        # Reihe aus DB holen
                        $query = "SELECT * from series";
                        $result = mysqli_query($mysqli, $query);

                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($row['series_german'] == $series_german) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['series_german'] . '</option>';
                        }

                        mysqli_free_result($result);

                        ?>

                    </select>
                </p>

                <p>
                    <label for="title">Genre*</label>
                    <select name="genre" id="genre">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php

                        # Enum-Werte für Genre aus DB holen
                        $query = "SHOW COLUMNS FROM books LIKE 'genre'";
                        $result = mysqli_query($mysqli, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_row($result);

                            # Enum-Werte in Array speichern und überflüssige Zeichen entfernen
                            $values = explode("','", substr(trim(preg_replace("/enum\('/", " ", $row[1])), 0, -2));
                        }

                        # Werte alphabetisch sortieren
                        sort($values);

                        # Enum-Werte als <option> ausgeben
                        foreach ($values as $value) {

                            if ($genre == $value) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $value . '" ' . $selected . '  >' . $value . '</option>';
                        }

                        ?>

                    </select>
                </p>

                <p>
                    <label for="title">Autor*</label>
                    <select name="author" id="author">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php

                        # Autoren aus DB holen
                        $query = "SELECT * from author";
                        $result = mysqli_query($mysqli, $query);

                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($row['lastname'] == $lastname_author) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['lastname'] . ', ' . $row['firstname'] . '</option>';
                        }

                        mysqli_free_result($result);

                        ?>

                    </select>

                </p>
                <p>
                    <label for="title">Übersetzer*</label>
                    <select name="translator" id="translator">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php

                        # Übersetzer aus DB holen
                        $query = "SELECT * from translator";
                        $result = mysqli_query($mysqli, $query);

                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($row['lastname'] == $lastname_translator) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['lastname'] . ', ' . $row['firstname'] . '</option>';
                        }

                        mysqli_free_result($result);

                        ?>

                    </select>
                </p>

                <p>
                    <label for="title">Verlag*</label>
                    <select name="publisher" id="publisher">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php
                        # Verlage aus DB holen
                        $query = "SELECT * from publisher";
                        $result = mysqli_query($mysqli, $query);

                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($row['name'] == $publisher) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['name'] . '</option>';
                        }

                        mysqli_free_result($result);

                        ?>

                    </select>
                </p>

                <p>
                    <label for="title">Auflage</label>
                    <input type="text" name="edition" id="edition" maxlength="150" value="<?php echo $edition; ?>">
                </p>

                <p>
                    <label for="title">Seitenzahl (1 - 2000)*</label>
                    <input type="number" name="page_number" id="page_number" maxlength="150"
                        value="<?php echo $page_number; ?>">
                </p>

                <p>
                    <label for="title">Veröffentlichung (1454 - 2024)*</label>
                    <input type="text" name="publishing_year" id="publishing_year" maxlength="150"
                        value="<?php echo $publishing_year; ?>">
                </p>

                <p>
                    <label for="title">Land der Veröffentlichung*</label>
                    <select name="place_of_publication" id="place_of_publication">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php
                        # Länder aus DB holen
                        $query = "SELECT * from countries";
                        $result = mysqli_query($mysqli, $query);

                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($row['country'] == $publishing_land) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['country'] . '</option>';
                        }

                        mysqli_free_result($result);

                        ?>

                    </select>
                </p>

                <p>
                    <label for="title">ISBN (10 oder 13)*</label>
                    <input type="text" name="isbn" id="isbn" maxlength="150" value="<?php echo $isbn; ?>">
                </p>

                <p>
                    <label for="title">Bewertung*</label>
                    <select name="rating" id="rating">
                        <option value="0" hidden>Bitte auswählen</option>

                        <?php
                        # Enum-Werte für die Bewertung aus DB holen
                        $query = "SHOW COLUMNS FROM books LIKE 'rating'";
                        $result = mysqli_query($mysqli, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result); // Use mysqli_fetch_assoc() instead
                        
                            # Enum-Werte in Array speichern und überflüssige Zeichen entfernen
                            $values = explode("','", substr(trim(preg_replace("/enum\('/", " ", $row['Type'])), 0, -2));
                        }

                        # Enum-Werte als <option ausgeben>
                        foreach ($values as $value) {

                            if ($rating == $value) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }

                            echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                        }
                        ?>

                    </select>
                </p>

                <!-- verstecktes Feld für Film-ID -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <section>
                    <div class="btn-center">
                        <button class="form-btn" type="submit" name="btn_save" value="save">Speichern</button>
                        <button class="form-btn form-btn-cancel" type="button" name="btn_cancel" value="cancel"
                            onClick="window.location.href = '../books.php';">Abbrechen</button>
                    </div>
                </section>

            </fieldset>
        </form>

    </div>
    <?php
    require '../footer.php';

    # Datenbankverbindung schliessen
    mysqli_close($mysqli);
    ?>


</body>

</html>