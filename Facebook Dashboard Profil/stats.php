<?php

require 'connect.php'; 



$action = isset($_POST['action']) ?  $_POST['action'] : false;
if($action=="gender"){
	$my_access_token=$facebook->getAccessToken();
try {

		$friends = $facebook->api('/me?fields=friends.fields(name,gender)&limit=5000&offset=5000',array('access_token'=>$my_access_token));
		} catch (FacebookApiException $e) {

		error_log($e);
		}
   
	// print_r($friends);
	$nb_amis=count($friends["friends"]["data"]);
	$female=0;
	$male=0;
	for($i=0; $i<=$nb_amis; $i++)
	{
		if($friends["friends"]["data"][$i]["gender"]=="female")
		{
			$female++;
		}
		else if($friends["friends"]["data"][$i]["gender"]=="male"){
			$male++;
		}
	}
	$gender=array();
	$gender[]=array("Femelle", (int)$female);
	$gender[]=array("Male", (int)$male);
	
	
	
	/*$gender = array();
	$gender = array(
    "0" => array("name" => "Femelle",
						"data" => $female),
    "1" => array("name" => "Male",
						"data" => $male),
    );*/
	echo json_encode($gender);
}
else if($action=="relationship_list")
{
	$my_access_token=$facebook->getAccessToken();
try {

		$friends_relationship = $facebook->api('/me?fields=friends.fields(name,gender,relationship_status)&limit=5000&offset=5000',array('access_token'=>$my_access_token));
		} catch (FacebookApiException $e) {

		error_log($e);
		}
	//print_r($friends_relationship);
	foreach($friends_relationship as $li3)
			{
				foreach($li3 as $li4)
				{
					foreach($li4 as $relationship_name)
					{
						
							//print_r($relationship_name);
							if($relationship_name["relationship_status"]=="Single")
							{

								$relationship_list[]["name"]=$relationship_name["name"];
								$relationship_list[]["gender"]=$relationship_name["gender"];
								
							}
							
						
						}
						
					}
					
				}
			
			
	
	echo json_encode($relationship_list);
	//echo json_encode($relationship_list_male);
	
	
}
else if($action=="relationship")
{
		$my_access_token=$facebook->getAccessToken();
try {

		$friends = $facebook->api('/me?fields=friends.fields(name,gender,relationship_status)&limit=5000&offset=5000',array('access_token'=>$my_access_token));
		} catch (FacebookApiException $e) {

		error_log($e);
		}
   
// print_r($friends);
	$nb_amis=count($friends["friends"]["data"]);
	$single=0;
	$not_single=0;
	$open_relationship=0;
	$domestic_relationship=0;
	$married=0;
	$engaged=0;
	$widow=0;
	$complicated=0;
	$divorced=0;
	$separated=0;
	$civil_union=0;
	//$unknown=0;
	
	for($i=0; $i<=$nb_amis; $i++)
	{
		if($friends["friends"]["data"][$i]["relationship_status"]=="Single")
		{
			$single++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="In a relationship"){
			$not_single++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="In an open relationship"){
			$open_relationship++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="Married"){
			$married++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="Engaged"){
			$engaged++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="In a domestic partnership"){
			$domestic_relationship++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="Widowed"){
			$widow++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="It's complicated"){
			$complicated++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="Divorced"){
			$divorced++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="Separated"){
			$separated++;
		}
		else if($friends["friends"]["data"][$i]["relationship_status"]=="In a civil union"){
			$civil_union++;
		}
	/*	else {
			$unknown++;
		}*/
	}
	$relationship=array();
	$relationship[]=array("Single", (int)$single);
	$relationship[]=array("In a relationship", (int)$not_single);
	$relationship[]=array("In a open relationship", (int)$open_relationship);
	$relationship[]=array("Married", (int)$married);
	$relationship[]=array("Engaged", (int)$engaged);
	$relationship[]=array("In a domestic partnership", (int)$domestic_relationship);
	$relationship[]=array("It's complicated", (int)$widow);
	$relationship[]=array("Divorced", (int)$widow);
	$relationship[]=array("Separated", (int)$widow);
	$relationship[]=array("In a civil union", (int)$widow);
	$relationship[]=array("Widowed", (int)$widow);
//	$relationship[]=array("NC", (int)$unknown);
	
	
	
	
	/*$gender = array();
	$gender = array(
    "0" => array("name" => "Femelle",
						"data" => $female),
    "1" => array("name" => "Male",
						"data" => $male),
    );*/
	echo json_encode($relationship);
}
else if($action=="top")
{
		$my_access_token=$facebook->getAccessToken();
try {

	$statut = $facebook->api('/me?fields=feed.fields(likes.limit(9999).fields(id,name))',array('access_token'=>$my_access_token));

		//$statut = $facebook->api('/me?fields=id,name,feed.fields(id,name,likes.fields(id,name))',array('access_token'=>$my_access_token));
		} catch (FacebookApiException $e) {

		error_log($e);
		}
	//echo $my_access_token;
	//print_r($statut);
    $paging = $statut["feed"]["paging"];
    $next = $paging["next"];
	$next = $next.'&access_token='.$my_access_token;	
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $next);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
	$return = curl_exec($curl);
	curl_close($curl);
	
	$return_array = json_decode($return, true);
	//print_r($return_array);
	//$statut = $facebook->api('/me?fields=feed.fields(likes.fields(id,name))&limit='.$par['limit'].'&until='.$par['until'].'',array('access_token'=>$my_access_token));
	//$hello = $facebook->api('/me?fields=feed.fields(likes.fields(id,name))&limit=25&since=1382885787',array('access_token'=>$my_access_token));
	//print_r($statut);
	$result = array_merge($statut['feed']['data'], $return_array['data']);
	//echo "\nnew : ";
	//print_r($return_array);
// 	print_r($all_statut);
//$all_statut = array();


// While there is still data in response

while (array_key_exists("paging", $return_array))
{
  	$paging = $return_array["paging"];
    $next = $paging["next"];

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $next);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
	$return = curl_exec($curl);
	curl_close($curl);
	
	$return_array = json_decode($return, true);
	//print_r($return_array);
	$result = array_merge($result, $return_array['data']);
}
//print_r($all_statut);

			foreach($result as $li3)
			{
				foreach($li3 as $li4)
				{
					foreach($li4 as $li5)
					{
						foreach($li5 as $likes){
							$like[]=$likes["name"];
						}
						
					}
					
				}
			
			}


		$likes= array_count_values($like);
		arsort($likes);
		$likes = array_slice($likes, 0, 10);
		//$likes_reverse = array_reverse($likes);
	foreach($likes as $key => $value)
		{
			$stat_likes[]=array('name'=>$key, 'data' =>array((int)$value));
		}
		echo json_encode($stat_likes);

}
else if($action=="age_range")
{
		$my_access_token=$facebook->getAccessToken();
try {

	$age = $facebook->api('/me?fields=id,name,friends.fields(birthday)',array('access_token'=>$my_access_token));

		//$statut = $facebook->api('/me?fields=id,name,feed.fields(id,name,likes.fields(id,name))',array('access_token'=>$my_access_token));
		} catch (FacebookApiException $e) {

		error_log($e);
		}
		//print_r($age);
		$age_range_18=0;
		$age_range_18_25=0;
		$age_range_25_45=0;
		$age_range_45=0;
		
				foreach($age as $li4)
				{
					foreach($li4 as $li5)
					{
						foreach($li5 as $age_range){
							$rest = substr($age_range["birthday"], 6);
							date_default_timezone_set('UTC');
							$date= date("Y");
							
							$rest_age = intval($date) - intval($rest);
							/*echo " ";
							echo $rest_age;*/
							
							if($rest_age <18 && $rest_age!=intval($date)){
								$age_range_18++;
							}
							else if($rest_age>=18 && $rest_age <25 && $rest_age!=intval($date)){
								$age_range_18_25++;
							}
							else if($rest_age>=25 && $rest_age <45 && $rest_age!=intval($date))
							{
								$age_range_25_45++;
							}
							else if($rest_age>=45 && $rest_age!=intval($date)){
								$age_range_45++;
							}
							 
							
						}
						
					}
					
				}
			
$stat_age[]=array('name'=>"<18", 'data' =>array((int)$age_range_18));
$stat_age[]=array('name'=>"18-25", 'data' =>array((int)$age_range_18_25));
$stat_age[]=array('name'=>"25-45", 'data' =>array((int)$age_range_25_45));
$stat_age[]=array('name'=>"45", 'data' =>array((int)$age_range_45));
echo json_encode($stat_age);
}
?>


