@extends( 'layouts.general' )

@section('title')
Вход
@endsection

@section('aside')
<div class="row">
<div class="col-md-12">
        {{ Form::open( [ 'url' => route('register')]) }}
        <fieldset>
            <!-- Form Name -->
            <legend>Регистрация</legend>

            <!-- Text input-->
            <div class="form-group">
              <label for="name">Email пользователя</label>
              <div>
              {{ Form::text( 'uName', '', ['placeholder' => 'email', 'class' => 'form-control input-sm chat-input'] ) }}
              </div>
            </div>

            <div class="form-group">
              <label for="name">Пароль</label>
              <div>
              {{ Form::password( 'uPassword', ['placeholder' => 'пароль', 'class' => 'form-control input-sm chat-input'] ) }}
              </div>
            </div>

            <div class="form-group">
              <label for="name">Повторить пароль</label>
              <div>
              {{ Form::password( 'uPasswordConfirm', ['placeholder' => 'еще раз пароль', 'class' => 'form-control input-sm chat-input'] ) }}
              </div>
            </div>

            <div class="form-group">
              <label for="name">Код приглашения</label>
              <div>
              {{ Form::text( 'uInvite', null, ['placeholder' => 'код приглашения', 'class' => 'form-control input-sm chat-input'] ) }}
              </div>
            </div>

            <!-- Button -->
            <div class="form-group">
              <labelfor="reg"></label>
              <div>
                  {{ Form::submit( 'Регистрация', ['class' => 'btn btn-primary']) }}
              </div>
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('content')



@endsection
