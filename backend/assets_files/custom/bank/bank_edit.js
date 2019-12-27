var $pjax = $('#pjax_container'),
    csrfToken = $('meta[name="csrf-token"]').attr("content"),
    bank_id = $('#bankform-id').val(),
    reloadItemList = function() {
        if (bank_id > 0) {
            $.pjax({
                container: '#item-container',
                url: $pjax.data('url'),
                data: {bank_id: bank_id},
                push: false,
                scrollTo: false,
                timeout: 3000
            });
        }
    };
reloadItemList();

$(document).ready(function(e) {
    var $add_btn = $('#add-mortgage');

    $add_btn.on('click', function(e) {
        var url = $(this).data('url');
        swal({
                title: "Добавить ипотеку",
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
                    data: {title: inputValue, bank_id: bank_id, _csrf: csrfToken},
                    success: function(json){
                        if(json.error){
                            swal("Ошибка", "%(", "error");
                        }
                        else{
                            reloadItemList();
                            swal("Готово", "Новая ипотека добавлена", "success");
                        }
                    }
                });
            });

        return false;
    });

});

$pjax.on('pjax:success', function(e) {
    var $table = $('#mortgages-table'),
        $del_btn = $('.delete-mortgage'),
        $sortable = $table.find('tbody'),
        delete_item = function () {
            var item_name = $(this).data('item-name'),
                item_id = $(this).data('item-id'),
                url = $(this).data('url');
            swal({
                    title: "Удалить ипотеку?",
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
                    url: $table.data('url'),
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

    $del_btn.on('click', delete_item);

});