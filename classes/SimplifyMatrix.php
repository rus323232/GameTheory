<?php
/**
 * 
 */
class SimplifyMatrix {
    private $pay_matrix = array();
    
    function __construct($argument) {
        $this->pay_matrix = $argument;
        //echo "Экземпляр создан <br />";
        //$this->pretty_array($argument);
        if (gettype($argument) != 'array') {
            //echo "Передаваемый аргумент должен быть массивом";
            exit;
        }
    }

    function get_result () {
        $this->check_rows();
        $this->check_cols();
        
        return $this->pay_matrix;
    }

    function check_rows() {
        
        $matrix     = $this->pay_matrix;
        $gamer_type = 'A';
        
        $matrix = $this->simplify_pay_matrix($matrix, $gamer_type);
        
        //$this->pretty_array($matrix);
        
        $this->pay_matrix = $matrix;
        
        
        
    }
    
    function check_cols() {
        
        $matrix       = $this->pay_matrix;
        $trans_matrix = array();
        $gamer_type   = 'B';
        
        //транспонировать матрицу для проверки по столбцам
        for ($i = 0; $i < count($matrix[0]); $i++) {
            $trans_matrix[$i] = array();
            for ($j = 0; $j < count($matrix); $j++) {
                $trans_matrix[$i][$j] = $matrix[$j][$i];
            }
        }
        //print_r($trans_matrix);
        //echo "<br>";
        //$this->pretty_array($trans_matrix);

        //упростить
        $trans_matrix = $this->simplify_pay_matrix($trans_matrix, $gamer_type);
        
        //перевернуть обратно
        for ($i = 0; $i < count($trans_matrix[$i]); $i++) {
            $matrix[$i] = array();
            for ($j = 0; $j < count($trans_matrix); $j++) {
                $matrix[$i][$j] = $trans_matrix[$j][$i];
            }
        }
        
        //echo "<br>";
        //echo "Упростили по колонкам и возвратили в исходное состояние<br>";
        //$this->pretty_array($matrix);
        
        $this->pay_matrix = $matrix;
    }
    
    private function simplify_pay_matrix($pay_matrix, $gamer_type) {
        
        $gamer_type = strtoupper($gamer_type);
        
        //упрощать матрицу до размерности 2 x 2
        if (count($pay_matrix) === 2 || count($pay_matrix[$i]) === 2) {
            //echo "<br>Готовый вариант <br>";
            //$this->pretty_array($pay_matrix, $gamer_type);
            return $pay_matrix;
        }
        
        //убираем доминирующие строки
        for ($k = 0; $k < count($pay_matrix) - 1; $k++) {
            
            for ($i = $k + 1; $i < count($pay_matrix); $i++) {
                
                for ($j = 0; $j < count($pay_matrix[$i]); $j++) {
                    
                    if ($gamer_type === 'B') {
                        $compare_cache[$j]         = $pay_matrix[$k][$j] >= $pay_matrix[$i][$j];
                        $compare_cache_reverse[$j] = $pay_matrix[$i][$j] >= $pay_matrix[$k][$j];
                    }
                    if ($gamer_type === 'A') {
                        $compare_cache[$j]         = $pay_matrix[$k][$j] <= $pay_matrix[$i][$j];
                        $compare_cache_reverse[$j] = $pay_matrix[$i][$j] <= $pay_matrix[$k][$j];
                    }
                    
                    //echo "<br>". $pay_matrix[$k][$j]." >= ".$pay_matrix[$i][$j]." номер массива = ".$i;
                    
                }
                
                $compare_cache         = array_unique($compare_cache);
                $compare_cache         = array_values($compare_cache);
                $compare_cache_reverse = array_unique($compare_cache_reverse);
                $compare_cache_reverse = array_values($compare_cache_reverse);
                //echo "<br>Кеш с результатами сравнения '<=' <br>";
                //var_dump($compare_cache_reverse);
                //echo "<br>Кеш с результатами сравнения '>=' <br>";
                //var_dump($compare_cache);
                
                if (!isset($compare_cache[1]) && ($compare_cache[0] != false)) {
                    
                    unset($pay_matrix[$k]);
                    $pay_matrix = array_values($pay_matrix);
                    
                    //echo "<br />Array".$k." Deleted";
                    //echo "Состояние массива <br>";
                    //print_r($pay_matrix);
                    //$this->pretty_array($pay_matrix);
                    $result = $this->simplify_pay_matrix($pay_matrix, $gamer_type);
                    
                    return $result;
                }
                
                if (!isset($compare_cache_reverse[1]) && ($compare_cache_reverse[0] != false)) {
                    
                    unset($pay_matrix[$i]);
                    $pay_matrix = array_values($pay_matrix);
                    
                    //echo "<br />Array".$i." Deleted";
                    // echo "Состояние массива <br>";
                    //print_r($pay_matrix);
                    //$this->pretty_array($pay_matrix);
                    $result = $this->simplify_pay_matrix($pay_matrix, $gamer_type);
                    return $result;
                }
                
            }
        }
        
    }
    
    private function pretty_array($arr) {
        echo "<br>";
        for ($i = 0; $i < count($arr); $i++) {
            echo "<br>";
            for ($j = 0; $j < count($arr[$i]); $j++) {
                echo $arr[$i][$j] . "       ";
            }
        }
    }
    
}

/*$arr1 = array(
    '0' => array(
        '0' => 7,
        '1' => 6,
        '2' => 0
    ),
    '1' => array(
        '0' => 4,
        '1' => 1,
        '2' => 0
    ),
    '2' => array(
        '0' => 4,
        '1' => 1,
        '2' => 2
    )
);

$arr = array(
    '0' => array(
        '0' => 5,
        '1' => 6,
        '2' => 5,
        '3' => 7,
        '4' => 5
    ),
    '1' => array(
        '0' => 9,
        '1' => 8,
        '2' => 6,
        '3' => 8,
        '4' => 6
    ),
    '2' => array(
        '0' => 12,
        '1' => 8,
        '2' => 10,
        '3' => 12,
        '4' => 10
    ),
    '3' => array(
        '0' => 6,
        '1' => 7,
        '2' => 5,
        '3' => 6,
        '4' => 5
    ),
    '4' => array(
        '0' => 9,
        '1' => 10,
        '2' => 10,
        '3' => 8,
        '4' => 10
    )
);
$val = 2;
$ex  = new SimplifyMatrix($arr);
$ex->check_rows();
$ex->check_cols();*/




?>