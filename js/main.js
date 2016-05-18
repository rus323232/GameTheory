(function() {

    var tableRows, tableColumns, _payMatrix, _transpayMatrix, _minmaxA, _maxminB;

    $('.build_matrix_button').click(function(event) {
        buildTable();
    });

    $('.shape_matrix_button').click(function(event) {
        calculate();
    });


    

    function buildTable () {
       var i, j;

       $('.pay_matrix').empty();

       tableRows = parseInt($('.rows').val(), 10);
       tableColumns = parseInt($('.columns').val(), 10);

       for (i = 0; i < tableRows; i++) {
         $('.pay_matrix').append('<tr id="' + i + '">');

         for (j = 0; j < tableColumns; j++) {
             $('#' + i + '').append('<td><input value="' + (i + 1) + (j + 1) + '" id="elem' + i + '-' + j + '"type="number"></td>');
         };
         $('.pay_matrix').append('</tr>');
       };
       $('.shape_matrix_button').css('visibility', 'visible');

    }

    function calculate () {
      var i = tableRows,
          j = tableColumns;
        // Создать многомерный массив
        var pay_matrix = new Array(i); // В таблице i строк

        for (var i = 0; i < pay_matrix.length; i++)
            pay_matrix[i] = new Array(j); // В каждой строке j столбцов

        // Инициализировать массив и вывести на консоль
        for (var row = 0, str = ''; row < pay_matrix.length; row++) {
            for (var col = 0; col < pay_matrix[row].length; col++) {
                pay_matrix[row][col] = $('#elem' + row + '-' + col).val();;
                str += pay_matrix[row][col] + '  ';
            }
            console.log(str + '\n');
            str = '';
        }

        if (findSaddlePoint(pay_matrix) === null) {
           var a = sendDataOnServer();
           console.log(a);
           resultOut();
        };

    }

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
        };

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
        $('.result').append('<p>Гарантированный выигрыш, определяемый нижней ценой игры a = max(ai) = ' + minmaxA + '</p><p>Верхняя цена игры b = min(bj) = ' + maxminB + '.</p>');

        if (minmaxA === maxminB) {
            saddlePoint = minmaxA;
            $('.result').append('<p>Так, как a = b, решением будет пара стратегий со значением ( ' + saddlePoint + ' ), а цена игры v будет соответственно равна = ' + minmaxA + '</p>');
        } else {
            _payMatrix = pay_matrix;
            _transpayMatrix = columns; //присваиваем получившиеся значения глобальным переменным для передачи на сервер 
            _minmaxA = minmaxA;
            _maxminB = maxminB;
        }


        _payMatrix = pay_matrix;
        _minmaxA = minmaxA;
        _maxminB = maxminB;

        return saddlePoint;

    }

    function sendDataOnServer() {
       var queryResult, value;

       queryResult = $.ajax({
                url: 'handler.php',
                type: 'POST',
                async: false,
                dataType: 'JSON',
                data: {
                    pay_matrix: _payMatrix,
                    trans_matrix: _transpayMatrix,
                    minmaxA: _minmaxA,
                    maxminB: _maxminB,
                    n: tableRows,
                    m: tableColumns

                },
                success: function(data) {
                    alert('Answers taken');
                }
       }).responseText;

       value = $.parseJSON(queryResult);

       return value;
    }

    function resultOut () {
        var data = sendDataOnServer(),
            outContainer = $('.result_shuffle_strategy');
        var text1 = "Находим решение игры в смешанных стратегиях. Объясняется это тем, что игроки не могут объявить противнику свои чистые стратегии: им следует скрывать свои действия.";
            text1+= "Игру можно решить, если позволить игрокам выбирать свои стратегии случайным образом (смешивать чистые стратегии).";
            text1+="Так как игроки выбирают свои чистые стратегии случайным образом, то выигрыш игрока I будет случайной величиной. В этом случае игрок I должен выбрать свои смешанные стратегии так, чтобы получить максимальный средний выигрыш.";
            text1+="Аналогично, игрок II должен выбрать свои смешанные стратегии так, чтобы минимизировать математическое ожидание игрока I.  ";
        var text2 ="<p>Решив систему уравнений получим ответ</p>"
        var gamerAanswer = buildAnswer(data.A);
        var gamerBanswer = buildAnswer(data.B);

           outContainer.empty();

           outContainer.append('Что свидетельствует об отсутствии седловой точки, так как a ≠ b, тогда цена игры находится в пределах '+_minmaxA+'≤ y ≤ '+_maxminB+'');   
           outContainer.append(text1); 
           outContainer.append(text2);
           outContainer.append('<p>Для игрока A: </p>');
           outContainer.append(gamerAanswer);
           outContainer.append('<p>Для игрока B: </p>');
           outContainer.append(gamerBanswer);
    }

    function buildAnswer (data) {

        var answerText ='', ansObj = data;

          for (var i = 0; i < ansObj[0].length; i++) {

                if (i == (ansObj[0].length)-1) {
                    answerText += "Y"+(i+1)+" = "+ansObj[0][i]+"<br />";
                    break;
                };

             answerText += "P"+(i+1)+" = "+ansObj[0][i]+"<br />";
                
          };

    return answerText;
    };



})();
