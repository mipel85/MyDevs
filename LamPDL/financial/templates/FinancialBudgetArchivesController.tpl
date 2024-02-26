<section id="module-financial" class="single-item">
	<header class="section-header">
		<h1>
			<span itemprop="name">{@financial.budget.archives} # IF C_YEAR_SELECTED #- {YEAR_TITLE}# ENDIF #</span>
		</h1>
	</header>
	<div class="sub-section">
		<div class="content-container">
            # INCLUDE YEARS_FORM #
            # IF C_TABLE_EXISTS #
                <article class="content">
                    <div class="responsive-table bordered-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    # START thead #
                                        <th>{thead.TH}</th>
                                    # END thead #
                                </tr>
                            </thead>
                            <tbody>
                                # START tbody #
                                    <tr>
                                        # IF tbody.C_DOMAIN #<td>{tbody.DOMAIN}</td># ENDIF #
                                        # IF tbody.C_NAME #<td class="align-left">{tbody.NAME}</td># ENDIF #
                                        # IF tbody.C_ANNUAL_AMOUNT #<td>{tbody.ANNUAL_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_REAL_AMOUNT #<td>{tbody.REAL_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_UNIT_AMOUNT #<td>{tbody.UNIT_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_QUANTITY #<td>{tbody.QUANTITY}</td># ENDIF #
                                        # IF tbody.C_REAL_QUANTITY #<td>{tbody.REAL_QUANTITY}</td># ENDIF #
                                    </tr>
                                # END tbody #
                            </tbody>
                        </table>
                    </div>
                </article>
            # ELSE #
                <article class="content">
                    # IF C_NO_TABLES #
                        <div class="message-helper bgc notice">{@financial.budget.archive.no.tables}</div>
                    # ELSE #
                        # IF C_YEAR_SELECTED #
                            <div class="message-helper bgc notice">{@financial.budget.archive.unexists}</div>
                        # ELSE #
                        <div class="message-helper bgc notice">{@financial.budget.archive.home}</div>
                        # ENDIF #
                    # ENDIF #
                </article>
            # ENDIF #
		</div>
	</div>
	<footer></footer>
</section>
