<?php
// header("Access-Control-Allow-Origin: *");
// require_once("./../connection.php");
// get the raw POST data
header("Access-Control-Allow-Origin: *");
require_once("./../connection.php");

 $conn = new mysqli($servername, $username, $password, $db_name);
 $json = (file_get_contents('php://input',true));
 $post = json_decode($json,true);
 $RegionID=$post['reg'];

//$data = json_decode(file_get_contents('php://input'), true);
//$regionId = $data["region_id"];
//proccess retrive data from database

$sql = "";
if (is_numeric($RegionID)) {
    $sql = " SELECT `id`, `RegionID`, `ShopName`,`phone`,`Address`,`longitude`,`latitude` FROM `pish_phocamaps_marker_store` WHERE RegionID = $RegionID";
}
    $query=$conn->query($sql);
    mysqli_set_charset($conn, "utf8");

    if ($query) {
        if ($query->num_rows > 0) {
            $features = [];
            $i=0;
            while ($row=mysqli_fetch_assoc($query)) {


                //down
                $lat=$row['latitude'];
                $long=$row['longitude'];
                $properties1=array('title'=> $row['ShopName'],'description'=> $row['phone'] ,'address'=>  $row['Address']);
                $arr=array('type' => 'Feature','properties' => $properties1,'geometry' => array('type' => 'Point','coordinates' => array(0 => $long,1 => $lat)));

        //up
        $features += ["$i" =>$arr ];

        $i++;

            }
        } 
        else {
            $features= null;
        }
    } 
    else {
        $features= null;
    }

    

//$array_multi=$features;
$data=
array('type' => 'FeatureCollection','features' => $features);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
