
    <header>
        <div class="logo">
            <a href="/">
                <img src="{{ url("images/logo.svg") }}" alt="logo">
            </a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="/apie-pamokas">
                        Apie pamokas
                        <div class="dropdown">
                            <ul>
                                <li>
                                    <a href="/pavasario-kursas">Pavasario kursas</a>
                                </li>
                                <li>
                                    <a href="/kaina">Kaina</a>
                                </li>
                            </ul>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/susitikimai">
                        Susitikimai
                    </a>
                </li>
                <li>
                    <a href="/nemokama-pamoka">
                        Nemokama pamoka
                    </a>
                </li>
                <li>
                    <a href="/komanda">
                        Komanda
                    </a>
                </li>
                <li>
                    <a href="/kontaktai">
                        Kontaktai
                    </a>
                </li>
                <li>
                    @if(Auth::check())
                        <a href="/dashboard">
                            Valdymas
                        </a>
                    @else
                        <a href="/login">
                            Prisijungti
                        </a>
                    @endif
                </li>
            </ul>
        </nav>
        <div class="clear"></div>
    </header>



