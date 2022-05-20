<?php

if (current_user_can('administrator')) {

    /*
      * Template name: studentenlijst
      */
    show_admin_bar(false);
    get_header();

    // End CSV import functie
    if (isset($_POST['PERM_DEL'])) {
        $IDTODELETE = $_POST['Leerling_ID'];
        $userToDelete = get_user_by('id', $IDTODELETE);
        $userDisplay = $userToDelete->display_name;
        $userNice = $userToDelete->user_nicename;
        $userStudentNummer = $userToDelete->student_number;
        $userEmail = $userToDelete->user_email;
        $wpdb->query("DELETE FROM mentorlijst WHERE mentorAfkorting = '$userNice' or mentorlijst WHERE mentorAfkorting = '$userDisplay'");
        $wpdb->query("DELETE FROM Aanmeldlijst WHERE Leerlingnummer = '$userStudentNummer'");
        $wpdb->query("DELETE FROM Aanmeldlijst_sec WHERE Leerlingnummer = '$userStudentNummer'");
        $wpdb->query("DELETE FROM Aanmeldlijst_trainer WHERE Leerlingnummer = '$userStudentNummer'");
        $wpdb->query("DELETE FROM mentor_koppeling WHERE studentNummer = '$userStudentNummer'");
        require_once(ABSPATH . 'wp-admin/includes/user.php');
        wp_delete_user($IDTODELETE);
    }
?>
    <script>
        function showDelButton(number) {
            document.getElementById("noDel" + number).hidden = false;
            document.getElementById("permDel" + number).hidden = false;
            document.getElementById("permDelText" + number).hidden = false;
            document.getElementById("delConfirm" + number).hidden = true;
            //noDel show
            //delConfirm hide

        }

        function hideDelButton(number) {
            //noDel hide
            //delConfirm show
            document.getElementById("noDel" + number).hidden = true;
            document.getElementById("permDel" + number).hidden = true;
            document.getElementById("permDelText" + number).hidden = true;
            document.getElementById("delConfirm" + number).hidden = false;
        }
    </script>
    <div class="col-sm-12 text-break">
        <div class="post-inner">
            <div class="post-content">
                <h1><?= wp_title() ?></h1>

                <form method="post" enctype="multipart/form-data" class="space2">


                    <div class="main small-12 medium-12 large-12 cell">

                    </div>
                </form>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="zoek studenten..." title="">
                <table id="myTable">
                    <tr>
                        <th style="font-size: 20px;">Gebruikersnaam</th>
                        <th style="font-size: 20px;">Studenten Nummer</th>
                        <th style="font-size: 20px;">Naam</th>
                        <th>Options</th>
                    </tr>
                    <?php

                    global $wpdb;
                    $result = $wpdb->get_results("SELECT * FROM wp_users");
                    $counter = 0;
                    foreach ($result as $print) {
                        if ($print->student_number == 0) {
                        } else {
                    ?>
                            <tr style="font-size: 20px;">
                                <td><?= $print->user_login ?></td>
                                <td><?= $print->student_number ?></td>
                                <td><?= $print->display_name ?></td>
                                <td>
                                    <?php $studentenNummer = $print->student_number;
                                    if ($studentenNummer != 0) {
                                        $counter++;
                                    ?>
                                        <form action="<?= get_home_url() . '/studentenlijst/'  ?>" method='post'>
                                            <!--hier staat de accepteer button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                        dit word als hidden gezet zodat niemand er last van heeft.-->

                                            <?php
                                            $result2 = $wpdb->get_results("SELECT * FROM wp_users WHERE student_number = $studentenNummer");
                                            foreach ($result2 as $print2) {
                                            ?><input type="text" name="Leerling_ID" value="<?= $print2->ID; ?>" hidden>
                                            <?php } ?>
                                            <span id="permDelText<?= $counter; ?>" hidden>Weet u het zeker?<br><br></span>
                                            <a class="DeleteConfirmbutton" href="#" id="delConfirm<?= $counter; ?>" onclick="showDelButton(<?= $counter ?>)">Delete</a>
                                            <input class="DeleteConfirmbutton" id="permDel<?= $counter; ?>" type="submit" name='PERM_DEL' value="Ja" hidden>
                                            <a class="DeleteConfirmbutton" href="#" id="noDel<?= $counter; ?>" onclick="hideDelButton(<?= $counter ?>)" hidden>Nee</a>
                                        </form>
                                    <?php
                                    }

                                    ?>
                                </td>
                            </tr>
                    <?php }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
<?php

    get_footer();
} else {
    echo "Je hebt administrator rechten nodig om de pagina te kunnen bekijken! Ga naar de <a href='" . home_url() . "'>home-pagina</a>.";
}
?>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>