var $pjax = $('#pjax_container'),
    reloadItemList = function() {
        var gallery_id = $('#galleryitemform-gallery_id').val();
        $.pjax({
            container: '#item-container',
            url: $pjax.data('url'),
            data: {gallery_id: gallery_id},
            push: false,
            scrollTo: false,
            timeout: 15000
        });
    };
reloadItemList();

$(document).ready(function(e) {
    var $form = $('#upload-picture-form'),
        upload_url = $form.data('url'),
        $done_btn = $('#picture-done-button'),
        $crop_modal = $('#cropper-modal');

    $done_btn.on('click', function (e) {
        var form_data = new FormData($form[0]);
        // form.append('file', $('input[type=file]')[0].files[0]);

        $crop_modal.modal('hide');
        swal({
            title: "Загрузка...",
            showCancelButton: false,
            showConfirmButton: false,
            closeOnConfirm: false,
            text: '<div class="sk-spinner sk-spinner-cube-grid"><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div></div>',
            html: true
        });

        $.post({
            url: upload_url,
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.error) {
                    swal("Ошибка", "%(", "error");
                } else {
                    reloadItemList();
                    swal("Готово", null, "success");
                }
            }
        });

    });
});

$pjax.on('pjax:success', function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $sortable_container = $('#sortable'),
        $sortable = $sortable_container.find('tbody'),
        $delete_btn = $('.delete-item'),
        $edit_btn = $('.edit-file'),
        $crop_img = $("#crop_img"),
        $crop_modal = $('#cropper-modal'),
        $inputImage = $("#galleryitemform-file"),
        $x = $('#galleryitemform-x'),
        $y = $('#galleryitemform-y'),
        $w = $('#galleryitemform-w'),
        $h = $('#galleryitemform-h'),
        showCoords = function (c) {
            $x.val(c.x);
            $y.val(c.y);
            $w.val(c.width);
            $h.val(c.height);
        },
        edit_item = function () {
            var picture_url = $(this).data('picture-url'),
                $file_field = $('#galleryitemform-file_id'),
                res = this.result;

            $file_field.val($(this).data('item-id'));
            $crop_img.attr('src', picture_url);
            $crop_modal.modal('show').on('shown.bs.modal', function () {
                $crop_img.cropper({
                    autoCropArea: 0.5,
                    minContainerHeight:300,
                    aspectRatio: 0.94,
                    crop: function(data) {
                        showCoords(data);
                    }
                }).cropper("reset", true);

            }).on('hidden.bs.modal', function () {
                $crop_img.attr('src', '').cropper('destroy');
                $file_field.val(null);
            });
        };

    $(".editable").editable();

    $sortable.sortable({
        revert: true,
        helper: 'clone',
        forceHelperSize: true,
        opacity: 0.85,
        update: function(event, ui) {
            var data = $(this).sortable('toArray', {attribute: "data-key"});
            if (data && data.length > 1) {
                $.post({
                    url: $sortable_container.data('url'),
                    data: {order: data, _csrf: csrfToken},
                    success: function (json) {
                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                    }
                });
            }
        }
    });

    $delete_btn.on('click', function(e) {
        var name = $(this).data('item-name'),
            id = $(this).data('item-id'),
            url = $(this).data('url');

        swal({
                title: "Удалить файл?",
                text: "" + name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Удалить",
                cancelButtonText: "Отмена"
            },
            function() {
                $.post({
                    url: url, data: {id: id, _csrf: csrfToken},
                    success: function (json) {
                        if (json.error) {
                            swal("Ошибка", "%(", "error");
                        }
                        else {
                            reloadItemList();
                            swal("Готово", "\n", "success");
                        }
                    }
                });
            });

        return false;
    });

    $edit_btn.on('click', edit_item);

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
                    var res = this.result;
                    $crop_modal.modal('show').on('shown.bs.modal', function () {
                        $crop_img.cropper({
                            autoCropArea: 0.5,
                            minContainerHeight:300,
                            aspectRatio: 0.94,
                            crop: function(data) {
                                showCoords(data);
                            }
                        }).cropper("reset", true).cropper("replace", res);

                    }).on('hidden.bs.modal', function () {
                        $crop_img.cropper('destroy');
                    });

                };
            } else {
                alert("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
    }


});