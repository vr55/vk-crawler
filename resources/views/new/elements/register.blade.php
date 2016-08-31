<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

    <div class="row" style="margin-top: 30px">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Регистрация</h3>
                        <p class="text-center text-muted">
                            Для полноценного доступа к ресурсу необходимо пройти процесс регистрации. Если вы уже зарегистрированы, перейдите на <a href="signin.html">страницу</a> ввода логина и пароля
                        <hr>
                        @include ( 'new.elements.error' )
                        {{ Form::open( [ 'url' => route('register')]) }}

                            <div class="top-margin">
                                <label>Email <span class="text-danger">*</span></label>
                                {{ Form::text( 'uName', '', ['placeholder' => 'email', 'class' => 'form-control'] ) }}
                            </div>

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

                            <div class="top-margin">
                                <label>Код приглашения <span class="text-danger">*</span></label>
                                {{ Form::text( 'uInviteCode', '', ['placeholder' => 'код', 'class' => 'form-control'] ) }}
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-lg-7">
                                    <label class="checkbox">

                                        <input type="checkbox" name="uAgreement">
                                        Я принимаю <a href="page_terms.html">условия использования</a>
                                    </label>
                                </div>
                                <div class="col-lg-5 text-right">
                                    {{ Form::submit( 'Регистрация', ['class' => 'btn btn-action']) }}
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
