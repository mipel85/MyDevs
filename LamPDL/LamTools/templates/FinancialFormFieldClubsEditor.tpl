<div id="input_fields_${escape(ID)}">
	# START fieldelements #
		<div id="${escape(ID)}_{fieldelements.ID}" class="cell">
			<div id="club_item_{fieldelements.ID}">
				<input list="clubs-choice" autocomplete="on" type="text" name="field_name_${escape(ID)}_{fieldelements.ID}" id="field_name_${escape(ID)}_{fieldelements.ID}" value="{fieldelements.NAME}" placeholder="" required />
				<datalist id="clubs-choice">
					# START clubs #
						<option value="{clubs.CLUB_FFAM_NUM} - {clubs.CLUB_DPT} - {clubs.CLUB_NAME}"></option>
					# END clubs #
				</datalist>
			</div>
		</div>
	# END fieldelements #
</div>
