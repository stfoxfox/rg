<?php
namespace frontend\controllers;

use Yii;
use common\components\controllers\FrontendController;
use yii\base\InvalidParamException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Complex;
use common\models\Flat;
use common\models\Page;
use common\models\DocVersion;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        $this->view->params = [
            'bodyClass' => 'page__main',
            'is_main' => true,
        ];

        $page = Page::findOne(['type' => Page::TYPE_MAIN]);
        if (!$page)
            throw new NotFoundHttpException;

        return $this->render('index', [
            'page' => $page,
        ]);
    }

    public function actionDocuments() {
        /** @var DocVersion $ver */
        $ver = DocVersion::find()->one();
        $category = $ver->doc->category;

        // $this->view->params['bodyClass'] = 'page--documents';
        $this->setTitleAndBreadcrumbs($category->title, [
            ['label' => 'Документы'],
        ]);

        return $this->render('documents', ['documents' => $category->getDocs()->orderBy('sort')->all()]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionContact() {
        $this->setTitleAndBreadcrumbs('Офис продаж', [
            ['label' => 'Офис продаж'],
        ]);

        $page = Page::findOne(['type' => Page::TYPE_CONTACT]);
        if (!$page)
            throw new NotFoundHttpException;

        return $this->render('contact', [
            'page' => $page,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAbout() {
        $this->view->params['bodyClass'] = 'page--about';
        $this->setTitleAndBreadcrumbs('Корпорация ФСК лидер', [
            ['label' => 'О застройщике'],
        ]);

        $page = Page::findOne(['type' => Page::TYPE_ABOUT]);
        if (!$page)
            throw new NotFoundHttpException;

        return $this->render('about', [
            'page' => $page,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionError() {
        $code = null;
        $exception = Yii::$app->errorHandler->exception;
        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        }

        $this->setTitleAndBreadcrumbs(($code) ? 'Ошибка ' . $code : 'Ошибка', [
            ['label' => 'Страница не найдена'],
        ]);

        return $this->render('error', [
            'exception' => $exception,
            'flats' => Flat::getThree($this->complex_id),
        ]);
    }

    /**
     * @info TEST action
     * @param $complex_id
     * @param $best_flat
     * @return string
     */
    public function actionComplexView($complex_id, $best_flat) {
        $complex = Complex::findOne($complex_id);
        $flat = Flat::findOne($best_flat);

        return $this->render(Html::tag('h3', 'Комплекс: ' . $complex->title) . Html::tag('h3', 'Лучшая квартира №' . $flat->number));
    }

    /**
     * @return Complex
     * @throws NotFoundHttpException
     */
    protected function findComplex() {
        $model = Complex::findOne($this->complex_id);
        if ($model === null) {
            throw new NotFoundHttpException('Комплекс не найден');
        }

        return $model;
    }
}
