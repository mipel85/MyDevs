<section id="module-planning" class="category-{CATEGORY_ID} single-item">
	<header class="section-header">
		<h1>
			<span itemprop="name">{@planning.warnings}</span>
		</h1>
	</header>
	<div class="sub-section">
		<div class="content-container">
			<article class="content">
                # IF C_NO_LAMCLUBS #
                    <div class="message-helper bgc error">{@planning.warnings.lamclubs}</div>
                # ENDIF #
                # IF C_NO_CATEGORIES #
                    <div class="message-helper bgc error">{@planning.warnings.categories}</div>
                # ENDIF #
			</article>
		</div>
	</div>
	<footer></footer>
</section>
