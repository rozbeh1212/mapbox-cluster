<?php
header("Access-Control-Allow-Origin: *");
require_once("./../connection.php");

//proccess retrive data from database
$sql = " SELECT RegionID,ShopName FROM `pish_phocamaps_marker_store` GROUP BY RegionID ";
$query = $conn->query($sql);
if ($query) {

  if ($query->num_rows > 0) {
    $features = [];
    $i = 0;

    while ($row = mysqli_fetch_assoc($query)) {
     $features[$i]=$row;
      $i++;
    }
  } else {
    $features = null;
  }
} else {
  $features = null;
}



//$array_multi=$features;
$data =
  array('type' => 'FeatureCollection', 'features' => $features);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
