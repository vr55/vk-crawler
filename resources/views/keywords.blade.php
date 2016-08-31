@extends( 'layouts.general' )

@section('title')
Управление ключевыми словами
@endsection

@section('aside')
@endsection

@section('content')
  <div style="padding-left: 15px; padding-top: 15px; padding-bottom: 35px">
    {{ Form::open() }}
      <div class="input-group" style = "width: 100%">
        {{ Form::label('Добавить ключевое слово') }}
        <div>{{ Form::text( 'keyword', '', ['placeholder' => 'ex. видео', 'style' => 'width: 100%'] ) }}</div>
      </div>
      {{ Form::submit( 'Добавить', ['class' =>'btn btn-primary', 'style' => 'margin-top: 10px; margin-bottom: 10px; width: 200px' ] ) }}
    {{ Form::close() }}
  </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
            <th>
              #
            </th>
            <th>
              ключ
            </th>
            <th>
              эффективность
            </th>
            <th>
                действие
            </th>
        </thead>
        <tbody>
          <?php $i = 0 ?>
          @foreach( $keywords as $word )
            <tr>
              <td>
                {{ $i }}
              </td>
              <td>
                {{ $word->keyword }}
              </td>
              <td>
                <span class="badge">{{ $word->efficiency }}</span>
              </td>
              <td>
                <a href={{ route( 'keyword.delete', $word->id ) }} class="btn btn-danger btn-xs">удалить</a>
              </td>
            </tr>
            <?php $i++ ?>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="row">
        <div class="col-md-12">
             {!! $keywords->links() !!}
        </div>

    </div>
@endsection
