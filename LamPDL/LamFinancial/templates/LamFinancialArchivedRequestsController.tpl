<section id="module-lamfinancial">
    <header class="section-header">
        <h1>{@lamfinancial.archived.requests}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container responsive-table">
            # IF C_ITEM #
                <table id="archived_requests" class="display">
                    <thead>
                        <tr>
                            <th>{@lamfinancial.form.radio.choices}</th>
                            <th>{@lamfinancial.club.name}</th>
                            <th>{@lamfinancial.club.ffam.number}</th>
                            <th>{@lamfinancial.club.activity.date}</th>
                            <th>{@lamfinancial.club.request.date}</th>
                            <th>{@lamfinancial.amount.real.paid}</th>
                            <th>{@lamfinancial.archived.date}</th>
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
                <div class="message-helper bgc notice">{@lamfinancial.no.archived.items}</div>
            # ENDIF #
        </div>
    </div>
    <footer></footer>
</section>