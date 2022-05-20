<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (current_user_can('administrator')) {

    /*
  * Template name: Aanmeld_Lijst
  */
    show_admin_bar(false);
    get_header();

    //zodra de leerling geaccepteerd word word de if uitgevoerd waarin , zodra de leerling verwijdert word, word de else if uitgevoerd.
    if (isset($_POST['accept'])) {
        //ik heb hier variabelen defined die ik moet toevoegen om de wpdb queries te laten werken.
        $kd_id = $_POST['kd_id'];
        $leerlingnummer = $_POST['leerlingnummer'];
        $wpdb->query("UPDATE Aanmelding_student SET `Status` = 'accepted' WHERE `keuzedeel_ID` = $kd_id AND `Leerlingnummer` = $leerlingnummer  ");
        $status = 'pending';
        //echo $kd_id . ' en ' . $leerlingnummer . 'worden nu naar de trainer database verzonden.';
        $wpdb->query("INSERT INTO `Aanmelding_student_trainer` (`keuzedeel_ID`, `Leerlingnummer`, `status`) VALUE ('$kd_id', '$leerlingnummer', '$status')");
    } else if (isset($_POST['deny'])) {
        //ik heb hier variabelen defined die ik moet toevoegen om de wpdb queries te laten werken.
        $kd_id = $_POST['kd_id'];
        $leerlingnummer = $_POST['leerlingnummer'];
        $wpdb->query("UPDATE Aanmelding_student SET `Status` = 'geweigerd' WHERE `keuzedeel_ID` = $kd_id AND `Leerlingnummer` = $leerlingnummer  ");
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
                        echo $_POST['leerlingnummer'] . ' is geweigerd voor het keuzedeel "' . $result->keuzedelen_naam . '"';


                        $email = $_POST['leerlingnummer'] . '@student.scalda.nl';

                        $to = "224990@student.scalda.nl";
                        $subject = 'Scalda-Keuzedelen';
                        $message = "Beste,<br><br>Je bent geweigerd voor het keuzedeel $result->keuzedelen_naam door je mentor. <br><br> Met vriendelijke groet,<br>Scalda keuzedelen-systeem";
                        $headers = array('Content-Type: text/html; charset=UTF-8');
                        $attachments = [];
                        wp_mail($to,  $subject,  $message, $headers, $attachments);


                        if (!$email->send()) {
                            echo 'Mailer Error: ' . $email->ErrorInfo;
                        } else {
                            //message is sent!
                        }
                    }
                    if (isset($_POST['accept'])) {
                        $keuzedeel_ID = $_POST['kd_id'];
                        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $keuzedeel_ID");
                        echo $_POST['leerlingnummer'] . ' is geaccepteerd voor het keuzedeel "' . $result->keuzedelen_naam . '"';

                        $email = $_POST['leerlingnummer'] . '@student.scalda.nl';

                        $to = "$email";
                        $subject = 'Scalda-Keuzedelen';
                        $message = "Beste,<br><br>Je bent geaccepteerd voor het keuzedeel $result->keuzedelen_naam door je mentor. <br><br> Met vriendelijke groet,<br>Scalda keuzedelen-systeem";
                        $headers = array('Content-Type: text/html; charset=UTF-8');
                        $attachments = [];
                        wp_mail($to,  $subject,  $message, $headers, $attachments);

                        if (!$email->send()) {
                            echo 'Mailer Error: ' . $email->ErrorInfo;
                        } else {
                            //message is sent!
                        }
                    }
                    ?>
                </h3>
                <br>


                <table id="myTable">
                    <thead>

                        <tr class="header">

                            <!--de titels voor de tabel-->
                            <th style="font-size: 20px;">Keuzedeel-ID</th>
                            <th style="font-size: 20px;">Naam</th>
                            <th style="font-size: 20px;">Mentor Status</th>
                            <th style="font-size: 20px;">Trainer Status</th>
                            <th style="font-size: 20px;">Opties</th>
                        </tr>
                    </thead>
                    <?php

                    //hier worden alle aanmeldingen uit de database gehaald.
                    $result = $wpdb->get_results("SELECT * FROM Aanmelding_student");
                    //hier gaat de foreach door alle aanmeldingen en zet ze in de tabel
                    foreach ($result as $print) {
                        $studentenNummer = $print->Leerlingnummer;
                        if ($studentenNummer != 0) {
                            $result1 = $wpdb->get_results("SELECT * FROM wp_users WHERE student_number = $studentenNummer");
                        }
                    ?>
                        <tr style="font-size: 20px;">
                            <?php $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $print->keuzedeel_ID"); ?>
                            <td class="student-<?= $print->Status ?>"><?= $result->keuzedelen_naam ?></td>
                            <td class="student-<?= $print->Status ?>"><?php
                                                                        foreach ($result1 as $print1) {
                                                                            echo $print1->display_name;
                                                                        }
                                                                        ?></td>
                            <td class="student-<?= $print->Status ?>"><?= $print->Status ?>
                                <?php if ($print->Status == 'accepted') {
                                ?>

                                    <?php $trainerStatus = $wpdb->get_results("SELECT * FROM Aanmelding_student_trainer where Leerlingnummer = $print->Leerlingnummer AND keuzedeel_ID = $print->keuzedeel_ID");
                                    $counterTrainerStatus = 0;
                                    foreach ($trainerStatus as $statusprinter) {
                                        $counterTrainerStatus++; ?>
                            <td class="student-<?= $statusprinter->status ?>">
                                <?php
                                        echo $statusprinter->status;
                                ?></td><?php }
                                        if ($counterTrainerStatus == 0) {
                                            echo "<td class='student-pending'>pending</td>";
                                        }
                                            ?>


                    <?php

                                } else {
                    ?>
                        <td class="student-pending">pending</td>
                    <?php
                                } ?>
                    </td>
                    <td>

                        <?php
                        if ($print->Status != 'accepted') {
                        ?>
                            <form action="<?= get_home_url() . '/aanmeld-lijst/'  ?>" method='post'>
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
                        <?php
                        if ($print->Status != 'geweigerd') {
                        ?>
                            <!--hier staat de verwijder button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                dit word als hidden gezet zodat niemand er last van heeft.-->
                            <form action="<?= get_home_url() . '/aanmeld-lijst/'  ?>" method='post'>
                                <input type="text" name="leerlingnummer" value="<?= $print->Leerlingnummer ?>" hidden>
                                <input type="text" name="kd_id" value="<?= $print->keuzedeel_ID ?>" hidden>
                                <input type="submit" name='deny' value="weigeren">
                            </form>
                        <?php
                        }
                        ?>
                    </td>
                        </tr>
                    <?php }
                    //hier worden de aantal aanmeldingen geteld, het totaal, de nog niet geaccepteerde en de geaccepteerden.
                    $count = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student");
                    $count1 = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student WHERE `Status` = 'pending'");
                    $count2 = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student WHERE `Status` = 'accepted'");
                    echo "Er zijn in totaal $count aanmeldingen waarvan $count1 in afwachting en $count2 zijn geaccepteerd";
                    ?>
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="zoek mentor..." title="">
                </table>
            </div>
        </div>
    </div>
<?php

    get_footer();
} else {
    echo "Je hebt administrator rechten nodig om de pagina te kunnen bekijken! Ga naar de <a href='" . home_url() . "'>home-pagina</a>.";
}

?>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
