<script>
    jQuery("input[name^='payment']").on('click', function() {
        var amount_paid = jQuery(this).closest('tr').find('td:eq(5)').text();
        var id = jQuery(this).attr('id');
        var club_name = jQuery(this).attr('value');
        jQuery.ajax({
            url: '${relative_url(LamUrlBuilder::payment_validation())}',
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

<h1>
    <span>
        {@lam.pending.requests}
    </span>
</h1>
<div>
    <div id="info" class = "payment-validation"></div>
    <table id = "requests">
        <thead>
            <tr>
                <th>{@lam.form.radio.choices}</th><th>{@lam.club.name}</th><th>{@lam.club.ffam.number}</th><th>{@lam.club.activity.date}</th><th>{@lam.club.request.date}</th><th>{@lam.amount.paid}</th><th>{@lam.club.payment}</th>
            </tr>
        </thead>
        # IF C_IS_AUTHORIZED #     
        # IF C_ITEM #
        <tbody>
            # START pending_requests #
            <tr>
                <td>{pending_requests.ACTIVITY_TYPE}</td>
                <td>{pending_requests.CLUB_NAME}</td>
                <td>{pending_requests.CLUB_FFAM_NUMBER}</td>
                <td>{pending_requests.CLUB_ACTIVITY_DATE}</td>
                <td>{pending_requests.CLUB_REQUEST_DATE}</td>
                <td>{pending_requests.AMOUNT_PAID}</td>
                <td><input id = "{pending_requests.CHECKBOX_ID}" type ="checkbox" name = "payment" aria-label = "{@lam.club.payment}" value = "{pending_requests.ACTIVITY_TYPE} de {pending_requests.CLUB_NAME}"</td>
            </tr>
            # END pending_requests #
            # ENDIF #
            # ELSE #
            <tr>
                <td colspan = 7>{@lam.no.current.items}</td>
            </tr>
        </tbody>
        # ENDIF #
    </table>
</div>