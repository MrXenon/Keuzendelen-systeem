<?php /*
  * Template name: WeeklyMailer
  */


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


?>
<table>
    <?php
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM Aanmelding_student_sec");
    
    $table = '';

    foreach ($result as $print) {
        $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $print->keuzedeel_ID");
        $result1 = $wpdb->get_row("SELECT * FROM Aanmelding_student WHERE Leerlingnummer = $print->Leerlingnummer AND keuzedeel_ID = $print->keuzedeel_ID");
        $keuzedelen_naam = $result->keuzedelen_naam;
        $keuzedelen_code = $result->code_keuzedeel;
        $table .= "<tr style='font-size: 20px;'>
            <td> $print->Leerlingnummer </td>
            <td> $keuzedelen_naam </td>
            <td> $keuzedelen_code </td>
            <td> $result1->aanmeld_datum </td>
            <td> $print->aanmeld_datum </td>
        </tr>";
    }
    ?>
</table>
<?php

$mail = new PHPMailer;
$mail->IsSMTP();

$mail->Host = "smtp.office365.com";
$mail->SMTPAuth = true;
$mail->Username = '216690@student.scalda.nl';
$mail->Password = '5sIzlwnp';

$mail->setFrom('216690@student.scalda.nl', 'keuzedelenwebsite');
$mail->addAddress('216690@student.scalda.nl');
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Wekelijkse keuzedelen aanmelding studenten lijst';

$mail->Body    =
    "Beste,<br> Hierbij de lijst leerlingen die is goedgekeurd door mentor en trainer.<br><table border='1'><tablehead><th>Leerling nummer</th><th>Keuzedeel</th><th>Keuzedeel code</th><th>AanmeldDatum</th><th>Datum geaccepteerd</th></tablehead>$table<table><br><br>Met vriendelijke groet,<br>Keuzedelen-Systeem Scalda";

$mail->AltBody = 'Scalda';

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    //message is sent!
    echo 'message has been sent';
}
