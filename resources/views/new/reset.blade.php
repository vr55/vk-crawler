@extends( 'new.layouts.general' )

@section( 'content' )
    @include( 'new.elements.nav' )


    <header id="head" class="secondary"></header>

    <!-- container -->
    <div class="container">

        <div class="row" style="margin-top: 30px">

            <!-- Article main content -->
            <article class="col-xs-12 maincontent">
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="thin text-center">Придумайте новый пароль</h3>
                            <hr>
                            @include ( 'new.elements.error' )

                            {{ Form::open(['url' => route('reset')]) }}
                            <div class="row top-margin">
                                <div class="col-sm-6">
                                    <label>Пароль <span class="text-danger">*</span></label>
                                    {{ Form::password( 'uPassword', ['placeholder' => 'пароль', 'class' => 'form-control'] ) }}
                                </div>
                                <div class="col-sm-6">
                                    <label>Повторить пароль <span class="text-danger">*</span></label>
                                    {{ Form::password( 'uPasswordConfirm', ['placeholder' => 'еще раз пароль', 'class' => 'form-control'] ) }}
                                </div>
                            </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4 text-right">
                                        {{ Form::hidden( 'user_id', $user_id ) }}
                                        {{ Form::hidden( 'code', $code ) }}
                                        {{ Form::submit( 'Продолжить', ['class' => 'btn btn-action'] ) }}
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>

                </div>

            </article>
            <!-- /Article -->

        </div>
    </div>	<!-- /container -->



    @include( 'new.elements.footer' )
@endsection
