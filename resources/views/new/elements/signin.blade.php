<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

    <div class="row" style="margin-top: 30px">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Войти в свой аккаунт</h3>
                        <p class="text-center text-muted">Если в еще не зарегистрированы, перейдите на <a href={{ route('signup' )}}>страницу</a> создания учетной записи. </p>
                        <hr>
                        @include ( 'new.elements.error' )

                        {{ Form::open(['url' => route('login')]) }}
                            <div class="top-margin">
                                <label>Email <span class="text-danger">*</span></label>
                                <input name="uName" value="{{ old( 'uName' ) }}" type="text" class="form-control">
                            </div>
                            <div class="top-margin">
                                <label>Пароль <span class="text-danger">*</span></label>
                                <input name="uPassword" value="{{ old('uPassword') }}" type="password" class="form-control">
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-lg-8">
                                    <b><a href={{ route( 'reminder' ) }}>Забыли пароль?</a></b>
                                </div>
                                <div class="col-lg-4 text-right">
                                    {{ Form::submit( 'Войти', ['class' => 'btn btn-action'] ) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                        <?php $oauth = new App\Http\Controllers\mcOAuth(); ?>
                          <div class="row" style="padding: 5px">
                            <div class="col-md-6" style="padding-bottom: 5px; padding-top:5px">
                                
                                <a style="padding: 6px 44px" class="btn btn-block btn-social btn-vk" href={{ $oauth->GetAuthLink( 'vkontakte' ) }}>
                                    <span class="fa fa-vk"></span>Вконтакте
                                </a> 
                            </div>
                            <div class="col-md-6" style="padding-bottom: 5px; padding-top:5px">
                                
                                <a style="padding: 6px 44px" class="btn btn-block btn-social btn-facebook" href={{ $oauth->GetAuthLink( 'facebook' ) }}>
                                    <span class="fa fa-facebook"></span>Facebook
                                </a> 
                            </div>
                          </div>
                    </div>
                    


                    
                   
                </div>

            </div>

        </article>
        <!-- /Article -->

    </div>
</div>  <!-- /container -->
