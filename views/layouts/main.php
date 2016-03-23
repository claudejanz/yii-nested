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
        <title><?= Html::encode(Yii::$app->controller->page->title) ?></title>

        <!-- CONFIGURATION -->

        <!-- Allow web app to be run in full-screen mode. -->
        <meta name="apple-mobile-web-app-capable"
              content="yes">

        <!-- Make the app title different than the page title. -->
        <meta name="apple-mobile-web-app-title"
              content="Mulaff Training">

        <!-- Configure the status bar. -->
        <meta name="apple-mobile-web-app-status-bar-style"
              content="black">

        <!-- Disable automatic phone number detection. -->
        <meta name="format-detection"
              content="telephone=no">

        <!-- ICONS -->

        <!-- iPad retina icon -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone152.png') ?>"
              sizes="152x152"
              rel="apple-touch-icon-precomposed">

        <!-- iPad retina icon (iOS < 7) -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone144.png') ?>"
              sizes="144x144"
              rel="apple-touch-icon-precomposed">

        <!-- iPad non-retina icon -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone76.png') ?>"
              sizes="76x76"
              rel="apple-touch-icon-precomposed">

        <!-- iPad non-retina icon (iOS < 7) -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone72.png') ?>"
              sizes="72x72"
              rel="apple-touch-icon-precomposed">

        <!-- iPhone 6 Plus icon -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone120.png') ?>"
              sizes="120x120"
              rel="apple-touch-icon-precomposed">

        <!-- iPhone retina icon (iOS < 7) -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone114.png') ?>"
              sizes="114x114"
              rel="apple-touch-icon-precomposed">

        <!-- iPhone non-retina icon (iOS < 7) -->
        <link href="<?= Yii::getAlias('@web/images/mobile/iphone57.png') ?>"
              sizes="57x57"
              rel="apple-touch-icon-precomposed">

        <!-- STARTUP IMAGES -->

        <!-- iPad retina portrait startup image -->
        <link href="<?= Yii::getAlias('@web/images/mobile/startup1536x2008.png') ?>"
              media="(device-width: 768px) and (device-height: 1024px)
              and (-webkit-device-pixel-ratio: 2)
              and (orientation: portrait)"
              rel="apple-touch-startup-image">

        <!-- iPad retina landscape startup image -->
        <link href="<?= Yii::getAlias('@web/images/mobile/startup2048x1496.png') ?>"
              media="(device-width: 768px) and (device-height: 1024px)
              and (-webkit-device-pixel-ratio: 2)
              and (orientation: landscape)"
              rel="apple-touch-startup-image">

        <!-- iPhone 6 Plus portrait startup image -->
        <link href="<?= Yii::getAlias('@web/images/mobile/startup1242x2148.png') ?>"
              media="(device-width: 414px) and (device-height: 736px)
              and (-webkit-device-pixel-ratio: 3)
              and (orientation: portrait)"
              rel="apple-touch-startup-image">

        <!-- iPhone 6 Plus landscape startup image -->
        <link href="<?= Yii::getAlias('@web/images/mobile/startup2208x1182.png') ?>"
              media="(device-width: 414px) and (device-height: 736px)
              and (-webkit-device-pixel-ratio: 3)
              and (orientation: landscape)"
              rel="apple-touch-startup-image">

        <!-- iPhone 6 startup image -->
        <link href="<?= Yii::getAlias('@web/images/mobile/startup750x1294.png') ?>"
              media="(device-width: 375px) and (device-height: 667px)
              and (-webkit-device-pixel-ratio: 2)"
              rel="apple-touch-startup-image">

        <!-- iPhone 5 startup image -->
        <link href="<?= Yii::getAlias('@web/images/mobile/startup640x1096.png') ?>"
              media="(device-width: 320px) and (device-height: 568px)
              and (-webkit-device-pixel-ratio: 2)"
              rel="apple-touch-startup-image">


        <?= Html::csrfMetaTags() ?>
        <?= Html::tag('meta', '', ['name' => 'description', 'content' => Yii::$app->controller->page->meta_description]); ?>
        <?= Html::tag('meta', '', ['name' => 'keywords', 'content' => Yii::$app->controller->page->meta_keywords]); ?>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,700,300,900' rel='stylesheet' type='text/css'>
        <?php $this->head() ?>
    </head>
    <?php
    $class = '';
    if (Yii::$app->user->isGuest) {
        $class = 'login';
    } elseif (Yii::$app->user->can('coach')) {
        $class = 'coaches';
    } else {
        $class = 'sportifs';
    }
    ?>
    <body class="<?= $class; ?>">
        <?php $this->beginBody() ?>
        <div class="wrap">    
            <?php
            if (!Yii::$app->user->isGuest) {
                NavBar::begin([
                    'innerContainerOptions' => ['class' => 'container-fluid'],
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
                    $turl = Url::to(array_merge([$route], $params));
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
            }
            ?>
            <?= $content ?>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <address class="pull-left">&copy; <?php
                    echo date('Y') . ', ';
                    echo 'Mulaff SA, ';
                    $adresses = Address::find()->all();
                    $messages = [];
                    foreach ($adresses as $address) {

                        $messages[] = $address->street . ', ' .
                                $address->city;
                    }
                    echo join(' et ', $messages);
                    ?>
                </address>
                <p class="pull-right">Powered by klod.ch</p>
            </div>
        </footer>
        <?php // GoogleAnalytics::widget();  ?>
        <?php //Google::widget(['pageId'=>'+KlodCh']); ?>
        <?= AjaxModal::widget(); ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage() ?>
