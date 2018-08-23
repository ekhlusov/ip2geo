#!/bin/bash
# Инициализация заполнения БД данными для GeoIP
# DB=geoip_test
# DB_USER=root

# mysql -h localhost -u $DB_USER $DB < db_create.sql

# wget http://geolite.maxmind.com/download/geoip/database/GeoLiteCity_CSV/GeoLiteCity-latest.zip
# unzip -j GeoLiteCity-latest.zip

# mv GeoLiteCity-Location.csv geo_location.csv
# mv GeoLiteCity-Blocks.csv geo_blocks.csv

# mysqlimport -u $DB_USER --ignore-lines=2 --fields-terminated-by=, --fields-optionally-enclosed-by='"' --local $DB geo_location.csv
# mysqlimport -u $DB_USER --ignore-lines=2 --fields-terminated-by=, --fields-optionally-enclosed-by='"' --local $DB geo_blocks.csv 

# rm GeoLiteCity-latest.zip, geo_location.csv, geo_blocks.csv

wget http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
gunzip GeoLiteCity.dat.gz
mv GeoLiteCity.dat GeoIPCity.dat