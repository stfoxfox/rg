/**
 * Created by anatoliypopov on 03/07/2017.
 */
$(document).ready(function() {

    var $image = $("#crop_img");


    var $inputImage = $(".input_file");
    if (window.FileReader) {
        $inputImage.change(function() {
            var fileReader = new FileReader(),
                files = this.files,
                file;


            var store_id = $(this).data('store-id');
            var aspect_ratio = $(this).data('aspect-ratio');


            if (!files.length) {
                return;
            }

            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $('#image-div-'+store_id).fadeIn(300);
                    //$inputImage.val("");
                    $image.cropper({
                        aspectRatio:aspect_ratio,
                        //  preview: ".img-preview",
                        minContainerHeight:300,

                        crop: function(data) {
                            // Output the result data for cropping image.
                            showCoords(data,store_id);
                        }
                    }).cropper("reset", true).cropper("replace", this.result);
                };
            } else {
                showMessage("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
    }







    function showCoords(c,store_id) {
        $('#' +store_id+'-x').val(c.x);
        $('#' +store_id+'-y').val(c.y);
        $('#' +store_id+'-h').val(c.height);
        $('#' +store_id+'-w').val(c.width);
    }



});