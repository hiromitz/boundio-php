<?php
/**
 * boundio API minimal client interface.
 *
 * Copyright (c) 2012, KDDI Web Communications Inc.
 * All rights reserved.
 * 
 * @package Boundio
 * @author hiromitz <hiromitz.m@gmail.com>
 * @link https://github.com/boundio/boundio-php
 * @license http://creativecommons.org/licenses/MIT/ MIT
 */
class Boundio {
	
	protected static $_config = array(
		'userSerialId' => '',
		'appId' => '',
		'authKey' => ''
	);
	
	protected static $_baseDevUrl = 'https://boundio.jp/api/v1/';
	
	protected static $_baseUrl = 'https://boundio.jp/api/v1/';
	
	protected static $_instance;
	
	public static function configure($key, $value) {
		self::$_config[$key] = $value;
	}
    
	protected function __constructor() {}
	
	protected function _getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public static function call($tel_to, array $cast) {
		$instance = self::_getInstance();
		
		return false;
	}
	
	public static function status($id=null) {
		$instance = self::_getInstance();
		
		return false;
	}
	
	public static function file($file='', $text='') {
		$instance = self::_getInstance();
		
		return false;
	}
	
	protected function _execute(array $params, $method='get') {
		return false;
	}
}

/**
 * BoundioException class
 * 
 */
class BoundioException extends Exception{}

