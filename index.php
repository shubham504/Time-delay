<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	
        setInterval(timestamp, 1000);
    });
	

function timestamp() {
    $.ajax({
		type : "POST",
        url: '<?php echo plugin_dir_url($file); ?>/timestamp.php',
        success: function(data) {
            $('#timestamp').html(data);
        },
    });
}
	

</script>

<?php

session_start();
	
$servername = "localhost";
$username = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$servername;dbname=YOUR_DB_NAME", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	
if($_SESSION["user"]==''){
$_SESSION["user"]=rand(22,444444).microtime();
}
$sess= $_SESSION["user"];
						
?>
<?php $stmt1 = $conn->prepare("select * from user where session_id=:ss");
 $stmt1->execute(array(':ss' => $sess));
 $count = $stmt1->rowCount();
 if($count>0){
	 ?>
<div id="timestamp" style="text-align:  center;padding: 48px;"></div>

<?php
 }else{
	
	// $val=rand(1905,2995 )."-01-01 00:00:00";
	$c_time=date("Y-m-d H:i:s");

	$randm=rand(190,210);
	 
$first_date = "2995-01-01 00:00:00";
$second_date = "1905-12-31 00:00:00";
$first_time = strtotime($first_date);
$second_time = strtotime($second_date);

$rand_time = rand($first_time, $second_time);
$val = date('Y-m-d H:i:s', $rand_time);
	 

$stmt1 = $conn->prepare("insert into user (`session_id`,`c_time`, `g_time`, `randm` ) values(:sid,:a,:b,:rd)");
 $stmt1->execute(array(':sid' => $sess,':a' => $c_time, ':b' => $val, ':rd' =>$randm ));
	 
	 
?>
<form id="as" action="#" method="POST" style="text-align:  center;padding: 48px;">
<input type="submit" id="sub"  name="sub" value="Generate Timestamp" />
</form>
 <?php } ?>
