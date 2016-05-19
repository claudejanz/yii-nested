<?php

use app\models\behaviors\GraphTypeBehavior;
use app\models\Category;
use app\models\Sport;
use app\models\SubCategory;
use app\models\TrainingType;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use moonland\phpexcel\Excel;
use yii\db\Migration;

class m160229_181714_excel_import extends Migration
{

    private $actualSportId;
    private $actualCatId;
    private $actualSubCatId;

    public function up()
    {
        $data = Excel::import(Yii::getAlias('@app/migrations/excel/mulaff_endurance_coaching_app.xls'), [
                    'getOnlySheet' => 'MULAFF ENDURANCE COACHING APP',
                    'setFirstRecordAsKeys' => true,
                    'setIndexSheetByName' => true,
        ]);
        foreach ($data as $line) {
            $this->setSportId($line);
            $this->setCatId($line);
            $this->setSubCatId($line);
            if (!empty($line['DESCRIPTION'])) {
                $tt = new TrainingType();
                $tt->setAttributes([
                    'sport_id' => $this->actualSportId,
                    'category_id' => $this->actualCatId,
                    'sub_category_id' => $this->actualSubCatId,
                    'title' => $line['DESCRIPTION'],
                    'time' => str_replace('h', ':', $line['DUREE']),
                    'rpe' => $line['RPE'],
                    'explanation' => $line['EXPLICATION'],
                    'extra_comment' => $line['COMMENTS PERSO (en grisé)'],
                    'graph' => mb_strtoupper($line['GRAPHIQUE'], 'UTF-8'),
                    'graph_type' => $this->getGraphType($line),
                    'published' => PublishBehavior::PUBLISHED_ACTIF,
                ]);
                if (!$tt->save())
                    var_dump(get_class($tt), $tt->errors);
            }
        }
        return true;
    }

    public function down()
    {
        $this->delete('training_type');
        $this->delete('sub_category');
        $this->delete('category');
        $this->delete('sport');
        return true;
    }

    public function setSportId($line)
    {
        $name = ucfirst(strtolower($line['SPORTS']));
        $sport = Sport::findOne(['title' => $name]);

        if (!$sport && $line['SPORTS'] != null) {
            $sport = new Sport();
            $sport->setAttributes([
                'title' => $name,
                'published' => PublishBehavior::PUBLISHED_ACTIF,
                'icon' => $this->getIcon($name),
            ]);
            if (!$sport->save())
                var_dump(get_class($sport), $sport->errors);
            $this->actualCatId = null;
            $this->actualSubCatId = null;
        }
        if ($sport) {
            $this->actualSportId = $sport->id;
        }
    }

    public function setCatId($line)
    {
        $name = ucfirst(strtolower($line['CATEGORIE']));
        $cat = Category::findOne([
                    'title' => $name,
                    'sport_id' => $this->actualSportId,
        ]);
        if (!$cat && $name != null) {
            $cat = new Category();
            $cat->setAttributes([
                'title' => $name,
                'published' => PublishBehavior::PUBLISHED_ACTIF,
                'sport_id' => $this->actualSportId,
            ]);
            if (!$cat->save())
                var_dump(get_class($cat), $cat->errors);
            $this->actualSubCatId = null;
        }
        if ($cat) {
            $this->actualCatId = $cat->id;
        }
    }

    public function setSubCatId($line)
    {
        $name = ucfirst(strtolower($line['SOUS-CATEGORIE']));
        $subcat = SubCategory::findOne([
                    'title' => $name,
                    'category_id' => $this->actualCatId,
        ]);
        if (!$subcat && $name != null) {
            $subcat = new SubCategory();
            $subcat->setAttributes([
                'title' => $name,
                'published' => PublishBehavior::PUBLISHED_ACTIF,
                'category_id' => $this->actualCatId,
            ]);
            if (!$subcat->save())
                var_dump(get_class($subcat), $subcat->errors);
        }
        if ($subcat) {
            $this->actualSubCatId = $subcat->id;
        }
    }

    public function getGraphType($line)
    {
        switch ($line['TYPE GRAPHIQUE']) {
            case 'Colonne histogramme':
                return GraphTypeBehavior::GRAPH_TYPE_HISTOGRAMME;
                break;
            case 'Courbe de Bézier':
                return GraphTypeBehavior::GRAPH_TYPE_BEZIER;
                break;
            default:
                return null;
        }
    }

    public function getIcon($name)
    {
        switch ($name) {
            case 'Course A Pied':
            case'Piste':
                return 'sports';
            case 'Marche':
                return 'sports-7';
            case'Velo Rouleau':
                return 'man';
            case'Vtt':
                return 'mountain';
            case'Spinning':
            case'Velo De Route':
                return 'silhouette-3';
            case'Peau De Phoque':
                return 'sports-6';
            case'Ski De Fond':
            case'Ski A Roulettes':
            case'Ski De Fond':
                return 'sports-9';
            case'Ski Backcountry':
                return 'sports-3';
            case'Natation':
            case'Aqua-jogging':
                return 'summer-1';
            case'Aviron':
            case'Kanu-kajak':
                return 'silhouette-7';
            default:
                return 'cup';
        }
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
