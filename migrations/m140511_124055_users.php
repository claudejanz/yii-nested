<?php

use app\models\User;
use Faker\Factory;
use yii\db\Migration;

class m140511_124055_users extends Migration
{

    public function up()
    {
        $faker = Factory::create('fr_CH');

        $superadmin = new User();
        $superadmin->scenario = 'create';
        $superadmin->detachBehavior('relation');
        $superadmin->attributes = [
            'username'  => 'claudejanz',
            'firstname' => 'Claude',
            'lastname'  => 'Janz',
            'address'   => '8a chemin de la chenalette',
            'npa'       => '1197',
            'city'      => 'Prangins',
            'tel'       => '+41 22 369 05 85',
            'email'     => 'claudejanz@bluewin.ch',
            'password'  => '12345678',
            'role'      => User::ROLE_SUPERADMIN,
            'language'  => 'fr',
            'birthday'  => '1976-09-18',
            'gender'    => User::GENDER_MALE,
            'country'    => 'CH',
        ];
        $superadmin->save();

        $admin = new User();
        $admin->scenario = 'create';
        $admin->detachBehavior('relation');
        $admin->attributes = [
            'username'  => 'iwan',
            'firstname' => 'Iwan',
            'lastname'  => 'Schuwey',
            'address'   => 'Place Bel-Air 5',
            'npa'       => '1260',
            'city'      => 'Nyon',
            'tel'       => '+41 79 220 07 69',
            'email'     => 'iwan@mulaff.ch',
            'password'  => '12345678',
            'role'      => User::ROLE_ADMIN,
            'language'  => 'fr',
            'birthday'  => $faker->dateTimeBetween('-40years', '-20years')->format('Y-m-d'),
            'gender'    => User::GENDER_MALE,
            'country'    => 'CH',
        ];
        $admin->save();


        $coach = new User();
        $coach->scenario = 'create';
        $coach->detachBehavior('relation');
        $coach->attributes = [
            'username'  => 'coach',
            'firstname' => $faker->firstName,
            'lastname'  => $faker->lastName,
            'address'   => $faker->streetAddress,
            'npa'       => $faker->postcode,
            'city'      => $faker->city,
            'tel'       => '+'.$faker->phoneNumber,
            'email'     => $faker->email,
            'password'  => '12345678',
            'role'      => User::ROLE_COACH,
            'language'  => 'fr',
            'birthday'  => $faker->dateTimeBetween('-40years', '-20years')->format('Y-m-d'),
            'gender'    => User::GENDER_MALE,
            'country'    => 'CH',
        ];
        $coach->save();
        
    }

    public function down()
    {
        return true;
    }

}
