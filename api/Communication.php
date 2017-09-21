<?php
/**
 * Created by PhpStorm.
 * User: wege
 * Date: 20.09.2017
 * Time: 08:37
 */

class Communication extends WP_REST_Controller {
	public function register_routes() {
		$version   = '1';
		$namespace = 'siwecos/v' . $version;
		$base      = '';
		register_rest_route( $namespace, '/' . $base . 'login', array(

			array(
				'methods'  => WP_REST_Server::CREATABLE,
				'callback' => array( $this, 'login' ),
				'args'     => $this->get_endpoint_args_for_item_schema( true ),
			),
		) );
		register_rest_route( $namespace, '/' . $base . 'logout', array(

			array(
				'methods'  => WP_REST_Server::CREATABLE,
				'callback' => array( $this, 'logout' ),
				'args'     => $this->get_endpoint_args_for_item_schema( true ),
			),
		) );
		register_rest_route( $namespace, '/' . $base . 'domains', array(

			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'getDomains' ),
				'args'     => $this->get_endpoint_args_for_item_schema( true ),
			),
		) );
	}

	/**
	 * @param WP_REST_Request $request
	 */
	public function login($request)
	{
		$username = $request->get_param('uname');
		$password = $request->get_param('psw');
		$apiCon = new apiConnector();
		return $apiCon->Login($username, $password);
	}

	/**
	 * @return array
	 */
	public function  logout(){
		delete_option(USER_TOKEN);
		delete_option(USER_NAME);
		return apiConnector::doResponse(200, 'Logout erfolgreich');
	}

	public function getDomains()
	{
		$userToken = get_option(USER_TOKEN);

	}
}