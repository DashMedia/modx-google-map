<?php
/**
 * googleMap Output Modifier
 *
 * DESCRIPTION
 *
 * This output modifier accepts an address and returns a url for the static map image
 * 
 * PARAMETERS: w, h, z, key - Google Maps API v3 Key, sensor (1 or 0), marker (1 or 0)
 *
 * OUTPUT MODIFIER USAGE:
 * <img src="[[*tvAddress:googleMap=`w=425,h=300,z=16,key=xxxxxxxxxxx,sensor=0,marker=1`]]" />
 *
 * key is the only REQUIRED variable, unless you set up a system setting named "google_api_key"
 * then the snippet will use that value whenever 'key' is not passed
 *
 * SNIPPET USAGE:
 *
 * <img src="[[!googleMap? &address=`[[*tvAddress]]` &w=`425` &h=`300` &z=`16` &marker=`1` &sensor=`0`]]" />
 *
 * 
 * AUTHOR: Jason Carney, DashMedia.com.au
 */

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

if(!isset($settings['key']) || $settings['key'] == '' || is_null($settings['key'])){
	//key not passed, check system settings for google api key
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
$api = 'http://maps.googleapis.com/maps/api/staticmap?';
$size = '&amp;size='.urlencode($settings['w']).'x'.urlencode($settings['h']);
$zoom = '&amp;zoom='.urlencode($settings['z']);
$markers = urlencode($settings['marker'])?'&amp;markers='.$address:'';
$sensor = urlencode($settings['sensor'])?'&amp;sensor=true':'&amp;sensor=false';

return $api.$center.$size.$zoom.$markers.$sensor;