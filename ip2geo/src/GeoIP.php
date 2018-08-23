<?php

/**
 * Класс для GeoIP
 */
class GeoIP
{
    /**
     * @var $ip
     */
    public $ip;

    /**
     * GeoIP constructor.
     *
     * @param $ip
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
        geoip_setup_custom_directory(__DIR__);
        geoip_db_filename(GEOIP_CITY_EDITION_REV0);
    }

    /**
     * Получаем инфо по запрошенному IP
     *
     * @return string
     */
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

    /**
     * Проверяем, является ли параметр IP
     *
     * @return bool
     */
    private function validateIP(): bool
    {
        $valid = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $this->ip);
        if (!$valid) {
            return false;
        }

        return true;
    }

    /**
     * Собираем нужный нам массив с данным для вывода
     *
     * @return array
     */
    public function geoInfoToArray(): array
    {
        $record = (object)geoip_record_by_name($this->ip);

        return [
            'latitude'   => $record->latitude, // Широта
            'longitude'  => $record->longitude, // Долгота
            'coutryName' => $record->country_name,
            'city'       => $record->city
        ];
    }
}
