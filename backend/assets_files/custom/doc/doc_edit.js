$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $complex = $('#docform-complex_id'),
        $corpus = $('#docform-corpus_num'),
        $section = $('#docform-section_id'),
        $table = $('#doc-versions-table'),
        $del_btn = $('.delete-doc-version'),
        delete_item = function () {
            var item_name = $(this).data('item-name'),
                item_id = $(this).data('item-id'),
                url = $(this).data('url');
            swal({
                    title: "Удалить версию?",
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
                            if (json.error) {
                                swal("Ошибка", "%(", "error");
                            } else {
                                $table.find('[data-key="'+item_id+'"]').remove();
                                swal("Готово", "\n", "success");
                            }
                        }
                    });
                });

            return false;
        };

    $del_btn.on('click', delete_item);

    $('#docform-complex_id, #docform-corpus_num').on('change', function(e) {
       var url = $(this).data('url'),
           type = $(this).data('type'),
           val = $(this).find(':selected').val(),
           complex_id = $complex.find(':selected').val();

        $.post({
            url: url,
            data: {value: val, type: type, complex_id: complex_id, _csrf: csrfToken},
            success: function (data) {
                if (data.success) {
                    data.corpus && $corpus.empty().append(data.corpus).select2();
                    $section.empty().append(data.section).select2();
                }
            }
        });
    });
});