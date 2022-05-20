<?php
// if (current_user_can('administrator')) {

/*
  * Template name: Aanmeld_Lijst_Secretariaat
  */
show_admin_bar(false);
get_header();
//ik heb hier variabelen defined die ik moet toevoegen om de wpdb queries te laten werken.
$kd_id = $_POST['kd_id'];
$leerlingnummer = $_POST['leerlingnummer'];
//zodra de leerling geaccepteerd word word de if uitgevoerd waarin , zodra de leerling verwijdert word, word de else if uitgevoerd.
if (isset($_POST['accept'])) {
    $wpdb->query("UPDATE Aanmelding_student SET `Status` = 'accepted' WHERE `keuzedeel_ID` ='$kd_id' AND `Leerlingnummer` ='$leerlingnummer'  ");
} else if (isset($_POST['deny'])) {
    $wpdb->query("DELETE FROM Aanmelding_student WHERE `keuzedeel_ID` ='$kd_id' AND `Leerlingnummer` ='$leerlingnummer'");
}

?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <h1><?= wp_title() ?></h1>
            <table>
                <tr>
                    <!--de titels voor de tabel-->
                    <th style="font-size: 20px;">Keuzedelen naam</th>
                    <th style="font-size: 20px;">Student Nummer</th>
                    <th style="font-size: 20px;">Naam</th>
                    <th style="font-size: 20px;">Datum</th>
                </tr>
                <?php

                global $wpdb;
                //hier worden alle aanmeldingen uit de database gehaald.
                $result = $wpdb->get_results("SELECT * FROM Aanmelding_student_sec");
                //hier gaat de foreach door alle aanmeldingen en zet ze in de tabel
                foreach ($result as $print) {
                    $studentenNummer = $print->Leerlingnummer;
                    if ($studentenNummer != 0) {
                        $result1 = $wpdb->get_results("SELECT * FROM wp_users WHERE student_number = $studentenNummer");
                    }
                ?>
                    <tr style="font-size: 20px;" class="student-<?= $print->Status ?>">
                        <?php $result = $wpdb->get_row("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = $print->keuzedeel_ID"); ?>
                        <td><?= $result->keuzedelen_naam ?></td>
                        <td><?php
                            foreach ($result1 as $print1) {
                                echo $print1->student_number;
                            }
                            ?></td>
                        <td><?php
                            foreach ($result1 as $print2) {
                                echo $print2->display_name;
                            }
                            ?></td>
                        <td><?php

                            echo $print->aanmeld_datum;

                            ?></td>
                    </tr>
                <?php }
                //hier worden de aantal aanmeldingen geteld, het totaal, de nog niet geaccepteerde en de geaccepteerden.
                $count = $wpdb->get_var("SELECT COUNT(*) FROM Aanmelding_student_sec");
                echo "Er zijn in totaal $count aanmeldingen, geaccepteerd door mentor en trainer.";
                ?>
            </table>
            <form action="<?= get_home_url() . '/export-secretariaat-lijst'  ?>" method='post'>
                <input type="submit" value="exporteren" name="DLCSV">
            </form>
            <?php
            
                
            

            ?>
        </div>
    </div>
</div>

<?php

get_footer();
// } else {
//     echo "Je hebt administrator rechten nodig om de pagina te kunnen bekijken! Ga naar de <a href='" . home_url() . "'>home-pagina</a>.";
// }

?>