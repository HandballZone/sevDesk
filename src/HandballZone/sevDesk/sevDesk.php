<?php
namespace HandballZone\sevDesk;

use Illuminate\Config\Repository as Config;

class SevDesk {	
	private $sconfig;
	
	public function __construct(Config $config) {
		if($config -> has('sevdesk')) {
			$this -> sconfig = $config -> get('sevdesk');
		}
		else throw new Exception('No config found.');
	}
	
	public function query($name, $method = 'GET', $model, $parameters = [], $fields = []) {
		$cc = curl_init();
		curl_setopt($cc, CURLOPT_URL, 'https://my.sevdesk.de/api/'.$this->sconfig['version'].'/'.$model.'/'.(count($parameters)>0) ? http_build_query($parameters) : null);
		curl_setopt($cc, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($cc, CURLOPT_HEADER, FALSE);
		
		curl_setopt($cc, CURLOPT_POST, TRUE);
		
		// Fields
		if(count($fields) >0) curl_setopt($cc, CURLOPT_POSTFIELDS, http_build_query($fields));
		
		curl_setopt($cc, CURLOPT_HTTPHEADER, array(
		  "Authorization: ".$this -> sconfig['API_KEY'],
		  "Content-Type: application/x-www-form-urlencoded"
		));
		
		$response = curl_exec($cc);
		curl_close($cc);
		
		var_dump($response);
	}
}
?>
