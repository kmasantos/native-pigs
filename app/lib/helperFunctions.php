if ( ! function_exists('standardDeviation')){
	function standardDeviation($arr, $samp = false){
    $ave = array_sum($arr) / count($arr);
    $variance = 0.0;
    foreach ($arr as $i) {
      $variance += pow($i - $ave, 2);
    }
    $variance /= ( $samp ? count($arr) - 1 : count($arr) );
    return (float) sqrt($variance);
	}
}