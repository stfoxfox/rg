$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $table = $('#gallery_table'),
        $delete_btn = $('.delete-gallery');

    $delete_btn.on('click', function(e) {
        var name = $(this).data('item-name'),
            id = $(this).data('item-id'),
            url = $(this).data('url');

        swal({
                title: "Удалить галерею?",
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
                            $table.find('[data-key="'+id+'"]').remove();
                            swal("Готово", "\n", "success");
                        }
                    }
                });
            });

        return false;
    });
});