<?php
//php mailer requirements, dit is nodig om de mailfunctie te laten werken.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//php mailer requirements end
$id = $_GET['id'];

global $wpdb;
$keuzedelen = $wpdb->get_results("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = '$id'")[0];

$keuzedeel_ID = $id;
$current_user = wp_get_current_user();
$studentnummer = $current_user->student_number;
$status = 'pending';
$current_email = $current_user->user_email;
//als er op de aanmeld knop gedrukt word, word dit uitgevoerd.
if (isset($_POST['submit'])) {
    $count = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student WHERE keuzedeel_ID = '$id' AND Leerlingnummer = '$studentnummer' ");
    if ($count >= 1) {
        //zodra je al bij een keuzedeel staat aangemeld, dit word gechecked in de database of jij en het id in de database staat op de zelfde regel, krijg je een melding.
        echo 'Je hebt je al aangemeld bij dit keuzedeel!';
    } else {
        //als je nog niet staat aangemeld word er je hieronder in de database gezet.
        $wpdb->query("INSERT INTO `Aanmelding_student` (keuzedeel_ID, Leerlingnummer, Status) VALUE ('$keuzedeel_ID', '$studentnummer', '$status')");

        $plaatsenBezet = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE Keuzedeel_ID = $id");
        $plaatsen = $plaatsenBezet->plaatsen_bezet + 1;
        $wpdb->query("UPDATE Keuzedelen SET plaatsen_bezet=$plaatsen WHERE Keuzedeel_ID = $keuzedeel_ID");
        //aanmeld melding
        echo 'Je bent aangemeld bij dit keuzedeel!';
        //het systeem is nu zo gebouwd dat je elke 10 aanmeldingen die niet zijn goedgekeurd een mail binnen krijgt met het aantal aanmeldingen die goedgekeurd moeten worden.
        $count1 = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student WHERE `Status` = 'pending'");
        //hieronder staat de mail functie.
        if ($count1 % 10 == 0) {
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = "smtp.office365.com";
            $mail->SMTPAuth = true;
            $mail->Username = '216690@student.scalda.nl';
            $mail->Password = '5sIzlwnp';
            $mail->setFrom('216690@student.scalda.nl', 'keuzedelenwebsite');
            $mail->addAddress($current_email);
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Nieuwe aanmeldingen!';

            $mail->Body = "Beste,<br><br>Er zijn $count1 aanmeldingen in afwachting van goedkeuring!<br><a href='" . get_home_url() . "/aanmeld-lijst'>Klik hier</a> om naar de lijst te gaan met alle aanmeldingen.";
            $mail->AltBody = 'Scalda Keuzedelen Systeem';

            if (!$mail->send()) {
            } else {
                //message is sent!
            }
        }
    }
}
?>
<br>
<script>
    function toggleKeuzendeelInfo(idx, idy, idz) {
        let x = document.getElementById(idx);
        let y = document.getElementById(idy);
        let z = document.getElementById(idz);
        if (x.style.display === "none") {
            x.removeAttribute("style")
        } else {
            x.style.display = "none";
        }
        if (x.style.display === "none") {
            y.removeAttribute("style")
        } else {
            y.style.display = "none";
        }
        if (x.style.display === "none") {
            z.removeAttribute("style")
        } else {
            z.style.display = "none";
        }
        if (y.style.display != "none" && idy === "tb1") {
            document.getElementById('oms1').style.display = "none";
            document.getElementById('pb1').style.display = "none";
            document.getElementById('ex1').style.display = "none";
            document.getElementById('per1').style.display = "none";
            document.getElementById('vws1').style.display = "none";
            document.getElementById('oms2').style.display = "none";
            document.getElementById('pb2').style.display = "none";
            document.getElementById('ex2').style.display = "none";
            document.getElementById('per2').style.display = "none";
            document.getElementById('vws2').style.display = "none";
            document.getElementById('oms').removeAttribute("style")
            document.getElementById('pb').removeAttribute("style")
            document.getElementById('ex').removeAttribute("style")
            document.getElementById('per').removeAttribute("style")
            document.getElementById('vws').removeAttribute("style")
        } else if (y.style.display != "none" && idy === "oms1") {
            document.getElementById('tb1').style.display = "none";
            document.getElementById('pb1').style.display = "none";
            document.getElementById('ex1').style.display = "none";
            document.getElementById('per1').style.display = "none";
            document.getElementById('vws1').style.display = "none";
            document.getElementById('tb2').style.display = "none";
            document.getElementById('pb2').style.display = "none";
            document.getElementById('ex2').style.display = "none";
            document.getElementById('per2').style.display = "none";
            document.getElementById('vws2').style.display = "none";
            document.getElementById('tb').removeAttribute("style");
            document.getElementById('pb').removeAttribute("style");
            document.getElementById('ex').removeAttribute("style");
            document.getElementById('per').removeAttribute("style");
            document.getElementById('vws').removeAttribute("style");
        } else if (y.style.display != "none" && idy === "pb1") {
            document.getElementById('oms1').style.display = "none";
            document.getElementById('tb1').style.display = "none";
            document.getElementById('ex1').style.display = "none";
            document.getElementById('per1').style.display = "none";
            document.getElementById('vws1').style.display = "none";
            document.getElementById('oms2').style.display = "none";
            document.getElementById('tb2').style.display = "none";
            document.getElementById('ex2').style.display = "none";
            document.getElementById('per2').style.display = "none";
            document.getElementById('vws2').style.display = "none";
            document.getElementById('oms').removeAttribute("style");
            document.getElementById('tb').removeAttribute("style");
            document.getElementById('ex').removeAttribute("style");
            document.getElementById('per').removeAttribute("style");
            document.getElementById('vws').removeAttribute("style");
        } else if (y.style.display != "none" && idy === "ex1") {
            document.getElementById('oms1').style.display = "none";
            document.getElementById('pb1').style.display = "none";
            document.getElementById('tb1').style.display = "none";
            document.getElementById('per1').style.display = "none";
            document.getElementById('vws1').style.display = "none";
            document.getElementById('oms2').style.display = "none";
            document.getElementById('pb2').style.display = "none";
            document.getElementById('tb2').style.display = "none";
            document.getElementById('per2').style.display = "none";
            document.getElementById('vws2').style.display = "none";
            document.getElementById('oms').removeAttribute("style");
            document.getElementById('pb').removeAttribute("style");
            document.getElementById('tb').removeAttribute("style");
            document.getElementById('per').removeAttribute("style");
            document.getElementById('vws').removeAttribute("style");
        } else if (y.style.display != "none" && idy === "per1") {
            document.getElementById('oms1').style.display = "none";
            document.getElementById('pb1').style.display = "none";
            document.getElementById('ex1').style.display = "none";
            document.getElementById('tb1').style.display = "none";
            document.getElementById('vws1').style.display = "none";
            document.getElementById('oms2').style.display = "none";
            document.getElementById('pb2').style.display = "none";
            document.getElementById('ex2').style.display = "none";
            document.getElementById('tb2').style.display = "none";
            document.getElementById('vws2').style.display = "none";
            document.getElementById('oms').removeAttribute("style");
            document.getElementById('pb').removeAttribute("style");
            document.getElementById('ex').removeAttribute("style");
            document.getElementById('tb').removeAttribute("style");
            document.getElementById('vws').removeAttribute("style");
        } else if (y.style.display != "none" && idy === "vws1") {
            document.getElementById('oms1').style.display = "none";
            document.getElementById('pb1').style.display = "none";
            document.getElementById('ex1').style.display = "none";
            document.getElementById('per1').style.display = "none";
            document.getElementById('tb1').style.display = "none";
            document.getElementById('oms2').style.display = "none";
            document.getElementById('pb2').style.display = "none";
            document.getElementById('ex2').style.display = "none";
            document.getElementById('per2').style.display = "none";
            document.getElementById('tb2').style.display = "none";
            document.getElementById('oms').removeAttribute("style");
            document.getElementById('pb').removeAttribute("style");
            document.getElementById('ex').removeAttribute("style");
            document.getElementById('per').removeAttribute("style");
            document.getElementById('tb').removeAttribute("style");
        }
    }
</script>
<div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-lg-4 ">
        <div>
            <h1 class="text-center"><?= $keuzedelen->keuzedelen_naam ?></h1>
        </div>

    </div>
    <div class="col-sm-4">
    </div>
</div>
<div class="row">

    <div class="col-lg-4">
        <h4 class="text-center"> Aantal klokuren test</h4>

        <div style="background-color: orange; border-radius: 6px; height: 5rem;">
            <div class="row">
                <div class="col-sm-4">
                    <img style="margin: 3px 0px 0px 5px; filter: brightness(0) invert(1); float: left; width: 40px; height: 40px" src="<?php echo get_template_directory_uri(); ?>/images/icons/iconfinder_Clock_657914.png">
                </div>
                <div class="col-sm-4">
                    <p class="text-break text-center" style="margin-top: 1rem; color: white;"><?= $keuzedelen->aantal_klokuur ?></p>
                </div>
                <div class="col-sm-4">

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <h4 class="text-center">Code keuzedeel</h4>
        <div class="text center" style="background-color: orange; border-radius: 6px; overflow: hidden; height: 1%;">
            <div class="row">
                <div class="col-sm-3">
                    <img style="margin: 3px 0px 0px 5px; filter: brightness(0) invert(1); float: left; width: 45px; height: 45px" src="<?php echo get_template_directory_uri(); ?>/images/icons/iconfinder_tag_1954202-e1560803971979.png">

                </div>
                <div class="text-break text-center col-sm-6">
                    <p style="margin-top: 1rem; color: white;" class="text-center"><?= $keuzedelen->code_keuzedeel ?></p>
                </div>
                <div class="col-sm-3">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <h4 class="text-center">Locatie</h4>
        <div style="background-color: orange; border-radius: 6px; height: 5rem;overflow: hidden; height: 1%;">
            <div class="row">
                <div class="col-sm-4">
                    <img style="margin: 3px 0px 0px 5px; filter: brightness(0) invert(1); float: left; width: 45px; height: 45px" src="<?php echo get_template_directory_uri(); ?>/images/icons/iconfinder_59_111134.png">
                </div>
                <div class="text-break text-center col-sm-4">
                    <p style="color: white; display: block; margin-top: 1rem;" class="text-center"><?= $keuzedelen->locatie ?></p>
                </div>
                <div class="col-sm-4">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <a onclick="toggleKeuzendeelInfo('oms','oms1','oms2')">
                <h4>Omschrijving inhoud <span id="oms">></span><span id="oms1" style="display: none;"> ∨</span></h4>
            </a>
            <p id="oms2" style="display:none;"><?= nl2br($keuzedelen->omschrijving_inhoud) ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <a onclick="toggleKeuzendeelInfo('pb','pb1','pb2')">
                <h4>Programma begeleiding <span id="pb">></span><span id="pb1" style="display: none;"> ∨</span></h4>
            </a>
            <p id="pb2" style="display:none;"><?= $keuzedelen->programma_begeleiding ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>

<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <a onclick="toggleKeuzendeelInfo('ex','ex1','ex2')">
                <h4>Examinering <span id="ex">></span><span id="ex1" style="display: none;"> ∨</span></h4>
            </a>
            <p id="ex2" style="display:none;"><?= $keuzedelen->examinering ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <a onclick="toggleKeuzendeelInfo('per','per1','per2')">
                <h4>Periode <span id="per">></span><span id="per1" style="display: none;"> ∨</span></h4>
            </a>
            <p id="per2" style="display:none;"><?= $keuzedelen->periode ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <a onclick="toggleKeuzendeelInfo('vws','vws1','vws2')">
                <h4>Voorwaarden Start <span id="vws">></span><span id="vws1" style="display: none;"> ∨</span></h4>
            </a>
            <p id="vws2" style="display:none;"><?= $keuzedelen->voorwaarden_start ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <a onclick="toggleKeuzendeelInfo('tb','tb1','tb2')">
                <h4>Trainers & Begeleiders <span id="tb">></span><span id="tb1" style="display: none;"> ∨</span></h4>
            </a>
            <p id="tb2" style="display:none;"><?= $keuzedelen->trainers_begeleiders ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>

<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <h4>Cohort</h4>
            <p><?= $keuzedelen->cohort ?></p>
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">

        <div>
            <h4>Plaatsen beschikbaar</h4>
            <p><?= ceil($keuzedelen->plaatsen_beschikbaar - $keuzedelen->plaatsen_bezet) ?></p>
        </div>
        <?php



        ?>
    </div>

    <div class="col-lg-2">

    </div>
</div>


<div class="row">

    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">
        <br>
        <div>
            <?php if (!$keuzedelen->verplicht_keuzedeel && $keuzedelen->plaatsen_beschikbaar - $keuzedelen->plaatsen_bezet > 0 /* && heeft al aangemeld*/) {
            ?>
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <input style="font-size: 25px;" type="submit" name="submit" value="Aanmelden">
                </form>
            <?php
            } else if ($keuzedelen->plaatsen_beschikbaar - $keuzedelen->plaatsen_bezet <= 0) {
                echo "Dit keuzedeel zit vol! Op dit moment is het niet mogelijk om u aan te melden.";
            } else {
                echo "Dit keuzedeel is verplicht";
            }
            ?>

        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>