<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\Box;
use backend\widgets\InputFileButton;
use backend\assets\custom\GalleryItemAsset;

/**
 * @var $this \yii\web\View
 * @var $picture_form \backend\models\forms\GalleryItemForm
 */
GalleryItemAsset::register($this);
$form = ActiveForm::begin([
    'id' => 'upload-picture-form',
    'options' => [
        'enctype' => 'multipart/form-data',
        'data-url' => Url::to(['add-item']),
    ]
]);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
//            'headerButtons' => [[
//                'label' => '<i class="fa fa-plus"></i> Добавить',
//                'url' => Url::to(['add-gallery']),
//                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
//            ]],
            'fileButton' => InputFileButton::widget(['model' => $picture_form]),
            'collapseButton' => false,
            'bodyOptions' => [
                'id' => 'pjax_container',
                'data-url' => Url::to(['view-grid'])
            ]
        ])?>

        <?=Html::activeHiddenInput($picture_form, 'x')?>
        <?=Html::activeHiddenInput($picture_form, 'y')?>
        <?=Html::activeHiddenInput($picture_form, 'w')?>
        <?=Html::activeHiddenInput($picture_form, 'h')?>
        <?=Html::activeHiddenInput($picture_form, 'gallery_id')?>
        <?=Html::activeHiddenInput($picture_form, 'file_id')?>

        <?=Pjax::widget([
            'id' => 'item-container',
            'enablePushState' => false,
            'timeout' => 15000,
            'formSelector' => false,
            'linkSelector' => '#sortable th a, ul.pagination a',
        ])?>

        <?php Box::end()?>
    </div>
</div>
<?php ActiveForm::end()?>


<div class="modal inmodal fade" id="cropper-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Обрезать фото</h4>
            </div>
            <div class="modal-body">
                <div id="cropper-example-2">
                    <img id="crop_img" height="300" width="300" src="" alt="Picture">
                </div>

            <div class="modal-footer">


                <button type="button" class="btn btn-success" id="picture-done-button">Готово</button>

                <button type="button" class="btn btn-white" data-dismiss="modal">Отмена</button>

            </div>
        </div>
    </div>
</div>
