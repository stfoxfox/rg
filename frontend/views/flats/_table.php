<?php
/**
 * @var \yii\web\View $this
 */
?>

<table class="flats_table">
    <thead>
    <tr>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="rooms_count">Комнат
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="number_on_floor">Этаж
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="corpus_num">Корпус
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="total_area">Общая площадь
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="decoration">Отделка
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="total_price">Цена без скидки
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <a class="sorting js_table_sorting" href="#" data-sort-by="sale_price">Цена по акции
                <span class="sorting__ico ico--triangle">
                    <svg class="icon__triangle" width="13px" height="9px">
                        <use xlink:href="#triangle"></use>
                    </svg>
                </span>
            </a>
        </th>
        <th>
            <span>Посмотреть квартиру</span>
        </th>
    </tr>
    </thead>
    <tbody class="js_flats_result"></tbody>
</table>

<div class="flats_table__loading js_flats_loading">
    <div class="spinner">
        <svg class="spinner__svg" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 55 55">
            <defs>
                <linearGradient id="spinner__linear_gradient--orange-1" x1="0" y1="50%" x2="100%" y2="50%">
                    <stop offset="0%" stop-color="#7f7f7f"></stop>
                    <stop offset="100%" stop-color="#fdfdfd"></stop>
                </linearGradient>
                <linearGradient id="spinner__linear_gradient--orange-2" x1="100%" y1="50%" x2="0%" y2="50%">
                    <stop offset="0%" stop-color="#000000"></stop>
                    <stop offset="100%" stop-color="#7f7f7f"></stop>
                </linearGradient>
            </defs>
            <g class="spinner__g">
                <circle class="spinner__circle circle-0" r="26" cx="50%" cy="50%"></circle>
                <circle class="spinner__circle circle-1" r="26" cx="50%" cy="50%"></circle>
                <circle class="spinner__circle circle-2" r="26" cx="50%" cy="50%"></circle>
            </g>
        </svg>
    </div>
</div>

