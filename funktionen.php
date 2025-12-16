<?php

#################### Funktionen #################### 

/**
 * Liest ein versendetes Formularfeld aus und gibt den gefilterten Wert zurück.
 * @param string $feld Name des Formularfeldes.
 * @param int $laenge Zulässige Länge des Wertes.
 * @return string der gefilterte Wert.
 */
function myPostEmpfang(string $feld, int $laenge)
{
    return filter_input(INPUT_POST, $feld, FILTER_CALLBACK, ['options' => myFilterCallback($laenge)]);
}

/**
 * Callback-Function für filter_input()
 * @param string $laenge zu prüfende Länge des POST-Strings
 * @return Closure 
 */
function myFilterCallback(string $laenge)
{
    # Closure
    return function ($value) use ($laenge) {

        # Länge zu groß
        if (strlen($value) > $laenge) {
            return false;
        }

        # getrimmten Wert zurückgeben
        return trim($value);
    };
}

/**
 * Überprüft, ob eine Email-Adresse valide ist.
 * @param string $email zu überprüfende Email-Adresse.
 * @return string|bool bei korrekter Email-Adresse $email, sonst false.
 */
function myCheckEmail(string $email): string|bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        return $email;
    }
}

/**
 * prüft, ob es eine gültige Session gibt
 */
function myCheckSession()
{

    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {

        header('Location: index.php');
        die('Bitte anmelden.');
    }
}
