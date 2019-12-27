var $pjax = $('#pjax_container'),
    reloadItemForm = function(data) {
        $.pjax({
            container: '#item-container',
            url: $pjax.data('url'),
            data: data,
            push: false,
            scrollTo: false,
            timeout: 3000
        });
    };

$(document).ready(function(e) {
var
    csrfToken = $('meta[name="csrf-token"]').attr("content"),
    $folder_list = $('#folder_list'),
    $add_item_btn = $('#add-item'),
    $nestable = $('#nestable'),
    $switchNestable = $('#switchNestable'),
    nestable_html = '<i class="fa fa-check"></i> Готово',
    unnestable_html = '<i class="fa fa-sort"></i> Режим сортировки',
    nestable_class = 'btn-primary',
    unnestable_class = 'btn-default',

    delete_item = function () {
        var item_name = $(this).data('name'),
            item_id = $(this).data('id'),
            url = $(this).data('url');
        swal({
                title: "Удалить элемент меню?",
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
                        reloadItemForm({id: null});
                        swal("Готово", "\n", "success");
                    }
                }
            });
        });

        return false;
    },

    updateNestable = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output'),
            url = $(e.target).data('url');
        $.post({
            url: url,
            data: {
                sort_data: window.JSON.stringify(list.nestable('serialize')),
                _csrf: csrfToken
            },
            success: function (json) {
                if (json.error) {
                    swal("Error", "%(", "error");
                }
            }
        });
    },

    init_func = function (e) {
        var $del_item_btn = $('.delete-item'),
            $item = $('li.dd-item'),
            $pjax = $('#pjax_container'),
            $form_title = $pjax.parent('div.ibox').find('.ibox-title').find('h5');

        $form_title.html('<i class="fa fa-bars"></i> Элемент');
        $del_item_btn.on('click', delete_item);
        $item.on('click', function(e) {
            var title = $(this).data('title');
            $form_title.html('<i class="fa fa-bars"></i> ' + title);
            reloadItemForm({id: $(this).data('id')});

            return false;
        });
        reloadItemForm({id: null});
    };

    $add_item_btn.on('click', function(e) {
        var url = $(this).data('url'),
            menu = $(this).data('menu'),
            $first_elem = $folder_list.find('li:eq(0)');
        swal({
                title: "Добавить элемент меню",
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
                    data: { title:inputValue, _csrf : csrfToken, menu_id: menu},
                    success: function(json){
                        if(json.error){
                            swal("Ошибка", "%(", "error");
                        }
                        else{
                            if ($first_elem.length > 0) {
                                $first_elem.before(json.item);
                            } else {
                                $folder_list.html(json.item);
                            }
                            init_func();
                            swal("Готово", "Новый элемент меню добавлен", "success");
                        }
                    }
                });
            });

        return false;

    });

    $switchNestable.addClass(unnestable_class).html(unnestable_html).on('click', function(e) {
        var $btn = $(this);
        e.preventDefault();

        if ($btn.hasClass(nestable_class)) {
            $btn.removeClass(nestable_class).addClass(unnestable_class).html(unnestable_html);
            $('#nestable').nestable('destroy');
        } else {
            $btn.removeClass(unnestable_class).addClass(nestable_class).html(nestable_html);
            $nestable.nestable({
                maxDepth: 4,
                expandBtnHTML: '',
                collapseBtnHTML: ''
            }).on('change', updateNestable);
        }
    });

    init_func();

    //$item_form.on('beforeSubmit', function(e) {
    //    e.preventDefault();
    //
    //    var $form = $(this);
    //    $.post({
    //        url: $form.attr('action'),
    //        data: $form.serialize(),
    //        success: function(data) {
    //            if (data.error) {
    //                swal("Ошибка", "%(", "error");
    //            } else {
    //                $folder_list.find('a.view-item[data-key="' + data.id + '"]')
    //                    .html(data.title);
    //            }
    //        }
    //    });
    //});

});

$pjax.on('pjax:success', function(e) {
    var $controller = $('#menuitemform-controller'),
        $action = $('#menuitemform-action'),
        item_id = $('#menuitemform-id').val();

    $controller.on('change', function(e) {
        reloadItemForm({id: item_id, controller: $(this).find(':selected').val()});
    });

    $action.on('change', function(e) {
        reloadItemForm({
            id: item_id,
            controller: $controller.find(':selected').val(),
            action: $(this).find(':selected').val()
        });
    });
});