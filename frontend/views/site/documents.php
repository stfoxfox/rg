<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $documents \common\models\Doc[]
 */
?>

<section class="section">
    <div class="section__container">
        <div class="section__content">
            <div class="document_list__wrap">
                <div class="document_list">

                    <div class="row p-14">
                    <?php foreach ($documents as $document) {
                        /** @var \common\models\Doc $document */
                        if ($model = $document->getLatestDocVersion()) {
                            /** @var \common\models\DocVersion $model */
                            if (!$model->file)
                                continue;

                            if ($model->file->is_img) {
                                $href = 'javascript:void(0)';
                                $content = Html::img($model->file->getThumbForFront('DocVersion'), [
                                    'width' => 85,
                                ]);
                            } else {
                                $href = $model->file->getOriginal('DocVersion');
                                $content = $model->file->getThumbForFront('DocVersion');
                            }

                            $content = Html::tag('div', $content, ['class' => 'document_list__illu']);
                            $doc = Html::tag('div', Html::tag('p', $document->title), ['class' => 'document_list__content']);

                            $html = Html::beginTag('div', ['class' => 'col-6']);
                            $html .= Html::a($content . $doc, $href, [
                                'class' => 'document_list__item',
                                'download' => $model->file->original_name,
                            ]);
                            $html .= Html::endTag('div');

                            echo $html;
                        }
                    }?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
