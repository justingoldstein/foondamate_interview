<style>
body{font-family:arial;}
</style>

<?php

$content =     file_get_contents("http://sam-user-activity.eu-west-1.elasticbeanstalk.com/");
//var_dump ($content);

//contains all the data
$userdata  = json_decode($content, true);


$dates = array_keys($userdata);
$firstdate = $dates[0];   //get first date
$lastdate = $dates[count($dates)-1];  //get last date
//echo '<pre>'; print_r($userdata); echo '</pre>'; // visual array
//echo 'first date '.$firstdate.' and last date '.$lastdate.'<br />';  //print first and last dates
$noofusers = array_values($userdata);


$inputdate1 = date("d-m-Y", strtotime($_POST["sdate"]));   //convert date to same format as data in the array 
$inputdate2 = date("d-m-Y", strtotime($_POST["edate"]));   //convert date to same format as data in the array 


$userdate1 = array_search($inputdate1, $dates);
$userdate2 = array_search($inputdate2, $dates);

//For testing
//echo 'user input 1 '.$userdate1;
//echo 'user input 2 '.$userdate2;


$arrJ = array();
for ($i = $userdate1; $i <= $userdate2; $i++) {
    $arrJ[] = array('y' => $noofusers[$i], 'label' => $dates[$i]);
}

//For testing
//echo json_encode($arrJ);
//echo '<pre>'; print_r($arrJ); echo '</pre>';
 

//var_dump($userdata);

 
 
 
?>




<!DOCTYPE HTML>
<html>
<body>
<br>
Start date Selected: <?php echo $_POST["sdate"]; ?><br><br>
End date selected: <?php echo $_POST["edate"]; ?><br><br>
<a href="index.php"><h2>Click here to select new dates</h2></a>

</body>
</html>


<!-- Use cancasjs to draw a grpah use data from array arrJ -->
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Users over Time"
	},
	axisY: {
		title: "Number of Users"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($arrJ, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>           





