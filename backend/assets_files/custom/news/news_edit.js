$(document).ready(function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"),
        $sortable_container = $('#sortable-tag'),
        $sortable = $sortable_container.find('ol'),
        $add_btn = $('#add-tag'),

        reload_tags = function (e) {
            var url = $add_btn.data('url-tags'),
                $tags = $('#newsform-news_tags');

            $.post({
                url: url,
                success: function (json) {
                    if (json.error) {
                        swal("Ошибка", "%(", "error");
                    } else {
                        $tags.empty().append(json.tags).select2();
                    }
                }
            });
        },

        delete_item = function (e) {
            var item_name = $(this).data('name'),
                item_id = $(this).data('id'),
                url = $(this).data('url');
            swal({
                    title: "Удалить тэг?",
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
                                $("#item_id_" + item_id).remove();
                                reload_tags(e);
                                swal("Готово", "\n", "success");
                            }
                        }
                    });
                });

            return false;
        },

        add_item = function (e) {
            var url = $(this).data('url'),
                $first_elem = $sortable.find('li:eq(0)');
            swal({
                    title: "Добавить тэг",
                    text: "Наименование:",
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
                        swal.showInputError("Наименование не может быть пустым");
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
                                if ($first_elem.length > 0) {
                                    $first_elem.before(json.item);
                                } else {
                                    $sortable.html(json.item);
                                }
                                init_func();
                                reload_tags(e);
                                swal("Готово", "Новый тэг добавлен", "success");
                            }
                        }
                    });
                });

            return false;
        },

        init_func = function (e) {
            var $delete_btn = $('.delete-tag');
            $delete_btn.on('click', delete_item);
        };

    $add_btn.on('click', add_item);

    $sortable.sortable({
        revert: true,
        helper: 'clone',
        forceHelperSize: true,
        opacity: 0.85,
        update: function(event, ui) {
            var data = $(this).sortable('toArray', {attribute: "data-id"});
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

    init_func();
});
