<?php
/**
 * @var $images \common\models\File[]
 */
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="fotos-line">
    <div class="container">
        <h3 class="title-h2 mb30">Фотогалерея</h3>
    </div>
    <?php if (!empty($images)): ?>
    <div class="gallery-wrap slideshow-wrapper">
        <ul id="gallery-fotos">]
            <?php foreach ($images as $image): ?>
            <li class="item">
                <a href="#">
                    <img src="<?=(new MyImagePublisher($image))->MyThumbnail(500, 400, 'name','page_block')?>" alt="<?= $image->title ?>">
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="gallery-wrap__nav">
            <div class="container">
                <a href="#" class="arrow-prev" id="gallery-fotos-prev"></a>
                <a href="#" class="arrow-next" id="gallery-fotos-next"></a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>