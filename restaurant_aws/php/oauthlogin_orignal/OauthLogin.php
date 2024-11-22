<?php
class OauthLogin {
	
	public function userDetails($user_session) 
	{
		$row_id=mysql_real_escape_string($user_session);
		$query = mysql_query("SELECT * FROM `users` WHERE id = '$row_id'") or die(mysql_error());
		$row=mysql_fetch_array($query);
	    return $row;
	}

    public function userSignup($userData,$loginProvider) 
	{
		
		$name='';
		$first_name='';
		$last_name='';
		$email='';
		$gender='';
		$birthday='';
		$location='';
		$hometown='';
		$bio='';
		$relationship='';
		$timezone='';
		$provider_id='';
		$picture='';
		
		
    if($loginProvider == 'facebook' || $loginProvider == 'google')
	{
	$email=mysql_real_escape_string($userData['email']);
    }
    else if($loginProvider == 'microsoft' )
	{
	$email=mysql_real_escape_string($userData->emails->account);
    }
	else if($loginProvider == 'linkedin' )
	{
	$email= mysql_real_escape_string($userData['email-address']);
    }
	
	$query = mysql_query("SELECT id,provider FROM `users` WHERE email = '$email'") or die(mysql_error());
	if(mysql_num_rows($query) == 0)
	{
		
		

        //Facebook Data
		if($loginProvider == 'facebook')
		{	
	            $name=mysql_real_escape_string($userData['name']);
				$first_name=mysql_real_escape_string($userData['first_name']);
				$last_name=mysql_real_escape_string($userData['last_name']);
				$email=mysql_real_escape_string($userData['email']);
				$gender=mysql_real_escape_string($userData['gender']);
				$birthday=mysql_real_escape_string($userData['birthday']);
				$location=mysql_real_escape_string($userData['location']['name']);
				$hometown=mysql_real_escape_string($userData['hometown']['name']);
				$bio=mysql_real_escape_string($userData['bio']);
				$relationship=mysql_real_escape_string($userData['relationship_status']);
				$timezone=mysql_real_escape_string($userData['timezone']);
				$provider_id=mysql_real_escape_string($userData['id']);
				$picture='https://graph.facebook.com/'.$provider_id.'/picture';
				
		}
		//Google Data
	    if($loginProvider == 'google')
		{
	
				$email =mysql_real_escape_string($userData['email']);
			    $name =mysql_real_escape_string($userData['name']);
				$first_name=mysql_real_escape_string($userData['given_name']);
				$last_name=mysql_real_escape_string($userData['family_name']);
				$gender=mysql_real_escape_string($userData['gender']);
				$birthday=mysql_real_escape_string($userData['birthday']);
				$picture=mysql_real_escape_string($userData['picture']);
				$provider_id =mysql_real_escape_string($userData['id']);
		
         }
		//Microsoft Live Data
	    if($loginProvider == 'microsoft')
		{
			
			    $name =$userData->name;
			    $first_name =$userData->first_name;
			    $last_name =$userData->last_name;
			    $provider_id =$userData->id;
			    $gender=$userData->gender;
			    $email=$userData->emails->account;
			    $email2=$userData->emails->preferred;
			    $birthday=$userData->birth_day.'-'.$userData->birth_month.'-'.$userData->birth_year;
	
			
		}
		
		//Linkedin Data
	    if($loginProvider == 'linkedin')
		{
			
			 $email= mysql_real_escape_string($userData['email-address']);
			 $provider_id= mysql_real_escape_string($userData['id']);
			 $first_name= mysql_real_escape_string($userData['first-name']);
			 $last_name= mysql_real_escape_string($userData['last-name']);
		     $name =$first_name.' '.$last_name;
		}

mysql_query("INSERT INTO users (email, name, first_name, last_name, gender, birthday, location, hometown, bio, relationship, timezone, provider, provider_id,picture) VALUES ('$email','$name','$first_name','$last_name','$gender','$birthday','$location','$hometown','$bio','$relationship','$timezone','$loginProvider','$provider_id','$picture')");	
       
		$success_query = mysql_query("SELECT id FROM `users` WHERE email = '$email'") or die(mysql_error());
		$success_row= mysql_fetch_array($success_query);
        $id=$success_row['id'];
        
		return $id;

    }
    else
	{ 
			$row= mysql_fetch_array($query);
	        $provider=$row['provider'];
	 		$id=$row['id'];
	        // Migrating user data with Facebook Data
	        if(($provider == 'google' || $provider == 'microsoft' || $provider == 'linkedin') && ($loginProvider == 'facebook'))
	        {
		     	 
					$gender=mysql_real_escape_string($userData['gender']);
					$birthday=mysql_real_escape_string($userData['birthday']);
					$location=mysql_real_escape_string($userData['location']['name']);
					$hometown=mysql_real_escape_string($userData['hometown']['name']);
					$bio=mysql_real_escape_string($userData['bio']);
					$relationship=mysql_real_escape_string($userData['relationship_status']);
					$timezone=mysql_real_escape_string($userData['timezone']);
					$provider_id=mysql_real_escape_string($userData['id']);
					$picture='https://graph.facebook.com/'.$provider_id.'/picture';
			
mysql_query("UPDATE users SET gender='$gender',location = '$location',hometown = '$hometown',bio='$bio',relationship='$relationship',timezone='$timezone',
	provider='$loginProvider',provider_id='$provider_id',picture='$picture' WHERE id = '$id';");
		
		       	return $id;
			}
			else
			{
				
				return $id;
			}

	}

}    

}

?>
