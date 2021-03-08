
jQuery(document).ready(function($) {

        // Ввод в глобальный поиск

        $("input[name='main_search']").bind('input', function() {

            var text_input = $(this).val();
            // Анимация иконки поиска
            if (text_input.length > 0) {
                $(".all_icon_search").addClass('active');
            }else{
                $(".all_icon_search").removeClass('active');
            }
        });

        $("img[name='clean_big_search']").click(function() {
            $("input[name='main_search']").val("");
            $(".all_icon_search").removeClass('active');
        });

        // Отображение даты и времени в шапке

        var monthNames = [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ]; 
        var newDate = new Date();
        newDate.setDate(newDate.getUTCDate());
        $('#date').html(newDate.getUTCDate() + ' ' + monthNames[newDate.getUTCMonth()]);
 
        setInterval( function() {
            var minutes = new Date().getUTCMinutes();
            $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
        },1000);
 
        setInterval( function() {
            var hours = new Date().getUTCHours();
            $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
        }, 1000);	


});