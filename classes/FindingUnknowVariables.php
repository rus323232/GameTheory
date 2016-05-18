<?php 


  /** Класс который считает вероятности выйгрыша для двух игроков
  *   Входящие переменные: 2 двумерных массива коэффициентов для игроков A и B соответственно(платежная матрица, транспонированная платежная матрица)
  *   Конструктор: Дополняет матрицы необходимыми коэффициентами, последующего решения системы уравнений
  *   solve_equation($a, $b): скрытый метод, решающий систему уравнений методом Гаусса $a- матрица с коэф. переменных, $b- та хрень что после знака равенства 
  *   findVar: открый метод, для выполнения всех вычилений
  *   На выходе: многомерный массив элемент [A][1] - массив значений переменных [A][2] - обратная матрица(аналогично с [B])
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


      for ($i = 0; $i < $matrix1_length ; $i++) 
      { 
       array_push($this->gamerA[$i], "-1");
       $gamerA_sum[$i] = 1;
       $this->Va[$i] = 0;

           if (($i+1) == $matrix1_length) {
              $gamerA_sum[$i+1] = 0;
              array_push($this->gamerA, $gamerA_sum);
              $this->Va[$i+1] = 1;
           }
      }

      for ($i = 0; $i < $matrix2_length ; $i++) 
      { 
        array_push($this->gamerB[$i], "-1");
        $gamerB_sum[$i] = 1;
        $this->Vb[$i] = 0;

           if (($i+1) == $matrix2_length) {
              $gamerB_sum[$i+1] = 0;
              array_push($this->gamerB, $gamerB_sum);
              $this->Vb[$i+1] = 1;
           }
      }
    }

 private function solve_equation($a, $b)
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
    return array($b, $a);
  }

    function findVar () {

      $gamerA_answer = $this->solve_equation($this->gamerA, $this->Va);
      $gamerB_answer = $this->solve_equation($this->gamerB, $this->Va);

      $answers[A] = $gamerA_answer;
      $answers[B] = $gamerB_answer;

      return $answers;
       //list(list($x, $y, $z)) = gaussj($matrix, $b);
    }

  }
?>
