<?php

use GuzzleHttp\Exception\RequestException;

/**
 * Created by PhpStorm.
 * User: wege
 * Date: 19.09.2017
 * Time: 13:27
 */
class apiConnector {

	/*
	 * @var string
	 */
	var $baseUrl;

	public function __construct() {
		$this->baseUrl = API_URL;
	}

	// Endpoints
	const LOGIN = 'user/login';
	const DOMAINS = 'domain/list';
	const DOMAIN_SCAN = 'internal/scanner';

	/**
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->baseUrl;
	}

	/**
	 * @param string $baseUrl
	 */
	public function setBaseUrl( $baseUrl ) {
		$this->baseUrl = $baseUrl;
	}

	public function Login( $username, $password ) {
		$data             = array();
		$data['username'] = $username;
		$data['password'] = $password;
		$result           = $this->doPostRequest( $data, self::LOGIN );
		if ( $result->code == 200 ) {
			// Save Token & Data to WP
			add_option( USER_TOKEN, $result->data->authcode );
			add_option( USER_NAME, $username );

			return $this->doResponse( 200, 'Login erfolgreich' );
		} else {
			return $this->doResponse( 403, 'Username / Password Falsch' );
		}
	}

	/**
	 * @param string $usertoken
	 * @return array
	 */
	public function GetDomainsForUser( $usertoken ) {
		$result = $this->doGetRequest($usertoken, self::DOMAINS);
		if ( $result->message == 'ok' ) {
			return self::doResponse(200, "Domains geladen", $result->collection);
		}
		return self::doResponse(500, "Ooops");
	}

	/**
	 * @param integer $domain_id
	 *
	 * @return array
	 */
	public function GetScanResultForDomainId($domain_id)
	{
		$result = $this->doGetRequest($domain_id, self::DOMAIN_SCAN);
		if ( $result->message == 'ok' ) {
			return self::doResponse(200, "Domains geladen", $result->collection);
		}
		return self::doResponse(500, "Ooops");
	}

	public static function doResponse( $code, $message, $data = null ) {
		$response            = array();
		$response['code']    = $code;
		$response['message'] = $message;
		$response['data'] = $data;

		return $response;
	}

	private function doPostRequest( $data, $endpoint ) {
		try {
			$rawUrl = $this->baseUrl . '/wp-json/siwecos/v1/' . $endpoint;
			$client = new \GuzzleHttp\Client();
			$res    = $client->request( 'POST', $rawUrl, [
				'form_params' => $data,
			] );

			$response = json_decode( $res->getBody() );

			return $response;
		} catch ( RequestException  $ex ) {
			LoggingEngine::AddError( $ex->getMessage() );
			$response = json_decode( $ex->getResponse()->getBody() );

			return $response;
		}
	}

	private function doGetRequest($usertoken, $endpoint)
	{
		try {
			$rawUrl = $this->baseUrl . '/wp-json/siwecos/v1/' . $endpoint . '/' . $usertoken;
			$client = new \GuzzleHttp\Client();
			$res    = $client->request( 'GET', $rawUrl );

			$response = json_decode( $res->getBody() );

			return $response;
		} catch ( RequestException  $ex ) {
			LoggingEngine::AddError( $ex->getMessage() );
			$response = json_decode( $ex->getResponse()->getBody() );

			return $response;
		}
	}
}