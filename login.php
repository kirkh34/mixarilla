<?php
$con = mysqli_connect("localhost","xxx","xxx", "xxx") or die(mysqli_error());


$userObject = $_POST['userObject'];

$fb_id      = $userObject["fb_id"];
$first_name = $userObject["first_name"];
$last_name  = $userObject["last_name"];
$email      = $userObject["email"];


//echo json_encode($userObject);



$sql = mysqli_query($con, "SELECT * FROM users WHERE fb_id='$fb_id' ")
or die(mysqli_error());

$result = mysqli_num_rows($sql);


if($result < 1){

$insert_sql = "INSERT INTO users (fb_id, first_name, last_name, email)
VALUES ('$fb_id', '$first_name', '$last_name', '$email')";

mysqli_query($con, $insert_sql)
or die(mysqli_error());

} else if($result > 0){

$row = mysqli_fetch_array($sql);

$userArray = array(
"fb_id"=>$row["fb_id"],
"first_name"=>$row["first_name"],
"last_name"=>$row["last_name"],
"email"=>$row["email"]
);

//echo json_encode($userArray);


}



//while($row = mysql_fetch_array($sql){}

/*
// requires php5
	$id = $_POST['id'];
	$img = $_POST['img'];
	$name = $_POST['name'];
	$dir = $_POST['dir'];
	$newName = $_POST['newName'];
	$newTags = $_POST['newTags'];

	$fullDir = $_POST['fullDir'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	//print $success ? $fullDir : 'Unable to save the file.';
	
	
	$png = mt_rand(0,1000000000) . ".png";
	$fullDir = 'images/canvasExport/' . $png;
	
	file_put_contents($fullDir, $data);
	
	//   mysql_query("UPDATE fonts SET name='$newName', path_img='$fullDir', tags='$newTags' WHERE id='$id' ")
      //  		or die(mysql_error());
        echo $fullDir;		
        		
//$json = array( "img" => $data);
//echo json_encode($json);

*/
?>