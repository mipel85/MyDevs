# IF NOT IS_USER_CONNECTED #
	<script>
		function check_connect()
		{
			if( document.getElementById('login').value == "" )
			{
				alert("{@warning.username}");
				return false;
			}
			if( document.getElementById('password').value == "" )
			{
				alert("{@warning.password}");
				return false;
			}
		}
	</script>
# ENDIF #

<div id="module-connect" class="# IF IS_USER_CONNECTED # user-connected# ELSE # user-not-connected# ENDIF #">
    # IF NOT IS_USER_CONNECTED #
        <a href="{PATH_TO_ROOT}/login/" class="connection-button" aria-label="<span>{@user.sign.in}</span>"><i class="fa fa-lg fa-sign-in-alt" aria-hidden="true"></i> </a>
    # ELSE # <!-- User Connected -->
        <div class="cell-list cell-list-inline connected-contents">
            <ul class="connect-container# IF C_HORIZONTAL # connect-container-horizontal# ENDIF #">
                <li class="li-stretch connect-profile">
                    # IF C_VERTICAL #
                        # IF IS_MODERATOR #
                            <i class="fa fa-user-tie" aria-hidden="true"></i>
                        # ELSE #
                            <i class="fa fa-user" aria-hidden="true"></i>
                        # ENDIF #
                        <a href="${relative_url(UserUrlBuilder::home_profile())}" class="offload">
                            <span>{@user.my.account}</span>
                        </a>
                    # ELSE #
                        <a href="${relative_url(UserUrlBuilder::home_profile())}" class="offload avatar-link" aria-label="{@user.my.account}: {USER_DISPLAYED_NAME}">
                            # IF C_USER_AVATAR #
                                <span class="avatar-picture" style="background-image: url({U_USER_AVATAR})"></span>
                            # ELSE #
                                # IF IS_MODERATOR #
                                    <i class="fa fa-user-tie" aria-hidden="true"></i>
                                # ELSE #
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                # ENDIF #
                            # ENDIF #
                        </a>
                    # ENDIF #
                </li>
                <li class="li-stretch connect-pm">
                    <a href="{U_USER_PM}" class="offload# IF C_HAS_PM # connect-alert# ENDIF #" aria-label="{@user.private.messaging}">
                        <span # IF C_HAS_PM #class="stacked member"# ENDIF #>
                            <i class="fa fa-fw fa-lg fa-people-arrows" aria-hidden="true"></i>
                            # IF C_HAS_PM #<span class="stack-event stack-circle stack-top-right bgc-full member blink">{PM_NUMBER}</span> # ENDIF #
                        </span>
                    </a>
                </li>
                # IF IS_ADMIN #
                    <li class="li-stretch connect-admin">
                        <a href="${relative_url(UserUrlBuilder::administration())}" class="offload# IF C_UNREAD_ALERTS # connect-alert# ENDIF #" aria-label="{@user.admin.panel}">
                            <span # IF C_UNREAD_ALERTS #class="stacked administrator"# ENDIF #>
                                <i class="fa fa-fw fa-lg fa-wrench" aria-hidden="true"></i>
                                # IF C_UNREAD_ALERTS # <span class="stack-event stack-circle stack-top-right bgc-full administrator blink">{UNREAD_ALERTS_NUMBER}</span> # ENDIF #
                            </span>
                        </a>
                    </li>
                # ENDIF #
                # IF IS_MODERATOR #
                    <li class="li-stretch connect-moderation" aria-label="{@user.moderation.panel}">
                        <a href="${relative_url(UserUrlBuilder::moderation_panel())}" class="offload">
                            <i class="fa fa-fw fa-lg fa-gavel" aria-hidden="true"></i>
                        </a>
                    </li>
                # ENDIF #
                <li class="li-stretch connect-contribution">
                    <a href="${relative_url(UserUrlBuilder::contribution_panel())}" class="offload# IF C_UNREAD_CONTRIBUTIONS # connect-alert# ENDIF #" aria-label="{@user.contribution.panel}">
                        <span # IF C_UNREAD_CONTRIBUTIONS #class="stacked moderator"# ENDIF #>
                            <i class="fa fa-fw fa-lg fa-file-alt" aria-hidden="true"></i>
                            # IF C_UNREAD_CONTRIBUTIONS #<span class="stack-event stack-circle stack-top-right bgc-full moderator blink">{UNREAD_CONTRIBUTIONS_NUMBER}</span># ENDIF #
                        </span>
                    </a>
                </li>
                # START additional_menus #
                    # IF additional_menus.C_DISPLAY #
                        <li class="li-stretch connect-{additional_menus.MENU_NAME}">
                            <a href="{additional_menus.URL}" class="offload# IF additional_menus.C_UNREAD_ELEMENTS # connect-alert# ENDIF #" aria-label="{additional_menus.LABEL}">
                                <span # IF additional_menus.C_UNREAD_ELEMENTS #class="stacked {additional_menus.LEVEL_CLASS}"# ENDIF #>
                                    <i class="fa-fw fa-lg# IF additional_menus.C_ICON # {additional_menus.ICON}# ELSE # far fa-file-alt# ENDIF #" aria-hidden="true"></i>
                                    # IF additional_menus.C_UNREAD_ELEMENTS #<span class="stack-event stack-circle stack-top-right blink bgc-full {additional_menus.LEVEL_CLASS} blink">{additional_menus.UNREAD_ELEMENTS_NUMBER}</span># ENDIF #
                                </span>
                            </a>
                        </li>
                    # ENDIF #
                # END additional_menus #
                <li class="li-stretch connect-sign-out">
                    <a href="${relative_url(UserUrlBuilder::disconnect())}" class="offload" aria-label="{@user.sign.out}">
                        <i class="fa fa-fw fa-lg fa-sign-out-alt" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
    # ENDIF #
</div>
