<?php
/**
 * @date	: April 2012
 * @project : urbanTraps
 * @package : /modules/ville
 * @author : Badger
 */
class model_ville extends modelDefault {
	public function __construct() {
		parent::__construct();
		parent::setTable('Ville');
		parent::setId('id');
	} 
	
	public function getCityNear($lat, $lng) {
		$q = "SELECT *,
			   (((acos(sin((".$lat."* pi() / 180)) * sin((lat * pi() / 180)) +
					   cos((".$lat." * pi() / 180)) * cos((lat * pi() / 180)) * 
					   cos((".$lng."  - lng) * pi() / 180))
				 ) * 180 / pi()
				) * 60 * 1.1515 * 1.609344 * 1000
			   ) as distance
		  FROM Ville
		HAVING distance < rayon * 1000	
	  ORDER BY distance ASC
		 LIMIT 0, 1";
	   
		$tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
		return is_array($tab) ? $tab : array();
	}
	
	public function getCity($name, $zipcode) {
		$q = 'SELECT * FROM Ville WHERE nom LIKE "%'.$name.'%" AND code_postal = "'.$zipcode.'"';
		$tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
		return is_array($tab) ? $tab : array();
	}
}
?>
