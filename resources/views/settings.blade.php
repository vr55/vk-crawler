@extends( 'layouts.general' )

@section('title')
Настройки
@endsection

@section('aside')
@endsection

@section('content')
{{ Form::model( $settings ) }}
    <div class="table-responsive">
      <table class="table table-responsive">
        <tbody>
            <tr>
                <td colspan="2">
                    <h2>Связь с администратором</h2>
                </td>
            </tr>
            <tr>
              <td>
                {{ Form::label( 'Отправлять на электронную почту?' ) }}
                <div style="font-size:10px; color: #777777; width:250px">включить отправку информации на электронную почту</div>
              </td>
              <td>
                {!! Form::hidden('send_email', 0) !!}
                {{ Form::checkbox( 'send_email' ) }}
              </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label( 'email администратора' ) }} <span style="font-size: 10px; font-weight: 300"><a href="#">проверить</a></span>
                    <div style="font-size:10px; color: #777777; width:250px">на этот email будет отправляться вся информация</div>
                </td>
                <td>
                    {{ Form::text( 'admin_email', null ) }}
                </td>
            </tr>

            <tr>
              <td>
                {{ Form::label( 'Отправлять на xmpp/jabber?' ) }}
                <div style="font-size:10px; color: #777777; width:250px">включить отправку информации на xmpp/jabber месенджер</div>
              </td>
              <td>
                {!! Form::hidden('send_xmpp', 0) !!}
                {!! Form::checkbox( 'send_xmpp', null ) !!}
              </td>
            </tr>

            <tr>
                <td>
                    {{ Form::label( 'xmpp идентификатор администратора' ) }} <span style="font-size: 10px; font-weight: 300"><a href={{ route( 'xmpp' ) }}>проверить</a></span>
                    <div style="font-size:10px; color: #777777; width:250px">xmpp адрес администратора, на который отправляется информация о новых сообщениях.
                        Зарегистрировать можно на <a target="_blank" href="http://www.jabber.ru">http://www.jabber.ru</a>
                    </div>

                </td>

                <td>
                    <div>{{ Form::text( 'xmpp', null, ['placeholder' => 'myname@jabber.ru'] ) }}</div>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <h2>Параметры сканирования</h2>
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label( 'Глубина сканирования' ) }}
                    <div style="font-size:10px; color: #777777; width:250px">количество последних записей из каждого сообщества, которые будут сканироваться</div>
                </td>
                <td>
                    {{ Form::selectRange( 'scan_depth', 1, 50 ) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label( 'Частота сканирования' ) }}
                    <div style="font-size:10px; color: #777777; width:250px">Как часто будет производиться сканирование</div>
                </td>
                <td>
                    {{ Form::select( 'scan_freq', [ '1' => '5 мин', '2' => '15 мин', '3' => '1 час', '4' => '24 часа'] ) }}
                </td>
            </tr>

        </tbody>
      </table>

    </div>

         {{ Form::submit( 'Сохранить', ['class' =>'btn btn-primary', 'style' => 'margin-top: 10px; margin-bottom: 10px'] ) }}
{{ Form::close() }}
@endsection
