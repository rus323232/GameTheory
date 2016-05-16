<?php 

    include_once 'FindingUnknowVariables.php';

    if(isset($_POST['pay_matrix']) && isset($_POST['n']) && isset($_POST['m']) && isset($_POST['minmaxA']) && isset($_POST['maxminB'])) {

    $paymatrix = $_POST['pay_matrix'];
    $minmaxA = $_POST['minmaxA'];
    $maxminB = $_POST['maxminB'];
    $n = $_POST['n'];
    $m = $_POST['m'];
    

    echo json_encode($paymatrix[1][1]);
    exit;
}
   



 ?>