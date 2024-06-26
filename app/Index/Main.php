<?php

namespace App\Index;

use System\Plugin;

class Main
{
    // 插件信息
    public static $info = [
        'title' => '首页',
        'version' => '1.0.0',
        'description' => '',
        'author' => 'Hairu Life',
        'url' => '',
    ];

    public static function enable()
    {
        Plugin::factory(__CLASS__)->run = __CLASS__ . '::view';
        Plugin::factory('index.php')->run = __CLASS__ . '::scheduler';
    }

    public static function disable()
    {
    }

    public static function config()
    {
    }

    public static function view()
    {
        echo '首页<br><a href="/admin">后台管理</a>';
    }

    public static function scheduler()
    {
        $path =  \System\Request::getPath();
        $name = \System\Utils::toCamelCase(explode('/', $path)[1]) ?: 'Index';

        $handler = \System\Utils::getPluginFullName($name, 'App');

        if (!\System\Plugin::exists($name) || !\System\Plugin::existsHandler($handler . ':run')) {
            $handler = \System\Utils::getPluginFullName('Error', 'App');
        }

        \System\Plugin::factory($handler)->run();
    }
}
