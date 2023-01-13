# IF C_IS_AUTHORIZED #     
<h1>
    <span>
        {@lam.financial.statement}
    </span>
</h1>

<div>
    <table class>
        <thead>
            <tr>
                <th>{@lam.activity}</th><th>{@lam.total.planned.budget}</th><th>{@lam.financial.day.amount}</th><th>{@lam.activity.nb.requests}</th><th>{@lam.provisional.budget.balance}</th>
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
# ENDIF #

    <div class="cell-table cell-flex cell-columns-2"># INCLUDE ACTIVITY_TABLE #</div>