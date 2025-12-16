<?php

# DB
require '../dbconn.php';

# Funktionen
require '../funktionen.php';

# Formulardaten empfangen
$email = myPostEmpfang('email', 50);
$password = myPostEmpfang('password', 30);
$btn = myPostEmpfang('btn', 20);

# Wenn Daten gesendet:
if ($btn == 'login') {

    # Formulardaten prüfen

    # Email
    if (empty($email)) {
        $info[] = 'Bitte Email eingeben.';
        # Prüfen ob korrekte Email-Adresse eingegeben
    } elseif (!myCheckEmail($email)) {
        $info[] = $email . ' ist keine gültige Email-Adresse.';
    }

    # Password
    if (empty($password)) {
        $info[] = 'Bitte Passwort eingeben.';
    }


    # Formulardaten verarbeiten
    if (!isset($info)) {

        # Hochkommas entschärfen
        if ($email) {
            $email = mysqli_escape_string($mysqli, $email);
        }

        # SQL user email
        $query = "SELECT * FROM user WHERE `email` = '$email'";

        $result = mysqli_query($mysqli, $query);

        $row = mysqli_fetch_assoc($result);

        # Email vorhanden und password prüfen
        if (mysqli_num_rows($result) == 1 && password_verify($password, $row['password'])) {

            # Session starten
            session_start();

            # Session-Daten
            $_SESSION['userid'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['login_time'] = time();
            $_SESSION['login'] = true;
            $_SESSION['last_login'] = $row['last_login'];

            // $info[] = 'angemeldet';

            mysqli_free_result($result);

            # Anmeldezeit speichern
            $query = "UPDATE user SET last_login = NOW() WHERE `email` = '$email'";

            $result = mysqli_query($mysqli, $query);

            # Weiterleitung zum Formular
            header('Location: logged-in.php');
        }
        # Wenn Daten nicht korrekt: 
        else {
            $info[] = 'Login nicht korrekt.';
        }
    }
}

# Passwort
// echo password_hash('cimdata', PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="../img/books.png">
    <title>Bücher - Login</title>
</head>

<body>

    <h1 id="header" class="border">
        <a id="icon" href="../index.php">📚</a>Login
    </h1>

    <div id="content" class="border">

        <!-- Infos -->
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

        <div id="login-form">
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">

                <section id="section_input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">

                    <label for="passwort">Passwort</label>
                    <input type="password" name="password" id="password">
                </section>

                <section>
                    <button class="btn" type="submit" name="btn" value="login">Login</button>
                </section>

            </form>

        </div>

    </div>

    <?php require '../footer.php'; ?>

</body>

</html>