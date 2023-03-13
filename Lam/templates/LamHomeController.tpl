<section id="Lam-main">
    <header>
        <h1>{TITLE}</h1>
    </header>
    # IF C_CHECK_CONFIG #
    <a href="${relative_url(LamUrlBuilder::activity())}" class="cssmenu-title offload button bgc moderator"><span>{@lam.activity.desc}</span></a>
    # ELSE #
       <br /><span class="message-helper bgc error">{@H|lam.check.configuration}</span>
    # ENDIF #
</section>