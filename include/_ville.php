<?
/**
 * @date	: April 2012
 * @project : urbanTraps
 * @package : /modules/ville
 * @author : Badger
 */
include_once(dirname(__FILE__).'/model_ville.php');
class ville extends pageDefault {
	private $_model = null;
	
	protected function _get() {
	   
	} 
	
	public function __construct() {
	 
	}
	
	public function witchCity($lat, $lng) {
		$this->_model = new model_ville();
		
		$specific = array( //because several zipCode in one city...
			'paris' => 75000,
			'lyon' => 69000,
			'marseille' => 13000
		);
		
		//point dans annecy : 45.90792769384896, 6.121273040771484 
		//on regarde si le emc est dans le périmetre d'une ville déjà en BDD
		$cityInDB = $this->_model->getCityNear($lat, $lng);
		if(count($cityInDB) > 0) {
			return $cityInDB[0];
		} else {
			//sinon, on interroge google pour avoir la ville, on regarde si elle existe déjà en BDD, sinon on la crée automatiquement
			$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&sensor=false";
			$json = file_get_contents($url);
			$reponse = json_decode($json);
			//print_r($reponse);
			$villeName = '';
			$zipCode = '';
			if($reponse->status == 'OK') {
				if(isset($reponse->results) && count($reponse->results) > 0) {
					if(isset($reponse->results[0]->address_components) && count($reponse->results[0]->address_components) > 0) {
						foreach ($reponse->results[0]->address_components as $ret) {
							if(in_array('locality', $ret->types)) {
								$villeName = strtolower($ret->short_name);
							} else if(in_array('postal_code', $ret->types)) {
								$zipCode = $ret->short_name;
							}
						}
					}
				}
			} else {
				return false;
			}
			
			$zipCode = isset($specific[$villeName]) ? $specific[$villeName] : $zipCode;
			
			$cityBD = $this->_model->getCity($villeName, $zipCode);
			if(count($cityBD) == 0) {
				//get latLng
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($villeName)."+france&sensor=false";
				$json = file_get_contents($url);
				$reponse = json_decode($json);
				
				if($reponse->status == 'OK') {
						$return = array(
							'nom' => $villeName,
							'code_postal' => $zipCode,
							'lat' => $reponse->results[0]->geometry->location->lat,
							'lng' => $reponse->results[0]->geometry->location->lng,
							'rayon' => 5,
							'webservice' => 0
						);
						$this->_model->insert($return);
						$cityBD = $this->_model->getCity($villeName, $zipCode);
						return $cityBD[0];
				} else {
					return false;
				}
			} else {
				return $cityBD[0];
			}
		}
	}
}
?>
