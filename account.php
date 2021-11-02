<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Exam Ground</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/font.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
  <script src="https://use.fontawesome.com/dd653cca0e.js"></script>
  <!--alert message-->
  <?php if (@$_GET['w']) {
    echo '<script>alert("' . @$_GET['w'] . '");</script>';
  }
  ?>
  <!--alert message end-->

</head>
<?php
include_once 'dbConnection.php';
$eid = "saif";
?>

<body>

  <!-- Setting up the navbar -->
  <header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <span class="navbar-brand" href="index.html">Online Examination System</span>
        <div class="col-md-4 ms-auto" style="text-align: right;">
          <?php
          include_once 'dbConnection.php';
          session_start();
          if (!(isset($_SESSION['email']))) {
            header("location:index.php");
          } else {
            $name = $_SESSION['name'];
            $email = $_SESSION['email'];

            include_once 'dbConnection.php';
            echo '<span class="pull-right title1" style = "justify-content:center;">
                  <span class="log1">
                    <span aria-hidden="true"></span> Hello, </span> 
                  <a href="account.php?q=1" class="log log1">' . $name . '</a>
                  <a href="logout.php?q=account.php" class="log" >
                    Signout
                  </a>
                </span>';
          } ?>
        </div>
      </div>
    </div>
  </header>


  <div class="bg" style="min-height: calc(100vh - 88px);">
    <!--navigation menu-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary title1">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand" href="#">Exam Ground</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="account.php?q=1">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="account.php?q=2">
                History
              </a>

            </li>
            <li class="nav-item">
              <a class="nav-link " href="account.php?q=3">Ranking</a>
            </li>
          </ul>

          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-dark" style="padding-left: 15px; padding-right: 28px;" type="submit">Search</button>
          </form>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <!--navigation menu closed-->


    <div class="container">
      <!--container start-->
      <div class="row">
        <div class="col-md-12">

          <!--home tab start-->
          <?php if (@$_GET['q'] == 1) {

            $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
            echo  '<div class="panel titl">
                      <div class="table-responsive">
                        <table class="table table-stripe title1">
                          <tr class = "table-dark" style = "font-weight:bold;">
                            <td>S.N.</td>
                            <td>Topic</td>
                            <td>Total question</td>
                            <td>Marks</td>
                            <td>Time limit</td>
                            <td></td>
                          </tr>';
            $c = 1;
            while ($row = mysqli_fetch_array($result)) {
              $title = $row['title'];
              $total = $row['total'];
              $sahi = $row['sahi'];
              $time = $row['time'];
              $eid = $row['eid'];

              $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
              $rowcount = mysqli_num_rows($q12);
              $temp;
              if ($rowcount == 0) {
                echo  '<tr class = "table-light"> 
                          <td>' . $c++ . '</td>
                          <td>' . $title . '</td>
                          <td>' . $total . '</td>
                          <td>' . $sahi * $total . '</td>
                          <td>' . $time . '&nbsp;min</td>
                          <td>
                            <b>
                                <a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn btn-success" style="margin:0px; padding-right: 1.25rem; padding-left: 1.07rem;" >
                                  <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;
                                  <span class="title1"><b> Start </b></span>
                                </a>
                            </b>
                          </td>
                        </tr>';
              } else {
                $temp = "update.php?q=quizre&step=25&eid=$eid&n=1&t=$total";
                echo  '<tr class = "table-info">
                          <td>' . $c++ . '</td>
                          <td>' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
                          <td>' . $total . '</td>
                          <td>' . $sahi * $total . '</td>
                          <td>' . $time . '&nbsp;min</td>
                          <td>
                            <b>
                              <a class="pull-right btn btn-warning" href = "account.php?q=restart&step=2&eid=' . $eid . '&n=1&t=' . $total . '"  style="margin:0px;"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b> Restart </b></span></a>
                            </b>
                          </td>
                        </tr>';
              }
            }
            $c = 0;
            echo '</table></div></div>';
          } ?>


          <!-- Modal for asking confirmation about retest -->
          <?php
          if (@$_GET['q'] == 'restart' && @$_GET['step'] == 2) {
            $eid = @$_GET['eid'];
            $total = @$_GET['t'];
            echo '<button type="button" id="launch" style = "display:none;" data-bs-toggle="modal" data-bs-target="#exampleModal"></button>';

            echo '<script type="text/javascript">
            $(document).ready(function() {
              $("#launch").click();
            });
          </script>';

            echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style = "font-family: ubuntu;">Do you really want to retake this exam?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                      <p style = "color: red;">Any previous Score for this exam will get reset.</p>
                      </div>
                      <div class="modal-footer">
                        <a type="button" class="btn btn-secondary" href = "account.php?q=1">Close</a>
                        <a type="button" class="btn btn-danger" href = "update.php?q=quizre&step=25&eid=' . $eid . '&n=1&t=' . $total . '">Confirm</a>
                      </div>
                    </div>
                  </div>
                </div>';
          }
          ?>


          <!-- <span id="countdown" class="timer"></span>
          <script>
            var seconds = 40;

            function secondPassed() {
              var minutes = Math.round((seconds - 30) / 60);
              var remainingSeconds = seconds % 60;
              if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
              }
              document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
              if (seconds == 0) {
                clearInterval(countdownTimer);
                document.getElementById('countdown').innerHTML = "Buzz Buzz";
              } else {
                seconds--;
              }
            }
            var countdownTimer = setInterval('secondPassed()', 1000);
          </script> -->

          <!--home closed-->

          <!--quiz start-->
          <?php
          if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
            $eid = @$_GET['eid'];
            $sn = @$_GET['n'];
            $total = @$_GET['t'];
            $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
            echo
            '<div class="panel" style="margin:5%">';
            while ($row = mysqli_fetch_array($q)) {
              $qns = $row['qns'];
              $qid = $row['qid'];
              echo '<b>Question &nbsp;' . $sn . '&nbsp;::<br />' . $qns . '</b><br /><br />';
            }
            $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");
            echo '<form action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal"><br />';

            while ($row = mysqli_fetch_array($q)) {
              $option = $row['option'];
              $optionid = $row['optionid'];
              echo '<input type="radio" name="ans" value="' . $optionid . '">' . $option . '<br /><br />';
            }
            echo '<br />
                        <button type="submit" class="btn btn-primary">
                          <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                        &nbsp;Submit
                        </button>
                      </form>
            </div>';
            //header("location:dash.php?q=4&step=2&eid=$id&n=$total");
          }

          //result display
          if (@$_GET['q'] == 'result' && @$_GET['eid']) {
            $eid = @$_GET['eid'];
            $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error157');
            echo  '<div class="panel">
                    <center>
                      <p class="title" style="color:#660033; font-size: 2rem;">Result</p>
                    <center>
                    <br />
                    <div class = "table-responsive">
                     <table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

            while ($row = mysqli_fetch_array($q)) {
              $s = $row['score'];
              $w = $row['wrong'];
              $r = $row['sahi'];
              $qa = $row['level'];
              echo  '<tr style="color:#66ccff">
                      <td>Total Questions</td>
                      <td>' . $qa . '</td>
                    </tr>
                    <tr style="color:#99cc32">
                      <td>right Answer&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td>
                      <td>' . $r . '</td>
                    </tr> 
                    <tr style="color:red">
                      <td>Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td>
                      <td>' . $w . '</td>
                    </tr>
                    <tr style="color:#66CCFF">
                      <td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td>
                      <td>' . $s . '</td>
                    </tr>';
            }
            $q = mysqli_query($con, "SELECT * FROM rank WHERE  email='$email' ") or die('Error157');
            while ($row = mysqli_fetch_array($q)) {
              $s = $row['score'];
              echo '<tr style="color:#990000"><td>Overall Score&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>' . $s . '</td></tr>';
            }
            echo '</table></div></div>';
          }
          ?>
          <!--quiz end-->




          <?php
          //history start
          if (@$_GET['q'] == 2) {
            echo '<script type="text/javascript">
            $(".navbar-nav li a").function() {
              $(".navbar-nav li a").removeClass(active);
              $(this).addClass(active);    
          };
          </script>';
            $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC ") or die('Error197');
            echo  '<div class="panel title">
                     <div class="table-responsive">
                      <table class="table table-striped title1" >
                        <tr class = "table-dark" style="color:red">
                          <td><b>S.N.</b></td>
                          <td><b>Quiz</b></td>
                          <td><b>Question Solved</b></td>
                          <td><b>Right</b></td>
                          <td><b>Wrong<b></td>
                          <td><b>Score</b></td>
                        </tr>';
            $c = 0;
            while ($row = mysqli_fetch_array($q)) {
              $eid = $row['eid'];
              $s = $row['score'];
              $w = $row['wrong'];
              $r = $row['sahi'];
              $qa = $row['level'];
              $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE  eid='$eid' ") or die('Error208');
              $row = mysqli_fetch_array($q23);
              $title = $row['title'];
              $c++;
              echo '<tr class = "table-primary" style = "font-weight: bold;">
                        <td style = "color: #2196f3" >' . $c . '</td>
                        <td>' . $title . '</td>
                        <td>' . $qa . '</td>
                        <td>' . $r . '</td>
                        <td>' . $w . '</td>
                        <td>' . $s . '</td>
                      </tr>';
            }
            echo '</table></div></div>';
          }

          //ranking start
          if (@$_GET['q'] == 3) {
            $q = mysqli_query($con, "SELECT * FROM rank  ORDER BY score DESC ") or die('Error223');
            echo  '<div class="panel title">
                    <div class="table-responsive">
                      <table class="table table-hover table-striped title1" >
                        <tr class = "table-dark">
                          <td><b>Rank</b></td>
                          <td><b>Name</b></td>
                          <td><b>Gender</b></td>
                          <td><b>College</b></td>
                          <td><b>Score</b></td>
                        </tr>';
            $c = 0;
            while ($row = mysqli_fetch_array($q)) {
              $e = $row['email'];
              $s = $row['score'];
              $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e' ") or die('Error231');
              while ($row = mysqli_fetch_array($q12)) {
                $name = $row['name'];
                $gender = $row['gender'];
                $college = $row['college'];
              }
              $c++;
              if ($c == 1) {
                echo '<tr class = "table-info" style = "color: #99cc32; font-weight: bold;">
                        <td style="color:#99cc32"><b>' . $c . '</b></td>
                        <td>' . $name . '</td>
                        <td>' . $gender . '</td>
                        <td>' . $college . '</td>
                        <td>' . $s . '</td>
                      <tr>';
              } else {
                echo '<tr class = "table-light" style = "font-weight: bold;">
                          <td style="color:#2196f3"><b>' . $c . '</b></td>
                          <td>' . $name . '</td>
                          <td>' . $gender . '</td>
                          <td>' . $college . '</td>
                          <td>' . $s . '</td>
                      <tr>';
              }
            }
            echo
            '</table>
              </div>
              </div>';
          }
          ?>



        </div>
      </div>
    </div>
  </div>
  <!--Footer start-->
  <footer class="row footer mt-auto ">
    <div class="col-md-3 box">
      <a href="http://www.projectworlds.in/online-examination" target="_blank">About us</a>
    </div>
    <div class="col-md-3 box">
      <a href="#" data-bs-toggle="modal" data-bs-target="#adminLogin">Admin Login</a>
    </div>
    <div class="col-md-3 box">
      <a href="#" data-bs-toggle="modal" data-bs-target="#developers">Developers</a>
    </div>
    <div class="col-md-3 box">
      <a href="feedback.php" target="_blank">Feedback</a>
    </div>
  </footer>
  <!--footer end-->


  <!-- Modal For Developers-->
  <div class="modal fade title1" id="developers" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="font-family:'typo' "><span style="color:orange">Developers</span>
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body" style="text-align: center;">

          <div class="row">
            <div class="col-md-6 float-md-end">
              <img src="image/pp.jpg" width=100 height=100 alt="Mohammad Saif Khan" class="img-rounded">
              <a href="#" style="display: block; color:#202020; font-family:'typo' ; font-size:16px; color: blue; text-decoration: none;" title="Find on Facebook">Mohd. Saif Khan</a>
              <h5 style="color:#202020; font-family:'typo'; font-size: 13px; " class="title1">+91 9140671497</h5>
              <a style="font-family:'typo';font-size: 14px; text-decoration: none;" class="title1" href="mailto:ksarim225@gmail.com" target="_blank">ksarim225@gmail.com</a>
            </div>

            <div class="col-md-6">
              <img src="image/emanur.jpg" width=100 height=100 alt="Emanur Rahman" class="img-rounded">
              <a href="#" style="display: block; color:#202020; font-family:'typo' ; font-size:16px; color: blue; text-decoration: none;" title="Find on Facebook">Emanur Rahman</a>
              <h5 style="color:#202020; font-family:'typo'; font-size: 13px;" class="title1">+91 7047615466</h5>
              <a style="font-family:'typo';font-size: 14px; text-decoration: none;" class="title1" href="mailto:ksarim225@gmail.com" target="_blank">emanur99rahman@gmail.com</a>

            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <a style="font-family:'typo'; display:'inline-block'; margin-bottom: 13px;" ; class="title1" href="https://www.iiests.ac.in/" target="_blank">Indian Institute of Engineering Science and
                Technology,
                Shibpur
              </a>
            </div>
          </div>

        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!--Modal for admin login-->
  <div class="modal fade title1" id="adminLogin">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="font-family:'typo' "><span style="color:orange">Log In</span>
          </h4>
          <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body title1">
          <form role="form" method="post" action="admin.php?q=index.php">
            <fieldset>

              <!-- text-input -->
              <div class="row mb-2">
                <div class="col-sm-10 col-md-6">
                  <input id="uName" name="uname" maxlength="20" placeholder="Admin user-id" class="form-control input" type="text" autofocus>
                </div>
              </div>


              <!-- Password input-->
              <div class="row mb-2">
                <div class="col-sm-10 col-md-6">
                  <input name="password" maxlength="15" placeholder="Password" type="password" class="form-control input">
                </div>
              </div>
            </fieldset>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="login" class="btn btn-primary">Log In</button>
            </div>
          </form>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>