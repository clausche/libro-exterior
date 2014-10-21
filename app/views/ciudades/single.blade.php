@foreach($tricks as $trick)
            
        @endforeach
@foreach ($trick->allCategories as $category)
            
        @endforeach
@section('title', $category->name)
@section('description', $ciudad->pageDescription)

@section('scripts')
    <script src="{{ url('js/vendor/highlight.pack.js')}}"></script>
    <script type="text/javascript">
    (function($) {
        hljs.tabReplace = '  ';
        hljs.initHighlightingOnLoad();
        $('[data-toggle=tooltip]').tooltip();
    })(jQuery);
    </script>
    @if(Auth::check())
   
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="content-box">
                    @if(Auth::check() && (Auth::user()->id == $ciudad->user_id))
                        <div class="text-right">
                            <a data-toggle="modal" href="#deleteModal">Delete</a> |
                            <a href="{{$trick->editLink}}">Editar</a>
                            @include('tricks.delete',['link'=>$ciudad->deleteLink])
                        </div>
                    @endif
                    <div class="trick-user">
                        
                        <div class="trick-user-data">
                            <h1 class="page-title">
                                {{ $category->name }} en {{ $ciudad->name }}
                            </h1>
                            @foreach ($trick as $trick)
                                {{-- expr --}}
                            @endforeach
                            {{ $trick->title }}
                        </div>
                    </div>
                    <p>{{{ $ciudad->countrycode }}}</p>
                    
                    {{ $category->name }}
                </div>
                
            </div>
                <div class="col-lg-3 col-md-4">
                    <div class="content-box">
                        <b>Stats</b>
                        <ul class="list-group trick-stats">
                            
                            <li class="list-group-item">
                                <span class="fa fa-eye"></span> Población : {{ number_format($ciudad->population) }}
                            </li>
                            <li class="list-group-item" >
                                <span class="fa fa-eye"></span> Distrito : {{ $ciudad->district }}
                                
                            </li>
                            <li class="list-group-item" >
                            @foreach ($trick->tags as $tag)
                                
                            @endforeach
                                <span class="fa fa-eye"></span> País : {{ $tag->name }}
                                
                            </li>
                        </ul>
                       @if(count($trick->allCategories))
                            <b>Categorias</b>
                            <ul class="nav nav-list push-down">
                                @foreach($trick->allCategories as $category)
                                    <li>
                                        <a href="{{ route('tricks.browse.category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(count($trick->tags))
                            <b>País-(Tags)</b>
                            <ul class="nav nav-list push-down">
                                @foreach($trick->tags as $tag)
                                    <li>
                                        <a href="{{ route('tricks.browse.tag', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <div class="clearfix">
                           
                        </div>
                    </div>
                </div>
            </div>
                

    </div>
@stop
