<section id="module-lamfinancial">
    <header class="section-header">
        <h1>{TITLE}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container">
            # IF C_CHECK_CONFIG #
            <a href="${relative_url(ToolsUrlBuilder::activity())}" class="offload button bgc visitor activity-button"><span>{@lamfinancial.activity.desc}</span></a>
            <a href="${relative_url(ToolsUrlBuilder::pending_requests())}" class="offload button requests-button"><span>{@lamfinancial.pending.requests.link}</span></a>
            # ELSE #
            <span class="message-helper bgc error">{@H|lamfinancial.check.configuration}</span>
            # ENDIF #
        </div>
    </div>
</section>