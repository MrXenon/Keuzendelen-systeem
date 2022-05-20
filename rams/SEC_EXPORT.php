<?php

/*
  * Template name: export_seclijst
  */
if (isset($_POST['DLCSV'])) {
  $wpdb->show_errors();


  global $wpdb;

  // Grab any post values you sent with your submit function


  // Build your query						
  $MyQuery = $wpdb->get_results($wpdb->prepare('SELECT Leerlingnummer,keuzedeel_ID,aanmeld_datum FROM Aanmelding_student_sec'));


  // Process report request
  if (!$MyQuery) {
    $Error = $wpdb->print_error();
    die("The following error was found: $Error");
  } else {
    // Prepare our csv download

    // Set header row values
    $csv_fields = array();
    $csv_fields[] = 'Leerlingnummer';
    $csv_fields[] = 'keuzedeel_ID';
    $csv_fields[] = 'aanmeld_datum';
    $output_filename = 'Aanmelding_studenten_Keuzedelen.csv';
    $output_handle = @fopen('php://output', 'w');

    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Description: File Transfer');
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename=' . $output_filename);
    header('Expires: 0');
    header('Pragma: public');

    // Insert header row
    fputcsv($output_handle, $csv_fields, ';', ' ');

    // Parse results to csv format
    foreach ($MyQuery as $Result) {
      $leadArray = (array) $Result; // Cast the Object to an array
      // Add row to file
      fputcsv($output_handle, $leadArray, ';', ' ');
    }

    // Close output file stream
    fclose($output_handle);
    $wpdb->query("DELETE FROM Aanmelding_student_sec WHERE `Leerlingnummer` != 0 ");
    die();
  }
}
