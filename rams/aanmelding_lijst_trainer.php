<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// if (current_user_can('administrator')) {

    /*
  * Template name: Aanmeld_Lijst_Trainer
  */
    show_admin_bar(false);
    get_header();
    //ik heb hier variabelen defined die ik moet toevoegen om de wpdb queries te laten werken.
    $kd_id = $_POST['kd_id'];
    $leerlingnummer = $_POST['leerlingnummer'];
    //zodra de leerling geaccepteerd word word de if uitgevoerd waarin , zodra de leerling verwijdert word, word de else if uitgevoerd.
    if (isset($_POST['accept'])) {
        $wpdb->query("UPDATE Aanmelding_student_trainer SET `Status` = 'accepted' WHERE `keuzedeel_ID` ='$kd_id' AND `Leerlingnummer` ='$leerlingnummer'  ");
        $wpdb->query("UPDATE Keuzedelen SET `plaatsen_bezet` = `plaatsen_bezet` + 1 WHERE `keuzedeel_ID` ='$kd_id'  ");
        $status = 'pending';
        $wpdb->query("INSERT INTO `Aanmelding_student_sec` (keuzedeel_ID, Leerlingnummer) VALUE ('$kd_id', '$leerlingnummer')");
    } else if (isset($_POST['deny'])) {
        $wpdb->query("UPDATE Aanmelding_student_trainer SET `Status` = 'geweigerd' WHERE `keuzedeel_ID` = $kd_id AND `Leerlingnummer` = $leerlingnummer  ");
    } else if (isset($_POST['afmelden'])) {
        $wpdb->query("UPDATE Aanmelding_student_trainer SET `Status` = 'afgerond' WHERE `keuzedeel_ID` ='$kd_id' AND `Leerlingnummer` ='$leerlingnummer'  ");
        $status = 'afgerond';
    }

?>
    <div class="col-sm-12 text-break">
        <div class="post-inner">
            <div class="post-content">
                <h1><?= wp_title() ?></h1>
                <h3 class="text-right">
                    <?php

                    global $wpdb;

                    if (isset($_POST['deny'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");

                        $email = $_POST['leerlingnummer'] . '@student.scalda.nl';

                        $to = "$email";
                        $subject = 'Scalda-Keuzedelen';
                        $message = "Beste,<br><br>Je bent geweigerd voor het keuzedeel $result->keuzedelen_naam door jouw trainer. <br><br> Met vriendelijke groet,<br>Scalda keuzedelen-systeem";
                        $headers = array('Content-Type: text/html; charset=UTF-8');
                        $attachments = [];
                        wp_mail($to,  $subject,  $message, $headers, $attachments);


                        if (!$mail->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                            //message is sent!
                        }
                    } else if (isset($_POST['accept'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");

                        $email = $_POST['leerlingnummer'] . '@student.scalda.nl';

                        $mail = new PHPMailer;
                        $mail->IsSMTP();

                        $mail->Host = "smtp.office365.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = '216690@student.scalda.nl';
                        $mail->Password = '5sIzlwnp';

                        $mail->setFrom('216690@student.scalda.nl', 'keuzedelenwebsite');
                        $mail->addAddress($email);
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Scalda-keuzedelen ';

                        $mail->Body = "Beste,<br><br>Je bent geaccepteerd voor het keuzedeel $result->keuzedelen_naam door jouw trainer. <br><br> Met vriendelijke groet,<br>Scalda keuzedelen-systeem";

                        $mail->AltBody = 'Scalda';

                        if (!$mail->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                            //message is sent!
                        }
                    } else if (isset($_POST['afmelden'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");

                        $email = $_POST['leerlingnummer'] . '@student.scalda.nl';

                        $mail = new PHPMailer;
                        $mail->IsSMTP();

                        $mail->Host = "smtp.office365.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = '216690@student.scalda.nl';
                        $mail->Password = '5sIzlwnp';

                        $mail->setFrom('216690@student.scalda.nl', 'keuzedelenwebsite');
                        $mail->addAddress($email);
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Scalda-keuzedelen ';

                        $mail->Body = "Beste,<br><br>Je hebt het keuzedeel $result->keuzedelen_naam afgerond, dit is in het systeem verwerkt door jouw trainer. <br><br> Met vriendelijke groet,<br>Scalda keuzedelen-systeem";

                        $mail->AltBody = 'Scalda';

                        if (!$mail->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                            //message is sent!
                        }
                    }
                    ?>
                </h3>
                <h3 class="text-right">
                    <?php
                    if (isset($_POST['deny'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");
                        echo $_POST['leerlingnummer'] . ' is geweigerd voor het keuzedeel "' . $result->keuzedelen_naam . '"';
                    }
                    if (isset($_POST['accept'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");
                        echo $_POST['leerlingnummer'] . ' is geaccepteerd voor het keuzedeel "' . $result->keuzedelen_naam . '"';
                    }
                    if (isset($_POST['afmelden'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");
                        echo $_POST['leerlingnummer'] . ' is als afgerond in het systeem verwerkt voor het keuzedeel "' . $result->keuzedelen_naam . '"';
                    }
                    ?>
                </h3>
                <br>
                <table>
                    <tr>
                        <!--de titels voor de tabel-->
                        <th style="font-size: 20px;">Keuzedeel-Naam</th>
                        <th style="font-size: 20px;">Student Naam</th>
                        <th style="font-size: 20px;">Status<br>
                            <?php
                            if (isset($_POST['filter_status'])) {
                                $filter = $_POST['filter_name'];
                            }
                            ?>
                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                <select name="filter_name">
                                    <option <?php if ($_POST['filter_name'] == 'pending') {
                                                echo 'selected';
                                            } ?>>pending
                                    </option>
                                    <option <?php if ($_POST['filter_name'] == 'accepted') {
                                                echo 'selected';
                                            } ?>>accepted
                                    </option>
                                    <option <?php if ($_POST['filter_name'] == 'geweigerd') {
                                                echo 'selected';
                                            } ?>>geweigerd
                                    </option>
                                    <option <?php if ($_POST['filter_name'] == 'afgerond') {
                                                echo 'selected';
                                            } ?>>afgerond
                                    </option>
                                </select>
                                <input name="filter_status" type="submit" value="Filter">
                            </form>
                        </th>
                        <th style="font-size: 20px;">Opties</th>
                    </tr>
                    <?php
                    global $wpdb;
                    //hier worden alle aanmeldingen uit de database gehaald.
                    $result = $wpdb->get_results("SELECT * FROM Aanmelding_student_trainer");
                    //hier gaat de foreach door alle aanmeldingen en zet ze in de tabel
                    foreach ($result as $print) {
                        $studentenNummer = $print->Leerlingnummer;
                        if ($studentenNummer != 0) {
                            $result1 = $wpdb->get_results("SELECT * FROM wp_users WHERE student_number = $studentenNummer");
                        }
                        if (isset($_POST['filter_status'])) {
                            if ($filter == $print->status) {
                    ?>
                                <tr style="font-size: 20px;" class="student-<?= $print->status ?>">
                                    <?php $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $print->keuzedeel_ID"); ?>
                                    <td><?= $result->keuzedelen_naam ?></td>
                                    <td><?php
                                        foreach ($result1 as $print1) {
                                            echo $print1->display_name;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $print->status ?></td>
                                    <td>

                                        <?php
                                        if ($print->status != 'accepted') {
                                        ?>
                                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                                <!--hier staat de accepteer button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                        dit word als hidden gezet zodat niemand er last van heeft.-->
                                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                                <input type="submit" name='accept' value="accepteren">
                                            </form>
                                            <br>
                                        <?php
                                        }
                                        ?>
                                        <!--hier staat de weiger button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                dit word als hidden gezet zodat niemand er last van heeft.-->
                                        <?php
                                        if ($print->status != 'geweigerd') {
                                        ?>
                                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                                <input type="submit" name='deny' value="weigeren">
                                            </form><br>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($print->status != 'afgerond') {
                                        ?>
                                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                                <input type="submit" name='afmelden' value="Afgerond">
                                            </form>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                        } else if (!isset($_POST['filter_status'])) {
                            if ("pending" == $print->status) {
                            ?>
                                <tr style="font-size: 20px;" class="student-<?= $print->status ?>">
                                    <?php $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $print->keuzedeel_ID"); ?>
                                    <td><?= $result->keuzedelen_naam ?></td>
                                    <td><?php
                                        foreach ($result1 as $print1) {
                                            echo $print1->display_name;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $print->status ?></td>
                                    <td>

                                        <?php
                                        if ($print->status != 'accepted') {
                                        ?>
                                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                                <!--hier staat de accepteer button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                        dit word als hidden gezet zodat niemand er last van heeft.-->
                                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                                <input type="submit" name='accept' value="accepteren">
                                            </form>
                                            <br>
                                        <?php
                                        }
                                        ?>
                                        <!--hier staat de weiger button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                dit word als hidden gezet zodat niemand er last van heeft.-->
                                        <?php
                                        if ($print->status != 'geweigerd') {
                                        ?>
                                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                                <input type="submit" name='deny' value="weigeren">
                                            </form><br>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($print->status != 'afgerond') {
                                        ?>
                                            <form action="<?= get_home_url() . '/aanmeld-lijst-trainer/'  ?>" method='post'>
                                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                                <input type="submit" name='afmelden' value="Afgerond">
                                            </form>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
                    }
                    //hier worden de aantal aanmeldingen geteld, het totaal, de nog niet geaccepteerde en de geaccepteerden.
                    $count = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student_trainer");
                    $count1 = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student_trainer WHERE `Status` = 'pending'");
                    $count2 = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student_trainer WHERE `Status` = 'accepted'");
                    echo "Er zijn in totaal $count aanmeldingen waarvan $count1 in afwachting en $count2 zijn geaccepteerd";
                    ?>
                </table>
            </div>
        </div>
    </div>
<?php

    get_footer();
// } else {
//     echo "Je hebt administrator rechten nodig om de pagina te kunnen bekijken! Ga naar de <a href='" . home_url() . "'>home-pagina</a>.";
// }

?>
