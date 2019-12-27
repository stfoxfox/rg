<?php
/**
 * @var \yii\web\View $this
 */
?>

<section class="section section--flat_chess">
    <div class="section__container">
        <div class="section__content">
            <div class="flat_chess">
                <div class="flat_chess__info">Выберите квартиру на шахматке</div>
                <div class="flat_chess__content js_chess">
                    <div class="flat_chess__house js_chess_house"></div>
                    <div class="flat_chess__loading js_chess_loading">
                        <div class="spinner">
                            <svg class="spinner__svg" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 55 55">
                                <defs>
                                    <linearGradient id="spinner__linear_gradient--orange-1" x1="0" y1="50%" x2="100%" y2="50%">
                                        <stop offset="0%" stop-color="#7f7f7f"></stop>
                                        <stop offset="100%" stop-color="rgba(247,247,247,0.1)"></stop>
                                    </linearGradient>
                                    <linearGradient id="spinner__linear_gradient--orange-2" x1="100%" y1="50%" x2="0%" y2="50%">
                                        <stop offset="0%" stop-color="#000000"></stop>
                                        <stop offset="100%" stop-color="#7f7f7f"></stop>
                                    </linearGradient>
                                </defs>
                                <g class="spinner__g">
                                    <circle class="spinner__circle circle-1" r="26" cx="50%" cy="50%"></circle>
                                    <circle class="spinner__circle circle-2" r="26" cx="50%" cy="50%"></circle>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flat_chess__actions">
                    <div class="flat_chess__legend">
                        <div class="flat_chess__legend_item">
                            <div class="flat_chess__flat flat--available">
                                <span>кв</span>
                            </div>
                            <div class="flat_chess__legend_description text--xs">Доступна</div>
                        </div>
                        <div class="flat_chess__legend_item">
                            <div class="flat_chess__flat flat--sold">
                                <span>кв</span>
                            </div>
                            <div class="flat_chess__legend_description text--xs">Продана</div>
                        </div>
                        <div class="flat_chess__legend_item">
                            <div class="flat_chess__flat flat--current">
                                <span>кв</span>
                            </div>
                            <div class="flat_chess__legend_description text--xs">Выбрана</div>
                        </div>
                        <div class="flat_chess__legend_item">
                            <div class="flat_chess__flat flat--unavailable">
                                <span>кв</span>
                            </div>
                            <div class="flat_chess__legend_description text--xs">Не доступна</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
