<?php
class import_kd
{
    //Function to import a CSV file
    public function importCSV($file)
    {
        $errorlogs = '';
        //Open the file so it can read what's in it
        if (($handle = fopen($file['tmp_name'], "r")) !== false) {
            //Gets line from file pointer and parse for CSV fields
            //$row is de lijn in het bestand waar mogelijk een fout op komt, dit word meegegeven wanneer een error voorkomt
            $row = 0;
            $success = true;
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                global $wpdb;
                $wpdb->show_errors();
                $error = 0;
                $row++;
                // store csv values
                // hieronder worden de rijen in variablen opgeslagen die later naar de database verzonden worden.
                $naamKD = $data[0];
                $codeKD = $data[1];
                $codecheck = str_split($codeKD);
                $urenKD = $data[2];
                $urencheck = str_split($urenKD);
                $omschrijvingKD = $data[3];
                $programmabegeleidingKD = $data[4];
                $locatieKD = $data[5];
                $examineringKD = $data[6];
                $periodeKD = $data[7];
                $voorwaardenstartKD = $data[8];
                $trainersbegeleidersKD = $data[9];
                //$opleiding = $data[10];
                //$opleidingen = explode(', ', $opleiding, 2);
                $opleiding_ID_KD = $wpdb->get_var("SELECT opleiding_ID FROM Opleiding WHERE opleiding_Naam = 'test'");
                //security check 1
                //1.1 regelcheck: als er lege velden zijn word de regel overgeslagen.
                $column = 0;
                $emptyColumns = '';
                for ($i = 0; $i < 10; $i++) {
                    $column++;
                    if ($data[$i] == '') {
                        $emptyColumns .= $column . ' ';
                    }
                }
                if($emptyColumns != ''){
                    $errorlogs .= 'de volgende kolommen zijn leeg: ' . $emptyColumns . ' op regel ' . $row . ' in het document.<br>';
                    $error++;
                }

                //1.2 urencheck: als er geen getallen in de kolom staan word de regel overgeslagen.
                $urencheckcounter = 0;
                for ($i = 0; $i < count($urencheck); $i++) {
                    if (is_numeric($urencheck[$i])) {
                        $urencheckcounter++;
                    }
                }
                if ($urencheckcounter === 0) {
                    $errorlogs .= 'Uren zijn fout ingevuld op regel ' . $row . ' in het document.<br>';
                    $error++;
                }
                //1.3 codecheck: de code is altijd K + 4 cijfers
                $codecheckcounter = 0;
                for ($i = 0; $i < count($codecheck); $i++) {
                    if (strtolower($codecheck[$i]) == 'k'){
                        $codecheckcounter++;
                    }
                    if (is_numeric($codecheck[$i])) {
                        $codecheckcounter++;
                    }
                }
                if ($codecheckcounter <= 4) {
                    $errorlogs .= 'De code moet een K en 4 cijfers bevatten, fout bevind zich op regel ' . $row . ' in het document.<br>';
                    $error++;
                }

                if ($error != 0) {
                    continue;
                }
                //1.4 naamcheck: als de naam al voorkomt in de database zal deze regel worden overgeslagen.
                $naamKDcheck = $wpdb->get_var("SELECT COUNT(*) FROM Keuzedelen WHERE keuzedelen_naam = '$naamKD'");
                if ($naamKDcheck > 0) {
                    continue;
                }
                //Call $wpdb
                //database connectie word hier gemaakt

                //!!!!!BEFORE IMPORT PLEASE ADD SECURITY ON EVERY ($data[])FIELD!!!!!
                //Insert query
                //hieronder worden de gegevens ingevoegd in de database
                $wpdb->insert(
                    'Keuzedelen',
                    array(
                        'keuzedelen_naam' => $naamKD,
                        'code_keuzedeel' => $codeKD,
                        'aantal_klokuur' => $urenKD,
                        'omschrijving_inhoud' => $omschrijvingKD,
                        'programma_begeleiding' => $programmabegeleidingKD,
                        'locatie' => $locatieKD,
                        'examinering' => $examineringKD,
                        'periode' => $periodeKD,
                        'voorwaarden_start' => $voorwaardenstartKD,
                        'trainers_begeleiders' => $trainersbegeleidersKD
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );
                $wpdb->insert(
                    'Opleiding_Keuzedelen',
                    array(
                        'opleiding_id' => $opleiding_ID_KD,
                        'keuzedeel_id' => $wpdb->get_var("SELECT keuzedeel_ID FROM Keuzedelen WHERE code_keuzedeel = '$codeKD'")
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );
                $wpdb->print_errors();
            }
        }
        if($errorlogs != ''){
            $success = false;
        }
        $view = array($success, $errorlogs);
        //Return the array
        return $view;
    }
}
