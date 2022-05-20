<?php

ob_start(); // ensures anything dumped out will be caught



/*
      * Template name: mentorCheck
      */
show_admin_bar(false);
get_header();

// End CSV import functie

if (isset($_POST['pickMentor'])) {
    $display_name = $_POST["display_name"];
    $mentorID = $_POST["mentorID"];
    $studentID = get_current_user_id();
    $studentnummergetter = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = " . get_current_user_id() . "");
    foreach ($studentnummergetter as $student) {
        $studentNummer = $student->student_number;
    }
    $wpdb->query("UPDATE wp_users SET mentorID = $mentorID WHERE ID = '$studentID'");
    $wpdb->query("INSERT INTO mentor_koppeling (mentorAfkorting, studentNummer ) VALUE ('$display_name', '$studentNummer')");
}
?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <h1><?= wp_title() ?></h1>
            <?php $result = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = " . get_current_user_id() . "");
            foreach ($result as $print) {
                if ($print->MentorID == 0) {
                    //Kies mentor programma:
            ?>
                    <table id="myTable">
                        <tr>
                            <th style="font-size: 20px;">Mentor naam</th>
                            <th style="font-size: 20px;">Mentor afkorting</th>
                            <th style="font-size: 20px;">Mentor kiezen</th>
                        </tr>
                        <?php

                        global $wpdb;
                        $result = $wpdb->get_results("SELECT * FROM mentorlijst");
                        foreach ($result as $print) {

                        ?>
                            <tr style="font-size: 20px;">
                                <td><?= $print->mentorNaam ?></td>
                                <td><?= $print->mentorAfkorting ?></td>

                                <td>
                                    <?php

                                    ?>
                                    <form action="<?= get_home_url() . '/mentor_check/'  ?>" method='post'>
                                        <!--hier staat de accepteer button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                        dit word als hidden gezet zodat niemand er last van heeft.-->

                                        <?php
                                        $user_login = $print->mentorAfkorting;
                                        $result1 = $wpdb->get_results("SELECT * FROM wp_users WHERE user_nicename = '$user_login'");
                                        foreach ($result1 as $print1) {
                                            $display_name_mentor = $print1->display_name;
                                            $result2 = $wpdb->get_results("SELECT * FROM mentorlijst WHERE mentorAfkorting = '$display_name_mentor'");
                                        ?>
                                            <input type="text" name="mentorID" value="<?php foreach ($result2 as $print2) {
                                                                                            echo $print2->mentorID;
                                                                                        } ?>" hidden>
                                            <input type="text" name="display_name" value="<?= $print1->display_name; ?>" hidden>
                                        <?php } ?>
                                        <input type="submit" name='pickMentor' value="Dit is mijn mentor">
                                    </form>
                                    <?php

                                    ?>
                                </td>
                            </tr>
                        <?php
                        } ?>

                    </table>
            <?php
                } else {
                    $url = site_url('/wat-zijn-keuzedelen/');
                    // clear out the output buffer
                    while (ob_get_status()) {
                        ob_end_clean();
                    }

                    // no redirect
                    header("Location: $url");
                }
            }

            ?>
        </div>
    </div>
</div>
<?php

get_footer();

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