<script>
    jQuery("input[name^='payment']").on('click', function() {
        var amount_paid = jQuery(this).closest('tr').find('td:eq(6)').text();
        var id = jQuery(this).attr('id');
        var club_name = jQuery(this).attr('value');
        jQuery.ajax({
            url: '${relative_url(FinancialUrlBuilder::payment_validation())}',
            type: "post",
            dataType: "json",
            data: {
                token: '{TOKEN}',
                id: id,
                amount_paid: amount_paid
            },
            success: function(returnData) {
                jQuery('#info').html(returnData.msg);
                jQuery('#info').show();
                jQuery('#info').delay(2000).fadeOut();
                jQuery('#requests').load(location.href + " #requests");
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(e) {
            }
        });
    });
</script>

<section id="module-financial">
    <header class="section-header">
        <h1>{@financial.pending.requests}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container responsive-table">
            <div id="info" class = "payment-validation"></div>
            # IF C_ITEMS #
                <table id="requests" class="">
                    <thead>
                        <tr>
                            <th>{@financial.form.radio.choices}</th>
                            <th>{@financial.club.ffam.number}</th>
                            <th>{@financial.club.dept}</th>
                            <th>{@financial.club.name}</th>
                            <th>{@financial.club.activity.date}</th>
                            <th>{@financial.club.request.date}</th>
                            <th>{@financial.amount.paid}</th>
                            # IF C_CONTROLS #<th>{@financial.club.payment}</th># ENDIF #
                        </tr>
                    </thead>
                    <tbody>
                        # START pending_requests #
                            <tr>
                                <td>{pending_requests.ACTIVITY_TYPE}</td>
                                <td>{pending_requests.CLUB_FFAM_NUMBER}</td>
                                <td>{pending_requests.CLUB_DEPT}</td>
                                <td>{pending_requests.CLUB_NAME}</td>
                                <td>{pending_requests.CLUB_ACTIVITY_DATE}</td>
                                <td>{pending_requests.CLUB_REQUEST_DATE}</td>
                                <td>{pending_requests.AMOUNT_PAID}</td>
                                # IF C_CONTROLS #
                                    <td><input id="{pending_requests.CHECKBOX_ID}" type="checkbox" name="payment" aria-label="{@financial.club.payment}" value="{pending_requests.ACTIVITY_TYPE} de {pending_requests.CLUB_NAME}" /></td>
                                # ENDIF #
                            </tr>
                        # END pending_requests #
                    </tbody>
                </table>
            # ELSE #
                <sapn class="message-helper bgc notice">{@financial.no.current.items}</sapn>
            # ENDIF #
        </div>
    </div>
    <footer></footer>
</section>