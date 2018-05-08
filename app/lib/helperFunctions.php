static function getWeightsPerYearOfBirth($year, $property_id){
	$pigs = Animal::where("animaltype_id", 3)->where("status", "active")->get();

	$bornonyear = [];
	foreach ($pigs as $pig) {
		if(substr($pig->registryid, -10, 4) == $year){
      array_push($bornonyear, $pig);
    }
	}

	$weights = [];
	foreach ($bornonyear as $bornpig) {
		$properties = $bornpig->getAnimalProperties();
		foreach ($properties as $property) {
			if($property->property_id == $property_id){
				if($property->value != ""){
					$weight = $property->value;
					array_push($weights, $weight);
				}
			}
		}
	}

	return $weights;
}