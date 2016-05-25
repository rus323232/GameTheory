<?php 

    include_once 'classes/FindingUnknowVariables.php';
    include_once 'classes/SimplifyMatrix.php';


    if (isset($_POST['pay_matrix']) && isset($_POST['n']) && isset($_POST['m']) && isset($_POST['minmaxA']) && isset($_POST['maxminB'])) {

    $paymatrix = $_POST['pay_matrix'];
    $minmaxA = $_POST['minmaxA'];
    $maxminB = $_POST['maxminB'];
    //$trans_matrix = $_POST['trans_matrix'];
    $n = $_POST['n'];
    $m = $_POST['m'];

    $SimplifyMatrix = new SimplifyMatrix ($paymatrix);
    $simpleMatrix = $SimplifyMatrix->get_result();

    $FindVariables= new FindVariables($simpleMatrix);
    $answer = $FindVariables->findVar();
    $answer['simple_matrix'] = $simpleMatrix;

    $answer = json_encode($answer);

   
    echo $answer;
    exit;
}
   
 ?>