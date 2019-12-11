<?php

namespace App\Maps;

/**
 * 
 */
class GeoDistance
{

	// distance between two points in meters
	// 3958      - Earth's radius (miles)
	// 3.1415926 - PI
	// 57.29578  - Number of degrees/radian (for conversion)
	// 1609.344  - meters = 1 mile
	public static function getGeoDistancePointToPoint($lat1, $lon1, $lat2, $lon2)
	{
		return 	(3958 * 3.1415926 * sqrt(($lat2 - $lat1) * ($lat2 - $lat1) 
				+ cos($lat2 / 57.29578) * cos($lat1 / 57.29578) * ($lon2 - $lon1) * ($lon2 - $lon1)) / 180) * 1609.344;
	}

	// get height from triangle where A or B are not obtuse
	private static function getHeightFromBaseTriangle($ab, $ac, $bc)
	{
		// find $s (semiperimeter) for Heron's formula
		$s = ($ab + $ac + $bc) / 2;
		
		// Heron's formula - area of a triangle
		$area = sqrt($s * ($s - $ab) * ($s - $ac) * ($s - $bc));
		
		// find the height of a triangle - ie - distance from point to line segment
		$height = $area / (.5 * $ab);
		
		return $area;
	}

	// returns angles of a triangle from the sides
	private static function getAnglesFromSides($ab, $bc, $ac)
	{
		$a = $bc;
		$b = $ac;
		$c = $ab;
		
		$angle['a'] = rad2deg(acos((pow($b,2) + pow($c,2) - pow($a,2)) / (2 * $b * $c)));
		$angle['b'] = rad2deg(acos((pow($c,2) + pow($a,2) - pow($b,2)) / (2 * $c * $a)));
		$angle['c'] = rad2deg(acos((pow($a,2) + pow($b,2) - pow($c,2)) / (2 * $a * $b)));
		
		return $angle;			
	}

	// $a, $b, $c lat lon array of line segments ($a and $b) and the off point ($c)
	public static function getGeoDistancePointToSegment($a, $b, $c)
	{
		$ab = self::getGeoDistancePointToPoint($a['lat'], $a['lon'], $b['lat'], $b['lon']); // base or line segment
		$ac = self::getGeoDistancePointToPoint($a['lat'], $a['lon'], $c['lat'], $c['lon']);
		$bc = self::getGeoDistancePointToPoint($b['lat'], $b['lon'], $c['lat'], $c['lon']);
		
		$angle = self::getAnglesFromSides($ab, $bc, $ac);
		
		if($ab + $ac == $bc) // then points are collinear - point is on the line segment
		{
			return 0;
		}
		elseif($angle['a'] <= 90 && $angle['b'] <= 90) // A or B are not obtuse - return height as distance
		{
			return self::getHeightFromBaseTriangle($ab, $ac, $bc);
		}
		else // A or B are obtuse - return smallest side as distance
		{
			return ($ac > $bc) ? $bc : $ac;
		}

	}

	public static function getGeoDistancePointToPolyLine($polyline, $point)
	{
		$d = 999999999999;

		for ($i = 0; $i < (sizeof($polyline)-1); $i++) {
			$dp = self::getGeoDistancePointToSegment($polyline[$i], $polyline[$i+1], $point);

			if($dp < $d) {
			    $d = $dp;  
			}
		}

		return $d;
	}
}
