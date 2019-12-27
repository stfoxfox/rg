$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $table = $('#news_table'),
        $del_btn = $('.delete-news'),
        $add_btn = $('#add-news'),

        add_item = function (e) {
            var url = $(this).data('url');
            swal({
                    title: "Новая новость",
                    text: "Заголовок:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Добавить",
                    cancelButtonText:"Отмена",
                    inputPlaceholder: ""
                },
                function(inputValue){
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("Заголовок не может быть пустым");
                        return false;
                    }
                    $.post({
                        url: url,
                        data: {title: inputValue, _csrf: csrfToken},
                        success: function(json){
                            if(json.error){
                                swal("Ошибка", "%(", "error");
                            }
                            else{
                                swal("Готово", "Новость добавлена", "success");
                            }
                        }
                    });
                });

            return false;
        },

        delete_item = function (e) {
            var item_name = $(this).data('item-name'),
                item_id = $(this).data('item-id'),
                url = $(this).data('url');
            swal({
                    title: "Удалить новость?",
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
    $add_btn.on('click', add_item);
});