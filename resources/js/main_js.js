
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


        // $("div.drag_and_drop_file").Dropzone({ url: "/file/post" });

        // var previewNode = $(".list_user_files");
        // var previewTemplate = document.createElement("div");
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone('div.drag_and_drop_file', { // Make the whole body a dropzone
          url: "/assets/ajax/ajax.upload-file.php", // Set the url
          thumbnailWidth: 80,
          maxFiles: 1,
          acceptedFiles: 'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          thumbnailHeight: 80,
          parallelUploads: 20,
          previewTemplate: previewTemplate,
          // autoQueue: false, // Make sure the files aren't queued until manually added
          previewsContainer: ".file-upload-list", // Define the container to display the previews
          // clickable: "#upload_but" // Define the element that should be used as click trigger to select files.
        });

        // Dropzone.options.myAwesomeDropzone = {
        //   init: function() {
        //     this.on("addedfile", function(file) { alert("Added file."); });
        //   }
        // };

        // myDropzone.on("addedfile", function(file) {
        //     console.log("1");
        //   // Hookup the start button
        //   file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        // });

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
  console.log(progress);
});

myDropzone.on('canceled', function(file) {
    console.log("canceled");
});
myDropzone.on('error', function(file) {
    file.previewElement.classList.add('error');
    console.log(file.previewElement);
    setTimeout(() => file.previewElement.remove(), 3000);
});
// myDropzone.on("queuecomplete", function(progress) {
//   document.querySelector("#total-progress").style.opacity = "0";
// });

// myDropzone.on("sending", function(file) {
//   // Show the total progress bar when upload starts
//   document.querySelector("#total-progress").style.opacity = "1";
//   // And disable the start button
//   file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
// });

// // Hide the total progress bar when nothing's uploading anymore
// myDropzone.on("queuecomplete", function(progress) {
//   document.querySelector("#total-progress").style.opacity = "0";
// });

// // Setup the buttons for all transfers
// // The "add files" button doesn't need to be setup because the config
// // `clickable` has already been specified.
// document.querySelector("#actions .start").onclick = function() {
//   myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
// };
// document.querySelector("#actions .cancel").onclick = function() {
//   myDropzone.removeAllFiles(true);
// };


});