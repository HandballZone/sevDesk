<?php
namespace HandballZone\SevDesk;

use Illuminate\Config\Repository as Config;

use PaulP\SevDesk\Traits\InvoiceTrait;

class SevDesk {
	use InvoiceTrait;
	
	private $sconfig;
	
	private $curl;
	
	public function __construct(Config $config) {
		if($config -> has('sevdesk')) {
			$this -> sconfig = $config -> get('sevdesk');
		}
		else throw new Exception('No config found.');
		
		$this -> curl = curl_init();
	}
	
	public function query($name, $method = 'GET', $model, $parameters = [], $fields = []) {
		curl_setopt($this -> curl, CURLOPT_URL, 'https://my.sevdesk.de/api/'.$this->sconfig['version'].'/'.$model.'/'.(count($parameters)>0) ? http_build_query($parameters) : null);
		curl_setopt($this -> curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this -> curl, CURLOPT_HEADER, FALSE);
		
		curl_setopt($this -> curl, CURLOPT_POST, TRUE);
		
		// Fields
		if(count($fields) >0) curl_setopt($this -> curl, CURLOPT_POSTFIELDS, http_build_query($fields));
		
		curl_setopt($this -> curl, CURLOPT_HTTPHEADER, array(
		  "Authorization: ".$this -> sconfig['API_KEY'],
		  "Content-Type: application/x-www-form-urlencoded"
		));
		
		$response = curl_exec($this -> curl);
		curl_close($this -> curl);
		
		var_dump($response);
	}
}
?>
