<?php

# DB einbinden
require 'dbconn.php';

# Funktionen 
require 'funktionen.php';

# Session starten
session_start();

# ID empfangen
$id = @$_REQUEST['id'];

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="img/books.png">
    <title>Buchdetails</title>
</head>

<body>

    <h1 id="header" class="border"><a id="icon" href="../books_db/index.php">📚</a>Buchdetails</h1>

    <div id="content" class="border">

        <div id="links">
            <!-- Zurück zur Tabelle -->
            <?php echo '<a class="link" href="books.php">Zurück</a>'; ?>
        </div>

        <?php
        # Alle Filminfos eines bestimmeten Films
        $query = "SELECT b.id,
                        b.german_title AS `Titel`, 
                        b.original_title AS `Originaltitel`,
                        s.series_german AS `Reihe`,
                        s.series_original AS `Originalreihe`,
                        b.genre AS `Genre`,
                        b.author_id,
                        b.translator_id,
                        b.publisher_id,
                        b.place_of_publication_id,
                        a.lastname AS `Nachname Autor`,
                        a.firstname AS `Vorname Autor`,
                        a1.lastname AS `Nachname 2. Autor`,
                        a1.firstname AS `Vorname 2. Autor`,
                        c.country AS `Land`,
                        t.lastname AS `Nachname Übersetzer`,
                        t.firstname AS `Vorname Übersetzer`,
                        t1.lastname AS `Nachname 2. Übersetzer`,
                        t1.firstname AS `Vorname 2. Übersetzer`,
                        t2.lastname AS `Nachname 3. Übersetzer`,
                        t2.firstname AS `Vornname 3. Übersetzer`,
                        p.name AS `Verlag`,
                        b.edition AS `Auflage`, 
                        b.page_number AS `Seitenzahl`, 
                        b.publishing_year AS `Veröffentlichung`, 
                        c.country AS `Land der Veröffentlichung`, 
                        b.isbn AS `ISBN`, 
                        b.rating AS `Bewertung`
                FROM books b
                        JOIN author a ON (b.author_id = a.id)
                        LEFT JOIN author a1 ON (b.author1_id = a1.id)
                        LEFT JOIN translator t ON (b.translator_id = t.id)
                        LEFT JOIN translator t1 ON (b.translator1_id = t1.id)
                        LEFT JOIN translator t2 ON (b.translator2_id = t2.id)
                        LEFT JOIN series s ON (b.series_id = s.id)
                        JOIN publisher p ON (b.publisher_id = p.id)
                        JOIN countries c ON (b.place_of_publication_id = c.id)
                WHERE b.id=$id
            ";

        $result = mysqli_query($mysqli, $query);

        # Daten als Tabelle ausgeben
        while ($row = mysqli_fetch_assoc($result)) {

            echo '<table>';

            # Optionale Felder auf Inhalt prüfen
        
            if ($row['Titel']) {
                echo '<tr>';
                echo '<td>Titel</td>';
                echo '<td>' . $row['Titel'] . '</td>';
                echo '<tr>';
            }

            if ($row['Originaltitel']) {
                echo '<tr>';
                echo '<td>Originaltitel</td>';
                echo '<td>' . $row['Originaltitel'] . '</td>';
                echo '<tr>';
            }

            if ($row['Reihe']) {
                echo '<tr>';
                echo '<td>Reihe</td>';
                echo '<td>' . $row['Reihe'] . '</td>';
                echo '<tr>';
            }

            if ($row['Originalreihe']) {
                echo '<tr>';
                echo '<td>Originalreihe</td>';
                echo '<td>' . $row['Originalreihe'] . '</td>';
                echo '<tr>';
            }

            echo '<tr>';
            echo '<td>Genre</td>';
            echo '<td>' . $row['Genre'] . '</td>';
            echo '<tr>';

            echo '<tr>';
            echo '<td>Autor</td>';
            echo '<td>' . $row['Vorname Autor'] . ' ' . $row['Nachname Autor'] . '</td>';
            echo '<tr>';

            if ($row['Vorname 2. Autor'] || $row['Nachname 2. Autor']) {
                echo '<tr>';
                echo '<td>2. Autor</td>';
                echo '<td>' . $row['Vorname 2. Autor'] . ' ' . $row['Nachname 2. Autor'] . '</td>';
                echo '<tr>';
            }

            if ($row['Vorname Übersetzer'] || $row['Nachname Übersetzer']) {
                echo '<tr>';
                echo '<td>Übersetzer</td>';
                echo '<td>' . $row['Vorname Übersetzer'] . ' ' . $row['Nachname Übersetzer'] . '</td>';
                echo '<tr>';
            }

            if ($row['Vorname 2. Übersetzer'] || $row['Nachname 2. Übersetzer']) {
                echo '<tr>';
                echo '<td>2. Übersetzer</td>';
                echo '<td>' . $row['Vorname 2. Übersetzer'] . ' ' . $row['Nachname 2. Übersetzer'] . '</td>';
                echo '<tr>';
            }

            if ($row['Vornname 3. Übersetzer'] || $row['Nachname 3. Übersetzer']) {
                echo '<tr>';
                echo '<td>3. Übersetzer</td>';
                echo '<td>' . $row['Vornname 3. Übersetzer'] . ' ' . $row['Nachname 3. Übersetzer'] . '</td>';
                echo '<tr>';
            }

            echo '<tr>';
            echo '<td>Land</td>';
            echo '<td>' . $row['Land'] . '</td>';
            echo '<tr>';

            echo '<tr>';
            echo '<td>Verlag</td>';
            echo '<td>' . $row['Verlag'] . '</td>';
            echo '<tr>';

            if ($row['Auflage']) {
                echo '<tr>';
                echo '<td>Auflage</td>';
                echo '<td>' . $row['Auflage'] . '</td>';
                echo '<tr>';
            }

            echo '<tr>';
            echo '<td>Seitenzahl</td>';
            echo '<td>' . $row['Seitenzahl'] . '</td>';
            echo '<tr>';

            echo '<tr>';
            echo '<td>Veröffentlichung</td>';
            echo '<td>' . $row['Veröffentlichung'] . '</td>';
            echo '<tr>';

            if ($row['Land der Veröffentlichung']) {
                echo '<tr>';
                echo '<td>Land der Veröffentlichung</td>';
                echo '<td>' . $row['Land der Veröffentlichung'] . '</td>';
                echo '<tr>';
            }


            echo '<tr>';
            echo '<td>ISBN</td>';
            echo '<td>' . $row['ISBN'] . '</td>';
            echo '<tr>';

            if ($row['Bewertung']) {
                echo '<tr>';
                echo '<td>Bewertung</td>';
                echo '<td>' . $row['Bewertung'] . '</td>';
                echo '<tr>';
            }


            echo '</table>';
        }
        ?>

        <!-- Links bearbeiten/löschen anzeigen wenn User angemeldet ist -->
        <?php if (isset($_SESSION['userid'])) {
            echo '<div id="links">';

            echo '<a class="link" href="./admin/buchform.php?id=' . $id . '">Bearbeiten</a>';
            echo '<a class="link" href="./admin/delete.php?id=' . $id . '">Löschen</a>';
        }
        echo '</div>';
        ?>

    </div>

    <!-- Footer -->
    <?php require 'footer.php';

    # Datenbankverbindung schliessen
    mysqli_close($mysqli);
    ?>

</body>

</html>