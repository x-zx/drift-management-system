<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
            'name'=>'admin_username',
            'content'=>'admin',
            'comment'=>'管理员用户名'
            ],
            [
            'name'=>'admin_password',
            'content'=>'admin',
            'comment'=>'管理员密码'
            ],
            [
            'name'=>'banner_src',
            'content'=>'img\banner.jpg',
            'comment'=>'横幅图片地址'
            ],
            [
            'name'=>'class_list',
            'content'=>'[]',
            'comment'=>''
            ],
            [
            'name'=>'class_name',
            'content'=>'["省份","城市","区县"]',
            'comment'=>''
            ]
        ]);


        DB::table('users')->insert([
            ['id'=>'1','name'=>'管理员']
        ]);

    }
}
