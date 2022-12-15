<?php
$connect = mysqli_connect("localhost", "root", "", "belajar");
$number = count($_POST["name"]);
if($number > 1)
{
	for($i=0; $i<$number; $i++)
	{
		if(trim($_POST["name"][$i] != ''))
		{
			$sql = "INSERT INTO tbl_name(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
			mysqli_query($connect, $sql);
		}
	}
	var_dump($_POST["name"]);
	exit;
	
}
else
{
	echo "Please Enter Name";
}