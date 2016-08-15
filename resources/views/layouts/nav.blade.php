<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href={{ route( 'home' ) }}><img style="display: inline; margin-top: -6px" src="http://www.monochromatic.ru/mc_logo32.png" alt="monochromatic logo" />
         <span> VK&nbsp;Crawler <span style="font-size: 10px">v0.2.0b-multiuser
        </span>
    </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav navbar-right">
        @if( Sentinel::check() )
            <li><a href={{ route( 'logout' ) }}><span class="glyphicon glyphicon-log-out"></span> Выход</a></li>
        @else
            <li><a href={{ route( 'register' ) }}><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
            <li><a href={{ route( 'login' ) }}><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>
