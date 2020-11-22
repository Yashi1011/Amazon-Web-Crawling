<?php

function getHTMLcode($url) {
	
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 10.10; labnol;) ctrlq.org");
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($curl);
	curl_close($curl);
	
	return $html;		
}

function amazon($search){

    $url="https://www.amazon.in/s?k=$search";

    $html= getHTMLcode($url);

    $html = trim(preg_replace('/\s+/', ' ', $html));

    $title = '/a-color-base a-text-normal" dir="auto">(?P<val>[^>]*)<\/span>/';
    preg_match_all($title,$html,$value);

    $image = '/img src="(?P<img>[^>]*)" class="s-image"/';
    preg_match_all($image,$html,$data);

    $price ='/<span class="a-offscreen">(?P<price>[^>]*)<\/span>/';
    preg_match_all($price,$html,$cost);

    return Array(@$value[val],@$data[img],@$cost[price]);

}

?>

 
