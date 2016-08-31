@extends( 'layouts.general' )

@section('title')
Коды приглашения
@endsection

@section('aside')
@endsection

@section('content')
    <div class="table-responsive">
      <table class="table table-hover" style="text-align: center">
        <thead>
          <th  style="text-align: center">
            #
          </th>
            <th  style="text-align: center">
                код
            </th>
            <th  style="text-align: center">
                id приглашенного
            </th>
            <th  style="text-align: center">
                использован код
            </th>
            <th  style="text-align: center">
                действие
            </th>
        </thead>
        <tbody>
          <?php $i = 0 ?>
            @foreach( $invites as $invite )
                <tr>
                  <td>
                    {{ $i }}
                    <?php $i++; ?>
                  </td>
                    <td>
                        {{ $invite->code }}
                    </td>
                    <td>
                        {{ $invite->invited_id }}
                    </td>
                    <td>
                      @if( $invite->used == true )
                      <span style="color:green" class="glyphicon glyphicon-ok-sign"></span>
                      @else
                        <span class="glyphicon glyphicon-minus-sign" style="color: blue"></span>
                      @endif

                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
@endsection
