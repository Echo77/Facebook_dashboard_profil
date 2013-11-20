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
else if($action=="top")
{
		$my_access_token=$facebook->getAccessToken();
try {

//		$statut = $facebook->api('/me?fields=feed.fields(likes.limit(9999).fields(id,name))',array('access_token'=>$my_access_token));

		$statut = $facebook->api('/me?fields=id,name,feed.fields(id,name,likes.fields(id,name))',array('access_token'=>$my_access_token));
		} catch (FacebookApiException $e) {

		error_log($e);
		}
/*	print_r($statut);
    $paging = $statut["feed"]["paging"];
    $next = $paging["next"];
echo "FIN 1ER";
	echo $next;
    // Extract limit and until parameter for next request
    $query = parse_url($next, PHP_URL_QUERY);
    parse_str($query, $par);
	
	//$statut = $facebook->api('/me?fields=feed.fields(likes.fields(id,name))&limit='.$par['limit'].'&until='.$par['until'].'',array('access_token'=>$my_access_token));
	$hello = $facebook->api('/me?fields=feed.fields(likes.fields(id,name))&limit='.$par['limit'].'&until='.$par['until'],array('access_token'=>$my_access_token));
	echo "\nnew : ";
	print_r($hello);
	//   	$all_statut = array_merge($all_statut, $statut["feed"]);
// 	print_r($all_statut);
//$all_statut = array();


/*
// While there is still data in response
while (in_array("paging", $statut["feed"]))
{
    // Merge all home objects into one array
    $all_statut = array_merge($all_statut, $statut["feed"]["data"] );

    // Retrieve paging value
    $paging = $statut["feed"]["paging"];
    $next = $paging["next"];

    // Extract limit and until parameter for next request
    $query = parse_url($next, PHP_URL_QUERY);
    parse_str($query, $par);

    $statut = $facebook->api(
            "/me", 'GET', array(
            'limit' => $par['limit'],
            'until'  => $par['until'],
            'field' => $par['field'] ));
     print_r($statut);
}*/
//print_r($all_statut);
	foreach($statut as $li)
	{
		foreach($li as $li2)
		{
			foreach($li2 as $li3)
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
		}
	}

		$likes= array_count_values($like);
		asort($likes);
		$likes_reverse = array_reverse($likes);
	foreach($likes_reverse as $key => $value)
		{
			$stat_likes[]=array('name'=>$key, 'data' =>array((int)$value));
		}
		echo json_encode($stat_likes);

}
?>
