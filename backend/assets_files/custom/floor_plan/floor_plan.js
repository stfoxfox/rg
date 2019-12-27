var $pjax = $('#pjax_container'),
    csrfToken = $('meta[name="csrf-token"]').attr("content"),
    reloadItemsList = function(data) {
        $.pjax({
            container: '#plan-container',
            url: $pjax.data('url'),
            data: data,
            push: false,
            scrollTo: false,
            timeout: 15000
        });
    };
reloadItemsList();

$(document).ready(function(e) {
    var $form = $('#import-form'),
        upload_url = $form.data('url'),
        $archive = $('#floorplanimportform-file'),
        import_archive = function (file) {
            //if (/^application\/x-zip-compressed$/.test(file.type)) {
            if (true) {
                swal({
                        title: "Начать импорт?",
                        text: "Архив " + file.name,
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Импортировать",
                        cancelButtonText: "Отмена"
                    },
                    function () {
                        var form_data = new FormData($form[0]);
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
                                    reloadItemsList();
                                    swal("Готово", null, "success");
                                }
                            }
                        });
                    }
                );

            } else {
                alert("Please choose an zip file.");
            }
        };

    if (window.FileReader) {
        $archive.change(function(e) {
            var files = this.files;
            files.length && import_archive(files[0]);
        });
    }
});

$pjax.on('pjax:success', function(e) {
    var $table = $('#plan-table'),
        $del_btn = $('.item-delete'),
        delete_item = function (e) {
            var item_name = $(this).data('item-name'),
                item_id = $(this).data('item-id'),
                url = $(this).data('url');
            swal({
                    title: "Удалить планировку?",
                    text: "" + item_name,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    showLoaderOnConfirm: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Удалить",
                    cancelButtonText: "Отмена"
                },
                function () {
                    $.post({
                        url: url,
                        data: {id: item_id, _csrf: csrfToken},
                        success: function (json) {
                            $table.find('[data-key="'+item_id+'"]').remove();
                            swal("Готово", "\n", "success");
                        }
                    });
                });

            return false;
        };

    $del_btn.on('click', delete_item);
});