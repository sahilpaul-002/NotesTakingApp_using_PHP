<?php
//Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notesapp";
$port = 3307;

//Create a connection
$conn = mysqli_connect($servername, $username, $password, "", $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
  //Create a databse if it doesn't exist
  $sql = "CREATE DATABASE IF NOT EXISTS notesapp";
  if (mysqli_query($conn, $sql)) 
  {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success : </strong> Database created or already exist.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  } 
  else 
  {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error : </strong> Database not created == ' . mysqli.error($conn) . '
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }

  //Select the database
  mysqli_select_db($conn, $dbname);

  //Create a table if it doesn't exist
  $sql = "CREATE TABLE IF NOT EXISTS `notes` (
    `id` int(10) AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(50) NOT NULL,
    `description` TEXT NOT NULL,
    `created at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )ENGINE=Innodb DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci";
    if(mysqli_query($conn, $sql))
    {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success : </strong> Table created or already exists.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    else
    {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error : </strong> Table not created == ' . mysqli.error($conn) . '
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <title>My Notes - easy note making</title>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">My Notes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    
    <!-- Form -->
    <div class="container mt-5">
        <h2>Add Your Note</h2>
        <form action="/NoteTakingApp/index.php" method="POST">
        <div class="form-group">
            <label for="noteTitle">Note Title</label>
            <input type="text" class="form-control" id="noteTitle" aria-describedby="noteTitleHelp" name = "noteTitle">
            <small id="noteTitle" class="form-text text-muted">Please provide title for your notes.</small>
        </div>
        <div class="form-group">
            <label for="noteDescription">Note Description</label>
            <textarea class="form-control" id="noteDescription"name="noteDescription" rows="7" cols="10"></textarea>
          </div>
        <button type="submit" class="btn btn-primary">Add note</button>
        </form>
        <?php
          //Insert/Update the note into the database
          if($_SERVER["REQUEST_METHOD"] == "POST")
          {
            if(isset($_POST["snoEdit"]))
            {
              //Update the note
              $snoEdit = $_POST["snoEdit"];
              $noteTitleEdit = $_POST["noteTitleEdit"];
              $noteDescriptionEdit = $_POST["noteDescriptionEdit"];
              $sql = "UPDATE `notes` SET `title` = '$noteTitleEdit', `description` = '$noteDescriptionEdit' WHERE `id` = '$snoEdit'";
              $result = mysqli_query($conn, $sql);
              if($result)
              {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success : </strong> Note updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
              }
              else
              {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error : </strong> Note not updated == ' . mysqli.error($conn) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
              }
            }
            //Insert the note into the database
            else
            {
              $noteTitle = $_POST["noteTitle"];
              $noteDescription = $_POST["noteDescription"];
              $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$noteTitle', '$noteDescription')";
              $result = mysqli_query($conn, $sql);
              if($result)
              {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success : </strong> Note added successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
              }
              else
              {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error : </strong> Note not added == ' . mysqli.error($conn) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
            }
          }

          //Delete the note from the database
          if(isset($_GET['delete']))
          {
            $snoDelete = $_GET['delete'];
            $sql = "DELETE FROM `notes` WHERE `id` = '$snoDelete'";
            $result = mysqli_query($conn, $sql);
            if($result)
            {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success : </strong> Note deleted successfully.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
            }
            else
            {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error : </strong> Note not deleted == ' . mysqli.error($conn) . '
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
            }
          }
        ?>
    </div>

    <!-- Table -->
    <div class="container" mt-3>
      <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">SL No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>

    <!-- Bootstarp Modal -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModal">Edit Note</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <!-- Form -->
          <form action="/NoteTakingApp/index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
                <label for="noteTitleEdit">Note Title</label>
                <input type="text" class="form-control" id="noteTitleEdit" aria-describedby="noteTitleHelp" name = "noteTitleEdit">
                <small id="noteTitleEdit" class="form-text text-muted">Please provide title for your notes.</small>
            </div>
            <div class="form-group">
                <label for="noteDescriptionEdit">Note Description</label>
                <textarea class="form-control" id="noteDescriptionEdit"name="noteDescriptionEdit" rows="7" cols="10"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Update note</button>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
      <?php
      //Fetch notes from the database and display them in the table
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $SlNo = 0; // Initialize the serial number
        while($row = mysqli_fetch_assoc($result))
        {
          $SlNo += 1;
          echo '<tr>
          <th scope="row">' . $SlNo . '</th>
          <td>' . $row['title'] . '</td>
          <td>' . $row['description'] . '</td>
          <td><button type="button" class="edit btn btn-primary" data-target="#editModal">Edit</button>
          <button type="button" class="delete btn btn-danger">Delete</button></td>
        </tr>';
        }
      ?>
      </tbody>
    </table>
  </div>
    <hr>
    <div class="container text-center mt-5 mb-5">
        <p>Copyright &copy; 2023 - All Rights Reserved</p>
    <div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#myTable').DataTable();
      });
    </script>

    <!-- Java Script Event Listner -->
     <script>
      edits = document.getElementsByClassName("edit");
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
              console.log("edit", e.target.parentNode.parentNode);
              tr = e.target.parentNode.parentNode;
              let serialNo = tr.getElementsByTagName("th")[0].innerText;
              let title = tr.getElementsByTagName("td")[0].innerText;
              let description = tr.getElementsByTagName("td")[1].innerText;
              console.log(serialNo, title, description);
              let noteTitleEdit = document.getElementById("noteTitleEdit");
              let noteDescriptionEdit = document.getElementById("noteDescriptionEdit");
              let snoEdit = document.getElementById("snoEdit");
              noteTitleEdit.value = title;
              noteDescriptionEdit.value = description;
              snoEdit.value = serialNo;
              console.log("snoEdit", snoEdit.value);
              $("#editModal").modal("toggle");
            });
          });
    
          deletes = document.getElementsByClassName("delete");
          Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
              console.log("delete", e.target.parentNode.parentNode);
              tr = e.target.parentNode.parentNode;
              let serialNo = tr.getElementsByTagName("th")[0].innerText;
              let title = tr.getElementsByTagName("td")[0].innerText;
              let description = tr.getElementsByTagName("td")[1].innerText;
              console.log(serialNo, title, description);
              if(confirm("Are you sure you want to delete this note !"))
              {
                console.log("yes");
                //Delete the note from the database
                let snoDelete = serialNo;
                console.log("snoDelete", snoDelete);
                window.location = `/NoteTakingApp/index.php?delete=${snoDelete}`;
              }
              else
              {
                console.log("no");
              }
            });
          });
        </script>
  </body>
</html>