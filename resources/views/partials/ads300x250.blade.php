<?php if (isset($settings->ads300x250) && trim($settings->ads300x250) != ""){
	echo "<div class='ads300x250'>" . $settings->ads300x250 ."</div>";
} 
	else {?>
		<div class='ads300x250'>
			<img src="{{ config('view.rootpath') }}/img/ads300x250.png" width="360">
		</div>

<?php } ?>