<?php

use app\models\User;
use Faker\Factory;
use yii\db\Migration;

class m140511_124055_users extends Migration
{

    public function up()
    {
        $superadmin = new User();
        $superadmin->scenario = 'create';
        $superadmin->detachBehavior('relation');
        $superadmin->attributes = [
            'username' => 'claudejanz',
            'firstname' => 'Claude',
            'lastname' => 'Janz',
            'address' => '8a chemin de la chenalette',
            'npa' => '1197',
            'city' => 'Prangins',
            'tel' => '+41 22 369 05 85',
            'email' => 'claudejanz@bluewin.ch',
            'password' => '12345678',
            'role' => User::ROLE_SUPERADMIN,
            'language' => 'fr'
        ];
        $superadmin->save();


        $admin = new User();
        $admin->scenario = 'create';
        $admin->detachBehavior('relation');
        $admin->attributes = [
            'username' => 'iwan',
            'firstname' => 'Iwan',
            'lastname' => 'Schuwey',
            'address' => 'Place Bel-Air 5',
            'npa' => '1260',
            'city' => 'Nyon',
            'tel' => '+41 79 220 07 69',
            'email' => 'iwan@mulaff.ch',
            'password' => '12345678',
            'role' => User::ROLE_ADMIN,
            'language' => 'fr'
        ];
        $admin->save();

        $faker = Factory::create('fr_CH');

        $coach = new User();
        $coach->scenario = 'create';
        $coach->detachBehavior('relation');
        $coach->attributes = [
            'username' => 'coach',
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'address' => $faker->streetAddress,
            'npa' => $faker->postcode,
            'city' => $faker->city,
            'tel' => $faker->phoneNumber,
            'email' => $faker->email,
            'password' => '12345678',
            'role' => User::ROLE_COACH,
            'language' => 'fr'
        ];
        $coach->save();
        $languages = array_keys(Yii::$app->params['translatedLanguages']);
        for ($index = 1; $index < 20; $index++) {
            shuffle($languages);
            $sportif = new User();
            $sportif->scenario = 'create';
            $sportif->detachBehavior('relation');
            $lastname = $faker->lastName;
            $firstname = $faker->firstName;
            $email = str_replace(
                            array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë', 'ç', 'ÿ', 'ñ'), array('a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n',
                            ), mb_strtolower($firstname . '.' . $lastname, 'UTF-8')) . '@' . $faker->freeEmailDomain ;
            $sportif->attributes = [
                'username' => 'sportif' . $index,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'address' => $faker->streetAddress,
                'npa' => $faker->postcode,
                'city' => $faker->city,
                'tel' => $faker->phoneNumber,
                'email' => $email,
                'password' => '12345678',
                'trainer_id' => ($index < 10) ? $admin->id : $coach->id,
                'language' => reset($languages),
            ];
            $sportif->save();
        }
    }

    public function down()
    {


        return true;
    }

}
