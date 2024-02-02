<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<div class="container">
        <?php require_once 'includes/sidebar.php' ?>
        <?php require_once 'includes/header.php' ?>
        <!-- Main Content -->
        <main>
            <h1>Services Offered</h1>
            <!-- Analyses -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">Add Service</button>
            <br>
            <br>
            <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Title</th>
      <th scope="col">Time Added</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>NBI</td>
      <td>1:35am 11/22/2023</td>
      <td>
      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>
      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Police</td>
      <td>1:35am 11/22/2023</td>
      <td>
      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>
      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>
      </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>PSA Birth Certificate</td>
      <td>1:35am 11/22/2023</td>
      <td>
      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>
      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>
      </td>
    </tr>
  </tbody>
</table>

        </main>
        <!-- End of Main Content -->

 <!-- Add Modal -->
 <div class="modal" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Service</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <!-- Edit form goes here -->
        <form>
          <div class="form-group">
            <label for="editName">Title</label>
            <input type="text" class="form-control" id="editName">
            
          </div>
          <br>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

    
<!-- Edit Modal -->
<div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Service</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <!-- Edit form goes here -->
        <form>
          <div class="form-group">
            <label for="editName">Title</label>
            <input type="text" class="form-control" id="editName">
              
          </div>
          <br>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Service</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <p>Are you sure you want to delete this service?</p>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>

        <?php require_once 'includes/rightsection.php' ?>
    </div>
    
  
    
    
    <?php
        require_once 'includes/scripts.php';
    ?>
</body>
</html>