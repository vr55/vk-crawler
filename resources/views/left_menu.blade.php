@if( Sentinel::check() )
  <ul class="ca-menu">
    <div style="text-align: center; font-size: 22px; padding-bottom: 15px">Меню</div>
    <li>
      <a href={{ route( 'home' ) }}>
        <div class="ca-content">
          <div class="ca-main">Главная</div>
          <div class="ca-sub">Personalized to your needs</div>
        </div>
      </a>
    </li>
  </ul>
  <ul class="ca-menu">
    <div style="text-align: center; font-size: 22px; padding-bottom: 15px">Настройки

    </div>
    <li>
      <a href={{ route( 'settings.main' ) }}>
        <div class="ca-content">
          <div class="ca-main">Общие</div>
          <div class="ca-sub">Personalized to your needs</div>
        </div>
      </a>
    </li>

    <li>
      <a href={{ route( 'settings.comunities' )}}>
        <div class="ca-content">
          <div class="ca-main">Сообщества</div>
          <div class="ca-sub">Добавьте сообщества, в которых необходимо производить поиск</div>
        </div>
      </a>
    </li>

    <li>
      <a href={{ route( 'settings.keywords' ) }}>
        <div class="ca-content">
          <div class="ca-main">Ключевые слова</div>
          <div class="ca-sub">Добавьте ключевые слова для поиска на стене сообществ</div>
        </div>
      </a>
    </li>
    <li>
      <a href={{ route( 'settings.invites' ) }}>
        <div class="ca-content">
          <div class="ca-main">Коды приглашения</div>
          <div class="ca-sub">Personalized to your needs</div>
        </div>
      </a>
    </li>
  </ul>
@endif
