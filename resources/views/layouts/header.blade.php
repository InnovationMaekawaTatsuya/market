@auth
    <ul class="header_nav">
        <div>
            <a href="/">Market</a>
        </div>
        <li>
            <p>こんにちは、{{ Auth::user()->name }}さん！</p>
        </li>
        <li>
            <a href="{{ route('users.show', Auth::user()->id) }}">プロフィール</a>
        </li>
        <li>
            <a href="{{ route('likes.index', Auth::user()->id) }}">お気に入り一覧</a>
        </li>
        <li>
            <a href="{{ route('items.index') }}">商品一覧</a>
        </li>
        <li>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <input type="submit" value="ログアウト">
            </form>
        </li>
    </ul>
@endauth

@guest
    <ul class="header_nav">
        <li>
            <a href="{{ route('register') }}">サインアップ</a>
        </li>
        <li>
            <a href="{{ route('login') }}">ログイン</a>
        </li>
    </ul>
@endguest
