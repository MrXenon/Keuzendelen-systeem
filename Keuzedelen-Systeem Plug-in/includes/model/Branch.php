<?php

/**
 * Class Branch
 *
 * @author  Arran Crowley
 * @version 0.1
 * Class Branch
 */
class Branch
{
    /**
     * @var string
     */
    private $branch_name;
    /**
     * @var int
     */
    private $branch_ID;

    /**
     * setBranchImage
     *Function to set the Branch Name
     *
     * @param string $branch_name
     */
    public function setBranchName($branch_name)
    {
        $this->branch_name = $branch_name;
    }

    /**
     * getBranchImage
     *Function to get the Branch Name
     *
     * @return string Returns the branch name
     */
    public function getBranchImage()
    {
        return $this->branch_image;
    }

    /**
     * setBranchImage
     *Function to set the Branch Image
     *
     * @param string $branch_name
     */
    public function setBranchImage($branch_image)
    {
        $this->branch_image = $branch_image;
    }
    
    /**
     * getBranchImage
     *Function to get the Branch Image
     *
     * @return string Returns the branch name
     */
    public function getBranchName()
    {
        return $this->branch_name;
    }

    /**
     * setBranchID
     * Function to set the Branch ID
     *
     * @param int $branch_ID
     */
    public function setBranchID($branch_ID)
    {
        $this->branch_ID = $branch_ID;
    }

    /**
     * getBranchID
     *Function to get the Branch ID
     *
     * @return int Returns the branch ID
     */
    public function getBranchID()
    {
        return $this->branch_ID;
    }

    /**
     * getPostValues:
     *Filter postvalues from input fields
     *
     * @return mixed returned de postvalues van de input velden.
     */
    public function getPostValues()
    {
        // Define the check for params
        $post_check_array = array(
            // submit action
            'toevoegen' => array('filter' => FILTER_SANITIZE_STRING),
            'bijwerken' => array('filter' => FILTER_SANITIZE_STRING),
            'verwijderen' => array('filter' => FILTER_SANITIZE_STRING),
            'branch_image' => array('filter' => FILTER_SANITIZE_STRING),
            'branch_naam' => array('filter' => FILTER_SANITIZE_STRING),
            'branchID' => array('filter' => FILTER_SANITIZE_NUMBER_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
        // RTS
        return $inputs;
    }

    /**
     * getGetValues :
     * Filter Get values
     *
     * @return array containing known GET input fields
     */
    public function getGetValues()
    {

        $get_check_array = array(
            // Action
            'action' => array('filter' => FILTER_SANITIZE_STRING),

            'branchId' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_GET, $get_check_array);
        // RTS
        return $inputs;
    }

    /**
     * handleGetAction:
     *Function to do stuff when an $action is filled.
     *
     * @param array $get_array
     *
     * @return string Returned the action.
     */
    public function handleGetAction($get_array)
    {
        $action = '';
        switch ($get_array['action']) {
            case 'bijwerken':
                // Indicate current action is update if id provided
                if (!is_null($get_array['branchId'])) {
                    $action = $get_array['action'];
                }
                break;

            case 'verwijderen':
                // Delete current id if provided
                if (!is_null($get_array['branchId'])) {
                    $this->verwijderBranch($get_array);
                }
                $action = 'verwijderen';
                break;
            default:
                // Oops
                break;
        }
        return $action;
    }

    /**
     * getAlleBranches:
     * Function to get all the branches.
     *
     * @return array|boolean All branches|true if succesfull
     */
    public function getAlleBranches()
    {
        try {
            global $wpdb;
            $return_array = array();
            // query to get all questions
            
            $result_array = $wpdb->get_results("SELECT branch_ID, branch_naam, branch_image FROM branches ORDER BY  branch_naam", ARRAY_A);
            // For all database results:
            foreach ($result_array as $idx => $array) {
                // New Branch object
                $branch = new Branch();
                // Set all info
                $branch->setBranchID($array['branch_ID']);
                $branch->setBranchName($array['branch_naam']);
                if(empty($array['branch_image'])|| $array['branch_image'] == null){
                    $branch->setBranchImage('https://opleiding.com/u/opleider/scalda.png');
                }else {
                    $branch->setBranchImage($array['branch_image']);
                }
                
                //Fill array with Branch info
                $return_array[] = $branch;
            }
            return $return_array;

        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    /**
     * getAllBranchesApp:
     * Function to get all branches
     *
     * @return array if fucntion is succesfull
     */
    public function getAllBranchesApp()
    {

        try {
            global $wpdb;
            $results  = [];
            $queryResult = $wpdb->get_results("SELECT branch_ID, branch_naam FROM branches ORDER BY  branch_naam", ARRAY_A);

            if (is_array($queryResult) || is_object($queryResult)) {
                foreach ($queryResult as $result) {
                    $results[] = $result;
                }
            }

            return $results;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }

    /**
     * getAllOpleidingenApp:
     * Gets all the opleiding from a given branch ID
     * @param $id
     *
     * @return array
     */
    public function getAllOpleidingenApp($id)
    {

        try {
            global $wpdb;
            $results  = [];
            $queryResult = $wpdb->get_results("SELECT opleiding_ID, opleiding_naam FROM Opleiding WHERE 	BranchesBranch_ID = '$id' ORDER BY  opleiding_naam", ARRAY_A);

            if (is_array($queryResult) || is_object($queryResult)) {
                foreach ($queryResult as $result) {
                    $results[] = $result;
                }
            }

            return $results;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }

    /**
     * getallKeuzedelenApp:
     * Gets all the keuzedelen from a given opleiding ID
     * @param int $id
     *
     * @return array If function is succesfull
     */
    public function getallKeuzedelenApp($id)
    {

        try {
            global $wpdb;
            $results  = [];
            $queryResult = $wpdb->get_results("SELECT keuzedeel_ID, keuzedelen_naam FROM Keuzedelen WHERE Opleidingopleiding_ID = '$id' ORDER BY keuzedelen_naam", ARRAY_A);

            if (is_array($queryResult) || is_object($queryResult)) {
                foreach ($queryResult as $result) {
                    $results[] = $result;
                }
            }

            return $results;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }

    /**
     * getinfoKeuzedeelApp:
     * Gets all the info of a given keuzedeel ID
     *
     * @param int $id
     *
     * @return array if function is succesfull
     */
    public function getinfoKeuzedeelApp($id)
    {

        try {
            global $wpdb;
            $results  = [];
            $queryResult = $wpdb->get_results("SELECT keuzedeel_ID, keuzedelen_naam, code_keuzedeel, aantal_klokuur, omschrijving_inhoud, programma_begeleiding, locatie, examinering, periode, voorwaarden_start, trainers_begeleiders FROM Keuzedelen WHERE keuzedeel_ID = '$id'", ARRAY_A);

            if (is_array($queryResult) || is_object($queryResult)) {
                foreach ($queryResult as $result) {
                    $results[] = $result;
                }
            }

            return $results;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }
    /**
     * voegBranchToe:
     * Function to add a new branch
     *
     * @param array $input_array
     *
     * @return bool If function is succesfull
     */
    public function voegBranchToe($input_array)
    {
        try {
            global $wpdb;
            //Name to add to database.
            
            $branchNaam = $input_array['branch_naam'];
            $branchImage = $input_array['branch_image'];
            // Insert query
            $wpdb->query(
                "INSERT INTO `branches` (`branch_naam`, `branch_image`) VALUE ('$branchNaam', '$branchImage')");
            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {
                $this->last_error = $wpdb->last_error;
                return false;
            }
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    /**
     * werkBranchBij:
     * Function to edit a existing Branch
     *
     * @param array $input_array
     *
     * @return bool if function is succesfull
     */
    public function werkBranchBij($input_array)
    {
        try {
            $current_branchID = $input_array['branchID'];
            $branch_naam = $input_array['branch_naam'];
            $branch_image = $input_array['branch_image'];
            global $wpdb;
            // Update query
            $wpdb->query("UPDATE branches SET `branch_naam` = '$branch_naam' WHERE `branch_ID` ='$current_branchID'");
            $wpdb->query("UPDATE branches SET `branch_image` = '$branch_image' WHERE `branch_ID` ='$current_branchID'");
            // Update link table query

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }

    /**
     * verwijderBranch:
     * Function to delete a existing Branch.
     *
     * @param array $get_array
     *
     * @return bool If function is succesfull
     */
    public function verwijderBranch($get_array)
    {
        try {
            //ID to get the branch that needs to be deleted
            $id = $get_array['branchId'];
            global $wpdb;
            // Delete query
            $wpdb->query("DELETE FROM branches WHERE branch_ID ='$id'");
            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {
                throw new Exception($wpdb->last_error);
            }
        } catch (Exception $exc) {
            echo '<pre>';
            $this->last_error = $exc->getMessage();
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
            echo '</pre>';
        }
        return true;
    }
}