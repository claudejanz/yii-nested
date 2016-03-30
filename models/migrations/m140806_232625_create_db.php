<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m140806_232625_create_db extends Migration
{

    public function up()
    {
        $tableOptions = NULL;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        $this->createTable('layout', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'path' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
                ], $tableOptions);

        $this->createTable('page', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NULL DEFAULT NULL',
            'breadcrumb_text' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'type' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'layout_id' => Schema::TYPE_INTEGER . '(11) NULL',
            'meta_description' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'meta_keywords' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'published' => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'controller' => Schema::TYPE_STRING . '(45) NOT NULL',
            'action' => Schema::TYPE_STRING . '(45) NOT NULL',
            'params' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'home_page' => Schema::TYPE_BOOLEAN . ' NULL DEFAULT NULL',
            'orderable' => Schema::TYPE_BOOLEAN . ' NULL DEFAULT 1',
            'root_menu' => Schema::TYPE_STRING . '(45) NULL DEFAULT NULL',
            'rights'  => Schema::TYPE_STRING . '(45) NULL DEFAULT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'UNIQUE INDEX slug_UNIQUE (slug ASC)',
            'INDEX index_controller (controller ASC)',
            'INDEX index_action (action ASC)',
            'INDEX index_params (params ASC)',
            'INDEX index_parent (parent_id ASC)',
            'INDEX fk_page_layout_idx (layout_id ASC)',
            'FOREIGN KEY (layout_id) REFERENCES layout (id) ON DELETE SET NULL ON UPDATE CASCADE',
            'FOREIGN KEY (parent_id) REFERENCES page (id) ON DELETE SET NULL ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('page_lang', [
            'id' => Schema::TYPE_PK,
            'page_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NULL DEFAULT NULL',
            'meta_description' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'meta_keywords' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'breadcrumb_text' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            'UNIQUE INDEX slug_UNIQUE (slug ASC)',
            'FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('place', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'layout_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'INDEX index_title (title ASC)',
            'INDEX index_layout_id (layout_id ASC)',
            'FOREIGN KEY (layout_id) REFERENCES layout (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('menu', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'page_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'menu_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'type' => Schema::TYPE_INTEGER . '(4) NULL DEFAULT NULL',
            'visible' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
            'FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE SET NULL  ON UPDATE SET NULL ',
            'INDEX index_title (title ASC)'
                ], $tableOptions);

        $this->createTable('element', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'class_css' => Schema::TYPE_INTEGER . '(4) NULL DEFAULT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'display_title' => Schema::TYPE_INTEGER . '(1) NULL DEFAULT NULL',
            'type' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_title (title ASC)'
                ], $tableOptions);

        $this->createTable('element_lang', [
            'id' => Schema::TYPE_PK,
            'element_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            
            'INDEX index_element_id (element_id ASC)',
            'FOREIGN KEY (element_id) REFERENCES element (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('element_text', [
            'id' => Schema::TYPE_PK,
            'element_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_element_id (element_id ASC)',
            'FOREIGN KEY (element_id) REFERENCES element (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('element_text_lang', [
            'id' => Schema::TYPE_PK,
            'element_text_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            
            'INDEX index_element_text_id (element_text_id ASC)',
            'FOREIGN KEY (element_text_id) REFERENCES element_text (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('element_image', [
            'id' => Schema::TYPE_PK,
            'element_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'url' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_element_id (element_id ASC)',
            'FOREIGN KEY (element_id) REFERENCES element (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);


        $this->createTable('place_element', [
            'id' => Schema::TYPE_PK,
            'place_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'element_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT 1',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_place (place_id ASC)',
            'FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
            'INDEX index_element (element_id ASC)',
            'FOREIGN KEY (element_id) REFERENCES element (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
                ], $tableOptions);

        $this->createTable('page_element', [
            'id' => Schema::TYPE_PK,
            'page_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'element_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT 1',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_page (page_id ASC)',
            'FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
            'INDEX index_element (element_id ASC)',
            'FOREIGN KEY (element_id) REFERENCES element (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
                ], $tableOptions);





        $this->createTable('element_slideshow', [
            'id' => Schema::TYPE_PK,
            'stretchImages' => Schema::TYPE_INTEGER . '(4) NOT NULL DEFAULT 2',
            'element_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_element (element_id ASC)',
            'FOREIGN KEY (element_id) REFERENCES element (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('element_slideshow_image', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(45) NOT NULL',
            'element_slideshow_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 1',
            'size' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'url' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_element_slideshow (element_slideshow_id ASC)',
            'FOREIGN KEY (element_slideshow_id) REFERENCES element_slideshow (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('element_slideshow_image_lang', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(45) NOT NULL',
            'element_slideshow_image_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX element_slideshow_image (element_slideshow_image_id ASC)',
            'FOREIGN KEY (element_slideshow_image_id) REFERENCES element_slideshow_image (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);
        
        
         $this->createTable('sport', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'icon' => Schema::TYPE_STRING . '(255) NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT 1',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_title (title ASC)'
                ], $tableOptions);
         
         $this->createTable('sport_lang', [
            'id' => Schema::TYPE_PK,
            'sport_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            
            'INDEX index_sport_id (sport_id ASC)',
            'FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('category', [
            'id' => Schema::TYPE_PK,
            'sport_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT 1',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_title (title ASC)',
            'INDEX index_sport (sport_id ASC)',
            'FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE ON UPDATE CASCADE ',
                ], $tableOptions);
        
        $this->createTable('category_lang', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            
            'INDEX index_category_id (category_id ASC)',
            'FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);

        $this->createTable('sub_category', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT 1',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_title (title ASC)',
            'INDEX index_category (category_id ASC)',
            'FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ON UPDATE CASCADE ',
                ], $tableOptions);
        
         $this->createTable('sub_category_lang', [
            'id' => Schema::TYPE_PK,
            'sub_category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            
            'INDEX index_sub_category_id (sub_category_id ASC)',
            'FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);
        
         $this->createTable('week', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'words_of_the_week' => Schema::TYPE_STRING . '(1024) NULL DEFAULT NULL',
            'sportif_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'date_begin' => Schema::TYPE_DATE . ' NOT NULL',
            'date_end' => Schema::TYPE_DATE . ' NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'INDEX index_date_begin (date_begin ASC)',
            'INDEX index_date_end (date_end ASC)',
            'INDEX index_sportif (sportif_id ASC)',
            'FOREIGN KEY (sportif_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_title (title ASC)',
                ], $tableOptions);
         
         $this->createTable('day', [
            'id' => Schema::TYPE_PK,
            'training_city' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'sportif_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'week_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'INDEX index_training_city (training_city ASC)',
            'INDEX index_date (date ASC)',
            'INDEX index_sportif (sportif_id ASC)',
            'FOREIGN KEY (sportif_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_week (week_id ASC)',
            'FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE ON UPDATE CASCADE ',
                ], $tableOptions);
        
        $this->createTable('training', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'sport_id' => Schema::TYPE_INTEGER . '(11) NOT NULL ',
            'category_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'sub_category_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'sportif_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'day_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'week_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'time' => Schema::TYPE_TIME. ' NULL DEFAULT NULL',
            'rpe' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'explanation' => Schema::TYPE_TEXT,
            'extra_comment' => Schema::TYPE_TEXT,
            'graph' => Schema::TYPE_TEXT ,
            'graph_type' => Schema::TYPE_INTEGER . '(11)',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            
            'INDEX index_title (title ASC)',
            'INDEX index_date (date ASC)',
            'INDEX index_sport (sport_id ASC)',
            'FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_category (category_id ASC)',
            'FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_sub_category (sub_category_id ASC)',
            'FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_sportif (sportif_id ASC)',
            'FOREIGN KEY (sportif_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_day (day_id ASC)',
            'FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_week (week_id ASC)',
            'FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE ON UPDATE CASCADE ',
                ], $tableOptions);
        
       
        
        $this->createTable('reporting', [
            'id' => Schema::TYPE_PK,
            'training_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'feedback' => Schema::TYPE_TEXT,
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'week_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'sport_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'km' => Schema::TYPE_FLOAT . ' NOT NULL',
            'done' => Schema::TYPE_BOOLEAN . ' NULL DEFAULT NULL',
            'time_done' => Schema::TYPE_BOOLEAN . ' NULL DEFAULT NULL',
            'time' => Schema::TYPE_TIME,
            'feeled_rpe' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX training (training_id ASC)',
            'FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_week (week_id ASC)',
            'FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_sport (sport_id ASC)',
            'FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE ON UPDATE CASCADE ',
                ], $tableOptions);
        

        
        
        

        $this->createTable('training_type', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'sport_id' => Schema::TYPE_INTEGER . '(11) NOT NULL ',
            'category_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'sub_category_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'time' => Schema::TYPE_TIME. ' NULL DEFAULT NULL',
            'rpe' => Schema::TYPE_FLOAT . ' NULL DEFAULT NULL',
            'explanation' => Schema::TYPE_TEXT,
            'extra_comment' => Schema::TYPE_TEXT,
            'graph' => Schema::TYPE_TEXT ,
            'graph_type' => Schema::TYPE_INTEGER . '(11)',
            'published' => Schema::TYPE_INTEGER . '(4) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            
            'INDEX index_title (title ASC)',
            'INDEX index_sport (sport_id ASC)',
            'FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_category (category_id ASC)',
            'FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ON UPDATE CASCADE ',
            'INDEX index_sub_category (sub_category_id ASC)',
            'FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE ON UPDATE CASCADE ',
                ], $tableOptions);
        
        $this->createTable('training_type_lang', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'training_type_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'explanation' => Schema::TYPE_TEXT,
            'extra_comment' => Schema::TYPE_TEXT,
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            
            'INDEX index_training_type_id (training_type_id ASC)',
            'FOREIGN KEY (training_type_id) REFERENCES training_type (id) ON DELETE CASCADE ON UPDATE CASCADE',
                ], $tableOptions);
        
         $this->createTable('user_sport', [
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'sport_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'PRIMARY KEY (user_id, sport_id)',
            'INDEX index_user (user_id ASC)',
            'FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
            'INDEX index_sport (sport_id ASC)',
            'FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE  ON UPDATE CASCADE ',
                ], $tableOptions);
        
        
        
          $this->createTable('address', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'street' => Schema::TYPE_STRING . '(255) NOT NULL',
            'city' => Schema::TYPE_STRING . '(255) NOT NULL',
            'lat' => Schema::TYPE_FLOAT . ' NOT NULL',
            'lng' => Schema::TYPE_FLOAT . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
                ], $tableOptions);

       
    }

    public function down()
    {
        $this->dropTable('address');
        $this->dropTable('user_sport');
        $this->dropTable('training_type_lang');
        $this->dropTable('training_type');
        $this->dropTable('reporting');
        $this->dropTable('training');
        $this->dropTable('day');
        $this->dropTable('week');
        $this->dropTable('sub_category_lang');
        $this->dropTable('sub_category');
        $this->dropTable('category_lang');
        $this->dropTable('category');
        $this->dropTable('sport_lang');
        $this->dropTable('sport');
        $this->dropTable('element_slideshow_image_lang');
        $this->dropTable('element_slideshow_image');
        $this->dropTable('element_slideshow');
        $this->dropTable('place_element');
        $this->dropTable('page_element');
        $this->dropTable('element_image');
        $this->dropTable('element_text_lang');
        $this->dropTable('element_text');
        $this->dropTable('element_lang');
        $this->dropTable('element');
        $this->dropTable('place');
        $this->dropTable('menu');
        $this->dropTable('page_lang');
        $this->dropTable('page');
        $this->dropTable('layout');
        return true;
    }

}
