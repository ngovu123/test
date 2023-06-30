@extends('layouts.content')
@section('title')
	About page
@stop
@section('content')
	<div class="content contentAbout">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 cntabout">
					<h1>About</h1>
					<?= html_entity_decode($abouts->contentabout) ?>
				</div>
			</div>
		</div>
	</div>
@stop