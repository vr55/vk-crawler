@extends( 'layouts.general' )

@section('title')
Главная страница
@endsection

@section('aside')
Главная страница
@endsection

@section('content')
  @if( Sentinel::check() )
    <a style="width: 95%; margin: 20px" class="btn btn-primary" href={{ route( 'update' ) }}>Ручное обновление</a>
  @endif
    <div class="row">
        <div class="col-md-12">
            {!! $posts->links() !!}
        </div>
    </div>

    @foreach( $posts as $post )
        <div class="panel panel-default">
          <div class="panel-heading">
              <a target="_blank" href="https://vk.com/wall<?php print $post->owner_id . '_' . $post->vk_id?>">{{ $post->owner_name }}</a>
              @if( date( 'd m Y', $post->date ) == date( 'd m Y' ) )
              <span class="label label-success">сегодня</span>
              @endif
              @if( $post->sent )
                <span class="label label-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;отправлено</span>
              @endif
              <div style="font-size: 12px; color: #a9a9a9">
                опубликовано: {{ date( 'd F Y' ,$post->date )}}
              </div>
          </div>
          <div style="padding-left: 15px; padding-top:5px">


          </div>

          <div class="panel-body" style="font-size: 12px; line-height: 1.8">


            <div><?php echo $post->text ?> </div>
          </div>
          <div class="panel-footer">
              <div class="row">
                  <div class="col-md-12">
                    <a href={{ route( 'post.delete', $post->id ) }} class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-sign"></span> удалить</a>
                  </div>

              </div>

          </div>
        </div>


    @endforeach()
    <div class="row">
        <div class="col-md-12">
            {!! $posts->links() !!}
        </div>
    </div>
@endsection
