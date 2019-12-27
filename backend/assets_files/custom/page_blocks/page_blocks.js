/**
 * Created by anatoliypopov on 04/07/2017.
 */
/**
 * Created by anatoliypopov on 23/06/2017.
 */

var added_id =0;

var dell_block_item = function () {
    var block_id = $(this).parents( ".page_block" ).data('page-block-id');
    var block_dell_id = $(this).data('block-dell-id');
    if(typeof block_id == 'undefined'){
        $(this).parents( ".page_block" ).remove();
    }else{
        swal({
            title: "Удалить блок?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        },
        function () {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "post",
                url: "/page/dell-block.html",
                data: {
                    'item_id': block_id,
                    _csrf: csrfToken
                },
                success: function (json) {
                    if (json.error) {
                        swal("Error!", "%(", "error");
                    }
                    else {
                        $("#block_" + block_id).remove();
                        swal("Готово!", "Блок удален. \n", "success");
                    }
                },
                dataType: 'json'
            });
        });
    }
    return false;

};

var dell_block_field_image = function () {
    var block_id = $(this).parents( ".page_block" ).data('page-block-id');
    var block = $(this).parents( ".page_block" );
    var imageField = $(this).data( "image-field" );
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    swal({
            title: "Удалить изображение блока?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        },
        function () {
            $.ajax({
                type: "post",
                url: "/page/delete-image-field.html",
                data: {
                    'block_id': block_id,
                    'imageField': imageField,
                    _csrf: csrfToken
                },
                success: function (html) {
                    block.replaceWith(html);
                    $('.dell-block-link').off().on('click', dell_block_item);
                    $('.save_btn').off().on('click', save_action);
                    $('.edit-block-link').off().on('click', edit_block_item);
                    $(".dell-block-field-image").off().on('click', dell_block_field_image);
                    $(".dell-page-block-gallery-image").off().on('click', dell_page_block_gallery_image);

                    resetFileInputs();
                    
                    swal("Готово!", "Фото блока удален. \n", "success");
                },
                dataType: 'html'
            });
        });
    return false;
};

var dell_page_block_gallery_image = function () {
    var block_id = $(this).parents( ".page_block" ).data('page-block-id');
    var block = $(this).parents( ".page_block" );
    var gallry_image_id = $(this).data( "page-block-gallery-image-id" );
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    swal({
            title: "Удалить изображение из галереи?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        },
        function () {
            $.ajax({
                type: "post",
                url: "/page/delete-page-block-gallery-image.html",
                data: {
                    'block_id': block_id,
                    'gallry_image_id': gallry_image_id,
                    _csrf: csrfToken
                },
                success: function (html) {
                    block.replaceWith(html);
                    $('.dell-block-link').off().on('click', dell_block_item);
                    $('.save_btn').off().on('click', save_action);
                    $('.edit-block-link').off().on('click', edit_block_item);
                    $(".dell-block-field-image").off().on('click', dell_block_field_image);
                    $(".dell-page-block-gallery-image").off().on('click', dell_page_block_gallery_image);

                    resetFileInputs();
                    
                    swal("Готово!", "Фото блока удален. \n", "success");
                },
                dataType: 'html'
            });
        });
    return false;
};

var edit_block_item = function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $block = $(this).parents(".page_block"),
        block_id = $block.data('page-block-id'),
        parent_id = $block.data('page-block-parent-id'),
        edit_url = $block.data('edit-url');

    $.post({
        url: edit_url,
        //dataType: 'html',
        data: {item_id: block_id, added_id: added_id, parent_id: parent_id, _csrf: csrfToken},
        success: function (html) {
            $block.replaceWith(html);
            $('.dell-block-link').off().on('click', dell_block_item);
            $('.save_btn').off().on('click', save_action);
            $('.edit-block-link').off().on('click', edit_block_item);
            $(".dell-block-field-image").off().on('click', dell_block_field_image);
            $(".dell-page-block-gallery-image").off().on('click', dell_page_block_gallery_image);

            resetFileInputs();

            added_id++;
        }
    });

    return false;
};

var add_block_item = function() {
    var type = $(this).data('block-type'),
        page_id = $(this).data('item-id'),
        parent_id = $(this).data('parent-id'),
        url = $(this).data('url');

    $.post({
        url: url,
        //dataType: 'html',
        data: {
            type_id: type,
            added_block_idx: added_id,
            page_id: page_id,
            parent_id: parent_id
        },
        success: function (html) {
            $('#blocks-list').append(html).on('click', '.dell-block-link', dell_block_item).on('click','#save_btn_'+added_id,save_action);

            /*if(type == 4){
             $("#files_"+added_id).click(function () {
             var block_id= $(this).data('block-id');
             var hr_block = $("#files_div_"+block_id);
             hr_block.append('<br><input type="file" id="image_n_0" name="PageBlockForm[files_array][]" accept="image/*">');
             });
             }
             if(type ==2 || type ==3||type ==8||type ==9){*/

            resetFileInputs();
            added_id++;
        }
    });
};

$(document).ready(function() {
    $('.dell-block-link').click(dell_block_item);
    $('.edit-block-link').click(edit_block_item);
    $(".add-block").click(add_block_item);
    $(".dell-block-field-image").click(dell_block_field_image);
    $(".dell-page-block-gallery-image").click(dell_page_block_gallery_image);
    WinMove();
});

function save_action(e) {

    var form_id = $(this).data('form_id');
    var block_id=$(this).data('block-id');

    $("#form_n_"+form_id).ajaxSubmit({
        success:  function (data) {
            $("#"+block_id).replaceWith(data);
            $('.dell-block-link').off().on('click', dell_block_item);
            $('.edit-block-link').off().on('click', edit_block_item);
            $(".dell-block-field-image").off().on('click', dell_block_field_image);
            $(".dell-page-block-gallery-image").off().on('click', dell_page_block_gallery_image);
            resetFileInputs();
            $("#blocks-list").sortable( "refresh" );
            var data = $("#blocks-list").sortable('toArray',{ attribute: "sort-id" });
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $('.save-item').editable();
            $.ajax({
                type: "POST",
                url:"/page/block-sort.html",
                data: {sort_data:data,
                    _csrf : csrfToken
                },
                success: function(json){
                    if(json.error){
                        swal("Error", "%(", "error");
                    }
                },
                dataType: 'json'
            });
        },
        error:function () {
        },
        url: $("#form_n_"+form_id).attr("action"),
        type: 'post',
        dataType: 'html'
    });
    e.preventDefault();
    e.stopPropagation();
}

function showCoords(c,blockid,fieldName) {
    $('#'+blockid+'-x-'+fieldName).val(c.x);
    $('#'+blockid+'-y-'+fieldName).val(c.y);
    $('#'+blockid+'-h-'+fieldName).val(c.height);
    $('#'+blockid+'-w-'+fieldName).val(c.width);
}



function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $("#blocks-list").sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8,
            update: function( event, ui ) {
                var data = $(this).sortable('toArray',{ attribute: "sort-id" });
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "POST",
                    url:"/page/block-sort.html",
                    data: {sort_data:data,
                        _csrf : csrfToken
                    },
                    success: function(json){
                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                    },
                    dataType: 'json'
                });
            }
        })
        .disableSelection();
}

function resetFileInputs() {
    $( ".pageBlockImageInput" ).each(function( index ) {
        var $image = $( this ).find("#crop_img_n"+added_id);
        var $image_div=  $( this ).find("#crop_div_"+added_id);
        var $inputImage = $( this ).find("#image_n_"+added_id);
        var $fieldName = $( this ).data('field-name');
        var $inputId= added_id;
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
                        $image_div.fadeIn(300);
                        //$inputImage.val("");
                        $image.cropper({
                            //aspectRatio:1,
                            //  preview: ".img-preview",
                            minContainerHeight:300,
                            crop: function(data) {
                                // Output the result data for cropping image.
                                showCoords(data,$inputId+"-n",$fieldName);
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
    });
}
