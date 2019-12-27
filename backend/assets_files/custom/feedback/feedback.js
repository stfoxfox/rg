$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $table = $('#feedback_table'),
        $del_btn = $('.delete-item'),
        delete_item = function (e) {
            var item_name = $(this).data('item-name'),
                item_id = $(this).data('item-id'),
                url = $(this).data('url');
            swal({
                    title: "Удалить запрос?",
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