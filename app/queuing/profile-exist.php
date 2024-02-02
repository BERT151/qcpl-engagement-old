<?php 
    require_once("includes/queue-header.php");

    if(isset($_SESSION['user_id'])){
        $firstname_error = '';
        $surname_error = '';

        $firstname_success = '';
        $surname_success = '';

        $firstname_value = '';
        $surname_value = '';

        if(isset($_POST['submit'])){
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
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

            function surnameInvalid($surname) {
                $surname_length = strlen($surname);
        
                if((!preg_match("/^[a-zA-Z ,.'-]+$/i", $surname)) || ($surname_length < 2)) {
                    $result = true;
                } else {
                    $result = false;
                }
                return $result;
            }

            function nameExists($conn, $firstname, $surname) {
                $sql = "SELECT * FROM client WHERE f_name = ? && l_name = ?;";
                $stmt = mysqli_stmt_init($conn);
        
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: profile-exist?error");
                    die();
                }
        
                mysqli_stmt_bind_param($stmt, "ss", $firstname, $surname);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                if($row = mysqli_fetch_assoc($resultData)) {
                    return $row;
                } else {
                    $result = false;
                    return $result;
                }
        
                mysqli_stmt_close($stmt);
            }
            if(nameExists($conn, $firstname, $surname) !== false) {
                $email_error = ' *Email is already taken.';
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
 
            $random = random_int(100000, 999999);
            if($age_value == 5){
                $queue_no = 'P' . $random;
            }else{
                $queue_no = 'N' . $random;
            }
        }
    }
?>
<body>
    <section>
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
                <form action="" method="post">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../../public/portal.php">Portal</a></li>
                    <li class="breadcrumb-item"><a href="queue.php">Demographic Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Existing User</li>
                </ol>
                </nav>
                    <div class="form-group">
                        <input type="text" name="firstname" id="" placeholder="Firstname" class="form-control">
                        <input type="text" name="surname" id="" placeholder="Surname" class="form-control">
                    </div>
                    <br>
                    <div class="form-wrapper">
                        <h1>Please Select Services</h1>
                        <input type="checkbox" id="nbi" name="nbi" value="nbi">
                        <label for="nbi"> NBI</label><br>
                        <input type="checkbox" id="policeclearance" name="policeclearance" value="nbi">
                        <label for="policeclearance"> POLICE CLEARANCE</label><br>
                        <input type="text" class="others[]" name="others[]" id="new_1">
                        <button onclick="add()" type="button" class="btn btn-info">Add</button>
                        <button onclick="remove()" type="button" class="btn btn-danger">remove</button>
                        <div id="new_chq"></div>
                        <input type="hidden" value="1" id="total_chq" name="total_input">
                    </div>
                    <button class="existBtn" onclick="window.location.href='queue.php';">
                    <a href="queue.php" class="existBtn">Don't have an Account?</a></button>
                    <button class="profileBtn" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
        
    </section>


      <script>
            // function For adding new input field
            function add(){
                var new_chq_no = parseInt($('#total_chq').val())+1;
                var new_input="<input type='text' id='new_"+new_chq_no+"' name='others[]' class='others"+new_chq_no+"'>";
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


      </script>
   </head>


</body>
</html>
