<?php
include_once 'dbConnection.php';
session_start();
$email = $_SESSION['email'];
//delete feedback


//delete user
if (isset($_SESSION['key'])) {
    if (@$_GET['demail'] && $_SESSION['key'] == 'sunny7785068889') {
        $demail = @$_GET['demail'];
        $r1 = mysqli_query($con, "DELETE FROM rank WHERE email='$demail' ") or die('Error');
        $r2 = mysqli_query($con, "DELETE FROM history WHERE email='$demail' ") or die('Error');
        $result = mysqli_query($con, "DELETE FROM user WHERE email='$demail' ") or die('Error');
        header("location:dash.php?q=1");
    }
}
//remove quiz


//add quiz


//add question

//quiz start
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];
    $ans = $_POST['ans'];
    $qid = @$_GET['qid'];
    $q = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid' ");
    while ($row = mysqli_fetch_array($q)) {
        $ansid = $row['ansid'];
    }


    $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' ");
    while ($row = mysqli_fetch_array($q)) {
        $sahi = $row['sahi'];  // fetch the marks for correct submission
        $wrong = $row['wrong']; // fetch the marks for wrong submission
    }

    //Reset the history for that quiz
    if ($sn == 1) {
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error139');
        $rowcount = mysqli_num_rows($q);
        if ($rowcount == 0) {
            $q = mysqli_query($con, "INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW() )") or die('Error137');
        }
    }
    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error115'); //fetch the history till this question

    while ($row = mysqli_fetch_array($q)) {
        $s = $row['score'];
        $r = $row['sahi'];
        $w = $row['wrong'];
    }

    if ($ans == $ansid) {
        $r++; //increase the correct answer count
        $s = $s + $sahi; // increase the score for this quiz
    } else {
        $w++;
        $s = $s - $wrong;
    }
    $q = mysqli_query($con, "UPDATE `history` SET `score`=$s,`level`=$sn,`sahi`=$r,  `wrong` =$w, date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error124');
    if ($sn != $total) {
        $sn++;
        header("location:account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total") or die('Error152');
    } else if ($_SESSION['key'] != 'sunny7785068889') {  //if the user is not admin => update his score
        $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error156');
        while ($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
        }
        $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
        $rowcount = mysqli_num_rows($q);
        //if the user is giving exam for the first time
        if ($rowcount == 0) {
            $q2 = mysqli_query($con, "INSERT INTO rank VALUES('$email','$s',NOW())") or die('Error165');
        } else { // if he had score for some previous exam
            while ($row = mysqli_fetch_array($q)) {
                $sun = $row['score'];
            }
            $sun = $s + $sun;
            $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
        }
        header("location:account.php?q=result&eid=$eid");
    } else {  // if the user is admin => just show the result
        header("location:account.php?q=result&eid=$eid");
    }
}

//restart quiz
if (@$_GET['q'] == 'quizre' && @$_GET['step'] == 25) {
    $eid = @$_GET['eid'];
    $n = @$_GET['n'];
    $t = @$_GET['t'];
    $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error156');
    while ($row = mysqli_fetch_array($q)) {
        $s = $row['score'];
    }
    $q = mysqli_query($con, "DELETE FROM `history` WHERE eid='$eid' AND email='$email' ") or die('Error184');
    $q = mysqli_query($con, "INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW() )") or die('Error137');
    $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
    while ($row = mysqli_fetch_array($q)) {
        $sun = $row['score'];
    }
    $sun = $sun - $s;
    $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
    header("location:account.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
}
