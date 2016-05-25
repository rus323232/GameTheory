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

           $this->pay_matrix = $matrix;
     

     	}

     function check_cols()
     { 
     	$matrix = $this->pay_matrix;
     	$trans_matrix = array();
        $cache = array();
        $cache_reverse = array();


        //транспонировать матрицу для проверки по столбцам

           echo "<br>";
        for ($i = 0; $i < count($matrix[0]); $i++) 
        {
          $trans_matrix[$i] = array();
            for  ($j = 0; $j < count($matrix); $j++) 
            {
               $trans_matrix[$i][$j] = $matrix[$j][$i];
             }
        }
          echo "<br>";
        //print_r($trans_matrix);
           $this->pretty_array($trans_matrix);
           $this->check_colses($trans_matrix);


   
    }

     function check_colses($trans_matrix) {
           if ( count($trans_matrix) === 2 || count($trans_matrix[$i]) === 2 ) {
            echo "OK";
            print_r($trans_matrix);
            return;
           }
              //убираем доминирующие строки
      for ($k=0; $k <  count($trans_matrix); $k++) { 

         for ($i=1; $i < count($trans_matrix) ; $i++) { 
            if ($i === $k) {
                $i++;
            }
            for ($j=0; $j < count($trans_matrix[$i]); $j++) {

                   $cache[$j] = $trans_matrix[$k][$j] >= $trans_matrix[$i][$j];
                   $cache_reverse[$j] = $trans_matrix[$i][$j] >= $trans_matrix[$k][$j];
    
                   echo "<br>". $trans_matrix[$k][$j]." >= ".$trans_matrix[$i][$j]." номер массива = ".$i;

            }

                $cache = array_unique($cache);
                $cache = array_values($cache);
                echo "<br>Что там у нас в КЕШЭЭЭЭЭЭЭ <br>";
                var_dump($cache);

                 if (!isset($cache[1]) && ($cache[0] != false)) {
                    unset($trans_matrix[$k]);
                    $trans_matrix = array_values($trans_matrix);
                  
                    echo "<br />Array".$k." Deleted";

                     echo "Состояние массива <br>";
                     //print_r($trans_matrix);
                      $this->pretty_array($trans_matrix);
                      $this->check_colses($trans_matrix);
                 }

                $cache_reverse = array_unique($cache_reverse);
                $cache_reverse = array_values($cache_reverse);
                echo "<br>Что там у нас в обратном сравнении<br>";
                var_dump($cache_reverse);
               
                if (!isset($cache_reverse[1]) && ($cache_reverse[0] != false)) {
                    unset($trans_matrix[$i]);
                    $trans_matrix = array_values($trans_matrix);
                  
                    echo "<br />Array".$i." Deleted";

                     echo "Состояние массива <br>";
                     //print_r($trans_matrix);
                      $this->pretty_array($trans_matrix);
                      $this->check_colses($trans_matrix);
                 }
        }
    }

}

    function pretty_array($arr) {
    echo "<br>";
        for ($i=0; $i < count($arr); $i++) { 
            echo "<br>";
            for ($j=0; $j < count($arr[$i]) ; $j++) { 
                echo $arr[$i][$j]. "       ";
            }
        }
    }

}

    $arr1 = array
     ('0' => array(
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
     $ex->check_cols();
   



 ?>