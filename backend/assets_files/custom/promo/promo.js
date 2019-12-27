$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $sortable_container = $('#sortable'),
        $sortable = $sortable_container.find('tbody'),
        $delete_btn = $('.item-delete');

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
                title: "Удалить акцию?",
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
                            $sortable.children('[data-key="'+id+'"]').remove();
                            swal("Готово", "\n", "success");
                        }
                    }
                });
            });

        return false;
    });

});