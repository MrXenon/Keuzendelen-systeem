<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include_once KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Keuzedeel.php";

/*
  * Template name: Aanmeld_Lijst
  */
show_admin_bar(false);
get_header();
//ik heb hier variabelen defined die ik moet toevoegen om de wpdb queries te laten werken.
$kd_id = $_POST['kd_id'];


?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <h1><?= wp_title() ?></h1>
            <h3 class="text-right">

            </h3>
            <br>

            <table id="myTable">
                <thead>


                    <tr class="header">
                        <!--de titels voor de tabel-->
                        <th style="font-size: 20px;">Keuzedelen</th>
                    </tr>
                    <?php


                    //hier worden alle aanmeldingen uit de database gehaald.
                    $result = $wpdb->get_results("SELECT * FROM Keuzedelen");
                    //hier gaat de foreach door alle aanmeldingen en zet ze in de tabel
                    foreach ($result as $print) {
                        $keuzedelenNummer = $print->Keuzedelennummer;
                    ?>
                        <tr style="font-size: 20px;" class="student-accepted">
                            <?php $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $print->keuzedeel_ID"); ?>

                            <td><a id="zoekResultaten" href="http://mit-keuzedelen.nl/Keuzedeel/?id=<?= $result->keuzedeel_ID ?>"><?= $result->keuzedelen_naam ?></a></td>

                        </tr>
                    <?php }
                    //hier worden de aantal aanmeldingen geteld, het totaal, de nog niet geaccepteerde en de geaccepteerden.
                    $count = $wpdb->get_var("SELECT COUNT(*) FROM Keuzedelen");
                    echo "Er zijn in totaal $count Keuzedelen beschikbaar";
                    ?>
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="zoek keuzedelen..." title="">
            </table>
        </div>
    </div>
</div>
<?php

get_footer();

?>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
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