<?
class Rate extends Config {
	function echoRate () {
		$totalRates = $averageRate = $numRates = 0;
//		$rates = $getRecord -> GET($this->tb.'_ratings', "`iid` = '{$this->id}' ", '', '');
//		$numRates = count($rates);
		$query = "SELECT * FROM ".$this->tb."_ratings WHERE
					iid = ?
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ratesL[] = $row;
			$numRates++;
			$totalRate++;
		}
		foreach ($ratesL as $rates) {
			$averageRate = $averageRate + $rates['rate'];
			$totalRates = $totalRates + $rates['rate']*100/5;
		}
		$percentRate = number_format((100*($averageRate/$numRates)/5), 2);
		$averageRate = $cGrade = number_format(($averageRate/$numRates), 1);
		
		$totalRate = count($ratesL);
		
		if (($averageRate - floor($averageRate)) > 0.5) $averageRate = floor($averageRate) + 0.5;
		else $averageRate = floor($averageRate);
		echo '		<div class="chart-grade rate-grade">
			'.$cGrade.'
		</div>
		<div class="chart-star star-info">';
			for ($z = 1; $z <= 5; $z++) { ?>
				<span class="fa fa-star<? if ($averageRate == $z - 0.5) echo '-half'; else if ($averageRate < $z) echo '-o' ?>"></span>
			<? }
			echo '<div class="gensmall rl-review-count">(<b>'.$totalRate.'</b>) <a>reviews</a></div>
		</div>';
	}
	function getRates () {
		$query = "SELECT * FROM
					".$this->tb."_ratings
				WHERE
					iid = ? AND show = 1
				ORDER BY `rate` DESC, LENGTH(likes) DESC, LENGTH(content) DESC";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['au'] = $this->getUserInfo($row['uid']);
			$this->rList[] = $row;
			$num++;
		}
		return $stmt;
	}
	function checkMyRate () {
		$query = "SELECT id FROM ".$this->tb."_ratings WHERE `iid` = ? AND `uid` = ? ";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->u);
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}
}
