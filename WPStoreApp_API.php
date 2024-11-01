<?php
namespace WPStoreApp\SpellCheck;


if(!class_exists( "WPStoreApp_API" )){
    class WPStoreApp_API {
        public static function init(  ) {
            add_action('rest_api_init', [WPStoreApp_API::class,'register_route']);
        }

        public static function register_route() {
            register_rest_route('chinese-spell-check/v1', '/check/', array(
                'methods'             => 'POST',
                'callback'            => [WPStoreApp_API::class,'process_request'],
                'permission_callback' => [WPStoreApp_API::class,'permission_check'],
            ));
        }

        public static function process_request($request) {
            if ( ! get_option( 'wpstore_spellcheck_token' ) ) {
                return new \WP_REST_Response( [
                    'code' => 1,
                    'msg'  => '请先完成 Token 设置'
                ], 200 );
            }
            $body     = $request->get_json_params();
            $response = wp_remote_post( 'https://api.wpstore.app/api/v1/spellcheck/check', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . get_option( 'wpstore_spellcheck_token' )
                ],
                'body'    => json_encode( array(
                    'text'   => $body['content'],
                    'length' => strlen( $body['content'] )
                ) ),
            ] );

            return new \WP_REST_Response( json_decode( $response['body'], true ) );
        }

	    public static function permission_check(  ) {
		    if ( ! current_user_can( 'edit_posts' ) ) {
			    return new \WP_Error( 'rest_forbidden', "你没有权限执行此操作哦～", array( 'status' => 401 ) );
		    }
			return true;
        }
	}
}