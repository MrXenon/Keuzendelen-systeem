<?php
class import
{
    //Function to import a CSV file
    public function importCSV($file)
    {
        $errorlogs = '';
        //Open the file so it can read what's in it
        if (($handle = fopen($file['tmp_name'], "r")) !== false) {
            //Gets line from file pointer and parse for CSV fields
            $row = 0;
           $success = true;
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                $row++;
                // store csv values
                $nummer = $data[0];
                $achternaam = $data[1];
                $volNaam = $data[2];
                $oplcode = $data[3];
                $organisatie = $data[4];
                $basisgroep = $data[5];
                $email = $data[6];

                if (is_numeric($nummer) == false) {
                    $errorlogs .= '<br>' . $data[2] . ' is geen geldig nummer! <br>fout bevind zich op lijn: ' . $row;
                    $success = false;
                    continue;
                }
                if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                    $errorlogs .= '<br>' . $data[6] . ' is geen geldige email! <br>fout bevind zich op lijn: ' . $row;
                    $success = false;
                    continue;
                }
                //Call $wpdb
                global $wpdb;
                //Insert query
                $wpdb->insert(
                    'tbl_info',
                    array(
                        'nummer' => $nummer,
                        'achternaam' => $achternaam,
                        'volledige_naam' => $volNaam,
                        'opleidingscode' => $oplcode,
                        'organisatie' => $organisatie,
                        'basisgroep' => $basisgroep,
                        'email_school' => $email
                    ),
                    array(
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );
            }
            
        }else{
            $success = false;
        }
        $view = array($success,$errorlogs);
        //Return the array
        return $view;
    }
}
