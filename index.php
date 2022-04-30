<style>
body{font-family:arial;}
</style>
<?php

$content =     file_get_contents("http://sam-user-activity.eu-west-1.elasticbeanstalk.com/");
//var_dump ($content);

//contains all the data
$array  = json_decode($content, true);
//echo '<pre>'; print_r($array); echo '</pre>'; // visual array

$dates = array_keys($array);

//$theDate    = new DateTime('2020-03-08');
$firstdate = new DateTime ($dates[0]);   //get first date
$lastdate = new DateTime($dates[count($dates)-1]);  //get last date
//$newFirstdate = date_format($firstdate,"yyyy/mm/dd");
//$newLastdate = date_format($lastdate,"yyyy/mm/dd");

$newFirstdate = date_format($firstdate,"Y-m-d");
$newLastdate = date_format($lastdate,"Y-m-d");

//echo $newFirstdate;

//echo $newLastdate;



//echo '<pre>'; print_r($dates); echo '</pre>'; // visual array keys
//echo 'first date '.$firstdate.' and last date '.$lastdate;  //print first and last dates
?>


<!DOCTYPE HTML>
<html>  
<body>
<h1>Visualise Growth of Userbase</h1>
<p>Select a start and end date and click the submit button to see the userbase graph<p>
<form action="graph.php" method="post">
Start Date: <input type="date" name="sdate"  id="sdate" min='<?php echo $newFirstdate;?>' max='<?php echo $newLastdate;?>' required><br><br>   
End Date: <input type="date" name="edate" id="edate" min='<?php echo $newFirstdate;?>' max='<?php echo $newLastdate;?>' required><br><br>  
<div id="message"></div>
<button type="submit" name="submit" id="submit">Click to Submit</button>
<script type="text/javascript">    //script to make sure start date is earlier than end date
  let startInput = document.getElementById('sdate');
  let endInput = document.getElementById('edate');
  let messageDiv = document.getElementById('message');
  let submitButton = document.getElementById('submit');

  let compare = () => {
    let startValue = (new Date(startInput.value)).getTime();
    let endValue = (new Date(endInput.value)).getTime();

    if (endValue < startValue) {
      messageDiv.innerHTML = 'Start date must be before end date!';
      submitButton.disabled = true;
    } else {
      messageDiv.innerHTML = '';
      submitButton.disabled = false;
    }
  };

  startInput.addEventListener('change', compare);
  endInput.addEventListener('change', compare);
</script>
</form>

</body>
</html>


