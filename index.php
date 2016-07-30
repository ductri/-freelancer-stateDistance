<?php 
require('./utils.php');
require('./Polyline.php');
$time = microtime(true);
// function getState($lat, $lng) {
// 	$cSession = curl_init(); 
	
// 	$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&key=AIzaSyAq_4lcmeuCIbZ288vbXMnYowGL-PO-lxk&result_type=administrative_area_level_1";

// 	//step2
// 	curl_setopt($cSession,CURLOPT_URL, $url);
// 	curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
// 	curl_setopt($cSession,CURLOPT_HEADER, false);

// 	//step3
// 	$result = json_decode(curl_exec($cSession));
// 	return $result;
// }
//34.139032, -118.357275
//41.839635, -87.623636
$cor1 = $_GET['latSrc'].",".$_GET['lngSrc'];
$cor2 = $_GET['latDst'].",".$_GET['lngDst'];
//step1
$cSession = curl_init(); 
//step2
curl_setopt($cSession,CURLOPT_URL,"https://maps.googleapis.com/maps/api/directions/json?origin=".$cor1."&destination=".$cor2."&key=AIzaSyAq_4lcmeuCIbZ288vbXMnYowGL-PO-lxk");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
//step3
$result=curl_exec($cSession);
$result = json_decode($result);

add_avariable('result', $result);
//[0]['legs'][0]['steps']
$steps = $result->{'routes'}[0]->{'legs'}[0]->{'steps'};
echo 'step = '.$result->{'routes'}[0]->{'legs'}[0]->{'distance'}->{'value'}.'<br>';
$locations = array();
$anchors = array();
$num_points = 0;



$state_dis = array();
$total_dis = 0;

for ($i=0; $i<count($steps); $i++) {
	array_push($anchors, $steps[$i]);
	//$locationInfo = getState($steps[$i]->{'start_location'}->{'lat'}, $steps[$i]->{'start_location'}->{'lng'});
	//array_push($locations, $locationInfo->{'results'}[0]->{'address_components'}[0]->{'long_name'});
	
	$encoded = $steps[$i]->{'polyline'}->{'points'};
	$points1 = Polyline::decode($encoded);
	$points2 = Polyline::pair($points1);
	$num_points += count($points2);

	$dis = floatval($steps[$i]->{'distance'}->{'value'});
	if (!isset($dis)) {
		$dis = 0;
	}
	$total_dis += $dis;
	//print "dis=".$dis."<br>";
	$in_out = array();
	for ($j=0; $j<count($points2); $j++) {
		array_push($in_out, getState($points2[$j][0], $points2[$j][1], $polygon));
	}
	$previous = $in_out[0];
	$anchor = 0;
	for ($j=1; $j<count($points2); $j++) {
		if ($j==(count($points2)-1)) { //Last point
			if ($previous!=$in_out[$j]) {
				if (isset($state_dis[$in_out[$anchor]])) {
					$state_dis[$in_out[$anchor]] += get_distance($points2[$anchor], $points2[$j-1]);//($j- $anchor - 1)*1.0/(count($in_out)-1)*$dis;	
				} else {
					$state_dis[$in_out[$anchor]] = get_distance($points2[$anchor], $points2[$j-1]);//($j- $anchor - 1)*1.0/(count($in_out)-1)*$dis;
				}

				$previous = $in_out[$j];
				$anchor = $j;
			} else {
				if ($anchor == 0) {
					if (isset($state_dis[$in_out[$anchor]])) {
						$state_dis[$in_out[$anchor]] += $dis;	
					} else {
						$state_dis[$in_out[$anchor]] = $dis;
					}	
				} else {
					if (isset($state_dis[$in_out[$anchor]])) {
						$state_dis[$in_out[$anchor]] += get_distance($points2[$anchor], $points2[$j]);//($j- $anchor - 1)*1.0/(count($in_out)-1)*$dis;	
					} else {
						$state_dis[$in_out[$anchor]] = get_distance($points2[$anchor], $points2[$j]);//($j- $anchor - 1)*1.0/(count($in_out)-1)*$dis;
					}					
				}
				
				//echo 'state '.$previous.'='.$state_dis[$in_out[$anchor]].'<br>';
				$previous = $in_out[$j];
				$anchor = $j;
			}

		} else if ($previous!=$in_out[$j]) {
			if (isset($state_dis[$in_out[$anchor]])) {
				$state_dis[$in_out[$anchor]] += get_distance($points2[$anchor], $points2[$j]);//($j- $anchor - 1)*1.0/(count($in_out)-1)*$dis;	
				print 'get_distance= '.get_distance($points2[$anchor], $points2[$j-1]).'<br>';
			} else {
				$state_dis[$in_out[$anchor]] = get_distance($points2[$anchor], $points2[$j-1]);//($j- $anchor - 1)*1.0/(count($in_out)-1)*$dis;
			}
			// for ($k = 0; $k < count($in_out); $k++) {
			// 	print 'in_out='.$in_out[$k].'<br>';
			// }
			add_avariable("in_out", $in_out);
			print 'i='.$i.'<br>';
			$previous = $in_out[$j];
			$anchor = $j;
		}
	}
}
print 'total_step = '.count($steps)."<br>";
$total_state_dis = 0;
print "-------------------------------<br>";
for ($i=0;$i<count(array_keys($state_dis)); $i++) {
	$total_state_dis += $state_dis[array_keys($state_dis)[$i]];
	print array_keys($state_dis)[$i].': '.$state_dis[array_keys($state_dis)[$i]]*0.000621371192." mi<br>";
}
print "-------------------------------<br>";
print "total_state_dis=".$total_state_dis*0.000621371192." mi<br>";
print "total_dis=".$total_dis*0.000621371192." mi<br>";

add_avariable("anchors", $anchors);
add_avariable("locations", $locations);
add_avariable("state_dis", $state_dis);
//step4
curl_close($cSession);
//step5
//echo $result;
//console_log($result);

// String to decode



//=> array(
//     41.90374,-87.66729,41.90324,-87.66728,
//     41.90324,-87.66764,41.90214,-87.66762
//   );
console_log($points1);
// Or list of tuples

//=> array(
//     array(41.90374,-87.66729),
//     array(41.90324,-87.66728),
//     array(41.90324,-87.66764),
//     array(41.90214,-87.66762)
//   );
console_log($points2);
add_avariable("points", $points2);
$location = array();

// for ($i=0;$i<10;$i++) {
// 	$cSession = curl_init(); 
// 	$lat = $points2[$i][0];
// 	$long = $points2[$i][1];
// 	$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&key=AIzaSyAq_4lcmeuCIbZ288vbXMnYowGL-PO-lxk&result_type=administrative_area_level_1";

// 	//step2
// 	curl_setopt($cSession,CURLOPT_URL, $url);
// 	curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
// 	curl_setopt($cSession,CURLOPT_HEADER, false);

// 	//step3
// 	$result = json_decode(curl_exec($cSession));
// 	array_push($location, $result);
// 	//echo gettype($result);
	
// }
// add_avariable("a_location", $location);
//echo $encoded;
print "num_points=".$num_points."<br>";

print "Time duration: ".(microtime(true) - $time)."s<br>";
// $polygon = array(
//     new Point(0,5),
//     new Point(3,5),
//     new Point(3,0),
//     new Point(4,3),
//     new Point(0,5),
// );
  
// $point1 = new Point(1,4);
  
// echo contains($point1,$polygon)?'IN':'OUT';
// echo "<br />";
  
// $point2 = new Point(3,2);
  
// echo contains($point2,$polygon)?'IN':'OUT';
// echo "<br />";
  
// $point3 = new Point(2,0.5);
  
// echo contains($point3,$polygon)?'IN':'OUT';
$p = new Point(41.11246879, -119.71801758);
echo contains($p, $polygon['CA'])?'IN':'OUT';
 ?>
