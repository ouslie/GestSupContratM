<?php
function WebserviceFacture($useridfacture,$designation,$tarif,$token,$quantity,$url){
    $data = array (
        'token' => $token,
        'useridfacture' => $useridfacture,
        'designation' => $designation,
        'tarif' => $tarif,
        'quantity' => $quantity,
        );
        
        $params = '';
    foreach($data as $key=>$value)
                $params .= $key.'='.$value.'&';
         
        $params = trim($params, '&');

    $ch = curl_init();
    $url .="webservice.php";
    curl_setopt($ch, CURLOPT_URL, $url); //Remote Location URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt($ch, CURLOPT_HEADER, 0);

        
    //We add these 2 lines to create POST request
    curl_setopt($ch, CURLOPT_POST, count($data)); //number of parameters sent
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //parameters data
    
    $result = curl_exec($ch);
    curl_close($ch);
    return    $result;
    }
?>