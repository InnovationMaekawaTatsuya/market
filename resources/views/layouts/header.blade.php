@auth
    <ul class="header_nav flex row">
        <div class="col-md-4">
            <a href="/">Market</a>
        </div>
        <li class="col-md-4">
            <p>こんにちは、{{ Auth::user()->name }}さん！</p>
        </li>
        <li class="col-md-4">
            <a href="{{ route('users.show', Auth::user()->id) }}">プロフィール</a>
        </li>
        <li class="col-md-4">
            <a href="{{ route('likes.index', Auth::user()->id) }}">お気に入り一覧</a>
        </li>
        <li class="col-md-4">
            <a href="{{ route('items.index') }}">商品一覧</a>
        </li>
        <li class="col-md-4">
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <input type="submit" value="ログアウト">
            </form>
        </li>
    </ul>
@endauth

@guest
    <ul class="header_nav flex">
        <li>
            <a href="{{ route('register') }}">サインアップ</a>
        </li>
        <li>
            <a href="{{ route('login') }}">ログイン</a>
        </li>
    </ul>
@endguest
