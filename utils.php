<?php 
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function add_avariable($varName, $var) {
	echo '<script>';
  echo 'var '.$varName.'='.json_encode( $var ).';';
  echo '</script>';	
}

function pointInPolygon($p, $polygon) {
    //if you operates with (hundred)thousands of points
    set_time_limit(60);
    $c = 0;
    $p1 = $polygon[0];
    $n = count($polygon);

    for ($i=1; $i<=$n; $i++) //any student need to go through this
    {
        $p2 = $polygon[$i % $n];
        if ($p->lng > min($p1->lng, $p2->lng)
            && $p->lng <= max($p1->lng, $p2->lng)
            && $p->lat <= max($p1->lat, $p2->lat)
            && $p1->lng != $p2->lng) 
        {
                $xinters = ($p->lng - $p1->lng) * ($p2->lat - $p1->lat) / ($p2->lng - $p1->lng) + $p1->lat;
                if ($p1->lat == $p2->lat || $p->lat <= $xinters) {
                    $c++;
                }
        }
        $p1 = $p2;
    }
    // if the number of edges we passed through is even, then it's not in the poly.
    return ($c%2 != 0);
}



class Point {
    public $lat;
    public $lng;
    function Point($lat, $lng) {
        $this->lat = $lat;
        $this->lng = $lng;
    }
}

$polygon = array();
$polygon['WA'] = [new Point(48.99815, -122.74492),
					new Point(48.99435	,-117.03684),
					new Point(46.00333	,-116.92835),
					new Point(46.00333	,-116.92835),
					new Point(45.60091	,-122.51284),
					new Point(46.26186	,-123.89162),
					];

$polygon['WY'] = [new Point(44.997611, -111.040583),
				new Point(41.020160, -111.042130),
				new Point(41.018553, -104.026575), 
				new Point(44.997824, -104.067098)];

$polygon['OR'] = [new Point(46.00122	,-123.75155),
				new Point(45.97068	,-116.98397),
				new Point(42.05384	,-117.11580), 
				new Point(42.02120	,-124.23494)];

$polygon['MT'] = [new Point(48.96981	,-116.06112),
				new Point(45.54143	,-114.30330),
				new Point(44.51654	,-111.22713), 
				new Point(45.01575	,-111.05135),
				new Point(45.04681	,-104.28377), 
				new Point(48.94096,	-104.15194)];

$polygon['ID'] = [new Point(48.96981	,-117.15975),
				new Point(42.08646	,-116.89608),
				new Point(42.11907	,-111.18319), 
				new Point(44.13931	,-111.18319), 
				new Point(45.63369	,-113.99569), 
				new Point(48.94096	,-116.06112)];

$polygon['CA'] = [new Point(42.03752	,-124.21297),
				new Point(42.00488	,-119.90633),
				new Point(38.99833	,-119.95028), 
				new Point(35.03501	,-114.67684),
				new Point(31.78534	,-114.79769),
				new Point(32.72660	,-116.94002)];

$polygon['NV'] = [new Point(41.96864	,-119.96126),
				new Point(39.04954	,-119.97225),
				new Point(35.12492	,-114.61092), 
				new Point(37.04253	,-113.99569), 
				new Point(41.92319	,-113.99569)];

$polygon['UT'] = [new Point(41.96685	,-114.04513),
				new Point(41.96864	,-111.07332),
				new Point(41.03064	,-111.05135), 
				new Point(40.98089	,-109.07381), 
				new Point(37.02115	,-109.05184), 
				new Point(37.02115	,-114.01766)];

$polygon['AZ'] = [new Point(36.95095,	-113.99569),
				new Point(37.00361	,-109.07381),
				new Point(31.41104	,-109.09578), 
				new Point(32.54792	,-114.76473),
				new Point(36.97234	,-113.89681)];

$polygon['CO'] = [new Point(40.96793	,-108.97493),
				new Point(40.86831	,-102.11947),
				new Point(37.00744	,-102.03158), 
				new Point(37.00744	,-108.93099)];

$polygon['ND'] = [new Point(48.96981,	-103.92122),
				new Point(48.96981	,-97.37337),
				new Point(46.03173	,-96.62630), 
				new Point(46.03173	,-103.96517)];

$polygon['SD'] = [new Point(45.87563,	-103.99813),
				new Point(45.89093	,-96.59334),
				new Point(42.94130	,-96.48348), 
				new Point(43.06985	,-103.97616)];

$polygon['NE'] = [new Point(43.07336,	-104.00911),
				new Point(42.78377	,-96.67025),
				new Point(40.21712	,-95.48372), 
				new Point(40.08276	,-102.03158),
				new Point(41.01769	,-102.03158)];

$polygon['KS'] = [new Point(39.94813,	-101.94368),
				new Point(39.98181	,-95.13216),
				new Point(37.16520	,-94.64876), 
				new Point(37.06007	,-101.98763)];

$polygon['NM'] = [new Point(37.02499,	-109.01888),
				new Point(37.06007	,-103.04232),
				new Point(32.14360	,-103.04232), 
				new Point(31.50885	,-108.97493)];

$polygon['OK'] = [new Point(37.02499,	-102.95443),
				new Point(37.02499	,-94.69271),
				new Point(33.72943	,-94.56087), 
				new Point(34.78275	,-102.91048)];

$polygon['TX'] = [new Point(36.13062,	-102.77865),
				new Point(35.98852	,-100.14193),
				new Point(33.09322	,-93.98958), 
				new Point(30.55453	,-94.16536),
				new Point(26.22625	,-97.68099),
				new Point(31.75790	,-106.64583),
				new Point(32.50219	,-103.13021),
				];

function getState($lat, $lng, $polygon) {
	$keys = array_keys($polygon);
	for ($i=0;$i<count($keys);$i++) {
		if (pointInPolygon(new Point($lat, $lng), $polygon[$keys[$i]])) {
			return $keys[$i];
		}
	}
	return "UN";
}
 ?>
