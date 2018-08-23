<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Cache;
/**
 * Класс для GeoIP
 */
class GeoIP
{
	public $ip;

	public function __construct($ip)
	{
		$this->ip = $ip;
		geoip_setup_custom_directory('../');
		geoip_db_filename(GEOIP_CITY_EDITION_REV0);
	}

	public function getInfo()
 	{
 		if ($this->validateIP() !== false) {
 			$cache = new Cache();
 			$inCache = $cache->getCache($this->ip);
 			if ($inCache) {
 				return json_encode($inCache);
 			} 

 			$geoInfo = $this->geoInfoToArray();
 			$cache->setCache($this->ip, $geoInfo);

 			
 			return json_encode($geoInfo);
 		}

 		header("Status: 404 Not Found"); 
 	}

 	private function validateIP()
 	{
 		$valid = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $this->ip);
 		if (!$valid) {
 			return false;
 		}
 		return true;
 	}

 	public function geoInfoToArray() :array
 	{
 		$record = (object) geoip_record_by_name($this->ip);
 		return [
			'latitude' 	 => $record->latitude, // Широта
			'longitude'  => $record->longitude, // Долгота
			'coutryName' => $record->country_name,
			'city'		 => $record->city
		];
 	}
}

/**
 * Memcache
 */
class Cache
{
	public $mc;
	public function __construct()
	{
		$this->mc = memcache_connect('localhost', 11211);
	}

	public function setCache($key, $data)
	{
		return memcache_set($this->mc, $key, $data, 0, 30*60);
	}

	public function getCache($key)
	{
		return memcache_get($this->mc, $key);
	}

}

// init
if (isset($_GET['ip'])) {
	header('Content-Type: application/json');

	$geo = new GeoIP($_GET['ip']);
	echo $geo->getInfo();
} else {
	header("Status: 404 Not Found");
	die(json_encode(['error' => 'no ip']));
}

