
<?php if (isset($settings->ads728x90) && $settings->ads728x90 != ""){
	echo "<div class='ads728x90'>" . $settings->ads728x90 ."</div>";
}
	else {?>
		<div class="ads728x90">
			<img src="{{ config('view.rootpath') }}/img/ads728x90.png">
		</div>
<?php } ?>
