<?php
if (current_user_can('administrator')) {

/*
  * Template name: import-kd-page
  */
show_admin_bar(false);
get_header();

    require_once 'import-keuzedelen-class.php';
    $import = new import_kd();
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
            <h1><?= wp_title()?></h1>
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
                        <th style="font-size: 20px;">Keuzedeel-Naam</th>
                        <th style="font-size: 20px;">Omschrijving</th>
                        <th style="font-size: 20px;">Begeleider(s)</th>
                    </tr>
                    <?php

                        global $wpdb;
                        $result = $wpdb->get_results("SELECT * FROM Keuzedelen");
                        foreach ($result as $print) {
                            ?>
                        <tr style="font-size: 20px;">
                            <td><?= $print->keuzedelen_naam ?></td>
                            <td><?= $print->omschrijving_inhoud ?></td>
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
} else {
    echo "Je hebt administrator rechten nodig om de pagina te kunnen bekijken! Ga naar de <a href='" . home_url() . "'>home-pagina</a>.";
}

?>
