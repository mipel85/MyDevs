# IF C_IS_AUTHORIZED #     
<h1>
    <span>
        {@lam.financial.statement}
    </span>
</h1>

<div>
    <table>
        <thead>
            <tr>
                <th>{@lam.form.radio.choices}</th><th>{@lam.total.planned.budget}</th><th>{@lam.list.day.amount}</th><th>{@lam.activity.nb.requests}</th><th>{@lam.estimated.amount}</th><th>{@lam.real.amount}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{JPO}</td>
                <td>{JPO_TOTAL_AMOUNT}</td>
                <td>{JPO_DAY_AMOUNT}</td>
                <td>{JPO_NB_REQUESTS}</td>
                <td>{JPO_ESTIMATED_REMAINING_AMOUNT}</td>
            </tr>
            <tr>
                <td>{EXAM}</td>
                <td>{EXAM_TOTAL_AMOUNT}</td>
                <td>{EXAM_DAY_AMOUNT}</td>
                <td>{EXAM_NB_REQUESTS}</td>
                <td>{EXAM_ESTIMATED_REMAINING_AMOUNT}</td>
            </tr>
        </tbody>
    </table>
</div>
# ENDIF #