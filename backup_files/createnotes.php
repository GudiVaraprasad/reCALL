<?php

require 'connect.php';

if (!isset($_SESSION['login_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['login_id'];

$get_user = mysqli_query($db_connection, "SELECT * FROM `users` WHERE `google_id`='$id'");

if (mysqli_num_rows($get_user) > 0) {
    $user = mysqli_fetch_assoc($get_user);
} else {
    header('Location: logout.php');
    exit;
}
$insert = false;
$update = false;
$delete = false;

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($db_connection, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];
        $id = $_SESSION['login_id'];

        // Sql query to be executed
        $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($db_connection, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "Failed to update!";
        }
    } else {
        $title = $_POST["title"];
        $description = $_POST["description"];

        // Sql query to be executed
        $sql = "INSERT INTO `notes` (`title`, `description`, `id`) VALUES ('$title', '$description', '$id')";
        $result = mysqli_query($db_connection, $sql);


        if ($result) {
            $insert = true;
        } else {
            echo "<script>alert('Failed to add your note');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>reCALL</title>
    <link rel="shortcut icon" href="icon.jpg" type="image/jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="createnotes.css">
</head>

<body>

    <!-- Vertical navbar -->
    <div class="vertical-nav" id="sidebar">
        <div class="py-4 px-3 mb-4">
            <div class="media d-flex align-items-center justify-content-center">
                <img width="100rem" height="auto" style="border-radius: 3rem;" src="<?php echo $user['profile_image']; ?>" alt="<?php echo $user['name']; ?>">
            </div>
            <div class="media-body text-center mt-3">
                <h4 style="color:white;" class="m-0"><?php echo $user['name']; ?></h4>
            </div>
        </div>



        <ul class="nav flex-column mb-0">
            <li class="nav-item">
                <a href="index.php" class="nav-link text-light">
                    <i class="fa fa-home mr-3 text-light fa-fw"></i>
                    Home
                </a>
            </li>
        </ul>
        <br>


        <p class="text-white font-weight-bold text-uppercase px-3 small pb-4 mb-0">Operations</p>

        <ul class="nav flex-column text-white mb-0">
            <li class="nav-item">
                <a href="createnotes.php" class="nav-link text-white">
                    <i class="fa fa-pencil-square-o mr-3 text-white fa-fw"></i>
                    Notes Making
                </a>
            </li>
            <li class="nav-item">
                <a href="managepassword.php" class="nav-link text-white">
                    <i class="fa fa-lock mr-3 text-white fa-fw"></i>
                    Manage Passwords
                </a>
            </li>

            <li class="nav-item">
                <a href="organizetask.php" class="nav-link text-white">
                    <i class="fa fa-window-restore mr-3 text-white fa-fw"></i>
                    Organize Tasks
                </a>
            </li>
        </ul>


        <div class="mt-5 text-center">
            <button type="button" class="btn btn-light"><a href="logout.php" style="color:black;text-decoration: none;">Logout</a></button>
        </div>

        <div style="padding-top:10rem; bottom: 0; width: 100%; color: white; text-align: center;">
            <p>Copyright &copy; reCALL</p>
        </div>
    </div>
    <!-- End vertical navbar -->


    <!-- Page content holder -->
    <div class="page-content p-5" id="content">
        <!-- Toggle button -->
        <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Menu</small></button>

        <!-- Demo content -->
        <h2 class="display-4 text-center"><b>reCALL - My Notebook</b></h2>

        <div class="separator"></div>
        <div class="row">
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit your Note</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="./createnotes.php" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="snoEdit" id="snoEdit">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" pattern="^[a-zA-Z0-9 ]+$" required title="This field is required" class="form-control" id="titleEdit" name="titleEdit" maxlength="40" aria-describedby="emailHelp">
                                </div>

                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea pattern="^[a-zA-Z0-9 ]+$" required class="form-control" maxlength="99999" id="descriptionEdit" name="descriptionEdit" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer d-block mr-auto">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-secondary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($insert) {
            echo "<script>alert('Added notes successfully!');</script>";
        }
        ?>

        <?php
        if ($delete) {
            echo "<script>alert('Deleted notes successfully!');</script>";
            echo "<script>window.location='createnotes.php'</script>";
        }
        ?>

        <?php
        if ($update) {
            echo "<script>alert('Updated notes successfully!');</script>";
        }
        ?>

        <div class="container my-5">
            <form action="./createnotes.php" method="POST">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" autocomplete="off" class="form-control" id="title" name="title" aria-describedby="emailHelp" pattern="^[a-zA-Z0-9 ]+$" required>
                </div>

                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea autocomplete="off" class="form-control" id="description" name="description" rows="6" pattern="^[a-zA-Z0-9 ]+$" required></textarea>
                </div>

                <button style="color: #fff; background-color: #2e3192;" type="submit" class="btn">Add Notes</button>

            </form>
        </div> <br>

        <div id="mytablestyles" class="container my-6">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Heading</th>
                        <th scope="col">Content</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $uid = $_SESSION['login_id'];
                    $sql = "SELECT * FROM `notes` WHERE `notes`.`id` = $uid";
                    $result = mysqli_query($db_connection, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td> 
                <button style='color: #fff; background-color: #2e3192;' class='edit btn btn-sm' id=" . $row['sno'] . ">Edit</button>
                <button class='delete btn btn-sm btn-danger' id=d" . $row['sno'] . ">Delete</button>
            </td>
          </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>




    <!-- End demo content -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("delete");
                sno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this note ?")) {
                    console.log("Yes");
                    window.location = `./createnotes.php?delete=${sno}`;
                } else {
                    console.log("No");
                }
            })
        })
    </script>
</body>

</html>