	<!-- <section class="section media">
		<div class="container">
			<div class="row">
			<div class="tabs_container">
			<ul class="tabs">
					<li class="active">Фотогалерея</li>
					<li>Видеогалерея</li>
				</ul>
				<ul class="tab__content">
					<li class="active">
						<div class="content__wrapper">
						Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Безопасную ему продолжил заманивший на берегу текстами путь приставка по всей океана. Прямо великий даже рукописи безорфографичный, пор путь семь собрал все.
						Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Безопасную ему продолжил заманивший на берегу текстами путь приставка по всей океана. Прямо великий даже рукописи безорфографичный, пор путь семь собрал все.
						Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Безопасную ему продолжил заманивший на берегу текстами путь приставка по всей океана. Прямо великий даже рукописи безорфографичный, пор путь семь собрал все.

						</div>
					</li>
					<li>
						<div class="content__wrapper">
						<?
						function youtubeVideo(){
							$api_key = 'AIzaSyAY9B2Z33ZwbGw3sO8_2_Sd2hbZwiXfqF8';
							$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&order=date&maxResults=5&playlistId=PLCouz0yJGoZSY4wckQlHdMhnS8b6ZQYRO&key=". $api_key;
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							$output = curl_exec($ch);
							$json = json_decode($output, true); 
							$arRes = array();
							foreach($json["items"] as $key => $value){
								$arRes[] = array(
									'currentTime' => date("d.m.Y"),
									'videoId'	=> $value["snippet"]["resourceId"]["videoId"],
									'videoTitle'	=> $value["snippet"]["title"],
									'videoDesc'	=> $value["snippet"]["description"],
									'videoImg'	=> $value["snippet"]["thumbnails"]["medium"]
								);
							}
							curl_close($ch);
							return $arRes;
						}
						function Youtube(){
							$file			= $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/app/api/youtube.json';	
							$youtube 	= json_decode(file_get_contents($file),TRUE);	
							if(count($youtube) == 0 or date("d.m.Y") != $youtube[0]['currentTime']){
								file_put_contents($file,json_encode(youtubeVideo()));
							}
							if(count($youtube) > 0){
								foreach($youtube as $key => $value){
									echo ('<div class="you_item" data-toggle="tooltip" data-placement="bottom" title="">
														<img class="you_icon" src="'.$value['videoImg']['url'].'">
												</div>');
								}
							}
						}
						Youtube();
						?>
						</div>
					</li>
				</ul>
			
				</div>
			</div>
		</div>
	</section> -->