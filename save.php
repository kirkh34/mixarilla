<?php
$con = mysqli_connect("localhost","xxx","xxx", "xxx") or die(mysqli_error());


$playlistObject = $_POST['playlistObject'];

$playlistTitle       = $playlistObject["playlistTitle"];
$playlistSongs 	     = $playlistObject["playlistSongs"];
$playlistDescription = $playlistObject["playlistDescription"];
$playlistGenre 			 = $playlistObject["playlistGenre"];
$playlistID          = $playlistObject["playlistID"];
$userID              = $playlistObject["userID"];

$playlistSongs = serialize($playlistSongs);



$sql = mysqli_query($con, "SELECT * FROM playlist WHERE playlist_id='$playlistID' ")
or die(mysqli_error());

$result = mysqli_num_rows($sql);


if($result < 1){

$insert_sql = "INSERT INTO playlist (playlist_id, title, description, genre, playlist, user_id)
VALUES ('$playlistID', '$playlistTitle', '$playlistDescription', '$playlistGenre', '$playlistSongs', '$userID')";

mysqli_query($con, $insert_sql)
or die(mysqli_error());

echo "created";


} else if($result > 0){

$row = mysqli_fetch_array($sql);

$userArray = array(
"fb_id"=>$row["fb_id"],
"first_name"=>$row["first_name"],
"last_name"=>$row["last_name"],
"email"=>$row["email"]
);

//echo json_encode($userArray);


$update_sql = "UPDATE playlist SET title='$playlistTitle', description='$playlistDescription', genre='$playlistGenre', playlist='$playlistSongs', user_id='$userID' WHERE playlist_id='$playlistID' ";

mysqli_query($con, $update_sql)
or die(mysqli_error());

echo "updated";

}



?>