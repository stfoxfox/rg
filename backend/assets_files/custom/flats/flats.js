var active_node = {},
    init_func = function () {
        $('.flat-delete').on('click', dell_flat);
    },
    reloadFlats = function(data) {
        var filter = data || active_node;
        $.pjax({
            container: '#flats',
            data: filter,
            push: false,
            scrollTo: false,
            timeout: 3000
        });
    },
    dell_flat = function () {
        var id = $(this).data('id'),
            name = $(this).data('name'),
            url = $(this).data('url');

        swal({
                title: "Удалить квартиру?",
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

            function () {
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.post({
                    url: url,
                    data: {id: id, _csrf: csrfToken},
                    success: function (json) {
                        if (json.error) {
                            swal("Ошибка", "%(", "error");
                        }
                        else {
                            reloadFlats(active_node);
                            swal("Готово", "\n", "success");
                        }
                    }
                });
            });

        return false;
    };

$(document).ready(function(e) {
    var $tree = $('#js-tree'),
        tree_url = $tree.data('url');
    init_func();

    $.post({
        url: tree_url,
        success: function(json) {
            $tree.jstree({
                'core': {
                    'data': json.data,
                    'check_callback' : true,
                    'plugins' : [ 'types', 'dnd' ],
                    'types' : {
                        'default': {
                            'icon': 'fa fa-folder'
                        }
                    }
                }
            }).on('changed.jstree', function (e, data) {
                //https://www.jstree.com/docs/interaction/
                var node = data.instance.get_node(data.selected[0]);
                active_node = node.original.a_atr;
                reloadFlats(active_node);
            });
        }
    });

}).on('pjax:end', function(e) {
    init_func();
});
