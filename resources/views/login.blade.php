@extends( 'layouts.general' )

@section('title')
Вход
@endsection

@section('aside')
<div class="row">
<div class="col-md-12">
    <legend>Вход</legend>
        {{ Form::open() }}
        <div class="form-login">
        <input type="text" name="uName" value="{{ old( 'uName' ) }}" class="form-control input-sm chat-input" placeholder="e-mail" />
        </br>
        <input type="password" name="uPassword" value="{{ old('uPassword') }}" class="form-control input-sm chat-input" placeholder="пароль" />
        </br>
        <div class="wrapper">
        <span class="group-btn">
            {{ Form::submit( 'Войти', ['class' => 'btn btn-primary btn-md'] ) }}
        </span>
        </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('content')



@endsection
