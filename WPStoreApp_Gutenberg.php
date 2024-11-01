<?php
namespace WPStoreApp\SpellCheck;

if(!class_exists( "WPStoreApp_Gutenberg" )){
    class WPStoreApp_Gutenberg {
        public static function init(  ) {
            add_action('init',[WPStoreApp_Gutenberg::class,'register_asset']);
            add_action('enqueue_block_editor_assets', [WPStoreApp_Gutenberg::class,'enqueue_script']);
        }

        public static function register_asset() {
            $asset_file = include(plugin_dir_path(__FILE__) . 'build/index.asset.php');
            wp_register_script(
                'wpstore-spellcheck',
                plugins_url('build/index.js', __FILE__),
                $asset_file['dependencies'],
                $asset_file['version'],
            );
        }

        public static function enqueue_script() {
            wp_enqueue_script('wpstore-spellcheck');
        }
    }
}