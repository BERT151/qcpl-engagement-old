<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<div class="container">
        <?php require_once 'includes/sidebar.php' ?>
        <?php require_once 'includes/header.php' ?>
        <!-- Main Content -->
        <main>
            <h1>Feedback</h1>


            <!-- Recent feedback Table -->
            <div class="recent-orders">
                <table>
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Queue Number</th>
                            <th>Time Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <th scope="row">Luffy</th>
                      <td>23-0732</td>
                      <td>11:59pm</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Zoro</th>
                      <td>23-0452</td>
                      <td>1:00pm</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Nami</th>
                      <td>23-0567</td>
                      <td>10:11am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Sanji</th>
                      <td>23-2326</td>
                      <td>7:00am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Brook</th>
                      <td>23-6789</td>
                      <td>11:12am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Ussop</th>
                      <td>23-4521</td>
                      <td>5:00pm</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Robin</th>
                      <td>23-7861</td>
                      <td>8:00am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Chopper</th>
                      <td>23-7632</td>
                      <td>9:34am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Jinbei</th>
                      <td>23-8979</td>
                      <td>10:59pm</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Franky</th>
                      <td>23-3412</td>
                      <td>11:14am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
            </div>
            <!-- End of Recent Orders -->

        </main>
        <!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>How did you learn about our service?</h4>
        <ul>
          <li>Online Search [ Sa Internet ]</li>
          <li>Word of Mouth [ Kwento ng Iba ]</li>
        </ul>
        <h4>How was your experience with our services?</h4>
        <ul>
          <li>Neutral &#128578;</li>
        </ul>
        <h4>How likely are you to recommend specific services within the E-Government Section to others?</h4>
        <ul>
          <li>Excellent &#128513;</li>
        </ul>
        <h4>How satisfied are you with the response time of the E-Government Section in addressing your queries and concerns?</h4>
        <ul>
        <li>Neutral &#128578;</li>
        </ul>
        <h4>Did you find the staff in the E-Government Section
helpful and knowledgeable?</h4>
        <ul>
        <li>Neutral &#128578;</li>
        </ul>
        <h4>Did you find the information presented within the E-Government Section to be easily comprehensible?</h4>
        <ul>
        <li>Neutral &#128578;</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        <?php require_once 'includes/rightsection.php'?>

    </div>
    
     
    <?php
        require_once 'includes/scripts.php';
    ?>
</body>

</html>