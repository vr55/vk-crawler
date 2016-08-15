@extends( 'layouts.general' )

@section('title')
Шаблоны деловых предложений
@endsection

@section('aside')
    @if ( count( $errors ) > 0 )
        <div class="alert alert-danger">
            <ul>
                @foreach ( $errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3>Добавить шаблон</h3>
    {{ Form::open() }}
    <div class="input-group">
        {{ Form::label('Текст шаблона') }}
        {{ Form::textarea( 'proposal', '', ['placeholder' => 'Деловое предложение', 'style' => 'width: 250px'] ) }}
    </div>
    {{ Form::submit( 'Добавить', ['class' =>'btn btn-primary', 'style' => 'margin-top: 10px; margin-bottom: 10px'] ) }}
    {{Form::close() }}
@endsection

@section('content')
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
            <th>
                id
            </th>
            <th>
                текст
            </th>
            <th>
                действие
            </th>
        </thead>
        <tbody>
            @foreach( $proposals as $proposal )
                <tr>
                    <td>
                        {{ $proposal->id }}
                    </td>
                    <td>
                        <div>{{ $proposal->text }}</div>
                    </td>
                    <td>
                        <a href={{ route( 'proposal.delete', $proposal->id ) }} class="btn btn-danger btn-xs">удалить</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>

    <div class="row">
        <div class="col-md-12">
             {!! $proposals->links() !!}
        </div>
    </div>
@endsection
