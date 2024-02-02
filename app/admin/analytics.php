<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php
// Include your database configuration file here
require_once('../core/init.php');

// Check if the "Show Daily" button is clicked
if (isset($_POST['showDaily'])) {
    // Get the current date
    $currentDate = date('Y-m-d');

    // Query to get clients created on the current day with age information
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id WHERE DATE(client.created_at) = '$currentDate'";
} elseif (isset($_POST['showMonthly'])) {
    // Get the selected month and year from the dropdown
    $selectedMonth = $_POST['selectedMonth'];
    $currentYear = date('Y');

    // Query to get clients created in the selected month of the current year with age information
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id WHERE MONTH(client.created_at) = '$selectedMonth' AND YEAR(client.created_at) = '$currentYear'";
} elseif (isset($_POST['showYearly'])) {
    // Get the selected year from the dropdown
    $selectedYear = $_POST['selectedYear'];

    // Query to get clients created in the selected year with age information
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id WHERE YEAR(client.created_at) = '$selectedYear'";
} else {
    // Default query to get all clients with age information (you can modify this based on your requirements)
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id";
}

// Execute the query and fetch the results
$result = mysqli_query($conn, $query);
?>


<div class="container">
        <?php require_once 'includes/sidebar.php' ?>
        <?php require_once 'includes/header.php' ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Main Content -->
        <main>
        
            <h1>Data Analytics</h1>
            <!-- Analyses -->
            <div>
    <!-- Add your dropdown and buttons for filtering here -->
    <form method="post" class="d-flex gap-2">
        <button type="submit" name="showDaily" class="btn btn-primary btn-sm">Show Daily</button>
        
        <!-- Monthly dropdown for monthly filter -->
        <select name="selectedMonth" class="form-select btn btn-primary btn-sm" style="width: 110px;">
            <!-- Generate options for each month -->
            <?php
            for ($month = 1; $month <= 12; $month++) {
                $monthName = date("F", mktime(0, 0, 0, $month, 1));
                echo '<option value="' . $month . '">' . $monthName . '</option>';
            }
            ?>
        </select>

        <button type="submit" name="showMonthly" class="btn btn-primary btn-sm">Show Monthly</button>
        
        <!-- Year dropdown for yearly filter -->
        <select name="selectedYear" class="form-select btn btn-primary btn-sm" style="width: 90px;">
            <!-- Add options dynamically based on your database data -->
            <?php
            // Assuming your 'client' table has a column named 'created_at'
            $yearsQuery = "SELECT DISTINCT YEAR(`created_at`) AS year FROM `client`";
            $yearsResult = mysqli_query($conn, $yearsQuery);
            
            while ($yearRow = mysqli_fetch_assoc($yearsResult)) {
                echo '<option value="' . $yearRow['year'] . '">' . $yearRow['year'] . '</option>';
            }
            ?>
        </select>

        <button type="submit" name="showYearly" class="btn btn-primary btn-sm">Show Yearly</button>

        <!-- Submit Button -->
        
    </form>
            <!-- start of data analysis of age -->
          <?php
                    $query1 = "SELECT age.age_range AS AGE_RANGE, COUNT(client.client_id) AS client_count
                    FROM age
                    INNER JOIN client ON age.age_id = client.age_id
                    GROUP BY age.age_range;
                    ";
                    $result1 = mysqli_query($conn, $query1);

                    foreach($result1 as $data1){
                      $age_range[] = $data1['AGE_RANGE'];
                      $client_count[] = $data1['client_count'];
                   
                    }
                ?>
                <div class="barchart1">
                    <canvas id="myChart1"></canvas>
                </div>

<script>
        // const labels = Utils.months({count: 7});
        const labels = <?php echo json_encode($age_range); ?>;
        const data = {
        labels: labels,
        datasets: [{
            label: 'TOTAL AGE COUNT PER MONTH',
            data: <?php echo json_encode($client_count); ?>,
            backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
            ],
            borderWidth: 2
        }]
        };

        const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        },
        };

        const myChart = new Chart(
            document.getElementById('myChart1'),
            config
        );
    </script>

<!-- end of data analysis of age -->

<!-- start of data analysis of gender -->
<?php
  $query2 = "SELECT all_genders.gender as genders, COALESCE(COUNT(client.gender), 0) AS gender_count
  FROM (
      SELECT 'Male' AS gender
      UNION
      SELECT 'Female'
      UNION
      SELECT 'Other'
  ) AS all_genders
  LEFT JOIN client ON all_genders.gender = client.gender
  GROUP BY all_genders.gender
  ";
  $result2 = mysqli_query($conn, $query2);

  foreach($result2 as $data2){
    $genders[] = $data2['genders'];
    $gender_count[] = $data2['gender_count'];
  }
?>
<div class="barchart1">
  <canvas id="myChart2"></canvas>
</div>

<script>
// const labels = Utils.months({count: 7});
const labels_gender = <?php echo json_encode($genders); ?>;
const data_gender = {
labels: labels_gender,
datasets: [{
label: 'TOTAL GENDER COUNT PER MONTH',
data: <?php echo json_encode($gender_count); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_gender = {
type: 'bar',
data: data_gender,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_gender = new Chart(
document.getElementById('myChart2'),
config_gender
);
</script>

<!-- end of data analysis of gender -->

<!-- start of data analysis of education -->
<?php
  $query3 = "SELECT all_education.education as educations, COALESCE(COUNT(client.education), 0) AS education_count
  FROM (
      SELECT 'Elementary Graduate' AS education
      UNION
      SELECT 'HighSchool Level'
      UNION
      SELECT 'HighSchool Graduate'
      UNION
      SELECT 'College Level'
      UNION
      SELECT 'College Graduate'
      UNION
      SELECT 'Master''s Degree' -- Corrected single quote usage
      UNION
      SELECT 'Doctorate Degree'
      UNION
      SELECT 'Vocational'
  ) AS all_education
  LEFT JOIN client ON all_education.education = client.education
  GROUP BY all_education.education;
  
  ";
  $result3 = mysqli_query($conn, $query3);

  foreach($result3 as $data3){
    $education[] = $data3['educations'];
    $education_count[] = $data3['education_count'];
  }
?>
<div class="barchart1">
  <canvas id="myChart3"></canvas>
</div>

<script>
// const labels = Utils.months({count: 7});
const labels_education = <?php echo json_encode($education); ?>;
const data_education = {
labels: labels_education,
datasets: [{
label: 'TOTAL EDUCATION COUNT PER MONTH',
data: <?php echo json_encode($education_count); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_education = {
type: 'bar',
data: data_education,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_education = new Chart(
document.getElementById('myChart3'),
config_education
);
</script>

<!-- end of data analysis of education -->



<!-- start of data analysis of occupation -->
<?php
  $query4 = "SELECT all_occupation.occupation as occupations, COALESCE(COUNT(client.occupation), 0) AS occupation_count
  FROM (
      SELECT 'Student' AS occupation
      UNION
      SELECT 'Unemployed'
      UNION
      SELECT 'Employed'
      UNION
      SELECT 'Retired'
  ) AS all_occupation
  LEFT JOIN client ON all_occupation.occupation = client.occupation
  GROUP BY all_occupation.occupation;
  ";
  $result4 = mysqli_query($conn, $query4);

  foreach($result4 as $data4){
    $occupations[] = $data4['occupations'];
    $occupation_count[] = $data4['occupation_count'];
  }
?>
<div class="barchart1">
  <canvas id="myChart4"></canvas>
</div>

<script>
const labels_occupations = <?php echo json_encode($occupations); ?>;
const data_occupations = {
labels: labels_occupations,
datasets: [{
label: 'TOTAL OCCUPATION COUNT PER MONTH',
data: <?php echo json_encode($occupation_count); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_occupations = {
type: 'bar',
data: data_occupations,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_occupations = new Chart(
document.getElementById('myChart4'),
config_occupations
);
</script>

<!-- end of data analysis of education -->



<!-- start of data analysis of services -->
<?php
  $query5 = "SELECT service, COUNT(service) AS count_service FROM queue_details GROUP BY service;
  ";
  $result5 = mysqli_query($conn, $query5);

  foreach($result5 as $data5){
    $service[] = $data5['service'];
    $count_service[] = $data5['count_service'];
  }
?>
<div class="barchart1">
  <canvas id="myChart5"></canvas>
</div>

<script>
const labels_service = <?php echo json_encode($service); ?>;
const data_service = {
labels: labels_service,
datasets: [{
label: 'TOTAL SERVICE COUNT PER MONTH',
data: <?php echo json_encode($count_service); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_service = {
type: 'bar',
data: data_service,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_service = new Chart(
document.getElementById('myChart5'),
config_service
);
</script>

<!-- end of data analysis of services -->


<!-- start of data analysis of q1 -->
<?php
$query6 = "SELECT
    emoji.value,
    (SELECT questions.english_question
        FROM questions
        WHERE questions.question_id = 1
        ORDER BY RAND()
        LIMIT 1
    ) AS english_question,
    COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
    emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 1
GROUP BY
    emoji.emoji_id, emoji.value, emoji.image_path;
";

$result6 = mysqli_query($conn, $query6);

foreach ($result6 as $data6) {
    $q1_label = $data6['english_question'];
    $value[] = $data6['value'];
    $count_feedback[] = $data6['count_feedback'];
}
?>

<div class="barchart1">
  <canvas id="myChart6"></canvas>
</div>

<script>
const labels_feedback = <?php echo json_encode($value); ?>;
const data_feedback = {
labels: labels_feedback,
datasets: [{
label: '<?php echo json_encode($q1_label); ?>',
data: <?php echo json_encode($count_feedback); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback = {
type: 'bar',
data: data_feedback,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback = new Chart(
document.getElementById('myChart6'),
config_feedback
);
</script>

<!-- end of data analysis of q1 -->


<!-- start of data analysis of q2 -->
<?php
  $query7 = "SELECT
  emoji.value,
  (SELECT questions.english_question
      FROM questions
      WHERE questions.question_id = 2
      ORDER BY RAND()
      LIMIT 1
  ) AS english_question,
  COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
  emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 2
GROUP BY
  emoji.emoji_id, emoji.value, emoji.image_path;
  ";
  $result7 = mysqli_query($conn, $query7);

  foreach($result7 as $data7){
    $q2_label = $data7['english_question'];
    $value1[] = $data7['value'];
    $count_feedback1[] = $data7['count_feedback'];
  }
?>
<div class="barchart1">
  <canvas id="myChart7"></canvas>
</div>

<script>
const labels_feedback2 = <?php echo json_encode($value1); ?>;
const data_feedback2 = {
labels: labels_feedback2,
datasets: [{
label: '<?php echo json_encode($q2_label); ?>',
data: <?php echo json_encode($count_feedback1); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback2 = {
type: 'bar',
data: data_feedback2,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback2 = new Chart(
document.getElementById('myChart7'),
config_feedback2
);
</script>

<!-- end of data analysis of q2 -->


<!-- start of data analysis of q3 -->
<?php
  $query8 = "SELECT
  emoji.value,
  (SELECT questions.english_question
      FROM questions
      WHERE questions.question_id = 3
      ORDER BY RAND()
      LIMIT 1
  ) AS english_question,
  COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
  emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 3
GROUP BY
  emoji.emoji_id, emoji.value, emoji.image_path;
  ";
  $result8 = mysqli_query($conn, $query8);

  foreach($result8 as $data8){
    $q3_label = $data8['english_question'];
    $value2[] = $data8['value'];
    $count_feedback2[] = $data8['count_feedback'];
  }
?>
<div class="barchart1">
  <canvas id="myChart8"></canvas>
</div>

<script>
const labels_feedback3 = <?php echo json_encode($value2); ?>;
const data_feedback3 = {
labels: labels_feedback3,
datasets: [{
label: '<?php echo json_encode($q3_label); ?>',
data: <?php echo json_encode($count_feedback2); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback3 = {
type: 'bar',
data: data_feedback3,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback3 = new Chart(
document.getElementById('myChart8'),
config_feedback3
);
</script>

<!-- end of data analysis of q3 -->


<!-- start of data analysis of q4 -->
<?php
  $query9 = "SELECT
  emoji.value,
  (SELECT questions.english_question
      FROM questions
      WHERE questions.question_id = 4
      ORDER BY RAND()
      LIMIT 1
  ) AS english_question,
  COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
  emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 4
GROUP BY
  emoji.emoji_id, emoji.value, emoji.image_path;
  ";
  $result9 = mysqli_query($conn, $query9);

  foreach($result9 as $data9){
    $q4_label = $data9['english_question'];
    $value3[] = $data9['value'];
    $count_feedback3[] = $data9['count_feedback'];
  }
?>
<div class="barchart1">
  <canvas id="myChart9"></canvas>
</div>

<script>
const labels_feedback4 = <?php echo json_encode($value3); ?>;
const data_feedback4 = {
labels: labels_feedback4,
datasets: [{
label: '<?php echo json_encode($q4_label); ?>',
data: <?php echo json_encode($count_feedback3); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback4 = {
type: 'bar',
data: data_feedback4,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback4 = new Chart(
document.getElementById('myChart9'),
config_feedback4
);
</script>

<!-- end of data analysis of q4 -->

<!-- start of data analysis of q5 -->
<?php
  $query10 = "SELECT
  emoji.value,
  (SELECT questions.english_question
      FROM questions
      WHERE questions.question_id = 5
      ORDER BY RAND()
      LIMIT 1
  ) AS english_question,
  COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
  emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 5
GROUP BY
  emoji.emoji_id, emoji.value, emoji.image_path;
  ";
  $result10 = mysqli_query($conn, $query10);

  foreach($result10 as $data10){
    $q5_label = $data10['english_question'];
    $value4[] = $data10['value'];
    $count_feedback4[] = $data10['count_feedback'];
  }
?>
<div class="barchart1">
  <canvas id="myChart10"></canvas>
</div>

<script>
const labels_feedback5 = <?php echo json_encode($value4); ?>;
const data_feedback5 = {
labels: labels_feedback5,
datasets: [{
label: '<?php echo json_encode($q5_label); ?>',
data: <?php echo json_encode($count_feedback4); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback5 = {
type: 'bar',
data: data_feedback5,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback5 = new Chart(
document.getElementById('myChart10'),
config_feedback5
);
</script>

<!-- end of data analysis of q5 -->


<!-- start of data analysis of q6 -->
<?php
  $query11 = "SELECT
  emoji.value,
  (SELECT questions.english_question
      FROM questions
      WHERE questions.question_id = 6
      ORDER BY RAND()
      LIMIT 1
  ) AS english_question,
  COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
  emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 6
GROUP BY
  emoji.emoji_id, emoji.value, emoji.image_path;
  ";
  $result11 = mysqli_query($conn, $query11);

  foreach($result11 as $data11){
    $q6_label = $data11['english_question'];
    $value5[] = $data11['value'];
    $count_feedback5[] = $data11['count_feedback'];
  }
?>
<div class="barchart1">
  <canvas id="myChart11"></canvas>
</div>

<script>
const labels_feedback6 = <?php echo json_encode($value5); ?>;
const data_feedback6 = {
labels: labels_feedback6,
datasets: [{
label: '<?php echo json_encode($q6_label); ?>',
data: <?php echo json_encode($count_feedback5); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback6 = {
type: 'bar',
data: data_feedback6,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback6 = new Chart(
document.getElementById('myChart11'),
config_feedback6
);
</script>

<!-- end of data analysis of q6 -->

<!-- start of data analysis of q7 -->
<?php
  $query12 = "SELECT
  emoji.value,
  (SELECT questions.english_question
      FROM questions
      WHERE questions.question_id = 7
      ORDER BY RAND()
      LIMIT 1
  ) AS english_question,
  COALESCE(COUNT(feedback.feedback_id), 0) AS count_feedback
FROM
  emoji
LEFT JOIN feedback ON emoji.emoji_id = feedback.emoji_id AND feedback.question_id = 7
GROUP BY
  emoji.emoji_id, emoji.value, emoji.image_path;
  ";
  $result12= mysqli_query($conn, $query12);

  foreach($result12 as $data12){
    $q7_label = $data12['english_question'];
    $value6[] = $data12['value'];
    $count_feedback6[] = $data12['count_feedback'];
  }
?>
<div class="barchart1">
  <canvas id="myChart12"></canvas>
</div>

<script>
const labels_feedback7 = <?php echo json_encode($value6); ?>;
const data_feedback7 = {
labels: labels_feedback7,
datasets: [{
label: '<?php echo json_encode($q7_label); ?>',
data: <?php echo json_encode($count_feedback6); ?>,
backgroundColor: [
'rgba(255, 99, 132, 0.7)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 205, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(201, 203, 207, 0.2)'
],
borderColor: [
'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'
],
borderWidth: 2
}]
};

const config_feedback7 = {
type: 'bar',
data: data_feedback7,
options: {
scales: {
y: {
beginAtZero: true
}
}
},
};

const myChart_feedback7 = new Chart(
document.getElementById('myChart12'),
config_feedback7
);
</script>

<!-- end of data analysis of q7 -->

        </main>
        <!-- End of Main Content -->

         <!-- Right Section -->
         <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Admin</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="./assets/images/profile-1.jpg">
                    </div>
                </div>

            </div>
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="./assets/images/qcpl.logo.png">
                    <h2>EngageMate</h2>
                    <p>Web-based KIOSK</p>
                </div>
            </div>
<!-- 
            <div class="reminders">
                <div class="header">
                    <h2>Recommendations</h2>
                    <span class="material-icons-sharp">
                        info
                    </span>
                </div>

                <div class="notification">
                    <div class="content">
                        <div class="info">
                            <h3>
                              <h3>Rating: Very bad!&#x1F627;
                                <br>
                                <br>

                            We appreciate your feedback, User B, and we're sorry to hear about your experience with the smartphone.
                               Your satisfaction is our priority. To address your concerns, we recommend checking out our customer support 
                               for assistance with any troubleshooting or to explore alternative smartphones with improved battery life and
                                faster performance. Your input is valuable, and we'll use it to enhance our product recommendations and 
                                better meet your expectations in the future. If you have any specific preferences or requirements,
                               please let us know so we can tailor our recommendations more accurately.</h3>
                           
                        </div>
                        
                    </div>
                    
                </div> -->

                <!-- predict possible client -->
                <!-- <h4>Predict Possible Client a year!</h4>
<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<script>
var xValues = [];
var yValues = [];
generateData("Math.sin(x)", 0, 10, 0.5);

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      pointRadius: 2,
      borderColor: "rgba(0,0,255,0.5)",
      data: yValues
    }]
  },    
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "y = sin(x)",
      fontSize: 16
    }
  }
});
function generateData(value, i1, i2, step = 1) {
  for (let x = i1; x <= i2; x += step) {
    yValues.push(eval(value));
    xValues.push(x);
  }
}
</script>

            </div> -->

        </div>


    </div>
    
    
    <?php
        require_once 'includes/scripts.php';
    ?>
</body>
</html>
