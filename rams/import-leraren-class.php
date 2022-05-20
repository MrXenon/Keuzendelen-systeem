<?php
//php mailer requirements, dit is nodig om de mailfunctie te laten werken.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//php mailer requirements end
class import
{
    //Function to import a CSV file
    public function importCSV($file)
    {
        $errorlogs = '';
        $passwordcheckfail = 0;
        //Open the file so it can read what's in it
        if (($handle = fopen($file['tmp_name'], "r")) !== false) {
            //Gets line from file pointer and parse for CSV fields
            //$row is de lijn in het bestand waar mogelijk een fout op komt, dit word meegegeven wanneer een error voorkomt
            $row = 0;
            $success = true;
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                $row++;
                
                // store csv values
                // hieronder worden de rijen in variablen opgeslagen die later naar de database verzonden worden.
                $nummer = $data[0];
                $vnaam = $data[1];
                $anaam = $data[2];
                $vnaamtest = substr($vnaam,0,2);
                $anaamtest = substr($anaam,0,4);
                $nummertest = $anaamtest . $vnaamtest;
                $email = $data[3];
                $usergeneratedpassword = PWGen();
                $register_date = date("Y-m-d h:i:sa");
                //hier word er gechecked of het formaat van het document juist is
                if (strlen($nummer) < 6 || strlen($nummer) > 6 || strtoupper($nummertest) != $nummer) {
                    $errorlogs .= '<br>' . $nummer . ' is geen geldig personeelsnummer! <br>fout bevind zich op lijn:' . $row . '<br>__________________________________________ ';
                    $success = false;
                    continue;
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorlogs .= '<br>' . $email . ' is geen geldige email! <br>fout bevind zich op lijn: ' . $row . '<br>__________________________________________';
                    $success = false;
                    continue;
                }
                if (strlen($usergeneratedpassword) > 8 || strlen($usergeneratedpassword) < 8){
                    if($passwordcheckfail > 0){
                        continue;
                    } 
                    $passwordcheckfail++;
                    $errorlogs .= '<br>import mislukt, wachtwoord functie werkt niet naar behoren <br> contacteer het bedrijf waar deze website is gemaakt.';
                    $success = false;
                    continue;
                }
                if (!validateDate($register_date,"Y-m-d h:i:sa")){
                    $errorlogs .= '<br>' . $register_date . ' is geen geldige datum gegenereerd! <br> deze fout mag niet voor komen, contacteer het bedrijf waar deze website is gemaakt.';
                    $success = false;
                    continue;
                }
                //Call $wpdb
                //database connectie word hier gemaakt
                global $wpdb;
                //hier word gechecked of de email al bestaat, als dit het geval is word deze lijn overgeslagen.
                $count = $wpdb->get_var("SELECT COUNT(*) FROM wp_users WHERE user_email = '$email'");
                if ($count > 0) {
                    continue;
                }
                //Insert query
                //hieronder worden de gegevens ingevoegd in de database
                $wpdb->insert(
                    'wp_users',
                    array(
                        'user_login' => $email,
                        'user_pass' => md5($usergeneratedpassword),
                        'user_nicename' => $nummer,
                        'user_email' => $email,
                        'display_name' => $nummer,
                        'crebo' => 'xxxx',
                        'student_number' => $nummer,
                        'user_registered' => $register_date
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );
                //student rol toegevoegd:
                $the_user = get_user_by('email', $email);
                $the_user_id = $the_user->ID;
                wp_update_user( array( 'ID' => $the_user_id, 'role' => 'contributor') );

                //mailfunctie:
                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = "smtp.office365.com";
                $mail->SMTPAuth = true;
                $mail->Username = 'mit-keuzedelen@outlook.com';
                $mail->Password = '8s9CyBE%%Jqcl%VY10yH';
                $mail->setFrom('mit-keuzedelen@outlook.com', 'keuzedelenwebsite');
                $mail->addAddress($email);
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Scalda-keuzedelen Login-gegevens';

                $mail->Body ='Beste student,<br><br>Dit zijn uw login gegevens voor de Scalda-Keuzedelen website:<br>Gebruikersnaam: ' . $email . '<br>Wachtwoord: ' . $usergeneratedpassword;
                $mail->AltBody = 'Uw Logingegevens voor de Scalda-keuzedelen website!';

                if (!$mail->send()) {
                } else {
                    //message is sent!
                }
            }
        } else {
            $success = false;
        }
        $view = array($success, $errorlogs);
        //Return the array
        return $view;
    }
}