<?php 
    require_once("includes/queue-header.php");

    if(isset($_SESSION['user_id'])){
        $firstname_error = '';
        $middlename_error = '';
        $surname_error = '';
        $suffix_error = '';

        $firstname_success = '';
        $middlename_success = '';
        $surname_success = '';
        $suffix_success = '';

        $firstname_value = '';
        $middlename_value = '';
        $surname_value = '';
        $suffix_value = '';
        $age_value = '';

        if(isset($_POST['submit'])){
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
            $suffix = mysqli_real_escape_string($conn, $_POST['suffix']);
            $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
            $education = mysqli_real_escape_string($conn, $_POST['education']);
            $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);
            $nbi = isset($_POST['nbi']) ? mysqli_real_escape_string($conn, $_POST['nbi']) : "";
            $police = isset($_POST['police']) ? mysqli_real_escape_string($conn, $_POST['police']) : "";
            $total_input = mysqli_real_escape_string($conn, $_POST['total_input']);

            // Initialize an empty array
            $others = array();

            // Functions for validating name
            function firstnameInvalid($firstname) {
                $firstname_length = strlen($firstname);
        
                if((!preg_match("/^[a-zA-Z ,.'-]+$/i", $firstname)) || ($firstname_length < 2)) {
                    $result = true;  
                } else {
                    $result = false;
                }
                return $result;
            }

            function middlenameInvalid($middlename) {
                if(!preg_match("/^[a-zA-Z ,.'-]+$/i", $middlename)) {
                    $result = true;
                } else {
                    $result = false;
                }
                return $result;
            }

            function surnameInvalid($surname) {
                $surname_length = strlen($surname);
        
                if((!preg_match("/^[a-zA-Z ,.'-]+$/i", $surname)) || ($surname_length < 2)) {
                    $result = true;
                } else {
                    $result = false;
                }
                return $result;
            }

            function suffixInvalid($suffix) {
                if(!preg_match("/^[a-zA-Z ,.'-]+$/i", $suffix)) {
                    $result = true;
                } else {
                    $result = false;
                }
                return $result;
            }

            if(firstnameInvalid($firstname) !== false) {
                $firstname_error = ' *Invalid first name.';
            } else {
                $firstname_error = '';
                $firstname_success = ' <i class="fa-sharp fa-solid fa-circle-check"></i>';
                $firstname_value = $firstname;
            }

            if(surnameInvalid($surname) !== false) {
                $surname_error = ' *Invalid surname.';
            } else {
                $surname_error = '';
                $surname_success = ' <i class="fa-sharp fa-solid fa-circle-check"></i>';
                $surname_value = $surname;
            }

            if(middlenameInvalid($middlename) !== false) {
                $middlename_error = ' *Invalid middle name.';
            } else {
                $middlename_error = '';
                $middlename_success = ' <i class="fa-sharp fa-solid fa-circle-check"></i>';
                $middlename_value = $middlename;
            }

            if(suffixInvalid($suffix) !== false) {
                $suffix_error = ' *Invalid suffix.';
            } else {
                $suffix_error = '';
                $suffix_success = ' <i class="fa-sharp fa-solid fa-circle-check"></i>';
                $suffix_value = $suffix;
            }

            if(empty($middlename)){
                $middlename_value = '';
                $middlename_error = '';
            }elseif(!empty($middlename )){
                $middlename_value = $middlename;
            }

            if(empty($suffix)){
                $suffix_value = '';
                $suffix_error = '';
            }elseif(!empty($suffix )){
                $suffix_value = $suffix;
            }

            //date in mm/dd/yyyy format; or it can be in other formats as well
            // $birthDate = "12/17/1983";
            //explode the date to get month, day and year
            $new_birthdate = date("m-d-Y", strtotime($birthdate));

            $new_birthdate = explode("-", $new_birthdate);
            //get age from date or birthdate
            $age = (date("md", date("U", mktime(0, 0, 0, $new_birthdate[0], $new_birthdate[1], $new_birthdate[2]))) > date("md")
                ? ((date("Y") - $new_birthdate[2]) - 1)
                : (date("Y") - $new_birthdate[2]));

            if(($age >= 0) && ($age <= 12)){
                $age_value = 1;
            }elseif(($age >= 13) && ($age <= 21)){
                $age_value = 2;
            }elseif(($age >= 22) && ($age <= 35)){
                $age_value = 3;
            }elseif(($age >= 36) && ($age <= 59)){
                $age_value = 4;
            }elseif($age >= 60){
                $age_value = 5;
            }

            if($age_value == 5 || $status == 1){
                $prefix = 'P-';
                $new_status = 1;
            }else{
                $prefix = 'N-';
                $new_status = 0;
            }

            $sql_queue = "SELECT * FROM queue_details ORDER BY qd_id DESC LIMIT 1;";
            $result_queue = mysqli_query($conn, $sql_queue);
            if(mysqli_num_rows($result_queue) > 0){
                $row = mysqli_fetch_assoc($result_queue);
        
                $queue_number = $row['queue_number'];
                list($new_prefix, $string_number) = explode('-', $queue_number);
                
                $int_number = intval($string_number);
                $int_number++;
                $new_int_number = sprintf('%05d', $int_number);
                $new_string_number = strval($new_int_number);
                $new_queue_number = $prefix . $new_string_number;
            }else{
                $string_number = 00000;
                $int_number = intval($string_number);
                $int_number++;
                $new_int_number = sprintf('%05d', $int_number);
                $new_string_number = strval($new_int_number);
                $new_queue_number = $prefix . $new_string_number;
            }
            
            if (!firstnameInvalid($firstname) && !surnameInvalid($surname) && (!middlenameInvalid($middlename) || !suffixInvalid($suffix)) || (middlenameInvalid($middlename) || suffixInvalid($suffix)) && 
                !empty($birthdate) &&
                $gender !== '' &&
                $education !== '' &&
                $occupation !== ''
            ) {
                $sql = "INSERT INTO client (f_name, m_name, l_name, suffix, age_id, gender, education, occupation, status) VALUES ('$firstname', '$middlename_value', '$surname', '$suffix_value', $age_value, '$gender', '$education', '$occupation', $new_status);";
    
                if(mysqli_query($conn, $sql)){
                    $client_id = mysqli_insert_id($conn);
                    if($nbi !== ''){
                        $sql_nbi = "INSERT INTO queue_details (client_id, queue_number, service) VALUES ($client_id, '$new_queue_number', '$nbi');";
                        if(mysqli_query($conn, $sql_nbi)){
                            header("location: queue-number.php?queue_no=" .$new_queue_number. "&totalinput=" .$total_input);
                        }
                        
                    }
                    if($police !== ''){
                        $sql_police = "INSERT INTO queue_details (client_id, queue_number, service) VALUES ($client_id, '$new_queue_number', '$police');";
                        if(mysqli_query($conn, $sql_police)){
                            header("location: queue-number.php?queue_no=" .$new_queue_number. "&totalinput=" .$total_input);
                        }
                    }

                    // Use a loop to create $_POST['others'][] based on $total_input
                    for ($i = 0; $i < $total_input; $i++) {
                        // Use mysqli_real_escape_string or any other necessary validation/sanitization
                        $others[$i] = mysqli_real_escape_string($conn, $_POST['others'][$i]);
                    }
                    // Iterate through $others and echo the values
                    foreach ($others as $key => $value) {
                        if(!empty($value) || $value !== ''){
                            $sql_others = "INSERT INTO queue_details (client_id, queue_number, service) VALUES ($client_id, '$new_queue_number', '$value');";
                            if(mysqli_query($conn, $sql_others)){
                                header("location: queue-number.php?queue_no=" .$new_queue_number. "&totalinput=" .$total_input);
                                // date_default_timezone_get();
                            }
                        }
                    }

                    date_default_timezone_set('Asia/Manila');
                    $date_today = date('Y-m-d');
                    $timestamp_today = date('Y-m-d h:i:s');

                    $sql_date = "SELECT * FROM queue WHERE queue_date = '$date_today';";
                    $result_date = mysqli_query($conn, $sql_date);
                    if(mysqli_num_rows($result_date) > 0){
                        while($row_date = mysqli_fetch_assoc($result_date)){
                            $sql_update = "UPDATE queue SET total_queue = total_queue + 1 WHERE queue_date = '$date_today';";
                            if(mysqli_query($conn, $sql_update)){
                                header("location: queue-number.php?queue_no=" .$new_queue_number);
                            }
                        }
                    }else{
                        $sql_date_insert = "INSERT INTO queue (total_queue, queue_date) VALUES (1, '$date_today');";
                        if(mysqli_query($conn, $sql_date_insert)){
                            header("location: queue-number.php?queue_no=" .$new_queue_number);
                        }
                    }
                }else{
                    echo 'Error: ' . mysqli_error($conn);
                }
            }

            // var_dump($firstname, $middlename, $surname, $suffix, $birthdate, $gender, $education, $occupation);
        }
    }else{
        header('location: ../../public/index.php');
        die();
    }
?>
<body onload="hidefield()">
<style>
    ion-icon{
        color: #ffffff;
        padding: 6px;
        background-color: #13a561;
        width: 30px;
        height: 30px;
        border-radius:50%;
        cursor: pointer;
        transition: 0.2s ease-in-out;
        border: 1px solid #13a561;
    }
    ion-icon:hover{
        color: #13a561;
        background-color: #ffffff;
        border: 1px solid #13a561;
    }
    .container-btn{
        position: relative;
        display: flex;
        box-shadow: 0 1px 2px rgba(0,0,0,0.15);
    }
    .logout-btn{
        position: relative;
        top:12em;
        left: 76em;
        position:fixed;
    }
</style>
    <section id="swup" class="transtion-fade">

    <div class="logo">
            <img src="../../public/assets/images/qclogo.jpg" alt="">
            <div class="title">
            <p>Quezon City Public Library</p>
            <p>Quezon City Government</p>
            </div>
            <img src="../../public/assets/images/qcplLogo.png" alt="">
        </div>

        <!-- start of demographic form -->
        <div class="wrapper">
            <div class="inner">
                <div class="image-holder">
                    <img src="../../public/assets/images/demographic-img.png" alt="">
                </div>
                <?php  
        if(isset($_SESSION['user_id'])){
            $sql = "SELECT * FROM users WHERE user_id = $user_id_session";
            $res = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($res)){
                echo '<div class="container-btn">';
                echo '<div class="logout-btn">';
                    echo '<a href="../includes/logout.php">Logout</a>';
                echo '</div>';
            echo '</div>';
            }
        }else
        echo '<a href="../includes/logout.php">Logout</a>';
    ?>

                <form action="" method="post" id="myForm">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../../public/portal.php">Portal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Demographic Profile</li>
                </ol>
                </nav>
                                    
                    <div class="form-group">
                        <span class="text-danger"><?= $firstname_error ?></span><span class="text-success"><?= $firstname_success ?></span>
                        <input type="text" name="firstname" id="" placeholder="First Name" class="form-control" value="<?= $firstname_value ?>" required>

                        <span class="text-danger"><?= $middlename_error ?></span><span class="text-success"><?= $middlename_success ?></span>
                        <input type="text" name="middlename" id="" placeholder="Middle Name" class="form-control" value="<?= $middlename_value ?>" >

                        <span class="text-danger"><?= $surname_error ?></span><span class="text-success"><?= $surname_success ?></span>
                        <input type="text" name="surname" id="" placeholder="Surname" class="form-control" value="<?= $surname_value ?>" required>

                        <span class="text-danger"><?= $suffix_error ?></span><span class="text-success"><?= $suffix_success ?></span>
                        <input type="text" name="suffix" id="" placeholder="Suffix" class="form-control" value="<?= $suffix_value ?>" >
                    </div>
                    <div class="form-group">
                        <input type="date" name="birthdate" id="birthdate" max="2000-13-13">
                    </div>
                    <div class="form-wrapper">
                        <select name="gender" id="" class="form-control">
                            <option value="" disabled selected>-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-wrapper">
                        <select name="education" id="" class="form-control">
                            <option value="" disabled selected>-- Select Educational Attainment --</option>
                            <option value="Elementary Graduate">Elementary Graduate</option>
                            <option value="HighSchool Level">High School Level</option>
                            <option value="HighSchool Graduate">High School Graduate</option>
                            <option value="College Level">College Level</option>
                            <option value="College Graduate">College Graduate</option>
                            <option value="Masters Degree">Master’s Degree</option>
                            <option value="Doctorate Degree">Doctorate Degree</option>
                            <option value="Vocational">Vocational</option>
                        </select>
                    </div>
                    <div class="form-wrapper">
                        <select name="occupation" id="" class="form-control">
                            <option value="" disabled selected>-- Select Occupation --</option>
                            <option value="Student">Student</option>
                            <option value="Unemployed">Unemployed</option>
                            <option value="Employed">Employed</option>
                            <option value="Retired">Retired</option>
                        </select>
                    </div>

                    <div class="form-wrapper">
                    <select name="travel_arriveVia" id="travel_arriveVia" onchange="showfield(this.options[this.selectedIndex].value)" class="form-control">
                        <option selected="selected">-- Select Status --</option>
                        <option value="Plane">PWD</option>
                        <option value="Train">PREGNANT</option>
                        <option value="Own Vehicle">PERSON W/DISABILITIES</option>
                        <option value="Other">Other</option>
                    </select>
                        <div id="div1">If Other, Please Specify :<input type="text" name="whatever" class="form-control"/></div>
                    </div>
                    <div class="form-wrapper">
                        <h1>Please Select Services</h1>
                        
                        <input type="checkbox" id="nbi" name="nbi" value="NBI">
                        <label for="nbi"> NBI</label><br>
                        <input type="checkbox" id="policeclearance" name="police" value="Police">
                        <label for="policeclearance"> POLICE CLEARANCE</label><br>

                        <p>Please Specify:</p>
                        <input type="text" class="others[]" name="others[]" id="new_1">
                        <button onclick="add()" type="button" class="btn btn-primary">Add</button>
                        <button onclick="remove()" type="button" class="btn btn-danger">remove</button>
                        <div id="new_chq"></div>
                        <input type="hidden" value="1" id="total_chq" name="total_input" >
                        
                    </div>
                    <button class="existBtn" onclick="window.location.href='profile-exist.php';">Already have an account?</button>
                    <!-- <a href="existProfile.php" class="existBtn">Already have Account?</a> -->
                    <button type="submit" name="submit" class="profileBtn">Submit</button>
                </form>
            </div>
        </div>
        
    </section>
<style>
    #others{
    border: 10px solid black;
    padding: 90px;
    }
</style>
      <script>
            $(function() {

                var dialog1 = $("#dialog1");
                var checkbox1 = $("#checkbox1");

                dialog1.dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Save: function() {$(this).dialog("close");}
                },
                title: "Type below...",
                close : function() {checkbox1.prop('checked', false);}

                });

                checkbox1.click(function() {
                if (checkbox1.prop("checked")) {
                    dialog1.dialog("open");
                }
                });

            });

            // allows datepicker to disable date after today
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            } 
                
            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("birthdate").setAttribute("max", today);

            // function For adding new input field
            function add(){
                var new_chq_no = parseInt($('#total_chq').val())+1;
                var new_input="<input type='text' id='new_"+new_chq_no+"' name='others[]' class='others"+new_chq_no+"' id='others'>";
                $('#new_chq').append(new_input);
                $('#total_chq').val(new_chq_no)
            }

            function remove(){
                var last_chq_no = $('#total_chq').val();
                if(last_chq_no>1){
                    $('#new_'+last_chq_no).remove();
                    $('#total_chq').val(last_chq_no-1);
                }
            }

            document.getElementById('myForm').addEventListener('submit', function(event) {
                var nbiChecked = document.getElementById('nbi').checked;
                var policeChecked = document.getElementById('policeclearance').checked;
                var otherInputs = document.querySelectorAll('[class^="others"]');
                var isValid = false;

                for (var i = 0; i < otherInputs.length; i++) {
                    var inputValue = otherInputs[i].value.trim();
                    if (inputValue !== '') {
                        isValid = true;
                        break;
                    }
                }
                // Example validation
                if (!nbiChecked && !policeChecked && !isValid) {
                    alert('Please either check the checkbox or provide additional text input.');
                    event.preventDefault(); // Prevent form submission
                }
            });

            //for adding textbox for others in status
            function showfield(name){
                if(name=='Other')document.getElementById('div1').style.display="block";
                else document.getElementById('div1').style.display="none";
            }
            
            function hidefield() {
            document.getElementById('div1').style.display='none';
            }
      </script>
   </head>
    <script src="https://unpkg.com/swup@4"></script>
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
