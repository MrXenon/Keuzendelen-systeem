<?php
/*
Template Name: AjaxHandler
*/
header("Access-Control-Allow-Origin: *");
include KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Branch.php";
(new AjaxHandler())->handle();
die();

class AjaxHandler{
    /**
     * @var Branch
     */
    private $branch;

    public function __construct()
    {
        $this->branch = new Branch();
    }
    /**
     * @return bool
     */
//    private function is_ajax()
//    {
//        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
//    }

    public function handle()
    {
//        if ($this->is_ajax()) {
        if (isset($_GET['action']) && !empty($_GET['action'])){
            switch ($_GET['action']) {
                case 'getAllBranches';
                    $this->getBranches();
                    break;
                    case 'getAllOpleidingen';
                    $this->getOpleiding();
                    break;
                    case 'getAllKeuzedelen';
                    $this->getAllKeuzedelen();
                    break;
                    case 'getInfoKeuzedeel';
                    $this->getInfoKeuzedeel();
                    break;
            }
        }
//        }
    }
    private function getBranches()
    {
       echo json_encode($this->branch->getAllBranchesApp());

    }
    private function getOpleiding(){
        $id = $_GET['branch_id'];
        echo json_encode($this->branch->getAllOpleidingenApp($id));
    }
    private function getAllKeuzedelen(){
        $id = $_GET['keuzedelen_id'];
        echo json_encode($this->branch->getallKeuzedelenApp($id));
    }
    private function getInfoKeuzedeel(){
        $id = $_GET['keuzedeel_id'];
        echo json_encode($this->branch->getinfoKeuzedeelApp($id));
    }
}