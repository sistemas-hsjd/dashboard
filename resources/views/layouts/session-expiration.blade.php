@auth
    <meta name="session-lifetime" content="{{ (int) config('session.lifetime') * 60 }}">
    <meta name="session-extend-url" content="{{ route('session.extend', [], false) }}">
    <meta name="session-login-url" content="{{ route('login', [], false) }}">
    <meta name="session-logout-url" content="{{ route('logout', [], false) }}">
@endauth
