<header class="header">
    <div class="header-inner">
        <div class="header-utilities">
            <div class="logo">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="ロゴ">
            </div>

            <nav>
                <ul class="header-nav">
                    @if(Auth::check())
                    <li class="header-nav__item">
                        <a class="header-nav__link" href="/attendance">勤怠</a>
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__link" href="/attendance/list">勤怠一覧</a>
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__link" href="/stamp_correction_request/list">申請</a>
                    </li>

                    <li class="header-nav__item">
                        <form class="form" action="/logout" method="post">
                            @csrf
                            <button class="header-nav__button">ログアウト</button>
                        </form>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>

        




