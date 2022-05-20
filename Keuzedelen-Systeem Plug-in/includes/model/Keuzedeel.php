<?php

/**
 * Class Keuzedeel
 *
 * @author  Arran Crowley
 * @version 0.1
 */
class Keuzedeel {
    /**
     * @var string
     */
    private $keuzedeel_naam;
    /**
     * @var int
     */
    private $keuzedeel_ID;
    /**
     * @var string
     */
    private $informatie_keuzedeel;
    /**
     * @var int
     */
    private $opleiding_opleidingID;
    /**
     * @var string
     */
    private $opleiding_name;

    /**
     * getKeuzedeelImage
     *Function to get the keuzedeel URL
     *
     * @return string Returns the keuzedeel URL
     */
    public function getBranchImage()
    {
        return $this->keuzedeel_image;
    }


    /**
     * setKeuzedeelImage:
     * Sets the KeuzedeelImage
     *
     * @param string $keuzedelenmage
     */
    public function setKeuzedeelPlaatsen($keuzedeel_plaatsen)
    {
        $this->keuzedeel_plaatsen = $keuzedeel_plaatsen;
    }

    /**
     * getKeuzedeelID:
     * Gets the KeuzedeelID
     *
     * @return string returned the KeuzedeelID
     */
    public function getKeuzedeelPlaatsen()
    {
        return $this->keuzedeel_plaatsen;
    }

    /**
     * setKeuzedeelImage:
     * Sets the KeuzedeelImage
     *
     * @param string $keuzedelenmage
     */
    public function setKeuzedeelCohort($keuzedeel_cohort)
    {
        $this->keuzedeel_cohort = $keuzedeel_cohort;
    }

    /**
     * getKeuzedeelID:
     * Gets the KeuzedeelID
     *
     * @return string returned the KeuzedeelID
     */
    public function getKeuzedeelCohort()
    {
        return $this->keuzedeel_cohort;
    }


    /**
     * setKeuzedeelImage:
     * Sets the KeuzedeelImage
     *
     * @param string $keuzedelenmage
     */
    public function setKeuzedeelImage($keuzedeel_Image)
    {
        $this->keuzedeel_Image = $keuzedeel_Image;
    }

    /**
     * getKeuzedeelID:
     * Gets the KeuzedeelID
     *
     * @return string returned the KeuzedeelID
     */
    public function getKeuzedeelImage()
    {
        return $this->keuzedeel_Image;
    }

    /**
     * setKeuzedeelID:
     * Sets the KeuzedeelID
     *
     * @param string $keuzedeel_ID
     */
    public function setKeuzedeelID($keuzedeel_ID)
    {
        $this->keuzedeel_ID = $keuzedeel_ID;
    }

    /**
     * getKeuzedeelID:
     * Gets the KeuzedeelID
     *
     * @return string returned the KeuzedeelID
     */
    public function getKeuzedeelID()
    {
        return $this->keuzedeel_ID;
    }

    /**
     * setKeuzedeelNaam:
     * Sets the KeuzedeelNaam
     *
     * @param string $keuzedeel_naam
     */
    public function setKeuzedeelNaam($keuzedeel_naam)
    {
        $this->keuzedeel_naam = $keuzedeel_naam;
    }

    /**
     * getKeuzedeelNaam:
     * Gets the KeuzedeelNaam
     *
     * @return string returned the KeuzedeelNaam
     */
    public function getKeuzedeelNaam()
    {
        return $this->keuzedeel_naam;
    }

    /**
     * setOpleidingName:
     * Sets the OpleidingName
     *
     * @param string $opleiding_name
     */
    public function setOpleidingName($opleiding_name)
    {
        $this->opleiding_name = $opleiding_name;
    }

    /**
     * getOpleidingName:
     * Gets the OpleidingName.
     *
     * @return string returned the OpleidingName
     */
    public function getOpleidingName()
    {
        return $this->opleiding_name;
    }

    /**
     * setOpleidingopleidingID:
     * Sets the OpleidingopleidingID
     *
     * @param string $opleiding_opleidingID returned the OpleidingopleidingID
     */
    public function setOpleidingopleidingID($opleiding_opleidingID)
    {
        $this->opleiding_opleidingID = $opleiding_opleidingID;
    }

    /**
     * getOpleidingopleidingID
     * Sets the OpleidingopleidingID
     *
     * @return string returned the OpleidingopleidingID
     */
    public function getOpleidingopleidingID()
    {
        return $this->opleiding_opleidingID;
    }

    /**
     * getPostValues:
     * Filter the postvalues from the admin view
     *
     * @return mixed returned the filter postvalues
     */
    public function getPostValues()
    {
        function getallenOpleidingen($val)
        {
            if (strpos($val, 'Opleidingopleiding_ID') !== false) {
                return $val;
            }
        }
        $key_array = array_filter(array_keys(filter_input_array(INPUT_POST)), 'getallenOpleidingen');

        // Define the check for params
        $post_check_array = array(
            // submit action
            'toevoegen' => array('filter' => FILTER_SANITIZE_STRING),
            'bijwerken' => array('filter' => FILTER_SANITIZE_STRING),
            'verwijderen' => array('filter' => FILTER_SANITIZE_STRING),
            'keuzedeelID' => array('filter' => FILTER_SANITIZE_NUMBER_INT),
            'keuzedeel_naam' => array('filter' => FILTER_SANITIZE_STRING),
            'keuzedelen_image' => array('filter' => FILTER_SANITIZE_STRING),
            'verplicht_keuzedeel' => array('filter' => FILTER_SANITIZE_STRING),
            'code_keuzedeel' => array('filter' => FILTER_SANITIZE_STRING),
            'aantal_klokuur' => array('filter' => FILTER_SANITIZE_STRING),
            'omschrijving_inhoud' => array('filter' => FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW),
            'programma_begeleiding' => array('filter' => FILTER_SANITIZE_STRING),
            'locatie' => array('filter' => FILTER_SANITIZE_STRING),
            'examinering' => array('filter' => FILTER_SANITIZE_STRING),
            'periode' => array('filter' => FILTER_SANITIZE_STRING),
            'voorwaarden_start' => array('filter' => FILTER_SANITIZE_STRING),
            'trainers_begeleiders' => array('filter' => FILTER_SANITIZE_STRING),
            'plaatsen' => array('filter' => FILTER_SANITIZE_STRING),
            'cohort' => array('filter' => FILTER_SANITIZE_STRING)
        );

        foreach ($key_array as $item) {
            $post_check_array[$item] = ['filter' => FILTER_SANITIZE_STRING];
        }

        // Get filtered input:
        // RTS
        return filter_input_array(INPUT_POST, $post_check_array);
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
            // Id of current keuzedeel
            'keuzedeelId' => array('filter' => FILTER_VALIDATE_INT),
            'keuzedelen_image' => array('filter' => FILTER_SANITIZE_STRING)
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
        if (!is_null($get_array['keuzedeelId'])) {
            switch ($get_array['action']) {
                case 'bijwerken':
                    // Indicate current action is update if id provided
                    $action = $get_array['action'];
                    break;

                case 'verwijderen':
                    // Delete current id if provided
                    $this->verwijderKeuzedeel($get_array);
                    $action = 'verwijderen';
                    break;
                default:
                    //action is none
                    break;
            }
        }
        return $action;
    }

    /**
     * getAlleKeuzedelen:
     * Function to het all keuzedelen and returning them in a array.
     *
     * @return array|bool Returns a array with all keuzedelen | Returns true if function was succesfull
     */
    public function getAlleKeuzedelen()
    {
        try {
            global $wpdb;
            $return_array = array();
            // query to get all questions
            $result_array = $wpdb->get_results("SELECT keuzedeel_ID, keuzedelen_Naam, keuzedelen_image, plaatsen_beschikbaar, cohort, code_keuzedeel FROM Keuzedelen", ARRAY_A);
            // For all database results:
            foreach ($result_array as $idx => $array) {
                // New Vraag object
                $keuzedeel = new Keuzedeel();
                // Set all info
                $keuzedeel->setKeuzedeelID($array['keuzedeel_ID']);
                $keuzedeel->setKeuzedeelNaam($array['keuzedelen_Naam']);
                $keuzedeel->setKeuzedeelImage($array['keuzedelen_image']);

                $return_array[] = $keuzedeel;
            }
            return $return_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }
    public function getallKeuzedelenView($id)
    {

        try {
            global $wpdb;
            $return_array  = [];
            $queryResult = $wpdb->get_results("SELECT Keuzedelen.keuzedeel_ID, Keuzedelen.keuzedelen_naam, Keuzedelen.keuzedelen_image FROM Keuzedelen INNER JOIN Opleiding_Keuzedelen ON Keuzedelen.keuzedeel_ID = Opleiding_Keuzedelen.keuzedeel_id WHERE Opleiding_Keuzedelen.opleiding_id = '$id' ORDER BY keuzedelen_naam", ARRAY_A);
            foreach ($queryResult as $idx => $array) {
                // New Vraag object
                $keuzedeel = new Keuzedeel();
                // Set all info
                $keuzedeel->setKeuzedeelID($array['keuzedeel_ID']);
                $keuzedeel->setKeuzedeelNaam($array['keuzedelen_naam']);
                if (empty($array['keuzedelen_image']) || $array['keuzedelen_image'] == null) {
                    $keuzedeel->setKeuzedeelImage($array['https://opleiding.com/u/opleider/scalda.png']);
                } else {
                    $keuzedeel->setKeuzedeelImage($array['keuzedelen_image']);
                }
                $return_array[] = $keuzedeel;
            }

            return $return_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }
    /**
     * getOpleidingNames:
     * Gets the names of the Opleidingen.
     *
     * @param int $id
     *
     * @return array
     */
    public function getOpleidingNames($id)
    {
        try {
            global $wpdb;
            // query to get all questions
            $result_array = $wpdb->get_results("SELECT opleiding_Naam FROM Opleiding INNER JOIN `Opleiding_Keuzedelen` ON `Opleiding_Keuzedelen`.opleiding_id = `Opleiding`.opleiding_ID WHERE `Opleiding_Keuzedelen`.keuzedeel_id = '$id'", ARRAY_N);

            if (empty($result_array)) {
                return [];
            }
            foreach ($result_array as $result) {
                $new_array[] = $result[0];
            }
            return $new_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }

    /**
     * getOpleidingNamesSelect:
     * gets all the opleidingen to put in the select form.
     *
     * @return array|bool returns array | returns true if succesfull
     */
    public function getOpleidingNamesSelect()
    {
        try {
            global $wpdb;
            $return_array = array();
            // query to get all questions
            $result_array = $wpdb->get_results("SELECT opleiding_naam, opleiding_ID FROM Opleiding", ARRAY_A);
            foreach ($result_array as $idx => $array) {
                $keuzedeel = new Keuzedeel();

                $keuzedeel->setOpleidingName($array['opleiding_naam']);
                $keuzedeel->setOpleidingopleidingID($array['opleiding_ID']);
                $return_array[] = $keuzedeel;
            }

            return $return_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    public function getAllOpleidingenForSelect($keuzedeelId)
    {
        try {
            global $wpdb;
            $result_array = $wpdb->get_results("SELECT `Opleiding`.opleiding_naam FROM Opleiding INNER JOIN `Opleiding_Keuzedelen` ON `Opleiding_Keuzedelen`.opleiding_id = `Opleiding`.opleiding_ID WHERE `Opleiding_Keuzedelen`.keuzedeel_id = '$keuzedeelId'", ARRAY_A);
            return $result_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
    }
    /**
     * getKeuzedeelInfoSelect:
     * Gets all the the data to put in the edit state of the form
     *
     * @param string $id
     *
     * @return bool returns true if succesfull
     */
    public function getKeuzedeelInfoSelect($id)
    {
        try {
            global $wpdb;
            // query to get all questions
            $result_array = $wpdb->get_results("SELECT `keuzedeel_ID`, `keuzedelen_naam`, `code_keuzedeel`, `verplicht_keuzedeel`, `aantal_klokuur`, `keuzedelen_image`,`omschrijving_inhoud`, `programma_begeleiding`, `locatie` , `examinering`, `periode`, `voorwaarden_start`,`trainers_begeleiders`,`plaatsen_beschikbaar`, `cohort` FROM Keuzedelen WHERE keuzedeel_ID = '$id'", ARRAY_A);

            return $result_array;
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    /**
     * voegKeuzedeelToe:
     * Function to add a new Keuzedeel.
     *
     * @param array $input_array
     *
     * @return bool Returns true if succesfull
     */
    public function voegKeuzedeelToe($input_array)
    {
        try {
            $filtered = array_filter($input_array, function ($key) {
                if (strpos($key, 'Opleidingopleiding_ID') !== false) {
                    return $key;
                }
            }, ARRAY_FILTER_USE_KEY);

            global $wpdb;
            $keuzedelen_image = $input_array['keuzedelen_image'];
            $keuzedeelNaam = $input_array['keuzedeel_naam'];
            $codeKeuzedeel = $input_array['code_keuzedeel'];
            $verplichtKeuzedeel = $input_array['verplicht_keuzedeel'];
            $aantal_klokuur = $input_array['aantal_klokuur'];
            $omschrijving_inhoud = $input_array['omschrijving_inhoud'];
            $omschrijving_inhoud = htmlspecialchars($omschrijving_inhoud);
            $programma_begeleiding = $input_array['programma_begeleiding'];
            $locatie = $input_array['locatie'];
            $examinering = $input_array['examinering'];
            $periode = $input_array['periode'];
            $voorwaarden_start = $input_array['voorwaarden_start'];
            $trainers_begeleiders = $input_array['trainers_begeleiders'];
            $plaatsen = $input_array['plaatsen'];
            $cohort = $input_array['cohort'];

            // Insert query
            $wpdb->query(
                "INSERT INTO `Keuzedelen` (`keuzedelen_naam`,`keuzedelen_image`,`code_keuzedeel`,`verplicht_keuzedeel`,`aantal_klokuur`,`omschrijving_inhoud`,`programma_begeleiding`,`locatie`,`examinering`,`periode`,`voorwaarden_start`,`trainers_begeleiders`,`plaatsen_beschikbaar`,`cohort`) 
                           VALUES ('$keuzedeelNaam','$keuzedelen_image','$codeKeuzedeel','$verplichtKeuzedeel','$aantal_klokuur','$omschrijving_inhoud','$programma_begeleiding','$locatie','$examinering','$periode','$voorwaarden_start','$trainers_begeleiders','$plaatsen','$cohort')"
            );

            foreach ($filtered as $filter) {
                $wpdb->query("INSERT INTO `Opleiding_Keuzedelen` (`opleiding_id`,`keuzedeel_id`) VALUES ('$filter', LAST_INSERT_ID())");
            }
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
     * werkKeuzedeelBij:
     * Function to edit a existing Keuzedeel
     *
     * @param array $input_array
     *
     * @return bool Returns true if succesfull
     */
    public function werkKeuzedeelBij($input_array)
    {
        //        echo '<pre>';
        //        var_dump($input_array);
        //        echo '</pre>';
        //        die();
        try {
            $filtered = array_filter($input_array, function ($key) {
                if (strpos($key, 'Opleidingopleiding_ID') !== false) {
                    return $key;
                }
            }, ARRAY_FILTER_USE_KEY);

            $keuzedeelId = $input_array['keuzedeelID'];
            $keuzedelen_image = $input_array['keuzedelen_image'];
            $keuzedeelNaam = $input_array['keuzedeel_naam'];
            $codeKeuzedeel = $input_array['code_keuzedeel'];
            $verplichtKeuzedeel = $input_array['verplicht_keuzedeel'];
            $aantal_klokuur = $input_array['aantal_klokuur'];
            $omschrijving_inhoud = $input_array['omschrijving_inhoud'];
            $programma_begeleiding = $input_array['programma_begeleiding'];
            $locatie = $input_array['locatie'];
            $examinering = $input_array['examinering'];
            $periode = $input_array['periode'];
            $voorwaarden_start = $input_array['voorwaarden_start'];
            $trainers_begeleiders = $input_array['trainers_begeleiders'];
            $plaatsen = $input_array['plaatsen'];
            $cohort = $input_array['cohort'];
            global $wpdb;
            // Update query
            $wpdb->query("UPDATE Keuzedelen SET `keuzedelen_naam` ='$keuzedeelNaam',
             `code_keuzedeel` = '$codeKeuzedeel' ,
          `verplicht_keuzedeel` = '$verplichtKeuzedeel' ,
             `keuzedelen_image` = '$keuzedelen_image' ,
             `aantal_klokuur` = '$aantal_klokuur',
             `omschrijving_inhoud` = '$omschrijving_inhoud',
             `programma_begeleiding` = '$programma_begeleiding',
             `locatie` = '$locatie',
             `examinering` = '$examinering',
             `periode` = '$periode',
             `voorwaarden_start` = '$voorwaarden_start',
             `trainers_begeleiders` = '$trainers_begeleiders',
             `plaatsen_beschikbaar` = '$plaatsen',
             `cohort` = '$cohort'
              
                WHERE `keuzedeel_ID` ='$keuzedeelId'");
            // Update link table query
            $wpdb->query("DELETE FROM Opleiding_Keuzedelen WHERE keuzedeel_id = '$keuzedeelId'");

            foreach ($filtered as $filter) {
                $wpdb->query("INSERT INTO `Opleiding_Keuzedelen` (`opleiding_id`,`keuzedeel_id`) VALUES ('$filter', '$keuzedeelId')");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }

    /**
     * verwijderKeuzedeel:
     * Function to delete a existing keuzedeel
     *
     * @param array $get_array
     *
     * @return bool Returns true if succesfull
     */
    public function verwijderKeuzedeel($get_array)
    {
        try {
            $id = $get_array['keuzedeelId'];
            global $wpdb;
            // Delete query
            $wpdb->query("DELETE FROM Keuzedelen WHERE keuzedeel_ID ='$id'");
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

