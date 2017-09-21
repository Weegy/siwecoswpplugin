<?php
/**
 * Created by PhpStorm.
 * User: wege
 * Date: 19.09.2017
 * Time: 13:30
 */

class loginModel {

	/*
	 * @var string
	 */
	var $username;

	/*
	 * @var string
	 */
	var $password;

	/*
	 * @var string
	 */
	var $apitoken;

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername( $username ) {
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword( $password ) {
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getApitoken() {
		return $this->apitoken;
	}

	/**
	 * @param string $apitoken
	 */
	public function setApitoken( $apitoken ) {
		$this->apitoken = $apitoken;
	}
}