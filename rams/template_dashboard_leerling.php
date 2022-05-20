<?php


/*
  * Template name: Dashboard_leerling_template
  */
show_admin_bar(false);
get_header();

?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <h1>Status keuzedelen</h1>
            <table>
                <tr>
                    <th style="font-size: 20px;">Keuzedeel naam</th>
                    <th style="font-size: 20px;">Status</th>
                </tr>
                <?php

                global $wpdb;
                $current_user = wp_get_current_user();
                $nummer = $current_user->user_nicename;
                $student = $wpdb->get_results("SELECT * FROM wp_users WHERE user_nicename = '$nummer'");
                $studentenNummer = $student[0]->student_number;
                ?>
                <tr>
                    <td><h1>DOOR MENTOR TE BEOORDELEN LIJST:</h1></td>
                    <td><h1>----------------------------</h1></td>
                </tr>
                <?php
                $result = $wpdb->get_results("SELECT * FROM Aanmelding_student WHERE Leerlingnummer = '$studentenNummer'");
                foreach ($result as $print) {
                ?>
                    <tr style="font-size: 20px;">
                        <td><?php
                            $kd_ID = $print->keuzedeel_ID;
                            $name = $wpdb->get_results("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = '$kd_ID'");
                            foreach ($name as $printName) {
                                echo $printName->keuzedelen_naam;
                            } ?>
                        </td>
                        <td><?= $print->Status ?></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td><h1>DOOR TRAINER TE BEOORDELEN LIJST:</h1></td>
                    <td><h1>----------------------------<h1/></td>
                </tr>
                <?php
                $result = $wpdb->get_results("SELECT * FROM Aanmelding_student_trainer WHERE Leerlingnummer = '$studentenNummer'");
                foreach ($result as $print) {
                ?>
                    <tr style="font-size: 20px;">
                        <td><?php
                            $kd_ID = $print->keuzedeel_ID;
                            $name = $wpdb->get_results("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = '$kd_ID'");
                            foreach ($name as $printName) {
                                echo $printName->keuzedelen_naam;
                            } ?>
                        </td>
                        <td><?= $print->status ?></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td><h1>VOLLEDIG GEACCEPTEERDE AANMELDINGEN:</h1></td>
                    <td><h1>----------------------------</h1></td>
                </tr>
                <?php
                $result = $wpdb->get_results("SELECT * FROM Aanmelding_student_sec WHERE Leerlingnummer = '$studentenNummer'");
                foreach ($result as $print) {
                ?>
                    <tr style="font-size: 20px;">
                        <td><?php
                            $kd_ID = $print->keuzedeel_ID;
                            $name = $wpdb->get_results("SELECT * FROM Keuzedelen WHERE keuzedeel_ID = '$kd_ID'");
                            foreach ($name as $printName) {
                                echo $printName->keuzedelen_naam;
                            } ?>
                        </td>
                        <td>N.V.T.</td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </div>
</div>
<?php

get_footer();


?>
