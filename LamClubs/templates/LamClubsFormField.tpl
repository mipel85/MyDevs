<div id="input_fields_${escape(ID)}">
	# START fieldelements #
		<div id="${escape(ID)}_{fieldelements.ID}">
			<div id="club_item_{fieldelements.ID}">
				<input class="w100" list="lamclubs-choice" autocomplete="on" type="text" name="field_name_${escape(ID)}_{fieldelements.ID}" id="field_name_${escape(ID)}_{fieldelements.ID}" value="{fieldelements.NAME}" placeholder="" required />
				<datalist id="lamclubs-choice">
					# START fieldelements.items #
						<option value="{fieldelements.items.FFAM_NB} - {fieldelements.items.DEPARTMENT} - {fieldelements.items.NAME}"></option>
					# END fieldelements.items #
				</datalist>
			</div>
		</div>
	# END fieldelements #
</div>
