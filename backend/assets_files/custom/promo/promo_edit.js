$(document).ready(function(e) {
    var $image = $('#crop_img'),
        $inputImage = $('#promoform-file'),
        $container = $('#image-div'),
        $avatar = $('#crop_img1'),
        $inputAvatar = $('#promoform-avatar'),
        $containerAvatar = $('#image-div1');

    if (!$image.attr('src')) {
        $container.fadeOut(300);
    }
    if (!$avatar.attr('src')) {
        $containerAvatar.fadeOut(300);
    }
    
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

        $inputAvatar.change(function() {
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
                    $containerAvatar.fadeIn(300);
                    $avatar.cropper({
                        aspectRatio: 4 / 3,
                        minContainerHeight: 100,
                        crop: function(data) {
                            showCoordsAvatar(data);
                        }
                    }).cropper("reset", true).cropper("replace", this.result);
                };

            } else {
                alert("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
        $inputAvatar.addClass("hide");
    }


    function showCoords(c) {
        $('#promoform-x').val(c.x);
        $('#promoform-y').val(c.y);
        $('#promoform-h').val(c.height);
        $('#promoform-w').val(c.width);
    }

    function showCoordsAvatar(c) {
        $('#promoform-x1').val(c.x);
        $('#promoform-y1').val(c.y);
        $('#promoform-h1').val(c.height);
        $('#promoform-w1').val(c.width);
    }
});