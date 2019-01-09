<?php

function sendslack($userid,$description,$title) {
require('connect.php');
//API Url
$url = 'https://hooks.slack.com/services/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';
//Initiate cURL.
$ch = curl_init($url);
$req=$db->prepare("SELECT login FROM tusers WHERE id=:id");
$req->execute(array('id' => $userid));
$row=$req->fetch();
$req->closeCursor();

$contentslack = $row["login"];
$contentslack .= "<br/> Description : ";
$contentslack .=$description;
$contentslack .= "<br/> Titre : ";
$contentslack .=$title;


//The JSON data.
$jsonData = array(
'text' => $contentslack
);


//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
$result = curl_exec($ch);

}

 ?>
