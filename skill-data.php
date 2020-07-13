<?php 

session_start();

if( !isset($_SESSION['login']) )
{
  header('Location: auth-login.php');
  exit;
}

require 'functions.php';

$skill = $dbh->prepare("SELECT * FROM Skill LIMIT $firstData, $amountData1Page");
$skill->execute();
$rows = $skill->fetchAll(PDO::FETCH_ASSOC);

$amountData1Page = 5;
$pagin = $dbh->prepare("SELECT * FROM Skill");
$pagin->execute();
$pgSkill = $pagin->fetchAll(PDO::FETCH_ASSOC);
$amoutnData = count( $pgSkill );
$amountPage = ceil( $amoutnData / $amountData1Page );
$activePage = ( isset($_GET['pg']) ) ? $_GET['pg'] : 1;
$firstData = ( $amountData1Page * $activePage ) - $amountData1Page;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Skill Data &mdash; S3M</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

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
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['login']; ?></div></a>
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
              <li class="active"><a class="nav-link" href="skill-data.php"><i class="fas fa-laptop-code"></i> <span>Skill</span></a></li>
              <li><a class="nav-link" href="users-data.php"><i class="fas fa-users"></i> <span>Users</span></a></li>
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Skill Data</h1>
            <div class="section-header-button">
              <a href="features-post-create-skill.php" class="btn btn-primary">Add New</a>
            </div>
          </div>

          <div class="section-body">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-md">
                  <tr>
                    <th>No.</th>
                    <th>Id</th>
                    <th>Skill</th>
                    <th>Action</th>
                  </tr>
                  <?php
                    $i = 1;
                    foreach( $rows as $row ) {
                    ?>
                    <tr>
                      <td><?= $i + $firstData ?></td>
                      <td><?= $row['sid'] ?></td>
                      <td><?= $row['skill'] ?></td>
                      <td>
                        <a href="features-profile-skill.php?id=<?= $row['sid'] ?>" class="btn btn-success mr-1">Edit</a>
                        <a href="delete-skill.php?id=<?= $row['sid'] ?>" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                  <?php $i++; } ?>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer text-center">
            <nav class="d-inline-block">
              <ul class="pagination mb-0">
                <?php if( $activePage > 1 ) { ?>
                  <li class="page-item">
                    <a class="page-link" href="?pg= <?php echo $activePage - 1; ?>" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                  </li>
                <?php } ?>

                <?php for( $i = 1; $i <= $amountPage; $i++ ) { ?>
                  <?php if( $i == $activePage ) { ?>
                    <li class="page-item active"><a class="page-link" href="?pg= <?php echo $i; ?>"><?php echo $i; ?> <span class="sr-only">(current)</span></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?pg= <?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php } ?>
                <?php } ?>

                <?php if( $activePage < $amountPage ) { ?>
                  <li class="page-item">
                    <a class="page-link" href="?pg= <?php echo $activePage + 1; ?>"><i class="fas fa-chevron-right"></i></a>
                  </li>
                <?php } ?>
              </ul>
            </nav>
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

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
