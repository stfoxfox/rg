$(document).ready(function(e) {
    var $image = $("#crop_img"),
        $inputImage = $("#docversionform-file"),
        $container = $('#image-div'),
        $content = $('#content'),
        $preview = $('#preview');

    $container.fadeOut(300);
    if (window.FileReader) {
        $inputImage.change(function() {
            var fileReader = new FileReader(),
                files = this.files,
                file;

            if (!files.length) {
                return;
            }
            file = files[0];
            $preview.find('embed').remove();

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $container.fadeIn(300);
                    $content.empty().fadeOut(300);
                    $image.cropper({
                        aspectRatio: 16 / 9,
                        minContainerHeight: 300,
                        crop: function(data) {
                            showCoords(data);
                        }
                    }).cropper("reset", true).cropper("replace", this.result);
                };

            } else if (/^application\/pdf$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $container.attr('src', '').fadeOut(300);
                    $content.empty().append('<embed src="' + this.result + '" width="100%" height="375">').fadeIn(300);
                };

            } else {
                $container.attr('src', '').fadeOut(300);
                $content.empty().append('<i style="font-size: 135px" class="fa fa-file-text-o"></i><p>' + file.name + '</p>').fadeIn(300);
            }
        });

    } else {
        $inputImage.addClass("hide");
    }


    function showCoords(c) {
        $('#docversionform-x').val(c.x);
        $('#docversionform-y').val(c.y);
        $('#docversionform-h').val(c.height);
        $('#docversionform-w').val(c.width);
    }
});