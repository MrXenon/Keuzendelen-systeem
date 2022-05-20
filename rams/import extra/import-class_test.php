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
                $username = $data[0];
                $password = $data[1];
                $created_at = $data[2];
                $owo = $data[3];
                $uwu = $data[4];
                $owu = $data[5];
                $uwo = $data[6];
                var_dump($data[]);
                //Call $wpdb
                global $wpdb;
                //Insert query
                $wpdb->insert(
                    'wp_users',
                    array(
                        'username' => $username,
                        'password' => $password,
                        'created_at' => $created_at
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
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
