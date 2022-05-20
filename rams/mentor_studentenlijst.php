<?php

// if (current_user_can('administrator')) {

/*
      * Template name: studentenlijst_voor_mentor
      */
show_admin_bar(false);
get_header();

// End CSV import functie
if (isset($_POST['PERM_DEL'])) {
    require_once(ABSPATH . 'wp-admin/includes/user.php');
    $IDTODELETE = $_POST['Leerling_ID'];
    $studentenNummer = $_POST['Leerling_Nummer'];
    $wpdb->query("UPDATE wp_users SET mentorID = 0 WHERE ID = '$IDTODELETE'");
    $wpdb->query("DELETE FROM mentor_koppeling WHERE studentNummer = '$studentenNummer'");
}
?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <h1><?= wp_title() ?></h1>

            <form method="post" enctype="multipart/form-data" class="space2">


                <div class="main small-12 medium-12 large-12 cell">

                </div>
            </form>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="zoek studenten..." title="">
            <table>
                <tr>
                    <th style="font-size: 20px;">Gebruikersnaam</th>
                    <th style="font-size: 20px;">Studenten Nummer</th>
                    <th style="font-size: 20px;">Naam</th>
                    <th style="font-size: 20px;">Verwijder optie</th>
                </tr>
                <?php

                global $wpdb;
                $result1 = $wpdb->get_results("SELECT * FROM mentor_koppeling");
                $result = $wpdb->get_results("SELECT * FROM wp_users");
                $currentMentor = '';
                foreach ($result as $print) {
                    if ($print->ID == get_current_user_id() && $print->ismentor == 1) {
                        $currentMentor = $print->display_name;
                        //echo "Uw afkorting is:" . $currentMentor;
                    }
                    foreach ($result1 as $print1) {
                        if ($print->student_number == 0 || $print->ismentor == 1) {
                        } else if ($print->student_number == $print1->studentNummer && $print1->mentorAfkorting == $currentMentor) {
                ?>
                            <tr style="font-size: 20px;">
                                <td><?= $print->user_login ?></td>
                                <td><?= $print->student_number ?></td>
                                <td><?= $print->display_name ?></td>
                                <td>
                                    <?php $studentenNummer = $print->student_number;
                                    if ($studentenNummer != 0) {

                                    ?>
                                        <form action="<?= get_home_url() . '/mentor_studentenlijst/'  ?>" method='post'>
                                            <!--hier staat de accepteer button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                        dit word als hidden gezet zodat niemand er last van heeft.-->
                                            <?php
                                            $result2 = $wpdb->get_results("SELECT * FROM wp_users WHERE student_number = $studentenNummer");
                                            foreach ($result2 as $print2) {
                                            ?>
                                                <input type="text" name="Leerling_ID" value="<?= $print2->ID; ?>" hidden>
                                                <input type="text" name="Leerling_Nummer" value="<?= $print->student_number ?>" hidden>
                                            <?php } ?>
                                            <input type="submit" name='PERM_DEL' value="Verwijderen">
                                        </form>
                                    <?php
                                    }

                                    ?>
                                </td>
                            </tr>
                <?php }
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>
<?php

get_footer();
// } else {
//     echo "Je hebt administrator rechten nodig om de pagina te kunnen bekijken! Ga naar de <a href='" . home_url() . "'>home-pagina</a>.";
// }
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