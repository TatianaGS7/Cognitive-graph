<?php

if (isset($_POST["saved"])) {
	$saved = json_decode($_POST["saved"]);
	$cd = $saved->cd; 
	
	$nodes = array($saved->nodes[0]);
	for ($i=1; $i<count($saved->nodes); $i++){
		$nodes[] = $saved->nodes[$i];
	}
	for ($i=0; $i<count($saved->links); $i++){
		$links[] = array('source'=>$saved->links[$i]->source,'target'=>$saved->links[$i]->target,'Val'=>$saved->links[$i]->Val); 
	}
	$domain = "domain_".$cd.".pl";
	
	$array = explode("\r\n", file_get_contents($domain));
	
	$fp = fopen($domain, "r+") or die("can't open file");
	ftruncate($fp, 0);
	fclose($fp);

	$fh = fopen($domain, 'w') or die("can't open file");
	
	fwrite($fh, $array[0]."\r\n");
	fwrite($fh, $array[1]."\r\n");
	
	for ($i=0; $i<count($nodes); $i++){
		$stringData = "de('".$nodes[$i]."').\r\n";
		fwrite($fh, $stringData);
	}
	
	for ($i=0; $i<count($links); $i++){
		$source = $links[$i]['source'];
		$target = $links[$i]['target'];
		$Val = $links[$i]['Val'];
		$stringData = "rel('".$source."','".$target."',".$Val.").\r\n";
		fwrite($fh, $stringData);
	}
	fwrite($fh, $array[count($array)-1]);
	fclose($fh);
	
	}

?>
