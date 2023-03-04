<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/x-icon" href="todo.png">
  <title>ToDone</title>
</head>

<body>
  <?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "todo";

  $conn = mysqli_connect($servername, $username, $password, $database);
  if (!$conn) {
    die("sorry connection failed " . mysqli_connect_error());
  }

  $sqlq = "SELECT * FROM `todo`";
  $result = mysqli_query($conn, $sqlq);

  $task = '';
  $progress = 'In progress';
  if (isset($_POST['task'])) {
    $task = $_POST['task'];
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
      $sql = "INSERT INTO `todo`(`slno`, `title`, `progress`) VALUES ('','$task','$progress')";
      $result = mysqli_query($conn, $sql);
      header("location:index.php");
      if ($result) {
        echo "<div class='alert alert-success' role='alert'>
  !yay task added...
  </div>";
      } else {
        echo ("error");
      }
    } 
    elseif (isset($_POST['delete'])) {
      $uid = $_POST['uid'];
      echo($uid);
      $sql4 = "DELETE FROM `todo` WHERE `slno`=$uid";
      $result4 = mysqli_query($conn, $sql4);
      header("location:index.php");
      if ($result4) {
        echo "<div class='alert alert-success' role='alert'>
  !yay task done....
  </div>";
      } else {
        echo ("error");
      }
    }
  }


  ?>
  <section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
          <div class="card rounded-3">
            <div class="card-body p-4">

              <h4 class="text-center my-3 pb-3">ToDone</h4>

              <form action="" method="post"
                class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                <div class="col-12">
                  <div class="form-outline">
                    <input type="text" id="form1" class="form-control" name="task" autocomplete="off" />
                    <label class="form-label" for="form1">Enter a task here</label>
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" name="save" class="btn btn-primary">Save</button>
                </div>
              </form>

              <table class="table mb-4">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Todo item</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql2 = "SELECT * FROM `todo`";
                  $result2 = mysqli_query($conn, $sql2);
                  if ($result2) {
                    $val = mysqli_num_rows($result);
                    if ($val > 0) {
                      $i = 0;
                      while ($i != $val) {
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <tr>
                          <th scope="row">
                            <?php echo ($i) ?>
                          </th>
                          <td id="text">
                            <?php echo ($data['title']); ?>
                          </td>
                          <td>
                            <?php echo ($data['progress']); ?>
                          </td>
                          <td>
                            <form action="" method="post">
                              <!--<button type="submit"  name="edit"  data-toggle="modal" data-target="#exampleModal" ">Edit</button>-->
                              <input type="hidden" name="uid" value="<?php echo ($data['slno']); ?>">
                              <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                          </td>
                        </tr>
                        <?php
                        $i++;
                      }
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <input type="text" name="update" class="form-control" autocomplete="off">
            <input type="hidden" name="uid2" value="<?php echo($uid2); ?>">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="edit2" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>
