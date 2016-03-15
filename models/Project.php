<?php

namespace app\models;

use app\models\base\ProjectBase;
use app\models\querys\ProjectQuery;
use claudejanz\toolbox\models\behaviors\AutoSlugBehavior;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

class Project extends ProjectBase
{

    public function rules()
    {

        return array_merge([
            ['published', 'default', 'value' => PublishBehavior::PUBLISHED_ACTIF],
            ['category', 'default', 'value' => self::CATEGORY_HABITATIONS],
            ['keywords', 'default', 'value' => function($model,$attribute){
                return mb_strtolower(join(', ',preg_split('@\.|\s@', $model->title)), 'UTF-8');
            }],
                ], parent::rules());
    }

    public function behaviors()
    {
        return array(
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'publish' => [
                'class' => PublishBehavior::className(),
            ],
            'autoSlug' => [
                'class' => AutoSlugBehavior::className(),
//                'addLanguage' => true,
            ],
        );
    }

    public static function find()
    {
        $q = new ProjectQuery(get_called_class());
        $q->orderBy('project.weight');
        return $q;
    }

    /**
     * Returns model display label
     * @param number $n
     * @return string
     */
    public static function getLabel($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Project} other{Projects}}', ['n' => $n]);
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectImage()
    {
        return $this->hasOne(ProjectImage::className(), ['project_id' => 'id'])->representFirst();
    }

    public static function loadMultipleWithFiles($models, $data, $formName = null)
    {
        if ($formName === null) {
            /* @var $first Model */
            $first = reset($models);
            if ($first === false) {
                return false;
            }
            $formName = $first->formName();
        }
        var_dump($formName);
        $success = false;
        foreach ($models as $i => $model) {
            /* @var $model Model */
            if ($formName == '') {
                if (!empty($data[$i])) {
                    $model->loadWithFiles($data[$i], '');
                    $success = true;
                }
            } elseif (!empty($data[$formName][$i])) {
                $model->loadWithFiles($data[$formName][$i], '', "[$i]");
                $success = true;
            }
        }

        return $success;
    }

    const CATEGORY_RENOVATIONS = 'Renovations';
    const CATEGORY_HABITATIONS = 'Habitations';
    const CATEGORY_INTERNATIONALS = 'Interationals';
    const CATEGORY_CONCOURS = 'Contest';

    /**
     * @return array category names indexed by category IDs
     */
    public static function getCategoryOptions()
    {
        return array(
            self::CATEGORY_RENOVATIONS => Yii::t('app', 'Renovations'),
            self::CATEGORY_HABITATIONS => Yii::t('app', 'Habitations'),
            self::CATEGORY_INTERNATIONALS => Yii::t('app', 'Interationals'),
            self::CATEGORY_CONCOURS => Yii::t('app', 'Contest'),
        );
    }
    
    /**
     * get label for category
     * @return type
     */
    public function getCategoryLabel()
    {
       $model = $this->owner;
        $publishedOptions = self::getCategoryOptions();
        return isset($publishedOptions[$model->category]) ? $publishedOptions[$model->category] : "unknown category ($model->category)";
    
    }

}
