<?php


class OauthLogin {
	
	public function userDetails($user_session) 
	{
		$row_id=($user_session);
		$query = mysql_query("SELECT * FROM users WHERE id = '$row_id'") or die(mysql_error());
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
	$email=($userData['email']);
    }
    else if($loginProvider == 'microsoft' )
	{
	$email=($userData->emails->account);
    }
	else if($loginProvider == 'linkedin' )
	{
	$email= ($userData['email-address']);
    }


//	print_r($userData);
//die;
	
	$query = mysql_query("SELECT id,provider FROM users WHERE email = '$email'") or die(mysql_error());

	if(mysql_num_rows($query) == 0)
	{
		

        //Facebook Data
		if($loginProvider == 'facebook')
		{	
	            $name=($userData['name']);
				$first_name=($userData['first_name']);
				$last_name=($userData['last_name']);
				$email=($userData['email']);
				$gender=($userData['gender']);
				$birthday=($userData['birthday']);
				$location=($userData['location']['name']);
				$hometown=($userData['hometown']['name']);
				$bio=($userData['bio']);
				$relationship=($userData['relationship_status']);
				$timezone=($userData['timezone']);
				$provider_id=($userData['id']);
				$picture='https://graph.facebook.com/'.$provider_id.'/picture/';
				
		}
		//Google Data
	    if($loginProvider == 'google')
		{
	
				$email =($userData['email']);
			    $name =($userData['name']);
				$first_name=($userData['given_name']);
				$last_name=($userData['family_name']);
				$gender=($userData['gender']);
				$birthday=($userData['birthday']);
				$picture=($userData['picture']);
				$provider_id =($userData['id']);
		
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
			
			 $email= ($userData['email-address']);
			 $provider_id= ($userData['id']);
			 $first_name= ($userData['first-name']);
			 $last_name= ($userData['last-name']);
		     $name =$first_name.' '.$last_name;
		}




		if(mysql_query("INSERT INTO users (email, name, first_name, last_name, gender, birthday, location, hometown, bio, relationship, timezone, provider, provider_id,picture) VALUES ('$email','$name','$first_name','$last_name','$gender','$birthday','$location','$hometown','$bio','$relationship','$timezone','$loginProvider','$provider_id','$picture')"))
		{
       

		

//*** end of email

	}
		$success_query = mysql_query("SELECT id FROM users WHERE email = '$email'") or die(mysql_error());
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
		     	 
					$gender=($userData['gender']);
					$birthday=($userData['birthday']);
					$location=($userData['location']['name']);
					$hometown=($userData['hometown']['name']);
					$bio=($userData['bio']);
					$relationship=($userData['relationship_status']);
					$timezone=($userData['timezone']);
					$provider_id=($userData['id']);
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
