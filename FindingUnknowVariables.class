<?php 

  //решение системы уравнений методом Гаусса-Жордана
  /**************** 
  4x + 7y + 2z = 34 
  3x + 1y + 5z = 21 
  8x + 2y + 6z = 52 
  ****************/ 
  //$matrix[0] = array(3, 8, -1);  
  //$matrix[1] = array(7, 4, -1);  
  //$matrix[2] = array(1, 1, 0); 
  //$b[0] = 0; 
  //$b[1] = 0; 
  //$b[2] = 1; 
  //// Решаем уравнение 
  //list(list($x, $y, $z)) = gaussj($matrix, $b);
  //echo "Решение<br />"; 
  //echo "X = $x<br />"; 
  //echo "Y = $y<br />"; 
  //echo "Z = $z<br />"; 
  // Проверка 
  //echo 4 * $x + 7 * $y + 2 * $z; 
  //echo "<br>"; 
  //echo 3 * $x + 1 * $y + 5 * $z; 
  //echo "<br>"; 
  //echo 8 * $x + 2 * $y + 6 * $z;
  // Решение системы линейных уравнений
  // методом Метод Гаусса-Жордана

  /**
  * 
  */
  class FindVariables
  {
    private $gamerA;
    private $gamerB;
    private $Va;
    private $Vb;
     
    function __construct($matrix1, $matrix2)
    {
      $this->gamerA = $matrix1;
      $this->gamerB = $matrix2;
      $matrix1_length = count($matrix1);
      $matrix2_length = count($matrix2);
      $gamerA_sum;
      $gamerB_sum;


      for ($i = 0; $i < $matrix1_length ; $i++) { 
       array_push($this->gamerA[$i], "-1");
       $gamerA_sum[$i] = 1;
       $this->Va[$i] = 0;

           if (($i+1) == $matrix1_length) {
              $gamerA_sum[$i+1] = 0;
              array_push($this->gamerA, $gamerA_sum);
              $this->Va[$i+1] = 1;
           }
      }

      for ($i = 0; $i < $matrix1_length ; $i++) { 
        array_push($this->gamerB[$i], "-1");
        $gamerB_sum[$i] = 1;
        $this->Vb[$i] = 0;

           if (($i+1) == $matrix1_length) {
              $gamerB_sum[$i+1] = 0;
              array_push($this->gamerB, $gamerB_sum);
              $this->Vb[$i+1] = 1;
           }
      }
    }

  function solve_equation($a, $b)
  {
    $n = count($a);
    for($j = 0; $j < $n; $j++)
    {
      $ipiv[$j] = 0;
    }
    for($i = 0; $i < $n; $i++)
    {
      $big = 0;
      for($j = 0; $j < $n; $j++)
      {
        if($ipiv[$j] != 1)
        {
          for($k = 0; $k < $n; $k++)
          {
            if($ipiv[$k] == 0)
            {
              if(abs($a[$j][$k]) >= $big)
              {
                $big = abs($a[$j][$k]);
                $irow = $j;
                $icol = $k;
              }
            }
            else if($ipiv[$k] > 1)
            {
              return "Матрица сингулярна";
            }
          }
        }
      }
      $ipiv[$icol] = $ipiv[$icol] + 1;
      if ($irow != $icol)
      {
        for($l = 0; $l < $n; $l++)
        {
          $dum = $a[$irow][$l];
          $a[$irow][$l] = $a[$icol][$l];
          $a[$icol][$l] = $dum;
        }
        $dum = $b[$irow];
        $b[$irow] = $b[$icol];
        $b[$icol] = $dum;
      }
      $indxr[$i] = $irow;
      $indxc[$i] = $icol;
      if($a[$icol][$icol] == 0) return "Матрица сингулярна";
      $pivinv = 1 / $a[$icol][$icol];
      $a[$icol][$icol] = 1;
      for($l = 0; $l < $n; $l++) $a[$icol][$l] = $a[$icol][$l] * $pivinv;
      $b[$icol] = $b[$icol] * $pivinv;
      for($ll = 0; $ll < $n; $ll++)
      {
        if($ll != $icol)
        {
          $dum = $a[$ll][$icol];
          $a[$ll][$icol] = 0;
          for($l = 0; $l < $n; $l++)
          {
            $a[$ll][$l] = $a[$ll][$l] - $a[$icol][$l] * $dum;
          }
          $b[$ll] = $b[$ll] - $b[$icol] * $dum;
        }
      }
    }
    for($l = $n -1; $l >= 0; $l--)
    {
      if($indxr[$l] != $indxc[$l])
      {
        for($k = 1; $k < $n; $k++)
        {
          $dum = $a[$k][$indxr[$l]];
          $a[$k][$indxr[$l]] = $a[$k][$indxc[$l]];
          $a[$k][$indxc[$l]] = $dum;
        }
      }
    }
    // $b - решение уравнения
    // $a - обратная матрица
    echo "$a";
    return array($b, $a);
  }

    function findVar () {
      echo "Решим уравнение";
      echo "</br>";
      echo "</br>";
      echo json_encode($this->gamerA);
      echo "</br>";
      echo json_encode($this->Va);
      echo "</br>";
      echo json_encode($this->gamerB);
      echo "</br>";
      echo json_encode($this->Vb);
      echo "</br>";

      list(list($x, $y, $z)) = $this->solve_equation($this->gamerA, $this->Va);
      echo "Решение<br />"; 
      echo "X = $x <br />"; 
      echo "Y = $y <br />"; 
      echo "Z = $z <br />"; 

    }

  }
?>
