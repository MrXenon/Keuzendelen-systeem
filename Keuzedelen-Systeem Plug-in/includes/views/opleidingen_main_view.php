<?php
include_once KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Opleiding.php";
$id = $_GET['id'];
$opleidingClass = new Opleiding;
$opleidingen = $opleidingClass->getAllOpleidingenView($id);
$url = get_site_url();
$url .= "/keuzedelen";



?>
<div class="row">
    <?php foreach ($opleidingen as $opleiding) {
        $local_url = $url . "?idKeuzedeel=" . $opleiding->getOpleidingID();
    ?>

        <a style="text-decoration: none;" href="<?= $local_url ?>">
            <div style=" height: 25rem;  border-radius: 5%;" class="col-md-3 content-col">
                <div style="background-color: #e6701a; border-radius: 10px; height: 20rem; overflow:hidden;">
                    <p class="text-center" style="color: white;"><?= $opleiding->getOpleidingName() ?></p>
                    <img class="img-fluid" src='<?= $opleiding->getOpleidingImage() ?>' style="border-radius: 0px 0px 10px 10px; ">
                </div>
            </div>
        </a>
    <?php
        $newurl = str_replace("?id=Keuzedeel=" . $opleiding->getOpleidingID(), "", $local_url);
        $local_url = $newurl;
    }
    ?>
</div>