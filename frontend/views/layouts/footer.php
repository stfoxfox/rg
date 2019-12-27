<?php
use yii\helpers\Html;
use common\models\SiteSettings;
use common\models\Menu;
use frontend\widgets\MenuWidget;

/**
 * @var $this \yii\web\View
 * @var $tel SiteSettings
 */
$tel = SiteSettings::findOne(['text_key' => 'phone']);
$phone = ($tel) ? $tel->string_value : '';
$menu = Menu::getEnabledOne(Menu::TYPE_FOOTER);
?>

<footer class="footer">
    <div class="footer__container">
        <div class="footer__content">
            <div class="footer__row footer__row--top">
                <div class="footer__col">
                    <a class="logo_main" href="/" title="Новый Раменский">Новый Раменский</a>
                </div>

                <div class="footer__col">
                    <?=MenuWidget::widget(['model' => $menu])?>
                </div>

                <div class="footer__col">
                    <div class="footer__sales_office">

                    </div>
                </div>

                <div class="footer__col footer__col--phone">
                    <div class="footer__call_back">
                        <?=Html::a($phone, 'tel:' . $phone, ['class' => 'phone_number comnewramenskiy'])?>
                        <?=Html::a(Html::tag('span', 'Документы', ['class' => 'btn__label']), ['site/documents'], [
                            'class' => 'btn btn--small btn_docs'
                        ])?>
                    </div>
                </div>
            </div>

            <div class="footer__row footer__row--bottom">
                <div class="block_social block_social--footer">
                    <a class="block_social__item block_social__item--fb" href="#" title="Facebook">
                        <svg class="flat__social_icon icon-social-fb" width="51px" height="51px">
                            <use xlink:href="#icon-social-fb"></use>
                        </svg>
                    </a>
                    <a class="block_social__item block_social__item--tw" href="#" title="Twitter">
                        <svg class="flat__social_icon icon-social-tw" width="51px" height="51px">
                            <use xlink:href="#icon-social-tw"></use>
                        </svg>
                    </a>
                    <a class="block_social__item block_social__item--ok" href="#" title="Одноклассники">
                        <svg class="flat__social_icon icon-social-ok" width="51px" height="51px">
                            <use xlink:href="#icon-social-ok"></use>
                        </svg>
                    </a>
                    <a class="block_social__item block_social__item--vk" href="#" title="Вконтакте">
                        <svg class="flat__social_icon icon-social-vk" width="51px" height="51px">
                            <use xlink:href="#icon-social-vk"></use>
                        </svg>
                    </a>
                </div>

                <div class="footer__made">
                    <a class="pinkman" href="https://www.pink-man.ru/" title="PINKMAN Digital. Разработка интерактивных сайтов" target="blank">
                        <span>Разработка и поддержка —</span>
                        <span class="pinkman__logo">
                            <svg class="pinkman__svg" viewbox="0 0 90 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs>
                            <lineargradient id="linearGradient-1" x1="0.284482759%" y1="49.4448239%" x2="100.014943%" y2="49.4448239%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-2" x1="0.331914894%" y1="49.4619943%" x2="100.065957%" y2="49.4619943%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-3" x1="-0.122885572%" y1="49.9165289%" x2="100.110945%" y2="49.9165289%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-4" x1="-5.100625%" y1="49.9458503%" x2="94.625625%" y2="49.9458503%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-5" x1="0.847945205%" y1="50.4375097%" x2="100.568493%" y2="50.4375097%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-6" x1="-6.73712121%" y1="49.844697%" x2="92.9780303%" y2="49.844697%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-7" x1="1.21384615%" y1="50.2286822%" x2="100.608462%" y2="50.2286822%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-8" x1="-8.17007874%" y1="50.2338583%" x2="91.6755906%" y2="50.2338583%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-9" x1="0.299122807%" y1="50.2693694%" x2="99.7692982%" y2="50.2693694%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-10" x1="-0.367%" y1="50.3115789%" x2="99.622%" y2="50.3115789%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-11" x1="-0.0816091954%" y1="50.3746835%" x2="99.4344828%" y2="50.3746835%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-12" x1="0.305479452%" y1="50.4730159%" x2="100.539726%" y2="50.4730159%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-13" x1="-0.442857143%" y1="50.0304348%" x2="100.201587%" y2="50.0304348%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-14" x1="0.407407407%" y1="50.7666667%" x2="99.7444444%" y2="50.7666667%">
                                <stop stop-color="#FFB9FF" offset="0%"></stop>
                                <stop stop-color="#FF5FB7" offset="20.43%"></stop>
                                <stop stop-color="#E4358D" offset="36.1%"></stop>
                                <stop stop-color="#4F0E32" offset="57.82%"></stop>
                                <stop stop-color="#151015" offset="100%"></stop>
                            </lineargradient>
                        </defs>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="nonzero">
                            <g transform="translate(27.446809, 3.191489)" fill="#000000">
                                <polygon points="9.44680851 1.78723404 9.82978723 2.10638298 9.82978723 7.40425532 9.44680851 7.53191489 9.44680851 9 12 9 12 7.53191489 11.6170213 7.40425532 11.6170213 2.10638298 12 1.78723404 12 0.382978723 9.44680851 0.382978723"></polygon>
                                <path d="M5.93617021,0.957446809 C5.23404255,0.510638298 4.34042553,0.382978723 3.82978723,0.382978723 L1.27659574,0.382978723 L1.27659574,0.382978723 L0.510638298,0.382978723 L0.510638298,9 L2.29787234,9 L2.29787234,6.31914894 L3.76595745,6.31914894 C4.59574468,6.31914894 5.42553191,6.06382979 6.06382979,5.68085106 C6.63829787,5.29787234 7.27659574,4.59574468 7.27659574,3.38297872 C7.34042553,2.10638298 6.57446809,1.34042553 5.93617021,0.957446809 Z M4.9787234,4.46808511 C4.59574468,4.72340426 4.08510638,4.78723404 3.76595745,4.78723404 L2.29787234,4.78723404 L2.29787234,1.91489362 L3.76595745,1.91489362 C3.82978723,1.91489362 5.55319149,1.9787234 5.55319149,3.38297872 C5.61702128,3.89361702 5.42553191,4.27659574 4.9787234,4.46808511 Z"></path>
                                <polygon points="41.4255319 1.91489362 38.8723404 5.4893617 36.3191489 1.91489362 36.3191489 0.382978723 34.5319149 0.382978723 34.5319149 9 36.3191489 9 36.3191489 4.59574468 38.8085106 8.10638298 38.8723404 8.10638298 38.9361702 8.10638298 41.4255319 4.59574468 41.4255319 9 43.212766 9 43.212766 0.382978723 41.4255319 0.382978723"></polygon>
                                <path d="M47.2340426,0.382978723 L48,1.91489362 L44.6170213,8.93617021 L46.4042553,8.93617021 L47.2978723,7.14893617 L50.5531915,7.14893617 L51.4468085,8.93617021 L53.2340426,8.93617021 L49.0851064,0.319148936 L47.2340426,0.319148936 L47.2340426,0.382978723 Z M48,5.68085106 L48.893617,3.82978723 L49.787234,5.68085106 L48,5.68085106 Z"></path>
                                <polygon points="60.2553191 0.382978723 60.2553191 5.29787234 56.4255319 1.9787234 56.4255319 0.382978723 54.7021277 0.382978723 54.7021277 8.87234043 54.7021277 9 56.4255319 9 56.4255319 8.87234043 56.4255319 4.14893617 61.6595745 9 61.9787234 9 61.9787234 0.382978723"></polygon>
                                <polygon points="32.6170213 0.382978723 30.5744681 0.382978723 27.2553191 3.76595745 26.8723404 3.76595745 26.8723404 0.382978723 25.0851064 0.382978723 25.0851064 3.76595745 25.0851064 5.29787234 25.0851064 9 26.8723404 9 26.8723404 5.29787234 27.1276596 5.29787234 30.5744681 9 32.7446809 9 28.5957447 4.59574468"></polygon>
                                <polygon points="20.5531915 5.29787234 16.787234 1.85106383 16.787234 0.382978723 15 0.382978723 15 8.87234043 15 9 16.787234 9 16.787234 8.87234043 16.787234 4.08510638 22.0212766 9 22.3404255 9 22.3404255 0.382978723 20.5531915 0.382978723"></polygon>
                            </g>
                            <g>
                                <polygon fill="#151015" points="8.93617021 7.91489362 21.2553191 0.510638298 21.2553191 15.3191489"></polygon>
                                <path d="M0.829787234,2.17021277 C1.14893617,1.85106383 5.42553191,4.0212766 5.87234043,4.0212766 C6.31914894,4.0212766 8.68085106,5.36170213 9,5.68085106 C9.31914894,6 11.4255319,7.59574468 11.4255319,8.04255319 C11.4255319,9 6.82978723,12.0638298 5.87234043,12.0638298 C5.42553191,12.0638298 1.14893617,14.1702128 0.829787234,13.9148936 C0.510638298,13.5957447 0.319148936,8.55319149 0.319148936,8.04255319 C0.319148936,7.53191489 0.510638298,2.42553191 0.829787234,2.17021277 Z" fill="url(#linearGradient-1)"></path>
                                <path d="M0.510638298,1.21276596 C0.638297872,1.08510638 6,4.08510638 6.25531915,4.08510638 C6.5106383,4.08510638 9.25531915,5.74468085 9.44680851,5.87234043 C9.57446809,6 12.2553191,7.78723404 12.2553191,8.04255319 C12.2553191,8.4893617 6.76595745,12 6.25531915,12 C6,12 0.70212766,15 0.510638298,14.8723404 C0.382978723,14.7446809 0.255319149,8.29787234 0.255319149,8.10638298 C0.319148936,7.72340426 0.382978723,1.34042553 0.510638298,1.21276596 Z" fill="url(#linearGradient-2)"></path>
                                <polygon fill="url(#linearGradient-3)" points="13.0851064 7.9787234 6.63829787 4.08510638 0.255319149 0.255319149 0.255319149 7.9787234 0.255319149 15.7021277 6.63829787 11.8085106"></polygon>
                                <path d="M1.14893617,3.06382979 C1.59574468,2.61702128 4.78723404,3.89361702 5.4893617,3.89361702 C6.19148936,3.89361702 8.10638298,4.9787234 8.55319149,5.42553191 C9,5.87234043 10.5957447,7.27659574 10.5957447,7.9787234 C10.5957447,9.38297872 6.89361702,12.0638298 5.4893617,12.0638298 C4.78723404,12.0638298 1.59574468,13.3404255 1.14893617,12.893617 C0.70212766,12.4468085 0.382978723,8.68085106 0.382978723,7.9787234 C0.382978723,7.27659574 0.70212766,3.57446809 1.14893617,3.06382979 Z" fill="url(#linearGradient-4)"></path>
                                <path d="M1.46808511,4.0212766 C2.10638298,3.38297872 4.21276596,3.82978723 5.10638298,3.82978723 C6.06382979,3.82978723 7.53191489,4.59574468 8.10638298,5.17021277 C8.74468085,5.80851064 9.70212766,7.0212766 9.70212766,7.91489362 C9.70212766,9.76595745 6.89361702,12.0638298 5.04255319,12.0638298 C4.14893617,12.0638298 2.04255319,12.4468085 1.40425532,11.8723404 C0.765957447,11.2340426 0.382978723,8.87234043 0.382978723,7.91489362 C0.446808511,7.0212766 0.829787234,4.65957447 1.46808511,4.0212766 Z" fill="url(#linearGradient-5)"></path>
                                <path d="M8.93617021,7.9787234 C8.93617021,10.2765957 7.08510638,12.1914894 4.72340426,12.1914894 C2.42553191,12.1914894 0.510638298,10.3404255 0.510638298,7.9787234 C0.510638298,6.82978723 0.957446809,5.74468085 1.72340426,4.9787234 C2.4893617,4.21276596 3.5106383,3.76595745 4.72340426,3.76595745 C5.87234043,3.76595745 6.95744681,4.21276596 7.72340426,4.9787234 C8.42553191,5.74468085 8.93617021,6.82978723 8.93617021,7.9787234 Z" fill="url(#linearGradient-6)"></path>
                                <path d="M4.9787234,3.82978723 C5.55319149,3.82978723 7.08510638,5.10638298 7.46808511,5.42553191 C7.85106383,5.80851064 9.06382979,7.34042553 9.06382979,7.91489362 C9.06382979,9.06382979 6.12765957,12.0638298 4.91489362,12.0638298 C3.76595745,12.0638298 0.765957447,9.12765957 0.765957447,7.91489362 C0.765957447,7.34042553 2.04255319,5.80851064 2.36170213,5.42553191 C2.87234043,5.10638298 4.40425532,3.82978723 4.9787234,3.82978723 Z" fill="url(#linearGradient-7)"></path>
                                <polygon fill="url(#linearGradient-8)" points="5.23404255 12 1.21276596 7.9787234 5.23404255 3.89361702 9.31914894 7.9787234"></polygon>
                                <polygon fill="url(#linearGradient-9)" points="6.19148936 4.40425532 9.63829787 7.9787234 6.19148936 11.4893617 4.34042553 10.1489362 2.36170213 7.9787234 4.34042553 5.80851064"></polygon>
                                <polygon fill="url(#linearGradient-10)" points="7.08510638 4.91489362 9.95744681 7.9787234 7.08510638 10.9787234 5.23404255 10.0851064 3.57446809 7.9787234 5.23404255 5.87234043"></polygon>
                                <polygon fill="url(#linearGradient-11)" points="7.9787234 5.42553191 10.2765957 7.9787234 7.9787234 10.4680851 6.12765957 10.0212766 4.72340426 7.9787234 6.12765957 5.87234043"></polygon>
                                <polygon fill="url(#linearGradient-12)" points="8.87234043 9.95744681 10.5319149 7.9787234 8.87234043 5.93617021 7.08510638 5.93617021 5.87234043 7.9787234 7.08510638 9.95744681"></polygon>
                                <polygon fill="url(#linearGradient-13)" points="11.1702128 7.91489362 9.5106383 6.63829787 7.72340426 6.44680851 7.14893617 7.91489362 7.72340426 9.38297872 9.5106383 9.19148936"></polygon>
                                <polygon fill="url(#linearGradient-14)" points="11.8085106 7.85106383 10.0851064 7.40425532 8.36170213 6.89361702 8.36170213 7.85106383 8.36170213 8.80851064 10.0851064 8.36170213"></polygon>
                            </g>
                        </g>
                    </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>