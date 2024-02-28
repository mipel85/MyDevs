<section id="module-planning" class="category-{CATEGORY_ID} single-item">
	<header class="section-header">
		<div class="controls align-right">
			<a class="offload" href="{U_SYNDICATION}" aria-label="{@common.syndication}"><i class="fa fa-rss warning" aria-hidden="true"></i></a>
			{@planning.module.title}# IF NOT C_ROOT_CATEGORY # - {CATEGORY_NAME}# ENDIF # # IF IS_ADMIN #<a class="offload" href="{U_EDIT_CATEGORY}" aria-label="{@common.edit}"><i class="far fa-edit" aria-hidden="true"></i></a># ENDIF #
		</div>
		<h1>
			<span itemprop="name">{TITLE}</span>
		</h1>
        <h3><span class="smaller">{@planning.organized.by} : </span> {CLUB_NAME} <span class="smaller">({CLUB_DPT})</span></h3>
	</header>
	<div class="sub-section">
		<div class="content-container">
			<article itemscope="itemscope" itemtype="https://schema.org/Event" id="planning-item-{ID}" class="planning-item# IF C_NEW_CONTENT # new-content# ENDIF #">

				<div class="flex-between">
					<div class="more"></div>
					# IF C_CONTROLS #
						<div class="controls align-right">
							# IF C_EDIT #
								<a class="offload" href="{U_EDIT}" aria-label="{@common.edit}"><i class="far fa-fw fa-edit" aria-hidden="true"></i></a>
							# ENDIF #
							# IF C_DELETE #
								<a href="{U_DELETE}" aria-label="{@common.delete}"# IF NOT C_BELONGS_TO_A_SERIE # data-confirmation="delete-element"# ENDIF #><i class="far fa-fw fa-trash-alt" aria-hidden="true"></i></a>
							# ENDIF #
						</div>
					# ENDIF #
				</div>

				# IF NOT C_APPROVED #
					# INCLUDE NOT_VISIBLE_MESSAGE #
				# ENDIF #

				<div class="content# IF C_CANCELLED # error# ENDIF #" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

					# IF C_CANCELLED #
                        <span class="message-helper bgc error">{@planning.cancelled.item}</span>
					# ENDIF #

					<div class="cell-tile day-infos cell-options">
						<div class="cell">
							<div class="cell-list">
								<ul>
									<li class="li-stretch">
										<span>{@planning.start.date}</span>
										<time class="text-strong" datetime="{START_DATE_ISO8601}" itemprop="startDate">{START_DATE_FULL}</time>
									</li>
                                    # IF C_END_DATE #
                                        <li class="li-stretch">
                                            <span>{@planning.end.date}</span>
                                            <time class="text-strong datetime="{END_DATE_ISO8601}" itemprop="endDate">{END_DATE_FULL}</time>
                                        </li>
									# ENDIF #
                                    # IF C_CONTACT #
                                        <li class="li-stretch">
                                            <span>{@planning.contact}</span>
                                            <div class="controls">
                                                # IF C_CONTACT_PHONE #
                                                <span>
                                                    <span class="small text-italic">{@planning.contact.phone} : </span>
                                                    {PHONE}
                                                </span>
                                                # ENDIF #
                                                # IF C_CONTACT_EMAIL #
                                                    <div class="modal-container">
                                                        <span class="flex-between" data-modal="" data-target="email-panel">
                                                            <span class="small text-italic">{@planning.contact.email.form} : </span>
                                                            <i class="fa iboost fa-iboost-email link-color"></i>
                                                        </span>
                                                        <div id="email-panel" class="modal modal-animation">
                                                            <div class="close-modal" aria-label="{@common.close}"></div>
                                                            <div class="content-panel">
                                                                <div class="align-right"><a href="#" class="error big hide-modal" aria-label="{@common.close}"><i class="far fa-circle-xmark" aria-hidden="true"></i></a></div>
                                                                # INCLUDE EMAIL_FORM #
                                                            </div>
                                                        </div>
                                                    </div>
                                                # ENDIF #
                                            </div>
                                        </li>
									# ENDIF #
									# IF C_LOCATION #
										<li class="li-stretch" itemprop="location" itemscope itemtype="https://schema.org/Place">
											<span class="text-strong">{@planning.location} : </span>
											<span class="location-text" itemprop="name">{LOCATION}</span>
										</li>
									# ENDIF #
                                    # IF C_HAS_THUMBNAIL #
                                        <li>
                                            # IF C_PDF #
                                            # ELSE #
                                                <img itemprop="thumbnailUrl" src="{U_THUMBNAIL}" alt="{TITLE}" />
                                            # ENDIF #
                                        </li>
                                    # ENDIF #
								</ul>
							</div>
						</div>
					</div>

					<div itemprop="text">{CONTENT}</div>

                    # IF C_LOCATION #
                        <aside class="location-map" itemprop="location" itemscope itemtype="https://schema.org/Place">
                            # IF C_LOCATION_MAP #<div class="location-map">{LOCATION_MAP}</div># ENDIF #
                        </aside>
                    # ENDIF #
				</div>

				<aside>
					${ContentSharingActionsMenuService::display()}
				</aside>

				# IF C_LOCATION #
					<aside class="location-map" itemprop="location" itemscope itemtype="https://schema.org/Place">
						# IF C_LOCATION_MAP #<div class="location-map">{LOCATION_MAP}</div># ENDIF #
					</aside>
				# ENDIF #
			</article>
		</div>
	</div>
	<footer>
		<meta itemprop="url" href="{U_ITEM}">
		<meta itemprop="about" content="{CATEGORY_NAME}">
	</footer>
</section>
