<section id="module-financial" class="single-item">
	<header class="section-header">
		<h1>
			<span itemprop="name">{@financial.warnings}</span>
		</h1>
	</header>
	<div class="sub-section">
		<div class="content-container">
			<article class="content">
                # IF C_NO_LAMCLUBS #
                    <div class="message-helper bgc error">{@financial.warnings.lamclubs}</div>
                # ENDIF #
                # IF C_BREAK #
                    <div class="message-helper bgc notice">{@financial.warnings.break}</div>
                # ENDIF #
			</article>
		</div>
	</div>
	<footer></footer>
</section>
