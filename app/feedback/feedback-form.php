<?php
    require_once 'includes/feedback-header.php';
?>
<body>
    <form id="regForm" method="post" action="">
        <!-- One "tab" for each step in the form: -->
        <?php
        // get the total rows of question table
        $sql_row = "SELECT COUNT(question_id) AS total_rows FROM questions;";
        $result_row = mysqli_query($conn, $sql_row);
        if (mysqli_num_rows($result_row) > 0) {
            while ($row_row = mysqli_fetch_assoc($result_row)) {
                $total_rows = $row_row['total_rows'];
            }
        }
        if (isset($_POST['submit'])) {
            // $username = mysqli_real_escape_string($conn, $_POST['username']);
            // $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Iterate through $others and echo the values
            for ($i = 1; $i <= $total_rows; $i++) {
                if (isset($_POST["question{$i}"])) {
                    $question_value = mysqli_real_escape_string($conn, $_POST["question{$i}"]);

                    $sql_qt = "SELECT qt_id FROM questions WHERE question_id = $question_value;";
                    $result_qt = mysqli_query($conn, $sql_qt);
                    if (mysqli_num_rows($result_qt) > 0) {
                        $row_qt = mysqli_fetch_assoc($result_qt);
                        $question_type = $row_qt['qt_id'];
                    }

                    if ($question_type == 2) {
                        $emoji_value = 6;
                    }

                    if (isset($_POST["text{$i}"])) {
                        // Get the value of the emoji radio button for the current question
                        $text_value = mysqli_real_escape_string($conn, $_POST["text{$i}"]);
                        echo $text_value;
                    }

                    if (isset($_POST["emoji{$i}"])) {
                        // Get the value of the emoji radio button for the current question
                        $emoji_value = mysqli_real_escape_string($conn, $_POST["emoji{$i}"]);
                        echo $emoji_value;
                    }

                    $sql = "INSERT INTO feedback (client_id, question_id, emoji_id, text_feedback) VALUES ($client_id, $question_value, $emoji_value, '$text_value');";
                    mysqli_query($conn, $sql);
                }
            }
        }
        $sql = "SELECT * FROM questions WHERE is_deleted != 1;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $question_id = $row['question_id'];
                $qt_id = $row['qt_id'];
                $english_question = $row['english_question'];
                $tagalog_question = $row['tagalog_question'];
        ?>
                <!-- emoji based answer starts here -->
                <div class="tab">
                    <div id="question-container">
                        <p id="english<?= $question_id ?>" class="fs-4"><?= $english_question; ?></p>
                        <p id="tagalog<?= $question_id ?>" class="fs-6 fst-italic"><?= $tagalog_question; ?></p>
                        <input type="hidden" value="<?= $question_id ?>" name="question<?= $question_id ?>" id="answer<?= $question_id ?>">
                        <div class="reaction-container">
                            <?php
                            if ($qt_id == 1) {
                                $sql_emoji = "SELECT * FROM emoji WHERE UNICODE != '0' ORDER BY emoji_id DESC LIMIT 5;";
                                $result_emoji = mysqli_query($conn, $sql_emoji);
                                if (mysqli_num_rows($result_emoji) > 0) {
                                    while ($row_emoji = mysqli_fetch_assoc($result_emoji)) {
                                        $emoji_id = $row_emoji['emoji_id'];
                                        $image_path = $row_emoji['image_path'];
                                        $value = $row_emoji['value'];
                            ?>
                                        <div class="reaction">
                                            <label>
                                                <input type="radio" id="emoji<?= $question_id . $emoji_id ?>" name="emoji<?= $question_id ?>" value="<?= $emoji_id ?>" required>
                                                <img src="../../<?= $image_path ?>" alt="Option 1">
                                            </label>
                                        </div>
                                <?php
                                    }
                                }
                            } else {
                                ?>
                                <input class="form-control form-control-lg" type="text" placeholder="" name="text<?= $question_id ?>" aria-label=".form-control-lg example" value="">
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        <!-- emoji based answer ends here -->
        <div style="overflow:auto;">

            <div style="float:right; margin-top:12px;">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)" class="">Next</button>
                <button type="submit" class="d-none" id="submit" name="submit">Submit</button>
            </div>
        </div>
        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
            <?php
            for ($i = 0; $i < $total_rows; $i++) {
                echo '<span class="step"></span>';
            }
            ?>
        </div>
    </form>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            console.log("Showing tab " + n);
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("submit").className = 'btn btn-lg';
                document.getElementById("nextBtn").className = "d-none";
            } else {
                document.getElementById("submit").className = 'd-none';
                document.getElementById("nextBtn").className = "";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            console.log("Current tab: " + currentTab);
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                // document.getElementById("regForm").submit();
                // return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            // for (i = 0; i < y.length; i++) {
            //     // If a field is empty...
            //     if (y[i].value == "") {
            //         // add an "invalid" class to the field:
            //         y[i].className += " invalid";
            //         // and set the current valid status to false
            //         valid = false;
            //     }
            // }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
    <!-- latest bootstrap js popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>

    <!-- latest bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>
</html>