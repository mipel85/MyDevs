# INCLUDE MAINTAIN #
<header id="header">
    <div id="header-container">
        <div id="top-header">
            # IF C_MENUS_TOP_HEADER_CONTENT #
                <div id="top-header-content" class="content-wrapper">
                    # START menus_top_header #
                        {menus_top_header.MENU}
                    # END menus_top_header #
                    <div class="spacer"></div>
                </div>
            # ENDIF #
        </div>
        <div id="inner-header">
            <div id="inner-header-container" class="content-wrapper">
                <div id="site-infos" role="banner">
                    <div id="site-logo-0" class="site-logo" # IF C_HEADER_LOGO #style="background-image: url({U_HEADER_LOGO});"# ENDIF #></div>
                    <div id="site-name-container">
                        <span id="site-name-seo">{SITE_NAME}</span>
                        <span id="site-name" class="align-center">
                            <span class="d-block">
                                <span class="first-letter">L</span>igue 
                                d'<span class="first-letter">A</span>éro<span class="first-letter">M</span>odélisme
                            </span>
                            <span class="d-block">
                                 des <span class="first-letter">P</span>ays <span class="first-letter">d</span>e la <span class="first-letter">L</span>oire</span>
                            </span>
                        </span>
                    </div>
                    <div id="site-logo-1" class="site-logo"></div>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            # IF C_MENUS_HEADER_CONTENT #
                <div id="inner-header-content">
                    # IF NOT IS_USER_CONNECTED #<span></span># ENDIF #
                    # START menus_header #
                        {menus_header.MENU}
                    # END menus_header #
                </div>
            # ENDIF #
        </div>
        <div id="sub-header">
            # IF C_MENUS_SUB_HEADER_CONTENT #
                <div id="sub-header-content" class="content-wrapper">
                    # START menus_sub_header #
                        {menus_sub_header.MENU}
                    # END menus_sub_header #
                    <div class="spacer"></div>
                </div>
            # ENDIF #
        </div>
    </div>
</header>

# IF IS_ADMIN #
    # IF C_VISIT_COUNTER #
        <div id="visit-counter" class="hidden-small-screens flex-between content-wrapper">
            <div></div>
            <div class="counter flex-between">
                <div class="visit-counter-total m-20">
                    <span class="lam-counter">{@user.guests} &nbsp;</span>
                    <span class="lam-counter">{VISIT_COUNTER_TOTAL}</span>
                </div>
                <div class="visit-counter-today">
                    <span class="lam-counter">{@date.today}</span>
                    <span class="lam-counter">{VISIT_COUNTER_DAY}</span>
                </div>
            </div>
        </div>
    # ENDIF #
# ENDIF #

<main id="global" class="content-preloader" role="main">
    <div id="global-container" class="content-wrapper">
        # IF C_MENUS_LEFT_CONTENT #
            <aside id="menu-left" class="aside-menu# IF C_MENUS_RIGHT_CONTENT # narrow-menu narrow-menu-left# ENDIF #">
                # START menus_left #
                    {menus_left.MENU}
                # END menus_left #
            </aside>
        # ENDIF #

        <div id="main" class="# IF C_MENUS_LEFT_CONTENT #main-with-left# ENDIF ## IF C_MENUS_RIGHT_CONTENT # main-with-right# ENDIF #" role="main">
            # IF C_MENUS_TOPCENTRAL_CONTENT #
                <div id="top-content">
                    # START menus_top_central #
                        {menus_top_central.MENU}
                    # END menus_top_central #
                </div>
                <div class="spacer"></div>
            # ENDIF #

            <div id="main-content" itemprop="mainContentOfPage">
                # INCLUDE ACTIONS_MENU #
                <nav id="breadcrumb" itemprop="breadcrumb">
                    <ol itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a class="offload" href="{START_PAGE}" itemprop="item">
                                <span itemprop="name">{@common.home}</span>
                                <meta itemprop="position" content="1" />
                            </a>
                        </li>
                        # START link_bread_crumb #
                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" # IF link_bread_crumb.C_CURRENT # class="current" # ENDIF #>
                                <a class="offload" href="{link_bread_crumb.URL}" itemprop="item">
                                    <span itemprop="name">{link_bread_crumb.TITLE}</span>
                                    <meta itemprop="position" content="{link_bread_crumb.POSITION}" />
                                </a>
                            </li>
                        # END link_bread_crumb #
                    </ol>
                </nav>
                # INCLUDE KERNEL_MESSAGE #
                {CONTENT}
            </div>

            # IF C_MENUS_BOTTOM_CENTRAL_CONTENT #
                <div id="bottom-content">
                    # START menus_bottom_central #
                        {menus_bottom_central.MENU}
                    # END menus_bottom_central #
                </div>
            # ENDIF #
        </div>

        # IF C_MENUS_RIGHT_CONTENT #
            <aside id="menu-right" class="aside-menu# IF C_MENUS_LEFT_CONTENT # narrow-menu narrow-menu-right# ENDIF #">
                # START menus_right #
                    {menus_right.MENU}
                # END menus_right #
            </aside>
        # ENDIF #
    </div>

</main>

<footer id="footer">

    # IF C_MENUS_TOP_FOOTER_CONTENT #
        <div id="top-footer" class="content-wrapper">
            # START menus_top_footer #
                {menus_top_footer.MENU}
            # END menus_top_footer #
            <div class="spacer"></div>
        </div>
    # ENDIF #

    <div id="lam-infos" class="content-wrapper align-center">
        <span class="d-block"><i class="fa fa-home"></i> Ligue d'Aéromodélisme des Pays de la Loire<br />Maison des Sports, 44, rue Romain Rolland, BP 90312, 44100 Nantes</span>
    </div>

    # IF C_MENUS_FOOTER_CONTENT #
        <div id="footer-content" class="content-wrapper">
            # START menus_footer #
                {menus_footer.MENU}
            # END menus_footer #
        </div>
    # ENDIF #

    <div id="footer-infos" class="content-wrapper" role="contentinfo">
        <span class="footer-infos-powered-by">{@common.powered.by} <i class="fa iboost fa-iboost-logo" aria-hidden="true"></i> <a class="offload" href="https://www.phpboost.com" aria-label="{@common.phpboost.link}">PHPBoost</a></span> | <span aria-label="{@common.phpboost.right}"><i class="fab fa-osi" aria-hidden="true"></i></span>
        # IF C_DISPLAY_BENCH #
            <span class="footer-infos-benchmark">| {@common.achieved} {BENCH}{@date.unit.seconds} - {REQ} {@common.sql.request} - {MEMORY_USED}</span>
        # ENDIF #
        # IF C_DISPLAY_AUTHOR_THEME #
            <span class="footer-infos-template-author">| {@common.theme} {L_THEME_NAME} ${TextHelper::lcfirst(@common.by)} <a class="offload" href="{U_THEME_AUTHOR_LINK}">{L_THEME_AUTHOR}</a></span>
        # ENDIF #
    </div>
</footer>

<div id="scroll-circle" class="hidden-xs hidden-sm">
    <div class="progression" style="background-image: linear-gradient(90deg, rgb(var(--darken)) 50%, transparent 50%), linear-gradient(90deg, rgb(var(--lighten)) 50%, rgb(var(--darken)) 50%);">
        <div class="percentage">0%</div>
        <div class="back-to-top" aria-label="{@common.scroll.to.top}"><i class="fas fa-arrow-up" aria-hidden="true"></i></div>
    </div>
</div>

<script src="{PATH_TO_ROOT}/templates/lampdl/js/scroll.circle# IF C_CSS_CACHE_ENABLED #.min# ENDIF #.js"></script>
<script>
    jQuery(window).on("load scroll", function() { PxScrollCircle(); });
    jQuery('#scroll-circle .back-to-top').on('click', function(){
        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
</script>
