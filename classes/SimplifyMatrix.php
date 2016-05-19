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
     		$cache = false;

     		for ($i=1; $i < count($matrix); $i++) { 
                for ($j=0; $j < count($matrix[$i]); $j++) { 
                	$cache = ($matrix[$i][$j] >= $matrix[$i-1][$j]);
                }

                if ($cache == true) {
                	//print_r($matrix[$i]);
                	unset($matrix[$i-1]);
                }
     		}

     		print_r($matrix);
     	}
     }

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