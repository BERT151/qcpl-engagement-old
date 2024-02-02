<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<?php 
    require_once("../app/includes/header.php");
    ?>
<body>

    <section id="swup" class="transtion-fade">
            <div class="logo">
                    <img src="assets/images/qclogo.jpg" alt="">
                    <div class="title">
                    <p>Quezon City Public Library</p>
                    <p>Quezon City Government</p>
                    </div>
                    <img src="assets/images/qcplLogo.png" alt="">
            </div>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card p-3  py-4">
                    <h5>Please Enter the Queue Number</h5>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter by
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Queue Number</a>
                                <a class="dropdown-item" href="#">Name</a>
                            </div>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Enter queue number......">                           
                        </div>
                        <div class="col-md-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Search Results</button>                                               
                        </div>                       
                    </div>        
                </div>               
            </div>           
        </div>
    </div>
</section>

                        <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">  
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">PERSONAL INFORMATION</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>     
                            </div>
                            <div class="modal-body">
                            <p>Info</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-info" >Submit</button>
                            </div>
                        </div>   
                        </div>
                    </div>

    <script src="https://unpkg.com/swup@4"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
