
(function () {

	var tableRows, tableColumns, _payMatrix, _minmaxA, _maxminB;
    
    $('.build_matrix_button').click(function(event) {

    	$('.pay_matrix').empty();

    	var i,j;

    	tableRows = parseInt( $('.rows').val(), 10);
    	tableColumns = parseInt( $('.columns').val(), 10);

         for ( i = 0; i < tableRows; i++) {
            $('.pay_matrix').append('<tr id="'+i+'">');

              for (j = 0; j < tableColumns; j++) {
    		       $('#'+i+'').append('<td><input value="'+(i+1)+(j+1)+'" id="elem' +i+ '-'+j+'"type="number"></td>');
    	       };
            $('.pay_matrix').append('</tr>');
    	 };
     $('.shape_matrix_button').css('visibility', 'visible');
    });

    $('.shape_matrix_button').click(function(event) {
    	var i = tableRows, j= tableColumns;
    	// Создать многомерный массив
        var pay_matrix = new Array(i);		// В таблице i строк

             for(var i = 0; i < pay_matrix.length; i++)
	             pay_matrix[i] = new Array(j);		// В каждой строке j столбцов

             // Инициализировать массив и вывести на консоль
             for (var row = 0, str = ''; row < pay_matrix.length; row++) {
	             for(var col = 0; col < pay_matrix[row].length; col++) {
		             pay_matrix[row][col] = $('#elem'+row+'-'+col).val();;
		             str += pay_matrix[row][col] + '  ';
	             }
	             console.log(str + '\n');
	             str = '';
             }

             if (findSaddlePoint(pay_matrix) === null){
             	sendDataOnServer();
             };

         
    });

    function findSaddlePoint (arr) {
    	var pay_matrix = arr;
    	var rows = [], columns = [],result = [], minRow = [], maxColumn = [], minmaxA, maxminB, saddlePoint = null;

    	//формируем массив из строк находим минимумы
    	for (var i = 0; i < pay_matrix.length; i++) {
    		rows[i] = pay_matrix[i];
            minRow[i] = Math.min.apply(null, rows[i]);
    	};

    	//формируем массив из столбцов находим максимумы
        for (var i = 0; i < tableColumns; i++) {
        	columns[i] = new Array();
        	for (var j = 0; j < tableRows; j++) {
        		columns[i][j] = pay_matrix [j][i];
        	}
          maxColumn[i] = Math.max.apply(null, columns[i]);
        }

        minmaxA = Math.max.apply(null, minRow);
        maxminB = Math.min.apply(null, maxColumn);
           
           $('.result').empty();
           $('.result').append('<p>Гарантированный выигрыш, определяемый нижней ценой игры a = max(ai) = '+minmaxA+'</p><p>Верхняя цена игры b = min(bj) = '+maxminB+'.</p>');

        if (minmaxA === maxminB) {
        	saddlePoint = minmaxA;
        	$('.result').append('<p>Так, как a = b, решением будет пара стратегий со значением ( '+saddlePoint+' ), а цена игры v будет соответственно равна = '+minmaxA+'</p>');
        }
        else {
        	  _payMatrix = pay_matrix;  //присваиваем получившиеся значения глобальным переменным для передачи на сервер 
              _minmaxA = minmaxA;
              _maxminB = maxminB;
        }

        console.log(columns);
        console.log(minRow);
        console.log(maxColumn);
        console.log(minmaxA);
        console.log(maxminB);


       _payMatrix = pay_matrix;
       _minmaxA = minmaxA;
       _maxminB = maxminB;

     return saddlePoint;

    }

    function sendDataOnServer () {
   

    	$.ajax({
    		url: 'handler.php',
    		type: 'POST',
    		dataType: 'JSON',
    		data: {
    			pay_matrix: _payMatrix,
          minmaxA: _minmaxA,
          maxminB: _maxminB,
          n: tableRows,
          m: tableColumns

    		},
        success: function (data) {
          console.log(data);
        }
    	})
    	
    	
    }

})();