<!-- Zeigt Session-Infos des angemeldeten Users -->
<div id="login-infos">
    <table id="table-session-infos">
        <tr>
            <td>Angemeldet als:</td>
            <td><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?></td>
        </tr>
        <tr>
            <td>Zuletzt angemeldet:</td>
            <td><?php echo $last_login_date . ' um ' . $last_login_time ?></td>
        </tr>
        <tr>
            <td>Angemeldet seit:</td>
            <td><?php echo date('H:i:s', $_SESSION['login_time']) ?></td>
        </tr>
    </table>
    <a href="logout.php">Abmelden</a>
</div>