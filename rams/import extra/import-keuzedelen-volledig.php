<?php
require_once 'import-keuzedelen-class.php';
$import = new import();
/*
  * Template name: import-kd-page-full
  */
show_admin_bar(false);
get_header();

// Start CSV import function!
// Putting the post values in a variable
$input_array = $_POST;
// Refers to uploaded file name
$fileName = $_FILES['csv_import']['name'];
// Refers to extention of file
$fileExtension = strtolower(end(explode('.', $fileName)));
// Get the only useable file type
$fileType = ['csv'];
//If the submit button for coach was clicked and a file was selected:

// End CSV import functie

?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <?php if (isset($input_array['submit']) && !empty($_FILES['csv_import']['name'])) {
                if (!in_array($fileExtension, $fileType)) {
                    echo ("Kies een CSV bestand");
                } else {
                    //Execute the import

                    $result = $import->importCSV($_FILES['csv_import']);
                    if ($result[0] == true) {
                        echo 'import succesfull!';
                    } else {
                        echo $result[1];
                    }
                }
            } ?>
            <form method="post" enctype="multipart/form-data" class="space2">


                <input type="file" name="csv_import" id="csv_import" accept=".csv">
                <input type="submit" class="btn2_custom" name="submit" id="submit" value="Toevoegen">
                <div class="main small-12 medium-12 large-12 cell">

                </div>
            </form>
            <table>
                <tr>
                    <th style="font-size: 20px;">keuzedeel_ID</th>
                    <th style="font-size: 20px;">OpleidingopleidingID</th>
                    <th style="font-size: 20px;">keuzedelen_naam</th>
                    <th style="font-size: 20px;">aantal_klokuur</th>
                    <th style="font-size: 20px;">omschrijving_inhoud</th>
                    <th style="font-size: 20px;">programma_begeleiding</th>
                    <th style="font-size: 20px;">locatie</th>
                    <th style="font-size: 20px;">examinering</th>
                    <th style="font-size: 20px;">periode</th>
                    <th style="font-size: 20px;">voorwaarde_start</th>
                    <th style="font-size: 20px;">trainers_begeleiders</th>
                </tr>
                <?php

                global $wpdb;
                $result = $wpdb->get_results("SELECT * FROM Keuzedelen");
                foreach ($result as $print) {
                    ?>
                    <tr style="font-size: 20px;">
                        <td><?= $print->keuzedeel_ID ?></td>
                        <td><?= $print->OpleidingopleidingID ?></td>
                        <td><?= $print->keuzedelen_naam ?></td>
                        <td><?= $print->aantal_klokuur ?></td>
                        <td><?= $print->omschrijving_inhoud ?></td>
                        <td><?= $print->programma_begeleiding ?></td>
                        <td><?= $print->locatie ?></td>
                        <td><?= $print->examinering ?></td>
                        <td><?= $print->periode ?></td>
                        <td><?= $print->voorwaarde_start ?></td>
                        <td><?= $print->trainers_begeleiders ?></td>
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