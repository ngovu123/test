@extends('layouts.content')
@section('title')
	The terms and rules
@stop
@section('content')
	<div class="content contentAbout">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 cntabout">
					<h1>The terms and rules</h1>
					<?= html_entity_decode($abouts->contentabout) ?>
				</div>
			</div>
		</div>
	</div>
@stop