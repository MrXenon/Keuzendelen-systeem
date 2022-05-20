<?php
include_once KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Keuzedeel.php";
$id = $_GET['idKeuzedeel'];
$keuzedelenClass = new Keuzedeel;
$url = get_site_url();
$url .= "/Keuzedeel";
$keuzedelen = $keuzedelenClass->getallKeuzedelenView($id);
?>
<div class="row">
    <?php foreach ($keuzedelen as $keuzedeel) {
        $local_url = $url . "?id=" . $keuzedeel->getKeuzedeelID();
    ?>
        <a href="<?= $local_url ?>">
            <div style=" height: 25rem;  border-radius: 5%;" class="col-md-3 content-col">
                <div style="background-color: #e6701a; border-radius: 10px; height: 20rem; overflow:hidden;">
                    <p class="text-center" style="color: white;"><?= $keuzedeel->getKeuzedeelNaam() ?></p>
                    <img class="img-fluid" src='<?= $keuzedeel->getKeuzedeelImage() ?>' style="border-radius: 0px 0px 10px 10px;">
                </div>
            </div>
        </a>
    <?php
        $newurl = str_replace("?id=" . $keuzedeel->getKeuzedeelID(), "", $local_url);
        $url = $newurl;
    }
    ?>
</div>
