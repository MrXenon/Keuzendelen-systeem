<?php


ob_start(); // ensures anything dumped out will be caught


/*
      * Template name: instellingen_leerlingen
      */
show_admin_bar(false);
get_header();


if (isset($_POST['repickMentor'])) {
    global $wpdb;
    
    $studentnummergetter = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = " . get_current_user_id() . "");
    foreach ($studentnummergetter as $student) {
        $studentNummer = $student->student_number;
    }
    $studentID = get_current_user_id();
    
    $wpdb->query("UPDATE wp_users SET mentorID = 0 WHERE ID = '$studentID'");
    $wpdb->query("DELETE FROM mentor_koppeling WHERE studentNummer = $studentNummer");
    // clear out the output buffer
    while (ob_get_status()) {
        ob_end_clean();
    }
    $url = site_url('/mentor_check/');
    // no redirect
    header("Location:$url ");
}
?>
<div class="col-sm-12 text-break">
    <div class="post-inner">
        <div class="post-content">
            <h1><?= wp_title() ?></h1>
            <?php
            $studentNummer = 0;
            $studentnummergetter = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = " . get_current_user_id() . "");
            foreach ($studentnummergetter as $student) {
                $studentNummer = $student->student_number;
            }
            $mentorKoppeling = $wpdb->get_results("SELECT * FROM mentor_koppeling WHERE studentNummer = $studentNummer");
            foreach ($mentorKoppeling as $koppeling) {
                echo "Jouw mentor is: " . $koppeling->mentorAfkorting;
            ?>
                <form action="<?= get_home_url() . '/instellingen-mentor/'  ?>" method='post'>
                    <input type="submit" name="repickMentor" value="mentor opnieuw kiezen">
                </form>
            <?php
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