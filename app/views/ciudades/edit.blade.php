@section('title', trans('tricks.trick'))

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('js/selectize/css/selectize.bootstrap3.css') }}">
@stop

@section('scripts')
	<script type="text/javascript" src="{{url('js/selectize/js/standalone/selectize.min.js')}}"></script>
	<script src="{{ asset('js/ace.js') }} "></script>
	<script type="text/javascript" src="{{ asset('js/trick-new-edit.min.js') }}"></script>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
				<div class="content-box">
				@foreach ($trick as $trick)
					{{--  --}}
				@endforeach
					
				 
					@if(Auth::check() && (Auth::user()->id == $trick->user_id))
						<div class="pull-right">
							<a data-toggle="modal" href="#deleteModal">{{ trans('tricks.delete') }}</a>
							@include('tricks.delete',['link'=>$trick->deleteLink])
						</div>
					@endif
					<h1 class="page-title">
						{{ trans('tricks.editing_tag') }}
					</h1>
					@if(Session::get('errors'))
					    <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ trans('tricks.errors_while_editing') }}</h5>
					         @foreach($errors->all('<li>:message</li>') as $message)
					            {{$message}}
					         @endforeach
					    </div>
					@endif

					@if(Session::has('success'))
					    <div class="alert alert-success alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ Session::get('success') }}</h5>
					    </div>
					@endif
					
					{{ Form::open(array('class'=>'form-vertical','id'=>'save-trick-form','role'=>'form'))}}
					    
					    
					        
					        <div class="form-group">
					    	<label for="name">Nombre Ciudad</label>
					    	{{Form::text('name', $ciudad->name, array('class'=>'form-control','placeholder'=>trans('tags.title_placeholder')));}}
					    	</div>
					    	<div class="form-group">
					    	<label for="slug">Nombre indicativo</label>
					    	{{Form::text('slug', $ciudad->slug, array('class'=>'form-control','placeholder'=>'Nombre del país unido por un guion -' ));}}
					    	</div>
					    
					    	<!-- <div class="form-group">
					    	<label for="spanish_name">Nombre del País en Español</label>
					    	{{--Form::text('spanish_name', $tag->spanish_name, array('class'=>'form-control','placeholder'=>'Nombre del país en Español' ));--}}
					    	</div>
					   	 	<div class="form-group">
					    	<label for="iso2">Nombre ISo2 del País</label>
					    	{{--Form::text('iso2', $tag->iso2, array('class'=>'form-control','placeholder'=>'Nombre ISO2 del país' ));--}}
					    	</div> -->
					    	<div class="text-right">
					          <button type="submit"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
					            {{ trans('tricks.update_tag') }}
					          </button>
					        </div>
					    </div>
					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>
@stop
