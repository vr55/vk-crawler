@extends( 'layouts.general' )

@section('title')
Список сообществ вконтакте
@endsection

@section('aside')
@endsection

@section('content')
  <div style="padding-left: 15px; padding-top: 15px; padding-bottom: 35px">
    {{ Form::open() }}
      <div class="input-group"  style="width: 100%">
        {{ Form::label('Добавить ссылку на сообщество') }}
        <div>{{ Form::text( 'url', '', ['placeholder' => 'https://vk.com/itcookies', 'style' => 'width: 100%'] ) }}</div>
      </div>
      {{ Form::submit( 'Добавить', ['class' =>'btn btn-primary', 'style' => 'margin-top: 10px; margin-bottom: 10px; width: 200px'] ) }}
    {{ Form::close() }}
  </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
            <th>
                #
            </th>
            <th>
                url
            </th>
            <th>
                эффективность
            </th>
            <th>
                действие
            </th>
        </thead>
        <tbody>
          <?php $i = 0; ?>
            @foreach( $comunities as $comunity )
                <tr>
                  <td>
                    {{ $i }}
                  </td>
                  <td>
                    <div>{{ $comunity->name }}</div>
                    <a style="font-size: 11px" href="{{ $comunity->url }}">{{ $comunity->url }}</a>
                  </td>
                  <td>
                    <span class="badge">{{ $comunity->efficiency }}</span>
                  </td>
                  <td>
                    <a href={{ route( 'comunity.delete', $comunity->id ) }} class="btn btn-danger btn-xs">удалить</a>
                  </td>
                </tr>
                <?php $i++ ?>
            @endforeach
        </tbody>
      </table>
    </div>

    <div class="row">
        <div class="col-md-12">
             {!! $comunities->links() !!}
        </div>
    </div>
@endsection
