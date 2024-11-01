<?php
namespace WPStoreApp\SpellCheck;
if ( ! class_exists( "WPStoreApp_Option" ) ) {
	class WPStoreApp_Option {
		public static function init() {
			add_action( 'admin_init', [ WPStoreApp_Option::class, 'settings_init' ] );
			add_filter( 'plugin_row_meta', [WPStoreApp_Option::class,'plugin_row_meta'], 10, 2 );
			add_filter('plugin_action_links', [WPStoreApp_Option::class,'plugin_action_links'], 10, 2);
		}

		public static function plugin_action_links($links, $file)
		{
            if ( strpos( $file, 'wpstore-spellcheck.php' ) !== false ) {
	            $links[] = '<a href="./options-writing.php">配置 Token</a>';
	            $links[] = '<a href="https://api.wpstore.app/plugins/spell-check/pricing" target="_blank">购买额度</a>';
            }
			return $links;
		}

		public static function plugin_row_meta(  $plugin_meta, $plugin_file)   {
			if ( strpos( $plugin_file, 'wpstore-spellcheck.php' ) !== false ) {
				$new_links = array(
					'doc' => '<a href="https://www.wpstore.app/?p=291" target="_blank">用户文档</a>',
					'mailto' => '<a href="mailto:hi@wpstore.app?subject=关于拼写检查插件的一些问题&body=" target="_blank">联系我们</a>'
				);
				$plugin_meta = array_merge( $plugin_meta, $new_links );
			}
			return $plugin_meta;
        }
        
		public static function settings_init() {
			/**
			 * 注册一个新的选项，用于存储后续的 Token
			 */
			register_setting( 'writing', 'wpstore_spellcheck_token' );
			/**
			 * 配置 Token
			 */
			add_settings_section(
				'wpstore_spellcheck_section',
				__( 'WPStore SpellCheck Service', 'wpstore-spell-check' ),
				[ WPStoreApp_Option::class, 'settings_section_callback' ],
				'writing'
			);
			add_settings_field(
				'wpstore_spellcheck_settings_field',
				__( "Token", "wpstore-spell-check" ),
				[ WPStoreApp_Option::class, 'wpstore_settings_field_callback' ],
				'writing',
				'wpstore_spellcheck_section'
			);
		}

		public static function settings_section_callback() {
			?>
            <p>前往 <a href="#">WPStore</a> 获取 Token，以正确调用服务</p>

			<?php
		}

		public static function wpstore_settings_field_callback() {
			$setting = get_option( 'wpstore_spellcheck_token' );
			?>
            <input type="text" name="wpstore_spellcheck_token"
                   value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
			<?php
		}
	}
}