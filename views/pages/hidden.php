<?php

use app\extentions\MulaffGraphWidget;
use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$string = 'I2X20/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X2.30/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I2X20';
$string2 = 'I2X1.50/I1X0.10/I3X1.50/I1X0.10/I4X1.50/I1X0.10/I5X1.50/I1X0.10/I5X1.50/I1X0.10/I4X1.50/I1X0.10/I3X1.50/I1X0.10/I2X1.50';
$string3 = 'I1X1/I4X25/I1X25/I5X25/I1X25/I4X25/I1X25';
echo Html::tag('h2','No lines no legends');
echo MulaffGraphWidget::widget(['value'=>$string,'width'=>300,'height'=>80]);
echo MulaffGraphWidget::widget(['value'=>$string2,'width'=>300,'height'=>80]);
echo MulaffGraphWidget::widget(['value'=>$string3,'width'=>300,'height'=>80,'type'=>2]);
echo Html::tag('h2','No legends');
echo MulaffGraphWidget::widget(['value'=>$string,'width'=>300,'height'=>80,'withLines'=>true]);
echo MulaffGraphWidget::widget(['value'=>$string2,'width'=>300,'height'=>80,'withLines'=>true]);
echo MulaffGraphWidget::widget(['value'=>$string3,'width'=>300,'height'=>80,'withLines'=>true,'type'=>2]);
echo Html::tag('h2','With legends and lines');
echo Html::tag('h3','Grays');
echo MulaffGraphWidget::widget(['value'=>$string,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true]);
echo MulaffGraphWidget::widget(['value'=>$string2,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true]);
echo MulaffGraphWidget::widget(['value'=>$string3,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,'type'=>2]);
echo Html::tag('h3','Rainbow');
echo MulaffGraphWidget::widget(['value'=>$string,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,  'color'=>MulaffGraphWidget::COLOR_RAINBOW]);
echo MulaffGraphWidget::widget(['value'=>$string2,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,  'color'=>MulaffGraphWidget::COLOR_RAINBOW]);
echo MulaffGraphWidget::widget(['value'=>$string3,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,'color'=>MulaffGraphWidget::COLOR_RAINBOW,'type'=>2]);
echo Html::tag('h3','Gradient');
echo MulaffGraphWidget::widget(['value'=>$string,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,  'color'=>MulaffGraphWidget::COLOR_GRADIENT]);
echo MulaffGraphWidget::widget(['value'=>$string2,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,  'color'=>MulaffGraphWidget::COLOR_GRADIENT]);
echo MulaffGraphWidget::widget(['value'=>$string3,'width'=>300,'height'=>80,'withLegends'=>true,'withLines'=>true,'color'=>MulaffGraphWidget::COLOR_GRADIENT,'type'=>2]);

//$data = Excel::import(Yii::getAlias('@app/migrations/excel/mulaff_endurance_coaching_app.xls'),[
//    'getOnlySheet' => 'MULAFF ENDURANCE COACHING APP',
//    'setFirstRecordAsKeys' => true,
//    'setIndexSheetByName' => true,
//]);
//        var_dump($data);
?>
