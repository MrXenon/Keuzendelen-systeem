<?php

/**
 * Class Opleiding
 *
 * @author  Arran Crowley
 * @version 0.1
 */
class Opleiding
{
    /**
     * @var string
     */
    private $opleiding_name;
    /**
     * @var int
     */
    private $opleiding_ID;
    /**
     * @var int
     */
    private $BranchesBranch_ID;
    /**
     * @var string
     */
    private $branch_naam;

    /**
     * setOpleidingID:
     * set the OpleidingID
     *
     * @param string $opleiding_ID
     */
    public function setOpleidingID($opleiding_ID)
    {
        $this->opleiding_ID = $opleiding_ID;
    }

    /**
     * getOpleidingID:
     * get the OpleidingID
     *
     * @return string Returns the OpleidingID
     */
    public function getOpleidingID()
    {
        return $this->opleiding_ID;
    }

    /**
     * setOpleidingID:
     * set the OpleidingID
     *
     * @param string $opleiding_ID
     */
    public function setOpleidingImage($opleiding_image)
    {
        $this->opleiding_image = $opleiding_image;
    }

    /**
     * getOpleidingID:
     * get the OpleidingID
     *
     * @return string Returns the OpleidingID
     */
    public function getOpleidingImage()
    {
        return $this->opleiding_image;
    }

    /**
     * setOpleidingName:
     * set the OpleidingName
     *
     * @param string $opleiding_name
     */
    public function setOpleidingName($opleiding_name)
    {
        $this->opleiding_name = $opleiding_name;
    }

    /**
     * getOpleidingName:
     * get the OpleidingName
     *
     * @return string Returns the OpleidingName
     */
    public function getOpleidingName()
    {
        return $this->opleiding_name;
    }

    /**
     * setBranchesBranchID:
     * set the BranchesBranchID.
     *
     * @param string $BranchesBranch_ID
     */
    public function setBranchesBranchID($BranchesBranch_ID)
    {
        $this->BranchesBranch_ID = $BranchesBranch_ID;
    }

    /**
     * getBranchesBranchID:
     * get the BranchesBranchID
     *
     * @return string Returns the BranchesBranchID
     */
    public function getBranchesBranchID()
    {
        return $this->BranchesBranch_ID;
    }

    /**
     * setBranchNaam:
     * set the BranchNaam
     *
     * @param string $branch_naam
     */
    public function setBranchNaam($branch_naam)
    {
        $this->branch_naam = $branch_naam;
    }

    /**
     * getBranchNaam:
     * get the BranchNaam
     *
     * @return string Returns the BranchNaam
     */
    public function getBranchNaam()
    {
        return $this->branch_naam;
    }

    /**
     * getPostValues:
     * Filter the postvalues from the admin view
     *
     * @return mixed returned the filter postvalues
     */
    public function getPostValues()
    {
        // Define the check for params
        $post_check_array = array(
            // submit form info
            'toevoegen' => array('filter' => FILTER_SANITIZE_STRING),
            'bijwerken' => array('filter' => FILTER_SANITIZE_STRING),
            'verwijderen' => array('filter' => FILTER_SANITIZE_STRING),
            'opleiding_image' => array('filter' => FILTER_SANITIZE_STRING),
            'opleiding_naam' => array('filter' => FILTER_SANITIZE_STRING),
            'opleidingID' => array('filter' => FILTER_SANITIZE_NUMBER_INT),
            'BranchesBranch_ID' => array('filter' => FILTER_SANITIZE_STRING)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
        // RTS
        return $inputs;
    }

    /**
     * getGetValues :
     * Filter input and retrieve GET input params
     *
     * @return array containing known GET input fields
     */
    public function getGetValues()
    {
        // Define the check for params
        $get_check_array = array(
            // Action
            'action' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current question
            'opleidingId' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_GET, $get_check_array);
        // RTS
        return $inputs;
    }

    /**
     * handleGetAction:
     * This function handles changes in the $action
     *
     * @param array $get_array
     *
     * @return string returned the current action and what to do with that function
     */
    public function handleGetAction($get_array)
    {
        $action = '';
        if (!is_null($get_array['opleidingId'])) {
            switch ($get_array['action']) {
                case 'bijwerken':
                    //action is the get array
                    $action = $get_array['action'];

                    break;

                case 'verwijderen':
                    // Delete opleiding if id is provided

                    //Call the delte function
                    $this->verwijderOpleiding($get_array);

                    $action = 'verwijderen';
                    break;
                default:
                    // Oops
                    break;
            }
        }
        return $action;
    }

    /**
     * getAlleOpleidingen:
     * Function to het all Opleidingen and returning them in a array.
     *
     * @return array|bool Returns a array with all opleidingen | Returns true if function was succesfull
     */
    public function getAlleOpleidingen()
    {
        try {
            global $wpdb;
            $return_array = array();
            // query to get all opleidingen
            $result_array = $wpdb->get_results("SELECT opleiding_ID, opleiding_Naam, opleiding_image,  BranchesBranch_ID FROM Opleiding ORDER BY BranchesBranch_ID", ARRAY_A);
            // For all database results:
            foreach ($result_array as $idx => $array) {
                // New Vraag object
                $opleiding = new Opleiding();
                // Set all info
                $opleiding->setOpleidingID($array['opleiding_ID']);
                $opleiding->setOpleidingName($array['opleiding_Naam']);
                $opleiding->setBranchesBranchID($array['BranchesBranch_ID']);
                $opleiding->setOpleidingImage($array['opleiding_image']);

                $return_array[] = $opleiding;
            }
            return $return_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }
    public function getAllOpleidingenView($id)
    {

        try {
            global $wpdb;
            $return_array  = [];
            $queryResult = $wpdb->get_results("SELECT opleiding_ID,opleiding_naam, opleiding_image FROM Opleiding WHERE BranchesBranch_ID = '$id' ORDER BY  opleiding_naam", ARRAY_A);

            foreach ($queryResult as $idx => $array) {
                // New Vraag object
                $opleiding = new Opleiding();
                // Set all info
                $opleiding->setOpleidingID($array['opleiding_ID']);
                $opleiding->setOpleidingName($array['opleiding_naam']);
                if (empty($array['opleiding_image']) || $array['opleiding_image'] == null) {
                    $opleiding->setOpleidingImage('https://opleiding.com/u/opleider/scalda.png');
                } else {
                    $opleiding->setOpleidingImage($array['opleiding_image']);
                }
                $return_array[] = $opleiding;
            }

            return $return_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }
    /**
     * getBranchNames:
     * Get the branch names for the result list.
     *
     * @param string $id
     *
     * @return bool|string Returns true if function was succesfull | Returns string if the result array is empty else it returns the branchnaam
     */
    public function getBranchNames($id)
    {
        try {
            global $wpdb;
            // query to get all questions
            $result_array = $wpdb->get_results("SELECT branch_naam FROM branches WHERE branch_ID = '$id'", ARRAY_A);
            $opleiding = new Opleiding();
            if (empty($result_array)) {
                return "Geen branch voor deze opleiding!";
            } else {
                $opleiding->setBranchNaam($result_array[0]["branch_naam"]);
                return $opleiding->getBranchNaam();
            }
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    /**
     * getBranchNamesSelect:
     * gets all the branches to put in the select form.
     *
     * @return array|bool returns array of the branches | returns true if succesfull
     */
    public function getBranchNamesSelect()
    {
        try {
            global $wpdb;
            $return_array = array();
            // query to get all questions
            $result_array = $wpdb->get_results("SELECT branch_naam, branch_ID FROM branches", ARRAY_A);
            foreach ($result_array as $idx => $array) {
                $opleiding = new Opleiding();

                $opleiding->setBranchNaam($array['branch_naam']);
                $opleiding->setBranchesBranchID($array['branch_ID']);
                $return_array[] = $opleiding;
            }

            return $return_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    /**
     * voegOpleidingToe:
     * Function to add a new Opleiding.
     *
     * @param array $input_array
     *
     * @return bool Returns true if succesfull
     */
    public function voegOpleidingToe($input_array)
    {
        try {
            global $wpdb;
            $opleidingNaam = $input_array['opleiding_naam'];
            $branchID = $input_array['BranchesBranch_ID'];
            $opleidingImage = $input_array['opleiding_image'];
            // Insert query
            $wpdb->query(
                "INSERT INTO `Opleiding` (`opleiding_Naam`, `opleiding_image`, `BranchesBranch_ID`) VALUES ('$opleidingNaam', '$opleidingImage', '$branchID')"
            );
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
     * werkOpleidingBij:
     * Function to edit a existing Opleiding
     *
     * @param array $input_array
     *
     * @return bool Returns true if succesfull
     */
    public function werkOpleidingBij($input_array)
    {
        try {
            $current_opleidingID = $input_array['opleidingID'];
            $opleiding_naam = $input_array['opleiding_naam'];
            $opleiding_image = $input_array['opleiding_image'];
            $branch_ID = $input_array['BranchesBranch_ID'];
            global $wpdb;
            // Update query
            $wpdb->query("UPDATE Opleiding SET `opleiding_naam` = '$opleiding_naam', `opleiding_image` = '$opleiding_image',`BranchesBranch_ID` = '$branch_ID' WHERE `opleiding_ID` ='$current_opleidingID'");
            // Update link table query

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }

    /**
     * verwijderOpleiding:
     * Function to delete a existing Opleiding
     *
     * @param array $get_array
     *
     * @return bool Returns true if succesfull
     */
    public function verwijderOpleiding($get_array)
    {
        try {
            $id = $get_array['opleidingId'];
            global $wpdb;
            // Delete query
            $wpdb->query("DELETE FROM Opleiding WHERE opleiding_ID ='$id'");
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
