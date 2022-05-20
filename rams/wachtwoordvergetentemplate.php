<?php /*
  * Template name: WWvergeten
  */






if (is_user_logged_in()) {
    exit("Om deze pagina te bekijken moet je uitgelogd zijn, ga alstublieft naar de <a href=' " . site_url('/wat-zijn-keuzedelen/') . "'>Homepage</a>");
}
?>
<a href="<?= get_home_url(); ?>">
    <-Terug naar inlogscherm </a>
        <div class="col-sm-12 text-break">
            <div class="post-inner">
                <div class="post-content">
                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                        Vul uw E-mail adres hieronder in om een nieuw wachtwoord in te stellen:<br>
                        <input type="text" size="35" name="Email" placeholder="Email">
                        <input type="submit" value="Verzenden" name="submit">
                    </form>
                </div>
            </div>
        </div>
        <?php
        $email = $_POST['Email'];
        global $wpdb;
        $admin = $wpdb->get_var("SELECT COUNT(*) FROM wp_users WHERE user_nicename = 'keuzedelen-systeem' AND user_email = '$email'");
        $count = $wpdb->get_var("SELECT COUNT(*) FROM wp_users WHERE user_email = '$email'");
        if ($_POST['submit']) {
            if ($email == '') {
                echo 'Vul een E-mail adres in!';
                exit;
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo 'Dit is geen geldig E-mail adres!';
                exit;
            } else if ($count == 0 || $admin >= 1) {
                echo 'Dit E-mail adres staat niet in het systeem!';
                exit;
            } else if ($email != '') {
                $passwordgen = PWGen();
                $newpassword = wp_hash_password($passwordgen);
                echo 'Er is een email naar: ' . $_POST['Email'] . ' gestuurd met het nieuwe wachtwoord. ';
            }
            $wpdb->update('wp_users', array('user_pass' => $newpassword), array('user_email' => $email));

            $to = "$email";
            $subject = 'Nieuw wachtwoord';
            $message = "Beste,\n\nHierbij uw nieuwe wachtwoord voor mit-keuzedelen.nl\nWachtwoord: $passwordgen\n\nFijne dag gewenst!";
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $attachments = [];
            wp_mail($to,  $subject,  $message, $headers, $attachments);
        } ?>
