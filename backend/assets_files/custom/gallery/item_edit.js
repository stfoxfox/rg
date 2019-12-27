$(document).ready(function() {
    var $image = $("#crop_img"),
        $inputImage = $("#galleryitemform-file"),
        $container = $('#image-div'),
        $complex = $('#galleryitemform-complex_id'),
        $corpus = $('#galleryitemform-corpus_num'),
        showCoords = function(c) {
            $('#galleryitemform-x').val(c.x);
            $('#galleryitemform-y').val(c.y);
            $('#galleryitemform-h').val(c.height);
            $('#galleryitemform-w').val(c.width);
        };

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
                    $container.fadeIn(300);
                    $image.cropper({
                        aspectRatio: 16 / 9,
                        minContainerHeight: 300,
                        crop: function(data) {
                            showCoords(data);
                        }
                    }).cropper("reset", true).cropper("replace", this.result);
                };

            } else {
                alert("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
    }

    $complex.on('change', function(e) {
        var url = $(this).data('url'),
            id = $(this).find(':selected').val();
        $.post({
            url: url, data: {id: id},
            success: function (data) {
                if (data.success) {
                    $corpus.empty().append(data.options).select2();
                }
            }
        });
    });
});