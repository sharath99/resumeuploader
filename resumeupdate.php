<?php
function extract_emails_from($string) 
{
			$pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
            preg_match_all($pattern, $string, $matches);
             return $matches[0]; 
}
function extract_mobile_from($string) 
{           
			$pattern='/[1-9]{1}[0-9]{9,11}/';
            preg_match_all($pattern, $string, $matches);
             return $matches[0]; 
}
 $targetfolder = "uploads/";

 $targetfolder = $targetfolder . basename( $_FILES['file']['name']) ;

if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))
 {
 	$pdf_file = $targetfolder; 

	$content = shell_exec('pdftotext ' . $pdf_file . ' -'); 

	$mysqli = new mysqli('localhost', 'root', '', 'resume');

	if ($mysqli->connect_error) {
    	die('Connect Error (' . $mysqli->connect_errno . ') '
        	    . $mysqli->connect_error);
	}
	else
	{
		$email=extract_emails_from($content)[0];
			$mobileno=extract_mobile_from($content)[0];
			$name=$_POST['name'];
		$sql="insert into userdata VALUES ('".$email."',
			'".$name."',".$mobileno.",'".$pdf_file."')";
		if ($mysqli->query($sql) === TRUE) 
		{
			
			echo $name;
			echo "<br>";
			echo $email;
			echo "<br>";
			echo $mobileno;
			echo "<br>";
    		echo "resume ". basename( $_FILES['file']['name']). " is uploaded";
    		echo "<br>";


  
	require'PHPMailer-5.2.25/PHPMailerAutoload.php'; 
	$mail=new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
		$mail->Host ='smtp.gmail.com';
		$mail->Port = '587';
		$mail->isHTML(true);
		$mail->Username ='demomailresume@gmail.com';
		$mail->Password = 'resume1234';
		$mail->SetFrom('demomailresume@gmail.com');
		$mail->Subject ='resume upload status';
		$mail->Body = "email id : ".$email."<br>mobile number : ".$mobileno."<br>resume uploaded successfully";
	        $mail->AddAddress($email);
	 	if(!$mail->Send()) {
	   	 echo "Mailer Error:" . $mail->ErrorInfo;
		}

		}
		else
		{
			if($mysqli->error == "Duplicate entry '".extract_emails_from($content)[0]."' for key 'PRIMARY'")
			{
				echo "use another email";
			}
			else
			{
	    		echo $mysqli->error;
    		}
		}
	}
	$mysqli->close();
 }

 else {

 echo "Problem uploading file";

 }
 include 'resumeupdate.html';
 ?>