<section id="module-lam">
    <header class="section-header">
        <h1>{TITLE}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container">
            # IF C_CHECK_CONFIG #
                <a href="${relative_url(LamUrlBuilder::activity())}" class="offload button bgc visitor activity-button"><span>{@lam.activity.desc}</span></a>
            # ELSE #
                <span class="message-helper bgc error">{@H|lam.check.configuration}</span>
            # ENDIF #
        </div>
    </div>
</section>