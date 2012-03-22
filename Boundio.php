<?php
/**
 * boundio API simple client interface.
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
	
	public static $_config = array(
		'env' => 'develop', // develop || production
		'userSerialId' => '',
		'appId' => '',
		'authKey' => ''
	);
	
	protected static $_baseDevUrl = 'https://boundio.jp/api/vd1/';
	protected static $_baseUrl = 'https://boundio.jp/api/v1/';
	
	public static function configure($key, $value) {
		static::$_config[$key] = $value;
	}
	
	protected static function getUrl() {
		$url = (static::$_config['env'] == 'develop') ? static::$_baseDevUrl : static::$_baseUrl;
		$url .= static::$_config['userSerialId'];
		return $url;
	}
	
	public static function call($tel_to, array $casts) {
		$tel_to = str_replace('-', '', $tel_to);
		
		// validation - phone number
		if(!preg_match('/^0\d{9,10}$/', $tel_to)) {
			return false;
		}
		
		// validation - casts
		foreach($casts as $cast) {
			if(!preg_match('/^(file\([0-9]+\)|num\([0-9]\)|silent\(\))$/', $cast)) {
				return false;
			}
		}
		// create cast string
		$cast = implode('%%', $casts);
		// execute call
		$result = static::_execute(static::getUrl(). '/call', array(
			'tel_to' => $tel_to,
			'cast' => $cast
		), 'post');
		
		$result = json_decode($result, true);
		
		return $result;
	}
	
	public static function status($id='', $start='', $end='', $count=100) {
		$start = preg_replace('/[-\/]/', '', $start);
		$end = preg_replace('/[-\/]/', '', $end);
		
		$params = array();
		
		if($id !== '') {
			$params['tel_id'] = $id;
		} elseif($start !== '') {
			// search one day if end day is not given
			if($end === '') {
				$end = $start;
			}
			$params['start'] = $start;
			$params['end'] = $end;
		}
		
		// execute get status
		$result = static::_execute(static::getUrl(). '/status', $params);
		
		$result = json_decode($result, true);
		
		return $result;
	}
	
	public static function file($text='', $file='', $filename) {
		
		$params = array();
		$options = array();
		
		if($text !== '') {
			$params['convtext'] = $text;
			$params['filename'] = $filename;
		} else {
			// file validation
			if(!file_exists($file)) {
				return false;
			}
			$params['file'] = '@'. $file;
			$params['filename'] = $filename;
		}
		
		// execute get status
		$result = static::_execute(static::getUrl(). '/file/post', $params);
		
		$result = json_decode($result, true);
		
		return $result;
	}
	
	protected static function _execute($url, array $params, $method='get', array $options = array()) {
		
		$params['auth'] = static::$_config['authKey'];
		$params['key'] = static::$_config['appId'];
		
		$defaults = ($method == 'post') ? array(
			CURLOPT_POST => ($method == 'post') ? 1: 0,
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $url,
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 4,
			CURLOPT_POSTFIELDS => http_build_query($params)
		) : array(
			CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($params),
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 4
		);
		
		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}

/**
 * BoundioException class
 * 
 */
class BoundioException extends Exception{}
