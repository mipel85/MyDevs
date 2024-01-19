<section id="module-financial">
    <header class="section-header">
        <h1>{TITLE}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container">
        # IF C_CLUBS #
            <div class="flex-between">
                <span class="open-span-button">{@financial.activity.desc}</span>
                <a href="${relative_url(FinancialUrlBuilder::activity())}" class="offload button bgc visitor open-button"><span>{@financial.form.open}</span></a>
            </div>
        # ELSE #
            <div class="message-helper bgc error">{@financial.clubs.module.missing}</div>
        # ENDIF #
        </div>
    </div>
</section>