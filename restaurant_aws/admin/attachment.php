<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$name_of_uploaded_file =  basename($_FILES['uploaded_file']['name']);
$type_of_uploaded_file =   substr($name_of_uploaded_file,strrpos($name_of_uploaded_file, '.') + 1);
$size_of_uploaded_file =  $_FILES["uploaded_file"]["size"]/1024;//size in KBs
$max_allowed_file_size = 1024; // size in KB
$allowed_extensions = array("jpg", "jpeg", "gif", "pdf");
$file_tmp = $_FILES["uploaded_file"]["tmp_name"];
$errors="";
if($file_tmp)
{
	//Validations
	if($size_of_uploaded_file > $max_allowed_file_size )
	{
		$errors .= "\n Size of file should be less than $max_allowed_file_size";
	}

	//------ Validate the file extension -----
	$allowed_ext = false;
	for($i=0; $i<sizeof($allowed_extensions); $i++)
	{
		if(strcasecmp($allowed_extensions[$i],$type_of_uploaded_file) == 0)
		{
			$allowed_ext = true;
		}
	}
 
	if(!$allowed_ext)
	{
		$errors .= "\n The uploaded file is not supported file type. "." Only the following file types are supported: ".implode(',',$allowed_extensions);
	}
	$file_name_val = explode(".",$name_of_uploaded_file);
	$new_file_name=$file_name_val[0].'_'.date("d_m_Y H_i_s").'.'.$file_name_val[1];
	if(!$errors)
	{
		if(move_uploaded_file($file_tmp,"mail_attachment/".$new_file_name))
		{
			echo 'success~'.$new_file_name;
		}
		else
			echo 'error~upload not possible';
		
	}
}
else
{
	echo 'success~';
	exit;
}

if(strlen($errors) > 0)
{
	echo 'error~'.$errors;
	exit;
}


?>