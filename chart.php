<?php
header("Access-Control-Allow-Origin: *");
require_once("./../connection.php");

$conn = new mysqli($servername, $username, $password, $db_name);
 $json = (file_get_contents('php://input',true));
 $post = json_decode($json,true);
 $RegionID=$post['reg'];

//$RegionID=$_post[`RegionID`];

// if (isset($_REQUEST['reg1'])){
// $RegionID1=$_REQUEST['reg1'];
// }
// else if($_REQUEST['reg1'] == 2){
//     echo "its 2";
// }
// else{
// $RegionID= 1;
// }

// if ($reg1==1) {
//     echo "1";
//     $RegionID= 1;
// }
//if(isset($_POST[`reg`])){
//$RegionID= (int) $RegionID;
// print $RegionID;
// $sql = " SELECT `id`, `RegionID`, `ShopName`,`phone`,`Address`,`longitude`,`latitude` FROM `pish_phocamaps_marker_store` limit 100 ";

$sql = " SELECT `id`, `RegionID`, `ShopName`,`phone`,`Address`,`longitude`,`latitude` FROM `pish_phocamaps_marker_store` where `RegionID`= $RegionID";
$query = $conn->query($sql);

mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



    $query=$conn->query($sql);
    $features = [];
    $i=0;

    while ($row=mysqli_fetch_array($query)) {
 
        $lat=$row['latitude'];
        $long=$row['longitude'];
        $properties1=array('id'=> $row['id'],'title'=> $row['ShopName'],'description'=> $row['phone'] ,'address'=>  $row['Address']);
        $arr=array('type' => 'Feature','properties' => $properties1,'geometry' => array('type' => 'Point','coordinates' => array(0 => $long,1 => $lat)));
        $features += ["$i" =>$arr ];

        $i++;

    }
    
$data=
array('type' => 'FeatureCollection','features' => $features);
echo json_encode($data,JSON_UNESCAPED_UNICODE);

//}