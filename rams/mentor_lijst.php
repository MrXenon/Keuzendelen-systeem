<?php

if (current_user_can('administrator')) {

    /*
      * Template name: mentorLijst
      */
    show_admin_bar(false);
    get_header();




?>
    <div class="col-sm-12 text-break">
        <div class="post-inner">
            <?php

            if (isset($_POST['create_mentor'])) {
                $register_date = date("Y-m-d h:i:sa");
                $usergeneratedpassword = PWGen();
                $email = $_POST['email'];
                $afkorting = $_POST['afkorting'];
                $naam = $_POST['naam'];

                if (isset($_POST['mentor'])) {
                    $ismentor = 1;
                } else {
                    $ismentor = 0;
                }
                $countID = $wpdb->get_var("SELECT COUNT(*) FROM wp_users");
                $countID++;
                $wpdb->insert(
                    'wp_users',
                    array(
                        'user_login' => $naam,
                        'user_pass' => md5($usergeneratedpassword),
                        'user_nicename' => $afkorting,
                        'user_email' => $email,
                        'display_name' => $afkorting,
                        'crebo' => 'xxxx',
                        'student_number' => 0,
                        'user_registered' => $register_date,
                        'ismentor' => $ismentor,
                        'MentorID' => $countID
                    ),
                    array(
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
                $wpdb->query("INSERT INTO mentorlijst (mentorNaam, mentorAfkorting ) VALUE ('$naam', '$afkorting')");
                //docent rol toegevoegd:
                $the_user = get_user_by('email', $email);
                $the_user_id = $the_user->ID;
                wp_update_user(array('ID' => $the_user_id, 'role' => 'contributor'));
                echo "Docent aangemaakt";
            }
            ?>
            <div class="post-content">
                <h1><?= wp_title() ?></h1>
                <?php
                if (isset($_POST['del_mentor'])) {
                    $display_name = $_POST["display_name"];
                    echo $display_name . " is verwijderd als mentor";
                    $wpdb->query("UPDATE wp_users SET ismentor = 0 WHERE display_name = '$display_name'");
                    $wpdb->query("DELETE FROM mentorlijst WHERE mentorAfkorting = '$display_name'");
                    $wpdb->query("DELETE FROM mentor_koppeling WHERE mentorAfkorting = '$display_name'");
                }
                if (isset($_POST['add_mentor'])) {
                    $display_name = trim($_POST["display_name"]);
                    echo $display_name . " Mentor is toegevoegd";
                    $afkorting = $_POST["MentorAfkorting"];
                    $afkorting = ltrim($afkorting);
                    $naam = $_POST["MentorNaam"];
                    $count = $wpdb->get_var("SELECT COUNT(*) FROM wp_users WHERE display_name = '$afkorting'");
                    if ($count > 0) {
                        $wpdb->query("UPDATE wp_users SET ismentor = 1 WHERE display_name = '$afkorting'");
                        $wpdb->query("INSERT INTO mentorlijst (mentorNaam, mentorAfkorting ) VALUE ('$naam', '$afkorting')");
                    } else {
                        echo "Selecteer A.U.B. een bestaande user.";
                    }
                }
                ?>
                <form method="post" enctype="multipart/form-data" class="space2">


                    <div class="main small-12 medium-12 large-12 cell">

                    </div>
                </form>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="zoek mentoren..." title="">
                <table id="myTable">
                    <thead>
                        <th style="font-size: 20px;">Mentor naam</th>
                        <th style="font-size: 20px;">Mentor afkorting</th>
                        <th style="font-size: 20px;">opties</th>
                    </thead>
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
                                <form action="<?= get_home_url() . '/mentorlijst/'  ?>" method='post'>
                                    <!--hier staat de accepteer button, hier worden de values uit de database gehaald en per aanmeldinging neer gezet,
                                        dit word als hidden gezet zodat niemand er last van heeft.-->

                                    <?php
                                    $user_login = $print->mentorAfkorting;
                                    $result1 = $wpdb->get_results("SELECT * FROM wp_users WHERE user_login = '$user_login' or user_nicename = '$user_login'");
                                    foreach ($result1 as $print1) {
                                    ?>
                                        <input type="text" name="display_name" value="<?= $print1->display_name; ?>" hidden>
                                    <?php } ?>
                                    <input type="submit" name='del_mentor' value="DELETE MENTOR">
                                </form>
                                <?php

                                ?>
                            </td>
                        </tr>
                    <?php
                    } ?>
                    <script>
                        var table, rows, switching, i, x, y, shouldSwitch;
                        table = document.getElementById("myTable");
                        switching = true;
                        /*Make a loop that will continue until
                        no switching has been done:*/
                        while (switching) {
                            //start by saying: no switching is done:
                            switching = false;
                            rows = table.rows;
                            /*Loop through all table rows (except the
                            first, which contains table headers):*/
                            for (i = 1; i < (rows.length - 1); i++) {
                                //start by saying there should be no switching:
                                shouldSwitch = false;
                                /*Get the two elements you want to compare,
                                one from current row and one from the next:*/
                                x = rows[i].getElementsByTagName("TD")[0];
                                y = rows[i + 1].getElementsByTagName("TD")[0];
                                //check if the two rows should switch place:
                                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                    //if so, mark as a switch and break the loop:
                                    shouldSwitch = true;
                                    break;
                                }
                            }
                            if (shouldSwitch) {
                                /*If a switch has been marked, make the switch
                                and mark that a switch has been done:*/
                                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                                switching = true;
                            }
                        }
                    </script>
                    <tr>
                        <td>
                            <h1>Beschikbare users om mentoren van te maken:</h1>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <table>

                    <thead>
                        <th style="font-size: 20px;">
                            Gebruikersnaam
                        </th>
                        <th style="font-size: 20px;">
                            Afkorting
                        </th>
                        <th style="font-size: 20px;">
                            Opties
                        </th>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                        <?php

                        $result = $wpdb->get_results("SELECT * FROM wp_users WHERE student_number = 0 && isMentor = 0");
                        foreach ($result as $print) {

                        ?>
                            <tr style="font-size: 20px;">
                                <td><?= $print->user_login ?></td>
                                <td><?= $print->display_name ?></td>
                                <td>
                                    <form action="<?= get_home_url() . '/mentorlijst/'  ?>" method='post'>
                                        <input type="text" style="font-size:16px;" name="MentorNaam" placeholder="Naam Mentor" value="<?= $print->user_login ?>" hidden>
                                        <input type="text" style="font-size:16px;" name="MentorAfkorting" placeholder="Afkorting Mentor" value="<?= $print->display_name ?>" hidden>
                                        <input type="submit" name='add_mentor' value="Voeg Mentor Toe">
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <h3>Docent niet gevonden? Maak hieronder een nieuwe docent aan!
                </h3>
                <table>
                    <thead>
                        <th style="font-size: 20px;">
                            E-mail
                        </th>
                        <th style="font-size: 20px;">
                            Naam en Afkorting
                        </th>
                        <th style="font-size: 20px;">
                            Opties
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <form action="" method="POST">
                                <td>
                                    <input type="text" style="font-size:16px;" name="email" placeholder="E-mail">
                                </td>
                                <td><input type="text" style="font-size:16px;" name="afkorting" placeholder="Afkorting">
                                    <input type="text" style="font-size:16px;" name="naam" placeholder="Naam">
                                </td>
                                <td>
                                    Mentor rol meegeven <input type="checkbox" class="form-check-input" name="mentor" checked><br> <br>
                                    <input type="submit" name="create_mentor" value="Aanmaken">
                                </td>
                            </form>

                        </tr>
                    </tbody>
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
