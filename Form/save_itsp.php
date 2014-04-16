<?php 

  /***
  Fields:
    company_name
    company_url
    company_address
    region
    type_of_business
    areas_served
    sales_name
    sales_phone
    sales_email
    testing_name
    testing_phone
    testing_email
    switch_platform
    interested_in_testing

  ****/
  /************** Validations *******************/
function died($error) {
	// your error code can go here
	echo "We are very sorry, but there were blank fields found with the form you
       submitted. ";
	$link_address = 'http://www.x.com/company/itsp';
	echo "<a href='".$link_address."'>Click to Go Back<br/></a>";
	die();
}

if ($_POST["submit"] == "Submit"){
  if (isset($_POST['company_name'])) 
  {
    $errors = "";

    //validate and sanitize company name
	  $company_name = filter_var($_POST['company_name'], FILTER_SANITIZE_STRING);
			if(empty($company_name))
			{
			    died();
			}
		
		//validate and sanitize company url
		$company_url = filter_var($_POST['company_url'], FILTER_SANITIZE_STRING);
		$company_url = preg_replace('/\s/', '', $company_url);
			if(empty($company_url))
			{
				died();
			}

    //validate and sanitize company address
    $company_address = filter_var($_POST['company_address'], FILTER_SANITIZE_STRING);
    	if(empty($company_address))
    	{
    		died();
    	}
    	
  $region = filter_var($_POST['region'], FILTER_SANITIZE_STRING);
    	if(empty($region))
    	{
    		died();
    	}
    
    if (is_array($_POST['type_of_business']) && !empty($_POST['type_of_business'])) {
    	$type_of_business_val = array();
    	foreach($_POST['type_of_business'] as $val) {
    		$type_of_business_val[] = $val;
    	}
    	$type_of_business = implode(',', $type_of_business_val);
    	$type_of_business = preg_replace('/\s/', '', $type_of_business);
    	if (empty($type_of_business))
    	{
    		died();
    	}
    }
    else
    	died();
    
    if (is_array($_POST['areas_served']) && !empty($_POST['areas_served'])) {
    	$areas_served_val = array();
    	foreach($_POST['areas_served'] as $val) {
    		$areas_served_val[] = $val;
    	}
    	$areas_served = implode(',', $areas_served_val);
    }
    else
    	died();
    //validate and sanitize sales name
    $sales_name = filter_var($_POST['sales_name'], FILTER_SANITIZE_STRING);
    if(empty($sales_name))
    {
    	died();
    }
    
    //validate and sanitize sales email
    $sales_email = filter_var($_POST['sales_email'], FILTER_SANITIZE_STRING);
    $sales_email = preg_replace('/\s/', '', $sales_email);
    if(empty($sales_email))
    {
    	died();
    }
    
    //validate and sanitize sales phone number
    $sales_phone = filter_var($_POST['sales_phone'], FILTER_SANITIZE_STRING);
    if(empty($sales_phone))
    {
    	died();
    }
    
    //validate and sanitize testing name
    $testing_name = filter_var($_POST['testing_name'], FILTER_SANITIZE_STRING);
    if(empty($testing_name))
    {
    	died();
    }
    
    //validate and sanitize testing email
    $testing_email = filter_var($_POST['testing_email'], FILTER_SANITIZE_STRING);
    if(empty($testing_email))
    {
    	died();
    }
    
    $testing_phone = filter_var($_POST['testing_phone'], FILTER_SANITIZE_STRING);
    if(empty($testing_phone))
    {
    	died();
    }
    
    if (is_array($_POST['switch_platform']) && !empty($_POST['switch_platform'])) 
    {
    	$switch_platform_val = array();
    	foreach($_POST['switch_platform'] as $val) {
    		$switch_platform_val[] = $val;
    	}
    	$switch_platform = implode(',', $switch_platform_val);
    }
    else
    	died();
    
    if (is_array($_POST['interested_in_testing']) && !empty($_POST['interested_in_testing'])) {
    	$interested_in_testing_val = array();
    	foreach($_POST['interested_in_testing'] as $val) {
    		$interested_in_testing_val[] = $val;
    	}
    	$interested_in_testing = implode(',', $interested_in_testing_val);
    }
    else
    	died();
  }
  /************** End Validations *******************/
  /* CAPTCHA :) */
  session_start();
  
  include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
  $securimage = new Securimage();
  if ($securimage->check($_POST['captcha_code']) == false) {
  	// the code was incorrect
  	// you should handle the error so that the form processor doesn't continue
   	// or you can use the following code if there is no validation or you do not know how
  	echo "The security code entered was incorrect.<br /><br />";
  	echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
  	exit;
  }  
  /*****Email*****/
  $ipaddress = $_SERVER['REMOTE_ADDR'];
  $to = "x";
  $na = "x";
  $latm = "x";
  $emea = "x";
  $apac = "x";
  $china = "x"; 
  
  $subject = "New ITSP Submission";
  $message1 = "A new ITSP has submitted their information:
    <br/><b>Company Name:</b> " . $company_name . "
    <br/><b>Company URL:</b> " . $company_url . "
    <br/><b>Company Address:</b> " . $company_address . "
    <br/><b>Region:</b> " . $region . "
    <br/><b>Type of Business:</b> " . $type_of_business . "
    <br/><b>Area(s) Served:</b> " . $areas_served . "
    <br/><b>Sales Name:</b> " . $sales_name . "
    <br/><b>Sales Email:</b> " . $sales_email . "
    <br/><b>Sales Phone:</b> " . $sales_phone . "
    <br/><b>Testing Name:</b> " . $testing_name . "
    <br/><b>Testing Email:</b> " . $testing_email . "
    <br/><b>Testing Phone:</b> " . $testing_phone . "
    <br/><b>Switch Platform:</b> " . $switch_platform . "
    <br/><b>Interested In Testing:</b> " . $interested_in_testing . "
    <br/><br/>IP Address: " . $ipaddress ;

  $headers = "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\n";
  $headers .= "X-Priority: 3\n";
  $headers .= "X-MSMail-Priority: Normal\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \'xCSS\' <noreply@x.com>\n";
  $headers .= "Return-Path: noreply@x.com\n";
  $headers .= "Return-Receipt-To: noreply@x.com\n";

  
  if ($region == 'na') {
  	mail($na,$subject,$message1,$headers);
  	header("location: http://www.x.com/company/itsp-confirmation/");
  }
  elseif ($region == 'latm') {
  	mail($latm,$subject,$message1,$headers);
  	header("location: http://www.x.com/company/itsp-confirmation/");
  }
  elseif ($region == 'apac') {
  	mail($apac,$subject,$message1,$headers);
  	header("location: http://www.x.com/company/itsp-confirmation/");
  }
  elseif ($region == 'emea') {
  	mail($emea,$subject,$message1,$headers);
  	header("location: http://www.x.com/company/itsp-confirmation/");
  }
  elseif ($region == 'china') {
  	mail($china,$subject,$message1,$headers);
  	header("location: http://www.x.com/company/itsp-confirmation/");
  }
  elseif ($ipaddress == '5.39.219.26') {
  	header("location: http://www.fbi.gov/scams-safety/e-scams");
  }
  else {
  	$subject = "ITSP Error";
  	$message1 = "Not sent to a region!";
  	mail($to,$subject,$message1,$headers);
  	header("location: http://www.x.com/company/itsp-confirmation/");
  }
}
else {
	header("location: http://www.x.com/company/itsp/");
}
?>
