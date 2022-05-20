<?php

/*
* Template Name: Adminopleidingen
*/
if (current_user_can('administrator')) {

    // Include model
    include KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Opleiding.php";
    // declare class variable
    $opleiding = new Opleiding();
    // Set base url to current file and add page specific vars
    //$base_url = get_admin_url() . 'admin.php';
    //$params = array('page' => basename(__FILE__, ".php"));

    //Add params to base url
    //$base_url = add_query_arg($params, $base_url);

    // Get the GET data in filtered array
    $get_array = $opleiding->getGetValues();

    // Keep track of current action.
    $action = false;

    if (!empty($get_array)) {
        // Check actions
        if (isset($get_array['action'])) {
            $action = $opleiding->handleGetAction($get_array);
        }
    }
    //Get the POST data in filtered array
    $post_array = $opleiding->getPostValues();
    // Collect Errors
    $error = false;
    // Check the POST data
    if (!empty($post_array)) {
        // Check the add form:
        $add = false;
        if (isset($post_array['toevoegen'])) {
            // Save question
            $result = $opleiding->voegOpleidingToe($post_array);
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
            $opleiding->werkOpleidingBij($post_array);
        }
    }
?>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    </head>

    <body>
        <script>
            function imageToURL(name) {
                let image = document.getElementById(name);
                let field = document.getElementById('imageURL');
                field.value = image.src;
                alert("Afbeelding aangepast!");
            }
        </script>
        <?php
        if ($action == 'bijwerken') {
            $branches = $opleiding->getBranchNamesSelect();
        ?>
            <div class="col-sm-4">
                <form action="<?php echo $base_url; ?>" method="post">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                            <h4>Pas de Opleiding aan</h4>
                        </span>
                        <input type="hidden" name="opleidingID" value="<?= $_GET['opleidingId'] ?>" required>
                        <input maxlength="255" name="opleiding_naam" type="text" class="form-control" placeholder="opleiding" value="<?= $_GET['opleiding_naam'] ?>" required>

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
                        <input id="imageURL" maxlength="255" name="opleiding_image" type="text" class="form-control" placeholder="opleiding_imageURL" value="<?= $_GET['opleiding_image'] ?>" required>
                        <select name="BranchesBranch_ID" class="custom-select" id="inputGroupSelect01" required>
                            <?php

                            foreach ($branches as $branchSelect) {
                            ?>
                                <option <?php if (trim($branchSelect->getBranchNaam()) == $_GET['branch_naam']) {
                                            echo "selected";
                                        } ?> value="<?= $branchSelect->getBranchesBranchID();  ?>" required>
                                    <?php
                                    echo $branchSelect->getBranchNaam();
                                    ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    </br>
                    <h5> Alle velden moeten ingevuld zijn</h5>
                    <button type="submit" name="bijwerken" value="Bijwerken" class="btn btn-primary">Werk opleiding bij</button>
                </form>
            </div>
        <?php
        } else {
            $branches = $opleiding->getBranchNamesSelect();
        ?>
            <div class="col-sm-4">
                <form action="<?php echo $base_url; ?>" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2">
                        <button onclick="history.go(-1);">Terug </button>
                            <h4>Voeg een opleiding toe</h4>
                        </span>
                        <h5>Opleiding Naam</h5>
                        <input maxlength="255" name="opleiding_naam" type="text" class="form-control" placeholder="Opleiding Naam" aria-label="opleiding" aria-describedby="basic-addon1" required>
                        <h5>Opleiding Image URL</h5>
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
                        <input id="imageURL" maxlength="255" name="opleiding_image" type="text" class="form-control" placeholder="Opleiding Image Url" aria-label="opleiding" aria-describedby="basic-addon1" required>
                        <h5>Branch naam</h5>
                        <select name="BranchesBranch_ID" class="custom-select" id="inputGroupSelect01" required>
                            <?php

                            foreach ($branches as $branchSelect) {
                            ?>
                                <option value="<?= $branchSelect->getBranchesBranchID(); ?>">
                                    <?php
                                    echo $branchSelect->getBranchNaam();
                                    ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    </br>
                    <button name="toevoegen" value="Toevoegen" type="submit" class="btn btn-primary">Voeg opleiding toe</button>
                </form>
            </div>
        <?php
        }
        ?>
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6">
            <table class="table table-striped">
                <th scope="row">Opleiding</th>
                <th scope="row">Branch</th>
                <?php
                $opleiding1 = $opleiding->getAlleOpleidingen();
                foreach ($opleiding1 as $IndividueeleOpleiding) {
                    // Create update link
                    $params = array('action' => 'bijwerken', 'opleidingId' => $IndividueeleOpleiding->getOpleidingID(), 'opleiding_naam' => $IndividueeleOpleiding->getOpleidingName(), 'opleiding_image' => $IndividueeleOpleiding->getOpleidingImage());
                    // Add params to base url update link
                    $upd_link = add_query_arg($params, $base_url);
                    // Create delete link
                    $params = array('action' => 'verwijderen', 'opleidingId' => $IndividueeleOpleiding->getOpleidingID());
                    // Add params to base url delete link
                    $del_link = add_query_arg($params, $base_url);
                ?>
                    <tr>
                        <td>
                            <?= $IndividueeleOpleiding->getOpleidingName(); ?>
                        </td>
                        <td>
                            <?= $IndividueeleOpleiding->getBranchNames($IndividueeleOpleiding->getBranchesBranchID()); ?>
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

    </html>

<?php } ?>