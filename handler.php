<?php 

    if(isset($_POST['JsonData'])){
    $req = false;
    ob_start();
    echo '<pre>';
    print_r($_POST['JsonData']);
    echo '</pre>';
    $req = ob_get_contents();
    ob_end_clean();
    echo json_encode($req);
    exit;
}



 ?>