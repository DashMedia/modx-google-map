<?php
/**
 * @name googleMap
 * @description Google Map output modifier snippet
 *
 * USAGE
 *
 *  <img src="[[!googleMap? &address=`[[*tvAddress]]` &w=`425` &h=`300` &z=`16` &marker=`1` &sensor=`0`]]" />
 *  
 * <img src="[[*tvAddress:googleMap=`w=425,h=300,z=16,key=xxxxxxxxxxx,sensor=0,marker=1`]]" />
 *
 * Copyright 2015 by Jason Carney <jason@dashmedia.com.au>
 * Created on 10-31-2014
 *
 *
 * Variables
 * ---------
 * @var $modx modX
 * @var $scriptProperties array
 *
 * @package googlemap
 */
// Your core_path will change depending on whether your code is running on your development environment
// or on a production environment (deployed via a Transport Package).  Make sure you follow the pattern
// outlined here. See https://github.com/craftsmancoding/repoman/wiki/Conventions for more info
$core_path = $modx->getOption('googlemap.core_path', null, MODX_CORE_PATH.'components/googlemap/');
include_once $core_path .'/vendor/autoload.php';
if(isset($options) && !is_null($options)){
	//options included, execute as output modifier
	$options = explode(",", $options);
	foreach ($options as $key => $value) {
		$line = explode("=", $value);
		$settings[$line[0]] = $line[1];
	}
	if (isset($input) && !is_null($input)) {
		$settings['address'] = $input;
	} 
} else {
	//options not included, execute as snippet call
	$settingsArray = array('w', 'h', 'z', 'address', 'key', 'sensor', 'marker');
	foreach ($settingsArray as $key => $value) {
		if(isset(${$value})){
			$settings[$value] = ${$value};
		}
	}
}

if(empty($settings['key'])){
	//key not passed, check system settings for google api key
	$settings['key'] = $modx->getOption('googlemap.api_key');
}

if(empty($settings['key'])){
	//stil no key, check old google_api_key setting
	$settings['key'] = $modx->getOption('google_api_key');
}

//we now have a setings array populated
$required = array('key', 'address');
foreach ($required as $key => $value) {
	if(!isset($settings[$value]) || is_null($settings[$value]) || $settings[$value] == ''){
		return "googleMap Error: Missing Required Option: ".$value;
	}
}
//we have all settings required, set defaults for any missing
$defaults = array(
	'w' => 435, 
	'h' => 300,
	'z' => 16,
	'sensor' => 0,
	'marker' => 1
	);
$settings = array_merge($defaults, $settings);

//settings array ready with any non-set values set to defaults




$address = urlencode($settings['address']);
$center = 'center='.urlencode($settings['address']);
$key = '&amp;key='.urlencode($settings['key']);
$api = 'https://maps.googleapis.com/maps/api/staticmap?';
$size = '&amp;size='.urlencode($settings['w']).'x'.urlencode($settings['h']);
$zoom = '&amp;zoom='.urlencode($settings['z']);
$markers = urlencode($settings['marker'])?'&amp;markers='.$address:'';
$sensor = urlencode($settings['sensor'])?'&amp;sensor=true':'&amp;sensor=false';

return $api.$center.$size.$zoom.$markers.$sensor;