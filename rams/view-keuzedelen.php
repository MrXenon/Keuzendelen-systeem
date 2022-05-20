<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include model
include KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Keuzedeel.php";
// declare class variable
$keuzedeel = new Keuzedeel();
// Set base url to current file and add page specific vars
//$base_url = get_admin_url() . 'admin.php';
//$params   = ['page' => basename(__FILE__, ".php")];
//echo 1;
////Add params to base url
//$base_url = add_query_arg($params, $base_url);

$base_url = get_permalink(get_page_by_title('keuzedelenadmin'));

// Get the GET data in filtered array
$get_array = $keuzedeel->getGetValues();

// Keep track of current action.
$action = false;
if (!empty($get_array)) {
    // Check actions
    if (isset($get_array['action'])) {
        $action = $keuzedeel->handleGetAction($get_array);
    }
}
//Get the POST data in filtered array
$post_array = $keuzedeel->getPostValues();

// Collect Errors
$error = false;
//Check the POST data
if (!empty($post_array)) {
    // Check the add form:
    $add = false;
    if (isset($post_array['toevoegen'])) {
        // Save question
        $result = $keuzedeel->voegKeuzedeelToe($post_array);
        if ($result) {
            // Save was succesfull
            $add = true;
        } else {
            // Indicate error
            $error = true;
        }
    }
    // check the post array
    if (isset($post_array['bijwerken'])) {
        // update question
        $keuzedeel->werkKeuzedeelBij($post_array);
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <script>
        function imageToURL(name) {
            let image = document.getElementById(name);
            let field = document.getElementById('imageURL');
            field.value = image.src;
        }
    </script>
    <?php
    if ($action == 'bijwerken') {
        $i                       = 1;
        $keuzedeelInfo           = $keuzedeel->getKeuzedeelInfoSelect($get_array['keuzedeelId']);
        $opleiding               = $keuzedeel->getOpleidingNamesSelect();
        $allOpleidingenKeuzedeel = $keuzedeel->getAllOpleidingenForSelect($get_array['keuzedeelId']);
    ?>
        <div class="col-sm-4">
            <form action="<?php echo $base_url; ?>" method="post">
                <div class="form-group mb-3">
                    <span class="input-group-text" id="basic-addon2">
                        <h4>Pas het Keuzedeel aan</h4>
                    </span>
                    <input type="hidden" name="keuzedeelID" value="<?= $get_array['keuzedeelId'] ?>">
                    <h5>Keuzedeel naam</h5>
                    <input name="keuzedeel_naam" type="text" class="form-control" placeholder="Keuzedeel naam" value="<?= $keuzedeelInfo[0]['keuzedelen_naam'] ?>">
                    <h5>Keuzedeel image</h5>
                    <?php
                    $counter = 0;
                    $media_query = new WP_Query(
                        array(
                            'post_type' => 'attachment',
                            'post_status' => 'inherit',
                            'posts_per_page' => -1,
                        )
                    );
                    $list = array();
                    foreach ($media_query->posts as $post) {
                        $list[] = wp_get_attachment_url($post->ID);
                    }
                    foreach ($list as $image) {
                        $counter++;
                        if ($counter % 3 != 0) {
                            echo "<tr>";
                        }
                        echo "<td><a href='#' onclick='imageToURL(`image-" . $counter . "`)'><img id='image-" . $counter . "' class='col-sm-4 h-50' src='" . $image . "'></a></td>";
                        if ($counter % 3 != 0) {
                            echo "</tr>";
                        }
                    }
                    echo "<br>";
                    ?>
                    <input id="imageURL" name="keuzedelen_image" type="text" class="form-control" placeholder="Keuzedeel Image URL" value="<?= $get_array['keuzedelen_image'] ?>">
                    <h5>Opleiding</h5>
                    <select name="Opleidingopleiding_ID" class="custom-select" id="inputGroupSelect01">
                        <?php

                        foreach ($opleiding as $opleidingSelect) {
                        ?>
                            <option <?php if ($allOpleidingenKeuzedeel[0]['opleiding_naam'] === $opleidingSelect->getOpleidingName()) {
                                        unset($allOpleidingenKeuzedeel[0]);
                                        echo "selected";
                                    } ?> value="<?= $opleidingSelect->getOpleidingopleidingID() ?>">
                                <?php
                                echo $opleidingSelect->getOpleidingName();
                                ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                    <div id="alleOpleidingen">
                        <?php
                        foreach ($allOpleidingenKeuzedeel as $all) {
                            $i++;
                        ?>
                            <div id="extraOpleiding">
                                <select name="Opleidingopleiding_ID<?= $i ?>" class="custom-select" id="inputGroupSelect01">
                                    <?php

                                    foreach ($opleiding as $opleidingSelect) {
                                    ?>
                                        <option <?php if ($all['opleiding_naam'] === $opleidingSelect->getOpleidingName()) {
                                                    echo "selected";
                                                } ?> value="<?= $opleidingSelect->getOpleidingopleidingID() ?>">
                                            <?php
                                            echo $opleidingSelect->getOpleidingName();
                                            ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>

                                <button type="button" class="deleteOpleiding">Delete</button>
                                <br>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="nummerAanNew" class="<?= $i ?>"></div>
                    <button type="button" id="meerOpleidingen">Klik voor meer Opleidingen</button>
                    </br>
                    <h5>Code Keuzedeel</h5>
                    <input maxlength="255" name="code_keuzedeel" type="text" class="form-control" placeholder="Code Keuzedeel" value="<?= $keuzedeelInfo[0]['code_keuzedeel'] ?>">
                    </br>

                    <h5>Verplicht Keuzedeel</h5>
                    <input type="checkbox" name="verplicht_check" id="verplicht_check" onclick="checkVerplicht()" <?php if ($keuzedeelInfo[0]['verplicht_keuzedeel']) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                    <script>
                        function checkVerplicht() {
                            let checkBox = document.getElementById("verplicht_check");
                            let text = document.getElementById("verplicht_keuzedeel");
                            if (checkBox.checked) {
                                text.value = 1
                            } else {
                                text.value = 0
                            }
                        }
                    </script>
                    <input type="number" id="verplicht_keuzedeel" name="verplicht_keuzedeel" hidden>

                    <h5>Aantal klokuren</h5>
                    <input name="aantal_klokuur" type="number" min="1" max="99999" class="form-control" placeholder="Aantal klokuren" value="<?= $keuzedeelInfo[0]['aantal_klokuur'] ?>">
                    </br>

                    <h5>Omschrijving inhoud</h5>
                    <textarea maxlength="65535" name="omschrijving_inhoud" class="form-control" rows="6" placeholder="Omschrijving inhoud"><?= $keuzedeelInfo[0]['omschrijving_inhoud'] ?></textarea>
                    </br>

                    <h5>Programma begeleiding</h5>
                    <textarea maxlength="65535" name="programma_begeleiding" class="form-control" rows="6"><?= $keuzedeelInfo[0]['programma_begeleiding'] ?></textarea>
                    </br>

                    <h5>Locatie</h5>
                    <input maxlength="255" name="locatie" type="text" class="form-control" placeholder="Locatie" value="<?= $keuzedeelInfo[0]['locatie'] ?>">
                    </br>

                    <h5>Examinering</h5>
                    <textarea maxlength="65535" name="examinering" class="form-control" rows="6"><?= $keuzedeelInfo[0]['examinering'] ?></textarea>
                    </br>

                    <h5>Periode</h5>
                    <input maxlength="255" name="periode" type="text" class="form-control" placeholder="Periode" value="<?= $keuzedeelInfo[0]['periode'] ?>">
                    </br>

                    <h5>Voorwaarden start</h5>
                    <textarea maxlength="65535" name="voorwaarden_start" class="form-control" rows="6"><?= $keuzedeelInfo[0]['voorwaarden_start'] ?></textarea>
                    </br>

                    <h5>Trainers/Begeleiders</h5>
                    <textarea maxlength="65535" name="trainers_begeleiders" class="form-control" rows="6"><?= $keuzedeelInfo[0]['trainers_begeleiders'] ?></textarea>


                    <h5>Totaal Plaatsen</h5>
                    <input maxlength="255" name="plaatsen" type="text" class="form-control" placeholder="Totaal Plaatsen" required value="<?= $keuzedeelInfo[0]['plaatsen'] ?>">
                    </br>

                    <h5>Cohort</h5>
                    <input maxlength="255" name="cohort" type="text" class="form-control" placeholder="Totaal Plaatsen" required value="<?= $keuzedeelInfo[0]['cohort'] ?>">
                    </br>


                </div>
                </br>
                <button type="submit" name="bijwerken" value="Bijwerken" class="btn btn-primary">Werk keuzedeel bij</button>
            </form>
        </div>
    <?php
    } else {
        $opleiding = $keuzedeel->getOpleidingNamesSelect();
    ?>
        <div class="col-sm-4">
            <form action="<?php echo $base_url; ?>" method="post">
                <div class="form-group mb-3">
                    <span class="input-group-text" id="basic-addon2">
                    <button onclick="history.go(-1);">Terug </button>
                        <h4>Voeg een keuzedeel toe</h4>
                    </span>
                    <h5>Keuzedeel naam</h5>
                    <input name="keuzedeel_naam" type="text" class="form-control" placeholder="Keuzedeel naam" aria-label="opleiding" aria-describedby="basic-addon1" required>
                    <h5>Opleiding</h5>
                    <select name="Opleidingopleiding_ID1" class="custom-select" id="inputGroupSelect01" required>
                        <?php
                        foreach ($opleiding as $opleidingSelect) {
                        ?>
                            <option value="<?= $opleidingSelect->getOpleidingopleidingID(); ?>"><?php
                                                                                                echo $opleidingSelect->getOpleidingName(); ?>
                            </option><?php
                                    } ?>
                    </select>
                    <div id="alleOpleidingen"></div>
                    <button type="button" id="meerOpleidingen">Klik voor meer Opleidingen</button>
                    <!--Add Image-->
                    <h5>Keuzedeel Image</h5>
                    <?php
                    $counter = 0;
                    $media_query = new WP_Query(
                        array(
                            'post_type' => 'attachment',
                            'post_status' => 'inherit',
                            'posts_per_page' => -1,
                        )
                    );
                    $list = array();
                    foreach ($media_query->posts as $post) {
                        $list[] = wp_get_attachment_url($post->ID);
                    }
                    foreach ($list as $image) {
                        $counter++;
                        if ($counter % 3 != 0) {
                            echo "<tr>";
                        }
                        echo "<td><a href='#' onclick='imageToURL(`image-" . $counter . "`)'><img id='image-" . $counter . "' class='col-sm-4 h-50' src='" . $image . "'></a></td>";
                        if ($counter % 3 != 0) {
                            echo "</tr>";
                        }
                    }
                    echo "<br>";
                    ?>
                    <input id="imageURL" name="keuzedelen_image" type="url" class="form-control" placeholder="keuzedelen_image" aria-label="opleiding" aria-describedby="basic-addon1" required>

                    <h5>Code Keuzedeel</h5>
                    <input maxlength="255" name="code_keuzedeel" type="text" class="form-control" placeholder="Code Keuzedeel" required>
                    </br>

                    <h5>Verplicht Keuzedeel</h5>
                    <input type="checkbox" name="verplicht_check" id="verplicht_check" onclick="checkVerplicht()">
                    <script>
                        function checkVerplicht() {
                            let checkBox = document.getElementById("verplicht_check");
                            let text = document.getElementById("verplicht_keuzedeel");
                            if (checkBox.checked) {
                                text.value = 1
                            } else {
                                text.value = 0
                            }
                        }
                    </script>
                    <input type="number" id="verplicht_keuzedeel" name="verplicht_keuzedeel" hidden>
                    </br>

                    <h5>Aantal klokuren</h5>
                    <input maxlength="255" name="aantal_klokuur" type="number" min="1" max="99999" class="form-control" placeholder="Aantal klokuren" required>
                    </br>

                    <h5>Omschrijving inhoud</h5>
                    <textarea maxlength="65535" name="omschrijving_inhoud" class="form-control" rows="6" placeholder="Omschrijving inhoud" required></textarea>
                    </br>

                    <h5>Programma begeleiding</h5>
                    <textarea maxlength="65535" name="programma_begeleiding" class="form-control" rows="6" placeholder="Programma begeleiding" required></textarea>
                    </br>

                    <h5>Locatie</h5>
                    <input maxlength="255" name="locatie" type="text" class="form-control" placeholder="Locatie" required>
                    </br>



                    <h5>Examinering</h5>
                    <textarea maxlength="65535" name="examinering" class="form-control" rows="6" placeholder="Examinering" required></textarea>
                    </br>

                    <h5>Periode</h5>
                    <input maxlength="255" name="periode" type="text" class="form-control" placeholder="Periode" required>
                    </br>

                    <h5>Voorwaarden start</h5>
                    <textarea maxlength="65535" name="voorwaarden_start" class="form-control" rows="6" placeholder="Voorwaarden start" required></textarea>
                    </br>

                    <h5>Trainers/Begeleiders</h5>
                    <textarea maxlength="65535" name="trainers_begeleiders" class="form-control" rows="6" placeholder="Trainers/Begeleiders" required></textarea>

                    <h5>Totaal Plaatsen</h5>
                    <input maxlength="255" name="plaatsen" type="text" class="form-control" placeholder="Totaal Plaatsen" required>
                    </br>

                    <h5>Cohort</h5>
                    <input maxlength="255" name="cohort" type="text" class="form-control" placeholder="Totaal Plaatsen" required>
                    </br>

                </div>
                <h5> Alle velden moeten ingevuld zijn</h5>
                <button name="toevoegen" value="Toevoegen" type="submit" class="btn btn-primary">Voeg keuzedeel toe</button>
            </form>
        </div>
    <?php
    }
    ?>

    <div class="col-sm-2">
    </div>
    <div class="col-sm-6">
        <table class="table table-striped">
            <th scope="row">Keuzedeel</th>
            <th scope="row">Opleiding</th>
            <?php
            $keuzedelen = $keuzedeel->getAlleKeuzedelen();
            foreach ($keuzedelen as $IndividueelKeuzedeel) {
                $keuzedeelRelatieOpleiding = $IndividueelKeuzedeel->getOpleidingNames($IndividueelKeuzedeel->getKeuzedeelID());
                // Create update link
                $params = [
                    'action'         => 'bijwerken',
                    'keuzedeelId'    => $IndividueelKeuzedeel->getKeuzedeelID(),
                    'opleiding_naam' => implode(',', $keuzedeelRelatieOpleiding),
                    'keuzedelen_image' => $IndividueelKeuzedeel->getKeuzedeelImage(),
                    'plaatsen_beschikbaar' => $IndividueelKeuzedeel->getKeuzedeelPlaatsen(),
                    'cohort' => $IndividueelKeuzedeel->getKeuzedeelCohort()

                ];
                // Add params to base url update link
                $upd_link = add_query_arg($params, $base_url);
                // Create delete link
                $params = ['action' => 'verwijderen', 'keuzedeelId' => $IndividueelKeuzedeel->getKeuzedeelID()];
                // Add params to base url delete link
                $del_link = add_query_arg($params, $base_url);
                // if/else statement to translate 1 to Open vraag and 0 to Gesloten vraag
            ?>
                <tr>
                    <td>
                        <?= $IndividueelKeuzedeel->getKeuzedeelNaam() ?>
                    </td>
                    <td>
                        <?php
                        if (empty($keuzedeelRelatieOpleiding)) {
                            echo 'Geen opleidingen geselecteerd!';
                        } else {
                            foreach ($keuzedeelRelatieOpleiding as $keuzedeelRelatie) {
                                echo $keuzedeelRelatie . '<br>';
                            }
                        }

                        ?>
                    </td>
                    <?php
                    if ($action !== 'bijwerken') {
                    ?>
                        <td>
                            <a href="<?php echo $upd_link; ?>">
                                <button class="btn btn-primary">Bijwerken</button>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo $del_link ?>">
                                <button onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-primary">Verwijderen</button>
                            </a>
                        </td>

                    <?php } ?>
                </tr>

            <?php
            }

            ?>
        </table>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        if ($('#nummerAanNew').attr('class') === undefined) {
            var input_fields = 1;
        } else {
            var input_fields = $('#nummerAanNew').attr('class');
        }

        $("#meerOpleidingen").click(function() {
            input_fields++;
            var buttonDelete = '<button type="button" class="deleteOpleiding">Delete</button>';
            $('#alleOpleidingen').append('<div id="extraOpleiding' + input_fields + '"></div>');
            $('#extraOpleiding' + input_fields).append($('#inputGroupSelect01').clone().attr('name', 'Opleidingopleiding_ID' + input_fields).removeAttr('selected'),
                buttonDelete,
                '<br>',
                '<div>'
            );
        });

        $(document).on('click', '.deleteOpleiding', function() {
            $(this).parent().remove();
        });
    });
</script>

</html>
