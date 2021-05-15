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

});

