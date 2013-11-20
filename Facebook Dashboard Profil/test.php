[{"name":"FR","data":[26]},{"name":"XX","data":[25]},{"name":"US","data":[2]},{"name":"BR","data":[2]}]
[{"name":"Florian Quattrocchi","data":4},{"name":"Leslie Frapin","data":12},{"name":"Ga\u00ebtan LMv","data":1},{"name":"Blezvenn Le Guyader","data":2}

<?php 
$page_size=50;
$i=0;
$followers = array();
// gets all the followers users
do //to get all the pages of results
{
$nextF = json_decode($client->get('me/followers.json', array('order' => 'username', 'limit' => $page_size, 'offset' => $i*$page_size)));
$followers = array_merge($followers, $nextF);
$i++;
}while(count($nextF)==50);
?>

