<?php
/**
 * @var $this \yii\web\View
 * @var $page \common\models\Page
 */
?>

<section class="section section--sidebar_left">
    <div class="section__container">
        <div class="section__content">

            <main class="main">
                <?=$this->render('@frontend/views/common/_pageBlocks', ['page' => $page])?>
            </main>

            <div class="sidebar">
                <?=$this->render('@frontend/views/common/_pageAnchors', ['page' => $page])?>
            </div>
        </div>
    </div>
</section>
        