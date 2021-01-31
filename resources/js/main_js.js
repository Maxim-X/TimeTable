jQuery(document).ready(function($) {

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