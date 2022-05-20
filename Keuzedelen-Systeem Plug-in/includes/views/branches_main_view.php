<?php
include_once KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Branch.php";

$branch = new Branch;

$customers = $branch->getAlleBranches();
$url = get_site_url();
$url .= "/opleidingen";

?>

<div class="row">
    <?php foreach ($customers as $customer) {
        $branchID = $customer->getBranchID();
        
            $url .= "?id=" . $customer->getBranchID();
    ?>
            <a href="<?= $url ?>">
                <div style=" height: 25rem;  border-radius: 5%;" class="col-md-3 content-col">
                    <div style="background-color: #e6701a; border-radius: 10px; height: 20rem; overflow:hidden;">
                        <p class="text-center" style="color: white;"><?= $customer->getBranchName(); ?></p>

                        <img class="img-fluid" src='<?= $customer->getBranchImage(); ?>' style="border-radius: 0px 0px 10px 10px; ">

                    </div>
                </div>
            </a>
        <?php
        
        $newurl = str_replace("?id=" . $customer->getBranchID(), "", $url);
        $url = $newurl;
    }
    ?>
</div>