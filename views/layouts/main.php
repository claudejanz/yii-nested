<?php

use app\assets\AppAsset;
use app\models\Address;
use app\models\Page;
use claudejanz\toolbox\widgets\ajax\AjaxModal;
use kartik\social\GoogleAnalytics;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;

/* @var $this View */
/* @var $content string */

AppAsset::register($this);
AssetBundle::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= Html::csrfMetaTags() ?>
        <?= Html::tag('meta', '', ['name' => 'description', 'content' => Yii::$app->controller->page->meta_description]); ?>
        <?= Html::tag('meta', '', ['name' => 'keywords', 'content' => Yii::$app->controller->page->meta_keywords]); ?>
        <link href='https://fonts.googleapis.com/css?family=Josefin+Sans:400,700,400italic,700italic|News+Cycle:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <title><?= Html::encode(Yii::$app->controller->page->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <?php $this->beginBody() ?>
        <div class="wrap">    
            <?php
            NavBar::begin([
                'innerContainerOptions'=>['class'=>'container-fluid'],
                'brandLabel' => Yii::$app->id,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $pages = Page::find()->where(['parent_id' => null, 'home_page' => null])->all();
            $menus = [];
            foreach ($pages as $page) {
                $menus = array_merge($menus, $page->getBreadcrumbsLink());
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $menus
            ]);

            $items = [];

            list ($route, $params) = Yii::$app->getRequest()->resolve();
            foreach (Yii::$app->params['translatedLanguages'] as $key => $value) {
                $params['language'] = Yii::$app->params['langsNames'][$key];
                $turl = Url::to(array_merge( [$route], $params));
                $items[] = ['label' => $value,
                    'url' => $turl,
                    'linkOptions' => ['data-method' => 'post'],
                    'active' => (Yii::$app->language == Yii::$app->params['langsNames'][$key]) ? true : false];
            }
            $items[] = Yii::$app->user->isGuest ?
                    ['label' => 'login', 'url' => ['/site/login']] :
                    ['label' => 'logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']];

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $items
            ]);

            NavBar::end();
            ?>
            <?= $content ?>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <address class="pull-left">&copy; <?php
                    echo date('Y').', ';
                    echo 'Mulaff SA, ';
                    $adresses = Address::find()->all();
                    $messages = [];
                    foreach ($adresses as $address) {
                        
                        $messages[]= $address->street.', '.
                        $address->city;
                    }
                    echo join(' et ',$messages);
                    ?>
                </address>
                <p class="pull-right">Powered by klod.ch</p>
            </div>
        </footer>
        <?php // GoogleAnalytics::widget(); ?>
        <?php //Google::widget(['pageId'=>'+KlodCh']); ?>
        <?= AjaxModal::widget(); ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage() ?>
