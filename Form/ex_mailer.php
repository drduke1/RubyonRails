<?php 

try {
    $db = new PDO('mysql:host=localhost;dbname=x;charset=utf8', 'x', 'x');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

try {
$db = new PDO('mysql:host=localhost;dbname=x;charset=utf8', 'x', 'x');
$ipaddress = $_SERVER['REMOTE_ADDR'];
$email = $_POST['email'];

$stmt = $db->prepare("SELECT * FROM ucm_signup WHERE email =? ");
$stmt->bindValue(1, $email, PDO::PARAM_STR);
$stmt->execute();

if($stmt->rowCount()== 0) {  
	//if there are no duplicates...insert
	$sql = $db->prepare("INSERT INTO ucm_signup (company, address1, address2, city, province, zip, fname, 
			lname, email, phone, session, iama, buyfrom, ipaddress)
	VALUES (:company, :address1, :address2, :city, :province, :zip, :fname, :lname, :email, :phone, :session, :iama, :buyfrom, :ipaddress)");
	
		$sql->bindParam(":company", $_POST['company'],PDO::PARAM_STR);
    $sql->bindParam(":address1", $_POST['address1'],PDO::PARAM_STR);
    $sql->bindParam(":address2", $_POST['address2'],PDO::PARAM_STR);
    $sql->bindParam(":city", $_POST['city'],PDO::PARAM_STR);
    $sql->bindParam(":province", $_POST['province'],PDO::PARAM_STR);
    $sql->bindParam(":zip", $_POST['zip'],PDO::PARAM_STR);
    $sql->bindParam(":fname", $_POST['fname'],PDO::PARAM_STR);
    $sql->bindParam(":lname", $_POST['lname'],PDO::PARAM_STR);
    $sql->bindParam(":email", $_POST['email'],PDO::PARAM_STR);
    $sql->bindParam(":phone", $_POST['phone'],PDO::PARAM_STR);
    $sql->bindParam(":session", $_POST['session'],PDO::PARAM_STR);
    $sql->bindParam(":iama", $_POST['iama'],PDO::PARAM_STR);
    $sql->bindParam(":buyfrom", $_POST['buyfrom'],PDO::PARAM_STR);
    $sql->bindParam(":ipaddress", $ipaddress,PDO::PARAM_STR);
		
		$sql->execute();
		//echo $sql->rowCount();
	  //$db = null;
		header( "Location: http://www.x.com/company/ex_signup2" );
 }	


if ( !$sql )
 {
 	die('Sorry, your email address has already been entered into our database.  If you believe that this has been due to an error, contact us at www.x.com, otherwise press back and use a different email address.  Thank you.');
 }
 } catch (PDOException $e) {
 	echo 'execute failed: ' . $e->getMessage();
 }
?>