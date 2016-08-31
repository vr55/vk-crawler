@if ( session()->has('msg') )
    <div class="alert alert-danger" role="alert">
      <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
     {{ session('msg') }}
    </div>
@endif

@if ( count( $errors ) > 0 )
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ( $errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
