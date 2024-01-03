# IF C_IS_AUTHORIZED #
    <section id="module-lamfinancial">
        <header class="section-header">
            <h1>{@lamfinancial.financial.statement}</h1>
        </header>
        <div class="sub-section">
            <div class="content-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{@lamfinancial.form.radio.choices}</th>
                            <th>{@lamfinancial.total.planned.budget}</th>
                            <th>{@lamfinancial.list.day.amount}</th>
                            <th>{@lamfinancial.activity.nb.requests}</th>
                            <th>{@lamfinancial.provisional.budget.balance}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{JPO}</td>
                            <td>{JPO_TOTAL_AMOUNT}</td>
                            <td>{JPO_DAY_AMOUNT}</td>
                            <td>{JPO_NB_REQUESTS}</td>
                            <td>{JPO_REMAINING_AMOUNT}</td>
                        </tr>
                        <tr>
                            <td>{EXAM}</td>
                            <td>{EXAM_TOTAL_AMOUNT}</td>
                            <td>{EXAM_DAY_AMOUNT}</td>
                            <td>{EXAM_NB_REQUESTS}</td>
                            <td>{EXAM_REMAINING_AMOUNT}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
# ENDIF #

# INCLUDE ACTIVITY_TABLE #