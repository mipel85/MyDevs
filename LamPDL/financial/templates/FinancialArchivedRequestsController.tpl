<section id="module-financial">
    <header class="section-header">
        <h1>{@financial.archived.requests}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container responsive-table">
            # IF C_ITEM #
                <table id="archived_requests">
                    <thead>
                        <tr>
                            <th>{@financial.form.radio.choices}</th>
                            <th>{@financial.club.name}</th>
                            <th>{@financial.club.ffam.number}</th>
                            <th>{@financial.club.activity.date}</th>
                            <th>{@financial.club.request.date}</th>
                            <th>{@financial.amount.real.paid}</th>
                            <th>{@financial.archived.date}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START archived_requests #
                        <tr>
                            <td>{archived_requests.ACTIVITY_TYPE}</td>
                            <td>{archived_requests.CLUB_NAME}</td>
                            <td>{archived_requests.CLUB_FFAM_NUMBER}</td>
                            <td>{archived_requests.CLUB_ACTIVITY_DATE}</td>
                            <td>{archived_requests.CLUB_REQUEST_DATE}</td>
                            <td>{archived_requests.AMOUNT_PAID}</td>
                            <td>{archived_requests.ARCHIVED_DATE}</td>
                        </tr>
                        # END archived_requests #
                    </tbody>
                </table>
            # ELSE #
                <div class="message-helper bgc notice">{@financial.no.archived.items}</div>
            # ENDIF #
        </div>
    </div>
    <footer></footer>
</section>