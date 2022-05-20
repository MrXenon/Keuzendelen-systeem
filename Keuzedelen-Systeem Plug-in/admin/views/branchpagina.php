<?php
// Include model
include KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Branch.php";
// declare class variable
$branch = new Branch();
// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));

//Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $branch->getGetValues();

// Keep track of current action.
$action = false;
if (!empty($get_array)) {
    // Check actions
    if (isset($get_array['action'])) {
        $action = $branch->handleGetAction($get_array);
    }
}
//Get the POST data in filtered array
$post_array = $branch->getPostValues();
// Collect Errors
$error = false;
// Check the POST data
if (!empty($post_array)) {
    // Check the add form:
    $add = false;
    if (isset($post_array['toevoegen'])) {
        // Save question
        $result = $branch->voegBranchToe($post_array);
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
        $branch->werkBranchBij($post_array);
    }
}
?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
    <script src="https://getbootstrap.com/2.3.2/assets/js/bootstrap-modal.js"></script>
</head>
<body>
<?php
if ($action == 'bijwerken') {
    ?>
    <div class="col-sm-4">
        <form action="<?php echo $base_url; ?>" method="post">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon2"><h4>Pas de Branch aan</h4></span>
                <input type="hidden" name="branchID" value="<?= $_GET['branchId'] ?>">
                <input maxlength="255" name="branch_naam" type="text" class="form-control" placeholder="Branch_naam"
                       aria-label="Branch"
                       aria-describedby="basic-addon1" value="<?= $_GET['branch_naam'] ?>">
                       <input maxlength="255" name="branch_image" type="text" class="form-control" placeholder="Branch_image"
                       aria-label="Branch"
                       aria-describedby="basic-addon1" value="<?= $_GET['branch_image'] ?>">
            </div>
            </br>
            <h5> Alle velden moeten ingevuld zijn</h5>
            <button type="submit" name="bijwerken" value="Bijwerken" class="btn btn-primary">Werk bij</button>
        </form>
    </div>
    <?php
} else {
    ?>
    <div class="col-sm-4">
        <form action="<?php echo $base_url; ?>" method="post">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon2"><h3>Voeg een branch toe</h3></span>
                <h5>Branch naam:</h5>
                <input maxlength="255" onchange="checkMaxLength()" name="branch_naam" type="text" class="form-control"
                       placeholder="Branch" aria-label="Branch" aria-describedby="basic-addon1" required>
                <!--Add Image-->
                <br>
                <h5>Branch image URL:</h5>
			    <input maxlength="250" onchange="checkMaxLength()" name="branch_image" type="text" class="form-control"
                       placeholder="Branch URL" aria-label="Branch" aria-describedby="basic-addon1" required>
            <br><br>
                    </div>
            </br>
            <button name="toevoegen" value="Toevoegen" type="submit" class="btn btn-primary">Voeg toe</button>
        </form>
    </div>
    <?php
}
?>
<div class="col-sm-2">

</div>
<div class="col-sm-6">
    <table class="table table-striped">
        <th scope="row">Branches</th>
        <?php
        $branches = $branch->getAlleBranches();
        foreach ($branches as $IndividueeleBranch) {
            // Create update link
            $params = array('action' => 'bijwerken', 'branchId' => $IndividueeleBranch->getBranchID(), 'branch_naam' => $IndividueeleBranch->getBranchName(),'branch_image' => $IndividueeleBranch->getBranchImage());
            // Add params to base url update link
            $upd_link = add_query_arg($params, $base_url);
            // Create delete link
            $params = array('action' => 'verwijderen', 'branchId' => $IndividueeleBranch->getBranchID());
            // Add params to base url delete link
            $del_link = add_query_arg($params, $base_url);
            // if/else statement to translate 1 to Open vraag and 0 to Gesloten vraag
            ?>
            <tr>
                <td>
                    <?= $IndividueeleBranch->getBranchName(); ?>
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
                            <button onclick="return confirm('Are you sure you want to delete this item?');" class="verwijderen btn btn-primary">Verwijderen</button>
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
