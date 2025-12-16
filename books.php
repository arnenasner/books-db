<?php

# DB-Verbindung
require 'dbconn.php';

# Funktionen
require 'funktionen.php';

# Standartwert für die Suche (deutscher Titel)
$search_option = $radio_vals[0];

# Genre
if (isset($_GET['genre'])) {
    $genre = $_GET['genre'];
} else {
    $genre = '';
}

// echo $genre;

# Hash
$hash = filter_input(INPUT_GET, 'hash');

# Prüfen ob GET manipuliert wurde
if (!empty($genre) && hash($algo, $genre . $salt) == $hash) {
    $genre = null;
}

# Suchfeld empfangen
$search_term = myPostEmpfang('keyword', 30);

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="img/books.png">
    <title>Bücher</title>
</head>

<body>

    <h1 id="header" class="border headline"><a id="icon" href="index.php">📚</a>Bücher</h1>

    <div id="content" class="border">

        <?php

        # Bücher aus der DB abfragen mit $genre
        if ($genre) {
            $query = "SELECT b.id,
                    b.german_title AS `Titel`, 
                    b.original_title AS `Originaltitel`,
                    concat(a.firstname,' ', a.lastname) as 'Name',
                    p.name AS `Verlag`,
                    b.genre AS `Genre`
                FROM books b
                    JOIN author a ON (b.author_id = a.id)
                    JOIN publisher p ON (b.publisher_id = p.id)
                WHERE b.genre = '$genre'
                ORDER BY german_title";
            # Wenn kein Genre gewählt ohne WHERE
        } else {
            $query = "SELECT b.id,
                    b.german_title AS `Titel`, 
                    b.original_title AS `Originaltitel`,
                    concat(a.firstname,' ', a.lastname) as 'Name',
                    p.name AS `Verlag`,
                    b.genre AS `Genre`
                FROM books b
                    JOIN author a ON (b.author_id = a.id)
                    JOIN publisher p ON (b.publisher_id = p.id)
                ORDER BY german_title";
        }

        ########## Suche ##########
        if (isset($_POST['submit'])) {

            # Wenn Suchbegriff eingegeben
            if ($_POST['keyword']) {

                # Suchbegriff
                $keyword = "%" . $_POST['keyword'] . "%";

                # Hochkommas für SQL entschärfen
                $sql_keyword = mysqli_escape_string($mysqli, $keyword);

                // $keyword = str_replace("'", "\'", $keyword);
        
                # Suchoption (Spalte der Tabelle)
                if (isset($_POST['search-option'])) {
                    $search_option = $_POST['search-option'];
                }

                # Testausgabe
                // echo  $search_option . '<br>';
        
                # Abfrage
        
                $query = "SELECT b.id,
                            b.german_title AS `Titel`, 
                            b.original_title AS `Originaltitel`,
                            concat(a.firstname,' ', a.lastname) as 'Name',
                            p.name AS `Verlag`,
                            b.genre AS `Genre`
                        FROM books b
                        JOIN author a ON (b.author_id = a.id)
                        JOIN publisher p ON (b.publisher_id = p.id)
                        WHERE $search_option LIKE '$sql_keyword'
                        ORDER BY $search_option";

                # Testausgabe
                // echo $query;
        
                # SQL ausführen
                $result = mysqli_query($mysqli, $query);

                # Anzahl der Suchergebnisse
                $number_of_rows = mysqli_num_rows($result);
                // echo $number_of_rows;
        
                # Info Anzahl der Suchergebnisse
                switch ($number_of_rows) {
                    case 0:
                        $info[] = 'Leider kein Suchergebnis.';
                        break;
                    case 1:
                        $info[] = $number_of_rows . ' Suchergebnis';
                        break;
                    default:
                        $info[] = $number_of_rows . ' Suchergebnisse';
                }

                mysqli_free_result($result);
            }
            # Wenn kein Suchbegriff eingegeben wurde:
            else {
                $info[] = 'Kein Suchbegriff eingegeben.';
            }
        }

        # Ergebnis der Abfrage
        $result = mysqli_query($mysqli, $query);
        ?>

        <!-- Nach Datensatz suchen  -->
        <form id="search-form" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">Suchbegriff

            <input id="searchfield" type="text" name="keyword" value="<?php if (isset($keyword)) {
                echo htmlspecialchars(substr($keyword, 1, -1));
            } ?>">
            <!-- radios um die Spalte in der gesucht werden sill auszuwählen-->
            <div id="radios">

                <input type="radio" id="<?php $radio_vals[0]; ?>" name="search-option"
                    value="<?php echo $radio_vals[0]; ?>" <?php if ($search_option == $radio_vals[0]) {
                           echo 'checked';
                       } ?>>
                <label for="<?php $radio_vals[0]; ?>">Deutscher Titel</label><br>

                <input type="radio" id="<?php $radio_vals[1]; ?>" name="search-option"
                    value="<?php echo $radio_vals[1]; ?>" <?php if ($search_option == $radio_vals[1]) {
                           echo 'checked';
                       } ?>>
                <label for="<?php $radio_vals[1]; ?>">Englischer Titel</label><br>


                <input type="radio" id="<?php $radio_vals[2]; ?>=" name="search-option" lastname"
                    value="<?php echo $radio_vals[2]; ?>" <?php if ($search_option == $radio_vals[2]) {
                           echo 'checked';
                       } ?>>
                <label for="<?php $radio_vals[2]; ?>">Autor</label>

                <input type="radio" id="<?php $radio_vals[3]; ?>" name="search-option"
                    value="<?php echo $radio_vals[3]; ?>" <?php if ($search_option == $radio_vals[3]) {
                           echo 'checked';
                       } ?>>
                <label for="<?php $radio_vals[3]; ?>">Verlag</label>

            </div>

            <input class="btn" type="submit" name="submit" value="Suchen">

        </form>

        <!-- Genres als Links -->
        <div class="navigation">
            <nav>

                <?php
                #Genres aus DB holen
                $query = "SHOW COLUMNS FROM books LIKE 'genre'";
                $genres = mysqli_query($mysqli, $query);
                $row = mysqli_fetch_row($genres);

                # Enum-Werte in Array speichern und überflüssige Zeichen entfernen
                $enum_values = explode("','", substr(trim(preg_replace("/enum\('/", " ", $row[1])), 0, -2));

                # Alle Bücher
                if ($genre == '') {
                    echo '<a class="active" href="books.php">Alle</a>';
                } else {
                    echo '<a href="books.php">Alle</a>';
                }


                # Werte alphabetisch sortieren
                if (is_array($enum_values)) {
                    sort($enum_values);

                    # Enum-Werte als Links ausgeben
                    foreach ($enum_values as $value) {

                        $hash = hash($algo, $genre . $salt);

                        if (strtolower($value) == $genre) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }

                        echo '<li><a class="' . $active . ' nav-hover" href="books.php?genre=' . strtolower($value) . '&hash=' . $hash . '">' . $value . '</a></li>';
                    }
                }

                ?>

            </nav>

        </div>

        <!-- Ausgabe der Infos -->
        <?php
        if (isset($info)) {

            echo '<p class="info">';
            if (isset($info)) {
                echo implode('<br>', $info);
            }
            echo '</p>';
        }
        ;
        ?>

        <!-- Kopfzeile der Tabelle -->
        <table>
            <thead>
                <tr>
                    <th>
                        Deutscher Titel
                    </th>
                    <th>
                        Originaltitel
                    </th>
                    <th>
                        Autor
                    </th>
                    <th>
                        Verlag
                    </th>
                </tr>
            </thead>
            <?php

            # Tabelleninhalt ausgeben
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td><a class="table-link" href="buchinfos.php?id=' . $row['id'] . '">' . $row['Titel'] . '</a></td>';

                # Wenn kein deutscher Titel vorhanden, englischen Titel als Link ausgeben
                if (empty($row['Titel'])) {
                    echo '<td><a class="table-link" href="buchinfos.php?id=' . $row['id'] . '">' . $row['Originaltitel'] . '</a></td>';
                }
                # Wenn deutscher Title vorhanden englischen Titel nicht als Link ausgeben
                else {
                    echo '<td>' . $row['Originaltitel'] . '</td>';
                }

                echo '<td>' . $row['Name'] . '</td>';
                echo '<td>' . $row['Verlag'] . '</td>';
            }

            mysqli_free_result($result);

            ?>

        </table>

        <?php

        # Link nach oben wenn alle Genres angezeigt werden
        if (!$genre) {
            echo '<a href="#" id="back-to-top">Zurück nach oben</a>';
        }
        ?>

    </div>

    <?php
    require 'footer.php';

    # Datenbankverbindung schliessen
    mysqli_close($mysqli);
    ?>

</body>

</html>