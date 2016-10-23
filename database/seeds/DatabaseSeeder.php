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
            'content'=>Hash::make('admin'),
            'comment'=>'管理员密码'
            ],
            [
            'name'=>'home_banner_pic',
            'content'=>'img\santi.jpg',
            'comment'=>'首页横幅图片地址'
            ],
            [
            'name'=>'home_banner_url',
            'content'=>'img\santi.jpg',
            'comment'=>'首页横幅图片链接'
            ],
        ]);
    }
}
