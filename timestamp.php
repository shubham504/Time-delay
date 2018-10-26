<?php
session_start();
$psid=$_SESSION["user"];
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
	$stmt1 = $conn->prepare("SELECT * from user where session_id=:ss");
 $stmt1->execute(array(':ss' => $psid));
 $result = $stmt1->fetchAll();
 foreach($result as $row){
	
	
$date_a = new DateTime(date("Y-m-d H:i:s"));
$date_b = new DateTime($row['c_time']);
 $date_c = new DateTime($row['g_time']);
$interval = date_diff($date_a,$date_b);
 $timestamp= $date_b->format('U') - $date_a ->format('U');
$second_120=floor($timestamp/2);
$variation = str_replace("-", "", $second_120);
$nval="PT".$variation."S";
$nval=new DateInterval($nval);
$exp_date=$variation/86400;
$date_c->add($nval);
$printv= $date_c;


if($exp_date>$row['randm']){
	$u_date = new DateTime($row['updated_time']);
$yar=$u_date->format("Y"); $new_year=$yar+1;
	$newtime=$new_year."-01-01 00:00:00";
	$randm=$row['randm']*2;
}else{
	

$newtime=date_format($printv, 'd-m-Y H:i:s');
$randm=$row['randm'];
}

$sthh = $conn->prepare("UPDATE user SET updated_time = :ba, randm=:rn  where session_id = :bb");
		$sthh->bindParam(':ba', $newtime); 
		$sthh->bindParam(':rn', $randm);
		$sthh->bindParam(':bb', $psid);
if($sthh->execute()){
	
				$stmt1 = $conn->prepare("SELECT * from user where session_id=:ss");
				$stmt1->execute(array(':ss' => $psid));
				$result = $stmt1->fetchAll();
				foreach($result as $row){
				//echo date("Y-m-d H:i:s",$printv);
				//echo "db rand inserted value:---------------   ".date_format($date_c, 'd/m/Y H:i:s')."<br>";
					echo "<div class='c_timez'><div class='date_zone'><span class='date'>".date('d')."</span><span class='months'>".date('m')."</span><span class='year'>".date('Y')."</span></div><div class='time_zone'><span class='hours'>".date('H')."</span><span class='minutes'>".date('i')."</span><span class='seconds'>".date('s')."</span></div></div></br>";
					$time_y=strtotime($row['updated_time']);
					
					

$newformat = date('Y',$time_y);
$newformat_m = date('m',$time_y);
$newformat_d = date('d',$time_y);
$newformat_h = date('H',$time_y);
$newformat_m = date('m',$time_y);
$newformat_s = date('s',$time_y);
					//echo "<div class='c_timez'>Stored Time zone:".$row['g_time']."</br>";
					echo "<div class='c_timez result_date_time'><div class='res_date_zone'><span class='re_date'>".$newformat_d."</span><span class='re_months'>".$newformat_m."</span><span class='re_year'>".$newformat."</span></div><div class='res_time_zone'><span class='re_hours'>".$newformat_h."</span><span class='re_minutes'>".$newformat_m."</span><span class='re_seconds'>".$newformat_s."</span></div></div>";
					
				}
}
}
?>
