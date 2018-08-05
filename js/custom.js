$(document).ready(function(){
    $( '#search-db-btn' ).click(function () {
        var formData = { search: $('#search-text').val() };
        var route = '/request_dataset/index.php';
        ajaxRequest(route, formData);
    });

    $( '#search-employee-btn' ).click(function () {
        var formData = {search: $( '#search-employee-text' ).val()};
        $('#result-emp, #employee-detail, #error').html('');
        $('.preloader').removeClass('hidden');

        $.ajax({
            type: 'post',
            url: './request_employees/index.php',
            data: formData,
            success: function(data) {
                var i = 1, obj = JSON.parse(data);

                if (obj.emp_row.length > 0) {
                    $('#employee-detail').html(
                        'Сотрудник: '
                        + '<strong>' + obj['emp_row'][0].first_name
                        + ' '
                        + obj['emp_row'][0].last_name
                        + '</strong> '
                    );
                }

                if ((obj.recCount > 0) && (obj.rows.length > 0)) {
                    $('#employee-detail').append('<hr>');

                    while (i < obj.rows.length) {
                        $('#result-emp').append('<tr><td>'
                            + 'В период c '
                            + obj['rows'][i].from_date
                            + ' по '
                            + obj['rows'][i].to_date
                            + ' зарплата у сотрудника составила: <i>'
                            + obj['rows'][i].salary
                            + ' руб.</i> '
                            + '['
                            + ' работал в отделе '
                            + '<i>'
                            + obj['rows'][i].dept_name
                            + '</i>'
                            + ' на должности '
                            + '<i>'
                            + obj['rows'][i].title
                            + '</i>'
                            + ']'
                            + '</td></tr>')
                        i++;
                    }
                } else {
                    $( '#error' ).append( '<div class="alert alert-danger">' + obj.error + '</div>' );
                }

                $( '#query' ).append( obj.query );
                $( '.preloader' ).addClass( 'hidden' );
            }
        });
    });


    $( '#result' ).on("click", "button", function() {
        window.location.href = "http://phpsmart.org/employees?emp_no=" + $( this ).attr( 'emp-no' );
    });
});

var ajaxForDinamicCreateElement = function ( el ) {
        var data_to = 100;
        var formData = { search: $( '#search-text' ).val(), data_from: $( el ).attr( 'data-from' ), data_to: data_to };

        ajaxRequest( './request_dataset/index.php', formData );
}

var ajaxRequest = function ( route, formData ) {
    $( '#set_count, #result, #bracket, #data-show, #execute-time, #error' ).html('');
    $( '.preloader' ).removeClass( 'hidden' );

    $.ajax({
        type: 'post',
        url: route,
        data: formData,
        success: function( data ) {
            var i = 0, obj = JSON.parse( data ), data_from = obj.data_from, data_to = obj.data_to, from = 1, to = 0;

            if (typeof obj.rec_count == "undefined") {
                $( '#error' ).append( 'Неверно переданный параметр. <hr>' );
                $( '.preloader' ).addClass( 'hidden' );
                return;
            }

            $( '#set_count' ).html('Количество записей по запросу: ' + obj.rec_count);
            $( '#execute-time' ).append('Время выполнения запроса: ' + obj.time_execute + ' сек.');

            if (obj.rec_count > 0) {
                while (i < obj.rows.length) {
                    $( '#result' ).append( '<tr><td>'+ '<button id="emp-no" emp-no="'+obj['rows'][i].emp_no+'" class="btn btn-link employee-detail">'+obj['rows'][i].emp_no+'</button></td><td>'+obj['rows'][i].dept_name+' </td><td>'+obj['rows'][i].first_name+'</td><td>'+obj['rows'][i].last_name+'</td><td>'+obj['rows'][i].title+'</td></tr>');
                    i++;
                }
            
                for ( i = 1; i <= obj.page_count; i++ ) {
                    to = obj.records*i;

                    if ( from == data_from ) {
                        $( '#bracket' ).append( '<button onclick="ajaxForDinamicCreateElement(this)" class="btn btn-link pdng-2 f-bold" data-from="' + from + '" data-to="' + to + '">[' + from + '-' + to + ']</button>' );
                        from += obj.records;
                        continue;
                    }
                    
                    $( '#bracket' ).append( '<button onclick="ajaxForDinamicCreateElement(this)" class="btn btn-link pdng-2" data-from="' + from + '" data-to="' + to + '">[' + from + '-' + to + ']</button>' );
                    from += obj.records;
                }
            
                to = 0;
                to += from;
                to += obj.modulo - 1;
                
                $( '#bracket' ).append( '<button onclick="ajaxForDinamicCreateElement(this)" class="btn btn-link pdng-2" data-from="' + from + '" data-to="' + obj.records*i + '">[' + from + '-' + to + ']</button>' );
                $( '#bracket' ).append( '<div>&nbsp;</div>');
                $( '#data-show' ).append( 'Показано записей: <span id="data-to">' + data_to + '</span>' );
                $( '#data-show' ).append( '<hr />' );
            }

            $( '#query' ).append( obj.query );
            $( '.preloader' ).addClass( 'hidden' );
        }
    });
}