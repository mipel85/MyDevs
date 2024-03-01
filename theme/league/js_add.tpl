<script src="{PATH_TO_ROOT}/templates/league/js/retrieve.caps# IF C_CSS_CACHE_ENABLED #.min# ENDIF #.js"></script>
<script src="{PATH_TO_ROOT}/templates/league/js/scroll.circle# IF C_CSS_CACHE_ENABLED #.min# ENDIF #.js"></script>

<script>
    jQuery(document).ready(function() {
        // Change caps color in website title
        retrieveCaps(jQuery('#site-name'));
        jQuery(window).on("load scroll", function() {  PxScrollCircle();  });
        jQuery('#scroll-circle .back-to-top').on('click', function(){
            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });

        // Change root category name
        jQuery('#module-planning #filters_form_1_id_category option, #module-financial #filters_form_1_id_category option, #PlanningItemFormController_id_category option').each(function() {
            if (jQuery(this).val() == 'all') {
                jQuery(this).attr('label', 'Toutes les activités')
            }
            if (jQuery(this).val() == 0) {
                jQuery(this).attr('label', ${escapejs(@theme.activities.other)})
            }
        });

        // Turn category into Activity
        jQuery('#cssmenu-module-planning li a, #breadcrumb ol li a span, #module-planning header h1, #module-planning form label').each(function() {
            let text = jQuery(this).text();
            if (text.indexOf('À placer dans la catégorie') > -1) {
                text = text.replace("la catégorie", "l'activité");
                jQuery(this).text(text);
            }
            if (text.indexOf('catégorie') > -1) {
                text = text.replace('catégorie', 'activité');
                jQuery(this).text(text);
            }
        });
    });
</script>

<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Goudy+Bookletter+1911&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto+Slab&display=swap" rel="stylesheet"> 