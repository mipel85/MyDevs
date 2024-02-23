<section id="module-financial" class="single-item">
	<header class="section-header">
		<h1>
			<span itemprop="name">{@financial.monitoring} - {YEAR_TITLE}</span>
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
                                        # IF tbody.C_NAME #<td>{tbody.NAME}</td># ENDIF #
                                        # IF tbody.C_ANNUAL_AMOUNT #<td>{tbody.ANNUAL_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_REAL_AMOUNT #<td>{tbody.REAL_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_TEMP_AMOUNT #<td>{tbody.TEMP_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_UNIT_AMOUNT #<td>{tbody.UNIT_AMOUNT}</td># ENDIF #
                                        # IF tbody.C_REAL_QUANTITY #<td>{tbody.REAL_QUANTITY}</td># ENDIF #
                                        # IF tbody.C_TEMP_QUANTITY #<td>{tbody.TEMP_QUANTITY}</td># ENDIF #
                                    </tr>
                                # END tbody #
                            </tbody>
                        </table>
                    </div>
                </article>
            # ELSE #
                <article class="content">
                    <div class="message-helper bgc notice">{@financial.budget.archive.no.tables}</div>
                </article>
            # ENDIF #
		</div>
	</div>
	<footer></footer>
</section>
