<section id="Lam-main">
    <header>
        <h1>{TITLE}</h1>
    </header>
    <nav id="Lan-activity" class="cssmenu cssmenu-vertical">
        <ul>
            <li><a href="${relative_url(LamUrlBuilder::activity())}" class="cssmenu-title offload button bgc moderator"><span>{@lam.activity.desc}</span></a></li>
        </ul>
    </nav>
    <nav id="Lan-facility" class="cssmenu cssmenu-vertical">
        <ul>
            <li><a href="${relative_url(LamUrlBuilder::activity())}" class="cssmenu-title offload button bgc member"><span>{@lam.handicap.desc}</span></a></li>
            <li><a href="${relative_url(LamUrlBuilder::activity())}" class="cssmenu-title offload button bgc administrator"><span>{@lam.security.desc}</span></a></li>
            <li><a href="${relative_url(LamUrlBuilder::activity())}" class="cssmenu-title offload button bgc moderator"><span>{@lam.sanitary.desc}</span></a></li>
        </ul>
    </nav>
</section>