<section id="module-planning" class="category-{CATEGORY_ID} single-item">
	<header class="section-header">
		<div class="controls align-right">
			<a class="offload" href="{U_SYNDICATION}" aria-label="{@common.syndication}"><i class="fa fa-rss warning" aria-hidden="true"></i></a>
			{@planning.module.title}# IF NOT C_ROOT_CATEGORY # - {CATEGORY_NAME}# ENDIF # # IF IS_ADMIN #<a class="offload" href="{U_EDIT_CATEGORY}" aria-label="{@common.edit}"><i class="far fa-edit" aria-hidden="true"></i></a># ENDIF #
		</div>
		<h1>
			<span itemprop="name">{TITLE}</span>
		</h1>
	</header>
	<div class="sub-section">
		<div class="content-container">
			<article itemscope="itemscope" itemtype="https://schema.org/Event" id="planning-item-{ID}" class="planning-item# IF C_NEW_CONTENT # new-content# ENDIF #">

				<div class="flex-between">
					<div class="more">
						<span class="pinned item-author"><i class="fa fa-user"></i> # IF C_AUTHOR_EXISTS #<a itemprop="author" href="{U_AUTHOR_PROFILE}" class="{AUTHOR_LEVEL_CLASS} offload" # IF C_AUTHOR_GROUP_COLOR # style="color:{AUTHOR_GROUP_COLOR}" # ENDIF #>{AUTHOR}</a># ELSE #<span class="visitor">{AUTHOR}</span># ENDIF #</span>
						<span class="pinned item-creation-date" aria-label="{@common.creation.date}"><i class="far fa-calendar-alt" aria-hidden="true"></i> <time datetime="{DATE_ISO8601}" itemprop="datePublished">{DATE}</time> </span>
						# IF NOT C_ROOT_CATEGORY #<span class="pinned-category item-category" data-color-surround="{CATEGORY_COLOR}"><a class="offload" aria-label="{@common.category}" href="{U_CATEGORY}">{CATEGORY_NAME}</a></span># ENDIF #
					</div>
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
				# IF C_HAS_UPDATE_DATE #
					<span class="pinned notice small text-italic item-modified-date"><i>{@common.last.update} : <time datetime="{UPDATE_DATE_ISO8601}" itemprop="datePublished">{UPDATE_DATE}</time></i></span>
				# ENDIF #

				# IF NOT C_APPROVED #
					# INCLUDE NOT_VISIBLE_MESSAGE #
				# ENDIF #

				<div class="content# IF C_CANCELLED # error# ENDIF #" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

					# IF C_CANCELLED #
					<span class="message-helper bgc error">{@planning.cancelled.item}</span>
					# ENDIF #

					<div class="cell-tile cell-options">
						<div class="cell">
							<div class="cell-list">
								<ul>
									<li class="li-stretch">
										<span class="text-strong">{@planning.start.date}</span>
										<time datetime="{START_DATE_ISO8601}" itemprop="startDate">{START_DATE_FULL}</time>
									</li>
									<li class="li-stretch">
										<span class="text-strong">{@planning.end.date}</span>
										<time datetime="{END_DATE_ISO8601}" itemprop="endDate">{END_DATE_FULL}</time>
									</li>
									# IF C_LOCATION #
										<li itemprop="location" itemscope itemtype="https://schema.org/Place">
											<span class="text-strong">{@planning.location}: </span>
											<span itemprop="name">{LOCATION}</span>
										</li>
									# ENDIF #
								</ul>
							</div>
						</div>
					</div>

					<div itemprop="text">{CONTENT}</div>
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
