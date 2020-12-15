Getlayersstructure.php<?php
// header("Access-Control-Allow-Origin: *");
require_once("./../connection.php");
// get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);
$regionId = $data["region_id"];
//proccess retrive data from database

$sql = "";
if(is_numeric($regionId)){
  $sql = " SELECT `ShopName`,`longitude`,`latitude` FROM `pish_phocamaps_marker_store` WHERE RegionID = $regionId";
}
	$query=$conn->query($sql);
	if($query){
	    
    if ($query->num_rows > 0) {	
	$features = [];
	$i=0;
	while($row=mysqli_fetch_assoc($query)){
        $features[$i]=$row;
		$i++;
	
    }
    }else{
        $features= null;
    }
	}else{
	    $features= null;
	}

	

//$array_multi=$features;
$data=
array ('type' => 'FeatureCollection','features' => $features);
echo json_encode($data,JSON_UNESCAPED_UNICODE );


?>