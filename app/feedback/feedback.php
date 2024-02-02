<?php
    require_once('../core/init.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quezon City Public Library</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="shortcut icon" href="../../public/assets/images/qcplLogo.png" type="image/x-icon">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<section id="swup" class="transtion-fade">
    <div class="logo">
        <img src="./images/qclogo.jpg" alt="">
        <div class="title">
            <p>Quezon City Public Library</p>
            <p>Quezon City Government</p>
        </div>
        <img src="./images/qcplLogo.png" alt="">
    </div>

    <!-- Start of feedback form -->
    <form action="" method="post">
        <div class="flex">
            <div class="textBox">
                <p style="font-size: 1.5em;">Please enter your queue number</p>
                <p style="font-size: 1em; font-style:italic;">Mangyaring ilagay sa ibaba inyong queue number</p>
                <input type="text" name="id" id="" class="inputnum">
                <br>
                <br>
                <button class="btn btn-success flex" type="submit" name="search">Search my Name</button>
                <?php
                    if(isset($_POST['search'])){
                        $id = $_POST['id'];

                        $sql = "SELECT CONCAT(LEFT(client.f_name, 1), REPEAT('*', LENGTH(client.f_name) - 1), ' ', LEFT(client.l_name, 1), REPEAT('*', LENGTH(client.l_name) - 1)) AS masked_name, queue_details.queue_number, queue_details.client_id FROM client INNER JOIN queue_details ON client.client_id = queue_details.client_id WHERE queue_number = '$id' LIMIT 1";
                        $res = mysqli_query($conn,$sql);

                        while($row = mysqli_fetch_array($res)){
                            $client_id = $row['client_id']
                            ?>
                <p style="font-size: 1.5em;">Client Identifier</p>
                <p style="font-size: 1em; font-style:italic;">Note* This is a type box that will auto-fill when your account exists.</p>
                
                <p style="font-size: 1em; font-style:italic;">Paalala* Ito ay kusang naglalagay ng pangalan kung kayo ay nakagawa na ng account.</p>
                <input type="text" name="" id="" disabled class="inputnum" style="padding:0px;" value="<?php echo $row['masked_name']?>"/>

                <button type="button" class="btn btn-success feedbackbtn" data-toggle="modal" data-target="#exampleModalCenter">Submit</button>
                    <?php
            }
                    }
                ?>
                <br>
                <br>
                <br>
            </div>
            <div class="numPan">
                <div class="nums">
                    <div class="flex r r1">
                        <div><span>1</span></div>
                        <div><span>2</span></div>
                        <div><span>3</span></div>
                    </div>
                    <div class="flex r r2">
                        <div><span>4</span></div>
                        <div><span>5</span></div>
                        <div><span>6</span></div>
                    </div>
                    <div class="flex r r3">
                        <div><span>7</span></div>
                        <div><span>8</span></div>
                        <div><span>9</span></div>
                    </div>
                    <div class="flex r r4">
                        <div><span>-</span></div>
                        <div><span>0</span></div>
                        <div class="del"><span>Del</span></div>
                    </div>
                    <div class="flex r r5">
                        <div><span>N</span></div>
                        <div class=""></div>
                        <div><span>P</span></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?php
                if(isset($_POST['search'])){
                    $id = $_POST['id'];

                    $sql = "SELECT CONCAT(LEFT(client.f_name, 1), REPEAT('*', LENGTH(client.f_name) - 1), ' ', LEFT(client.l_name, 1), REPEAT('*', LENGTH(client.l_name) - 1)) AS masked_name, queue_details.queue_number FROM client INNER JOIN queue_details ON client.client_id = queue_details.client_id WHERE queue_number = '$id' LIMIT 1";
                    $res = mysqli_query($conn,$sql);

                    while($row = mysqli_fetch_array($res)){
            ?>
                        <p style="font-style: italic;">Hi,</p>
                        <p><?php echo $row['masked_name']?></p>
                <?php
                    }
                }else{
                    
                }
            ?>
                <p>Would you like to submit a feedback?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"><a href="feedback-form.php" style="text-decoration:none; color:#fff;">No</a></button>
                <button type="button" class="btn btn-success"><a href="feedback-form.php?client_id=<?= $client_id ?>" style="text-decoration:none; color:#fff;">Yes</a></button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7/dist/jquery.min.js"></script>
<script src="https://unpkg.com/swup@4"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    var btn = document.querySelectorAll(".r > div");
    var inpt = document.querySelector(".inputnum");

    btn.forEach(val => {
        val.addEventListener("click", () => {
            if (val.innerText === "Del") {
                inpt.value = inpt.value.slice(0, -1); // Remove the last character
            } else {
                inpt.value += val.innerText;
            }
        });
    });
</script>

</body>
</html>