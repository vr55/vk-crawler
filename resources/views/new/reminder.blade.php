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
                            <h3 class="thin text-center">Восстановление пароля</h3>
                            <p class="text-center text-muted">
                            Введите Email, указанный при регистрации </p>
                            <hr>
                            @include ( 'new.elements.error' )
                            {{ Form::open(['url' => route('reminder')]) }}
                                <div class="top-margin">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input name="uEmail" value="{{ old( 'uEmail' ) }}" type="text" class="form-control">
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4 text-right">
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
