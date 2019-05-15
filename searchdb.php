<?php
echo "<center>";
$email=$_POST['email']; 
$link = mysqli_connect("localhost", "root", "", "resume"); 

if ($link == false) { 
	die("ERROR: Could not connect. "
				.mysqli_connect_error()); 
} 
$sql="SELECT * FROM userdata WHERE email='".$email."'";
if ($res = mysqli_query($link, $sql)) { 
	if (mysqli_num_rows($res) > 0) { 
		echo "<table>"; 
		echo "<tr>"; 
		echo "<th>name</th>"; 
		echo "<th>email</th>"; 
		echo "<th>mobile number</th>"; 
		echo "<th>resume</th>";
		echo "</tr>"; 
		while ($row = mysqli_fetch_array($res)) { 
			echo "<tr>"; 
			echo "<td>".$row['name']."</td>"; 
			echo "<td>".$row['email']."</td>"; 
			echo "<td>".$row['mobileno']."</td>";
			echo "<td>".$row['resumepdf']."</td>"; 
			echo "</tr>"; 
		} 
		echo "</table>"; 
	} 
	else { 
		echo "No matching records are found."; 
	} 
} 
else { 
	echo "ERROR: Could not able to execute $sql. "
								.mysqli_error($link); 
} 
mysqli_close($link); 
echo "<br>";
include 'resumeupdate.html';
echo "</center>";
?> 