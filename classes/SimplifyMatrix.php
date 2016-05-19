<?php
     /**
     * 
     */
     class SimplifyMatrix
     {
     	private $pay_matrix = array();
     	
     	function __construct($argument)
     	{
     	   $this->pay_matrix = $argument;
     	   echo "Экземпляр создан <br />";
     	   if (gettype($argument) != 'array')
     	   {
     	   	echo "Передаваемый аргумент должен быть массивом";
     	   	exit;
     	   }
     	}

     	function check_rows()
     	{
     		$matrix = $this->pay_matrix;
     		$cache = array();

     		for ($i=0; isset($matrix[$i]); $i++) {

                for ($j=0; $j < count($matrix[$i]); $j++) { 

                	$cache[$j] = ($matrix[$i][$j] <= $matrix[$i+1][$j]);

                	//echo "<br/>".$matrix[$i][$j]." <= ".$matrix[$i+1][$j]. "<br />";
                	//var_dump($cache);
                }

                 $res = array_unique($cache);
                 $res = array_values($res);
                 //var_dump($cache);

                 if (!isset($res[1]) && $res[0] != false) {
                    unset($matrix[$i]);
                    //echo "<br />Array".$i." Deleted";
                 }
     		}
           $matrix = array_values($matrix);
     	   print_r($matrix);
     	   echo "<br />
     	   <br />
     	   <br />
     	   <br />
     	   <br />
     	   <br />";

     	   $this->check_cols($matrix);
     	}

     function check_cols($arr)
     { 
     	$matrix = $arr;
     	$trans_matrix = array();


        for ($i = 0; $i < count($matrix[0]); $i++) 
        {
          $trans_matrix[$i] = array();
            for  ($j = 0; $j < count($matrix); $j++) 
            {
               $trans_matrix[$i][$j] = $matrix[$j][$i];
             }

        	for ($i=0; isset($trans_matrix); $i++) {

                for ($j=0; $j < count($matrix[$i]); $j++) { 

                	$cache[$j] = ($matrix[$i][$j] <= $matrix[$i+1][$j]);

                	//echo "<br/>".$matrix[$i][$j]." <= ".$matrix[$i+1][$j]. "<br />";
                	//var_dump($cache);
                }

                 $res = array_unique($cache);
                 $res = array_values($res);
                 //var_dump($cache);

                 if (!isset($res[1]) && $res[0] != false) {
                    unset($matrix[$i]);
                    //echo "<br />Array".$i." Deleted";
                 }
     		}
      }

           $trans_matrix = array_values($trans_matrix);
           $array= array_map("unserialize", array_unique( array_map("serialize", $trans_matrix) ));

        foreach ($array as $rows) {
        	foreach ($val as $cols) {
        		
        	}
        }

     	   print_r($array);  
     }
}

    $arr1 = array ('0' => array(
     	      '0'=> 7,
     	      '1'=> 6,
     	      '2'=> 0),
          '1' => array(
      	      '0'=> 4,
     	      '1'=> 1,
     	      '2'=> 0),
          '2' => array(
     	      '0'=> 4,
     	      '1'=> 1,
     	      '2'=> 2),
          );

     $arr = array
     ('0' => array(
     	      '0'=> 5,
     	      '1'=> 6,
     	      '2'=> 5,
     	      '3'=> 7,
     	      '4'=> 5),
      '1' => array(
      	      '0'=> 9,
     	      '1'=> 8,
     	      '2'=> 6,
     	      '3'=> 8,
     	      '4'=> 6),
      '2' => array(
     	      '0'=> 12,
     	      '1'=> 8,
     	      '2'=> 10,
     	      '3'=> 12,
     	      '4'=> 10),
      '3' => array(
     	      '0'=> 6,
     	      '1'=> 7,
     	      '2'=> 5,
     	      '3'=> 6,
     	      '4'=> 5),
      '4' => array(
     	      '0'=> 9,
     	      '1'=> 10,
     	      '2'=> 10,
     	      '3'=> 8,
     	      '4'=> 10),
      );
     $val = 2;
     $ex = new SimplifyMatrix($arr);
     $ex->check_rows();
   



 ?>