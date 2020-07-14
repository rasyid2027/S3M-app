<?php 

session_start();

if( !isset($_SESSION['login']) )
{
  header('Location: auth-login.php');
  exit;
}

require 'functions.php';

$id = $_GET['id'];
$stmt = $dbh->prepare("SELECT * FROM Users WHERE id = ?");
$stmt->execute([$id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($id);
// die;

if( isset($_POST['submit']) )
{
  if( $_POST['confirm'] === $_POST['password'] )
  {
    $id = $_POST['id'];
    $pass = htmlspecialchars(sha1($_POST['password']));
    $query = "UPDATE Users SET
                password = ?
              WHERE id = ?
              ";

    $stmt = $dbh->prepare($query);
    $stmt->execute([$pass, $id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if( $rows > 0 )
    {
      echo "
            <script>
              alert('successfully edited data')
              document.location.href = 'users-data.php';
            </script>
          ";
    } else {
      echo "
            <script>
              alert('failed to edit data')
              document.location.href = 'users-data.php';
            </script>
          ";
    }
  } else {
      echo "
            <script>
              alert('password doesn\'t match')
              document.location.href = 'users-data.php';
            </script>
          ";
  }
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Profile &mdash; S3M</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['login']['name']; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.php">Sun-3 Management</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php">S3M</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li><a class="nav-link" href="index.php"><i class="fas fa-home"></i> <span>Home</span></a></li>
              <li class="menu-header">Menu</li>
              <li><a class="nav-link" href="santri-data.php"><i class="fas fa-table"></i> <span>Santri Data</span></a></li>
              <li><a class="nav-link" href="skill-data.php"><i class="fas fa-laptop-code"></i> <span>Skill</span></a></li>
              <li><a class="nav-link" href="users-data.php"><i class="fas fa-users"></i> <span>Users</span></a></li>
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Reset Users</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Users</a></div>
              <div class="breadcrumb-item">Reset Users</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Hi, Admin!</h2>
            <p class="section-lead">
              Reset password of this data on this page.
            </p>

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                      <h4>Edit Users Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-10 col-12">
                          <input type="hidden" class="form-control" name="id" value="<?= $users[0]['id'] ?>" required="">
                        </div>
                        <div class="form-group col-md-10 col-12">
                          <label>New Password</label>
                          <input type="password" class="form-control" data-toggle="tooltip" data-placement="right" title="Max. 20 characters" name="password" maxlength="20" placeholder="Enter a new password" value="" required="">
                          <div class="invalid-feedback">
                            Please fill in the field
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-10 col-12">
                          <label>Confirm Password</label>
                          <input type="password" class="form-control" data-toggle="tooltip" data-placement="right" title="Max. 20 characters" name="confirm" maxlength="20" placeholder="Confirm new password" value="" required="">
                          <div class="invalid-feedback">
                            Please fill in the field
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="card-footer text-right">
                        <button class="btn btn-primary" name="submit">Save Changes</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="../node_modules/summernote/dist/summernote-bs4.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
