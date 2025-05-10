<script>
	function check_search_mini_form_post()
	{
		var textSearched = document.getElementById('search-text').value;
		if (textSearched.length >= 3)
		{
			textSearched = escape_xmlhttprequest(textSearched);
			return true;
		}
		else
		{
			alert(${escapejs(@search.warning.length)});
			return false;
		}
	}

	jQuery(document).ready(function() {
		jQuery('#search-token').val(TOKEN);
	});
</script>

<div id="module-mini-search">
    <a href="{U_ADVANCED_SEARCH}" aria-label="{@form.search}" class="search-button offload"><i class="fa fa-lg fa-search" aria-hidden="true"></i></a>
</div>
