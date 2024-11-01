<?php

/*
Plugin Name: WPStore.app Spell Check
Plugin URI: https://www.wpstore.app/?p=291
Description: 为中国作者定制的中文语法检查插件，识别你的文章中的「的地得」错误，帮你纠正文章中的基本错误。
Version: 0.0.5
Author: WPStore.app Team
Author URI: https://wpstore.app
License: GPL v2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 5.0
Text Domain: wpstore-spell-check
Domain Path: /languages
*/

if (!class_exists("WPStoreApp_SpellCheck")) {
    require_once "WPStoreApp_Option.php";
    require_once "WPStoreApp_API.php";
    require_once "WPStoreApp_Gutenberg.php";

    class WPStoreApp_SpellCheck
    {
        public function init()
        {
            \WPStoreApp\SpellCheck\WPStoreApp_Option::init();
            \WPStoreApp\SpellCheck\WPStoreApp_API::init();
            \WPStoreApp\SpellCheck\WPStoreApp_Gutenberg::init();
        }
    }
    $instance = new WPStoreApp_SpellCheck();
    $instance->init();
}
