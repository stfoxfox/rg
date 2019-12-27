var $pjax = $('#pjax_container'),
    csrfToken = $('meta[name="csrf-token"]').attr("content"),
    reloadItemsList = function(data) {
        $.pjax({
            container: '#doc-container',
            url: $pjax.data('url'),
            data: data,
            push: false,
            scrollTo: false,
            timeout: 3000
        });
    };
reloadItemsList({category_id: null});

$(document).ready(function(e) {
    var $sortable_container = $('#sortable-category'),
        $sortable = $sortable_container.find('ol'),
        $add_btn = $('#add-doc-category'),
        $add_doc_btn = $('#add-doc'),

        delete_item = function () {
            var item_name = $(this).data('name'),
                item_id = $(this).data('id'),
                url = $(this).data('url'),
                $box_title = $pjax.parent('div.ibox').find('.ibox-title').find('h5');
            swal({
                    title: "Удалить категорию?",
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
                                $box_title.html('<i class="fa fa-folder"></i> Категория');
                                $add_doc_btn.addClass('hide').attr('data-id', '');
                                reloadItemsList({category_id: null});
                                swal("Готово", "\n", "success");
                            }
                        }
                    });
                });

            return false;
        },

        init_func = function (e) {
            var $delete_btn = $('.delete-doc-category'),
                $item = $('li.dd-item'),
                $box_title = $pjax.parent('div.ibox').find('.ibox-title').find('h5');

            $box_title.html('<i class="fa fa-folder"></i> Категория');
            $add_doc_btn.addClass('hide').attr('data-id', '');
            $delete_btn.on('click', delete_item);
            $item.on('click', function(e) {
                var title = $(this).data('title');
                $box_title.html('<i class="fa fa-folder-open"></i> ' + title);
                $add_doc_btn.removeClass('hide').attr('data-id', $(this).data('id'));
                reloadItemsList({category_id: $(this).data('id')});

                //return false;
            });
        };

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
                    data: {order: data, table: $sortable_container.data('table'), _csrf: csrfToken},
                    success: function (json) {
                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                    }
                });
            }
        }
    });

    $add_btn.on('click', function(e) {
        var url = $(this).data('url'),
            $first_elem = $sortable.find('li:eq(0)');
        swal({
                title: "Добавить категорию",
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
                            swal("Готово", "Новый категория добавлена", "success");
                        }
                    }
                });
            });

        return false;
    });

    $add_doc_btn.on('click', function(e) {
        var id = $(this).data('id'),
            url = $(this).data('url');

        $.post({
            url: url, data: {id: id, _csrf: csrfToken}
        });
    });

    init_func();
});

$pjax.on('pjax:success', function(e) {
    var $sortable_container = $('#sortable-doc'),
        $sortable = $sortable_container.find('tbody'),
        $delete_btn = $('.delete-doc');

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
                    data: {order: data, table: $sortable_container.data('table'), _csrf: csrfToken},
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
            url = $(this).data('url'),
            category_id = $(this).data('category-id');

        swal({
                title: "Удалить документ?",
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
                            reloadItemsList({category_id: category_id});
                            swal("Готово", "\n", "success");
                        }
                    }
                });
            });

        return false;
    });
});