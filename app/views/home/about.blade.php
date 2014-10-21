@section('title', trans('home.about_tricks_website'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1 class="text-center">{{ trans('home.about_title') }}</h1>
			<div class="row">
				<div class="col-md-6">
					{{ trans('home.about_what_is_this') }}
				</div>

				<div class="col-md-6">
					{{ trans('home.about_who') }}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>{{ trans('home.share_title') }}</h2>
					
				</div>
			</div>
		</div>
	</div>
</div>
@stop



