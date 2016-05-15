<?php 

    if(isset($_POST['pay_matrix']) && isset($_POST['n']) && isset($_POST['m']) && isset($_POST['minmaxA']) && isset($_POST['maxminB'])) {

    $paymatrix = $_POST['pay_matrix'];
    $minmaxA = isset($_POST['minmaxA']);
    $maxminB = isset($_POST['maxminB']);
    $n = isset($_POST['n']);
    $m = isset($_POST['m']);
    

    echo json_encode($paymatrix[1][1]);
    exit;
}



 ?>