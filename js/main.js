(function() {

    var tableRows, tableColumns, _payMatrix, _minmaxA, _maxminB;
    var tableComplete = false;

    //Вывод формы для ввода платежной матрицы
    $('.form-but').click(function(event) {
        tableComplete = buildTable();
        inputFilter();
    });
    //кнопка найти решение
    $('.shape_matrix_button').click(function(event) {
        calculate();
    });
    
    //фильтрация ввода данных
    function inputFilter () {
        $('.pay-matrix').keyup(function(event) {
        var reg = /[^\d\.-]/g;
           if (this.value .search(reg) != -1){
             alert('Принимается только числовой тип данных');
             this.value = '';
           }
       });
    }
    
    //построение формы ввода матрицы
    function buildTable () {
       var i, j;

       $('.pay_matrix').empty();

       tableRows = parseInt($('.rows').val(), 10);
       tableColumns = parseInt($('.columns').val(), 10);

       for (i = 0; i < tableRows; i++) {
         $('.pay_matrix').append('<tr id="' + i + '">');

         for (j = 0; j < tableColumns; j++) {
             $('#' + i + '').append('<td><input class="pay-matrix" maxlength="11" value="' + (i + 1) + (j + 1) + '" id="elem' + i + '-' + j + '"type="text"></td>');
         }
         $('.pay_matrix').append('</tr>');
       }
       $('.shape_matrix_button').css('visibility', 'visible');

       return true;

    }
    
    //произвести расчеты
    function calculate () {
      var i = tableRows,
            j = tableColumns;
        // Создать многомерный массив
        var pay_matrix = new Array(i); // В таблице i строк

        for ( var i = 0; i < pay_matrix.length; i++) {
            pay_matrix[i] = new Array(j); // В каждой строке j столбцов
        }
        // Инициализировать массив и вывести на консоль
        for (var row = 0, str = ''; row < pay_matrix.length; row++) {
            for (var col = 0; col < pay_matrix[row].length; col++) {
                pay_matrix[row][col] = $('#elem' + row + '-' + col).val();;
                str += pay_matrix[row][col] + '  ';
            }
            console.log(str + '\n');
            str = '';
        }
        //отправить запрос на сервер если седловая точка не найдена
        if (findSaddlePoint(pay_matrix) === null) {
           resultOut();
        }

    }
    //поиск седловой точки
    function findSaddlePoint(arr) {
        var pay_matrix = arr;
        var rows = [],
            columns = [],
            result = [],
            minRow = [],
            maxColumn = [],
            minmaxA, maxminB, saddlePoint = null;

        //формируем массив из строк находим минимумы
        for (var i = 0; i < pay_matrix.length; i++) {
            rows[i] = pay_matrix[i];
            minRow[i] = Math.min.apply(null, rows[i]);
        }

        //формируем массив из столбцов находим максимумы
        for (var i = 0; i < tableColumns; i++) {
            columns[i] = new Array();
            for (var j = 0; j < tableRows; j++) {
                columns[i][j] = pay_matrix[j][i];
            }
            maxColumn[i] = Math.max.apply(null, columns[i]);
        }

        minmaxA = Math.max.apply(null, minRow);
        maxminB = Math.min.apply(null, maxColumn);

        $('.result').empty();
        $('.result_shuffle_strategy').empty();
        $('.result').append('<p>Гарантированный выигрыш, определяемый нижней ценой игры a = max(ai) = ' + minmaxA + '</p><p>Верхняя цена игры b = min(bj) = ' + maxminB + '.</p>');

        if (minmaxA === maxminB) {
            saddlePoint = minmaxA;
            $('.result').append('<p>Так, как a = b, решением будет пара стратегий со значением ( ' + saddlePoint + ' ), а цена игры v будет соответственно равна = ' + minmaxA + '</p>');
        } else {
            _payMatrix = pay_matrix; //присваиваем получившиеся значения глобальным переменным для передачи на сервер 
            _minmaxA = minmaxA;
            _maxminB = maxminB;
        }


        _payMatrix = pay_matrix;
        _minmaxA = minmaxA;
        _maxminB = maxminB;

        return saddlePoint;

    }
    
    //функция формирует AJAX запрос на сервер и возвращает ответ
    function sendDataOnServer() {
       var queryResult, value;

       queryResult = $.ajax({
                url: 'handler.php',
                type: 'POST',
                async: false,
                dataType: 'JSON',
                data: {
                    pay_matrix: _payMatrix,
                    minmaxA: _minmaxA,
                    maxminB: _maxminB,
                    n: tableRows,
                    m: tableColumns

                },
                success: function(data) {

                }
       }).responseText;

       value = $.parseJSON(queryResult);

       return value;
    }
    
    //вывод результатов пользователю
    function resultOut () {
        var data = sendDataOnServer(),
            outContainer = $('.result_shuffle_strategy');
        var text1 = "Находим решение игры в смешанных стратегиях. Объясняется это тем, что игроки не могут объявить противнику свои чистые стратегии: им следует скрывать свои действия.";
            text1+= "Игру можно решить, если позволить игрокам выбирать свои стратегии случайным образом (смешивать чистые стратегии).";
            text1+="Так как игроки выбирают свои чистые стратегии случайным образом, то выигрыш игрока I будет случайной величиной. В этом случае игрок I должен выбрать свои смешанные стратегии так, чтобы получить максимальный средний выигрыш.";
            text1+="Аналогично, игрок II должен выбрать свои смешанные стратегии так, чтобы минимизировать математическое ожидание игрока I.  ";
        var text2 ="<p>Составив систему уравнений вида <br> X11P1+X12P2+X13P3+...+X1nPn = Y <br> X21P1+X22P2+X23P3+...+X2nPn = Y<br>";
            text2+="..................................................<br> Xn1P1+Xn2P2+Xn3P3+...+XnnPn = Y <br> P1+P2+P3+...+Pn = 1 <br> И решив ее методом Гаусса получим</p>";
        var gamerAanswer = buildAnswer(data.A);
        var gamerBanswer = buildAnswer(data.B);
        var simple_matrix = simple_matrix_out(data);

           outContainer.empty();

           outContainer.append('Что свидетельствует об отсутствии седловой точки, так как a ≠ b, тогда цена игры находится в пределах '+_minmaxA+'≤ y ≤ '+_maxminB+'');   
           outContainer.append(text1); 
           outContainer.append('<p>По возможности убрав все доминирующие строки получим матрицу: </p>');
           outContainer.append(simple_matrix);
           outContainer.append(text2);
           outContainer.append('<p>Для игрока A: </p>');
           outContainer.append(gamerAanswer);
           outContainer.append('<p>Для игрока B: </p>');
           outContainer.append(gamerBanswer);
    }
    
    //получает ответ с сервера, выводит решение системы уравненй
    function buildAnswer (data) {

        var answerText ='', answerText1 ='', ansObj = data, answerText2 = 'Оптимальная смешанная стратегия = (';

        if (ansObj[0] === 'М') {
             alert('Матрица сингулярна необходимо применить симплекс метод(в разработке)');
             return;
        }

          for (var i = 0; i < ansObj[0].length; i++) {

                if (i == (ansObj[0].length)-1) {
                    answerText1 += "Y = "+ansObj[0][i]+"<br />";
                    answerText2 = answerText2.slice(0, -2);
                    answerText2 += ")";
                    break;
                };

             answerText1 += "P"+(i+1)+" = "+ansObj[0][i]+"<br />";
             answerText2 += ansObj[0][i]+", ";
                
          };

          answerText = answerText1 + answerText2;

     

    return answerText;
    }
    
    //получает ответ с сервера, выводит упрощенную платежную матрицу
    function simple_matrix_out (arr) {
        var matrix = arr.simple_matrix, out = '<table class="simple_matrix">';
        for (var i = 0; i < matrix.length; i++) {
               out += "<tr>";
            for (var j = 0; j < matrix[i].length; j++) {
                out += "<td>"+matrix[i][j]+"</td>";
            };
               out +="</tr>";
        };
        out += "</table>";

    return out;
    }

})();
