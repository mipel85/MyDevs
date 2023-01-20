<div id="input_fields_${escape(ID)}">
	# START fieldelements #
		<div id="${escape(ID)}_{fieldelements.ID}" class="cell">
			<div id="club_item_{fieldelements.ID}">
				<input list="clubs-choice" autocomplete="on" type="text" name="field_name_${escape(ID)}_{fieldelements.ID}" id="field_name_${escape(ID)}_{fieldelements.ID}" value="{fieldelements.NAME}" placeholder="" required />
				<datalist id="clubs-choice">
					# START fieldelements.clubs #
						<option value="{fieldelements.clubs.CLUB_NB} - {fieldelements.clubs.CLUB_NAME} - {fieldelements.clubs.CLUB_STATE}"></option>
					# END fieldelements.clubs #
				</datalist>
			</div>
		</div>
	# END fieldelements #
</div>
