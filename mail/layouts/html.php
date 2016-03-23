<?php

use app\models\Address;
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head style='background-color:#2c1212'>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <title><?php
            if (!isset($this->title))
                $this->title = Yii::$app->name;
            echo Html::encode($this->title);
            ?></title>
        <style type="text/css">
            body, td { font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; font-size:14px; }
            body { background-color: #2c1212; margin: 0; padding: 0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
            h2{ padding-top:12px; /* ne fonctionnera pas sous Outlook 2007+ */color:#0E7693; font-size:22px; }
            .article-content {
                padding: 50px 0;
            }
            @media only screen and (max-width: 480px) { 

                table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
                table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }  
                table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
                table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
                img{ height:auto;}
                /*illisible, on passe donc sur 3 lignes */
                table[class=w180], td[class=w180], img[class=w180] { 
                    width:280px !important; 
                    display:block;
                }    
                td[class=w20]{ display:none; }    
            } 

        </style>
        <?php $this->head() ?>
    </head>

    <body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">

        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0f0f0" >
            <tbody>
                <tr>
                    <td class="w640"  width="640" height="15" bgcolor="#f0f0f0"></td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#F0F0F0">
                        <table  cellpadding="0" cellspacing="0" border="0">
                            <tbody>                            
                                <!--  separateur horizontal de 15px de haut -->
                                <tr>
                                    <td class="w640"  width="640" height="15" bgcolor="#f60100"></td>
                                </tr>
                                <!-- entete -->
                                <tr class="pagetoplogo">
                                    <td class="w640"  width="640">
                                        <table  class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#97cccd">
                                            <tbody>
                                                <tr>
                                                    <td class="w30"  width="30"></td>
                                                    <td  class="w580"  width="580" valign="middle" align="left">
                                                        <div class="pagetoplogo-content">
                                                            <h1 style="color:#FFFFFF; font-size:30px; padding-top:12px; text-align: center;text-transform:uppercase;font-weight:200;letter-spacing: 2px;">
                                                                <?= Html::encode($this->title) ?> 
                                                            </h1>
                                                        </div>
                                                    </td> 
                                                    <td class="w30"  width="30"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!--  separateur horizontal de 15px de haut -->
                                <tr>
                                    <td class="w640"  width="640" height="15" bgcolor="#f60100"></td>
                                </tr>
                                <!--  separateur horizontal de 15px de haut -->
                                <tr>
                                    <td class="w640"  width="640" height="15" bgcolor="#ffffff"></td>
                                </tr>
                                <!-- contenu -->
                                <tr class="content">
                                    <td class="w640" class="w640"  width="640" bgcolor="#ffffff">
                                        <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td  class="w30"  width="30"></td>
                                                    <td  class="w580"  width="580">
                                                        <!-- une zone de contenu -->
                                                        <table class="w580"  width="580" cellpadding="0" cellspacing="0" border="0">
                                                            <tbody>                                                            
                                                                <tr>
                                                                    <td class="w580"  width="580">


                                                                        <div align="left" class="article-content">
                                                                            <?php $this->beginBody() ?>
                                                                            <?= $content ?>
                                                                            <?php $this->endBody() ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- fin zone -->                                                   


                                                    </td>
                                                    <td class="w30" class="w30"  width="30"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <!--  separateur horizontal de 15px de haut -->
                                <tr>
                                    <td class="w640"  width="640" height="15" bgcolor="#ffffff"></td>
                                </tr>

                                <!-- pied de page -->
                                <tr class="pagebottom">
                                    <td class="w640"  width="640">
                                        <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#2c1212">
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" height="10"></td>
                                                </tr>
                                                <tr>
                                                    <td class="w30"  width="30"></td>
                                                    <td class="w580"  width="580" valign="top">
                                                        <p align="right" class="pagebottom-content-left" style="color:#FFFFFF">
                                                            &copy; <?php
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
                                                        </p>
                                                    </td>

                                                    <td class="w30"  width="30"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" height="10"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w640"  width="640" height="60"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
<?php $this->endPage() ?>
