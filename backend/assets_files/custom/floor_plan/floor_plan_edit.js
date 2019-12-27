$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $inputImage = $("#floorplanform-file"),
        $container = $('#image-div'),
        complex_id = $('#floorplanform-complex_id').val(),
        $corpus = $('#floorplanform-corpus_num'),
        $section = $('#floorplanform-section_num');

    //$container.fadeOut(300);
    if (window.FileReader) {
        $inputImage.change(function() {
            var fileReader = new FileReader(),
                files = this.files,
                file;

            if (!files.length) {
                return;
            }
            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $container.html('<img src="' + this.result + '" height="387">').fadeIn(300);
                };

            } else {
                alert("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
    }

    $corpus.on('change', function(e) {
        var url = $(this).data('url'),
            val = $(this).find(':selected').val();

        $.post({
            url: url,
            data: {value: val, complex_id: complex_id, _csrf: csrfToken},
            success: function (data) {
                if (data.success) {
                    data.section && $section.empty().append(data.section).select2();
                }
            }
        });
    });

});