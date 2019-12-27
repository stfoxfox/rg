<?php
use frontend\widgets\SocialsWidget;
use frontend\widgets\FeedbackWidget;

/**
 * @var $this \yii\web\View
 * @var $page \common\models\Page
 */
?>

<section class="section section--contacts">
    <div class="section__container">
        <div class="section__content">
            <div class="row">

                <div class="col-7">
                    <?=$this->render('@frontend/views/common/_pageBlocks', ['page' => $page])?>
                </div>

                <div class="col-1"></div>

                <div class="col-3">
                    <?=FeedbackWidget::widget(['type' => FeedbackWidget::CONTACT])?>
                </div>

            </div>
        </div>
    </div>
</section>

