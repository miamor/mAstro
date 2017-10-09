		<div class="form-group">
			<div class="col-lg-3 no-padding control-label">Name</div>
			<div class="col-lg-9"><input type="text" name="name" placeholder="Name"/></div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-lg-3 no-padding">Gender</div>
			<div class="col-lg-4">
				<label class="radio">
					<input type="radio" value="f" checked name="gender"/> Female
				</label>
			</div>
			<div class="col-lg-4">
				<label class="radio">
					<input type="radio" value="m" name="gender"/> Male
				</label>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-lg-3 no-padding control-label">Birthday</div>
			<div class="col-lg-9">
<!--				<input name="day" size="3" value="" maxlength="2" type="number" min="1" max="31" placeholder="dd"> -->
				<select class="day" id="day" name="day">
				<? for ($i = 1; $i <= 31; $i++) {
					if ($i < 10) $t = '0'.$i; else $t = $i;
					echo '<option value="'.$i.'">'.$t.'</option>';
				} ?>
				</select>
				<select id="month" name="month">
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
				<input name="year" size="7" maxlength="4" placeholder="YYYY">
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-lg-3 no-padding control-label">Birth-hour</div>
			<div class="col-lg-5">
				<select class="hour" id="hour" name="hour">
					<option value="0">0 [12 midnight]</option>
					<option value="1">1 [am]</option>
					<option value="2">2 [am]</option>
					<option value="3">3 [am]</option>
					<option value="4">4 [am]</option>
					<option value="5">5 [am]</option>
					<option value="6">6 [am]</option>
					<option value="7">7 [am]</option>
					<option value="8">8 [am]</option>
					<option value="9">9 [am]</option>
					<option value="10">10 [am]</option>
					<option value="11">11 [am]</option>
					<option value="12">12 [noon]</option>
					<option value="13">13 [1 pm]</option>
					<option value="14">14 [2 pm]</option>
					<option value="15">15 [3 pm]</option>
					<option value="16">16 [4 pm]</option>
					<option value="17">17 [5 pm]</option>
					<option value="18">18 [6 pm]</option>
					<option value="19">19 [7 pm]</option>
					<option value="20">20 [8 pm]</option>
					<option value="21">21 [9 pm]</option>
					<option value="22">22 [10 pm]</option>
					<option value="23">23 [11 pm]</option>
				</select>
				:
				<select class="min" id="min" name="min">
				<? for ($i = 0; $i < 60; $i++) {
					if ($i < 10) $t = '0'.$i; else $t = $i;
					echo '<option value="'.$i.'">'.$t.'</option>';
				} ?>
				</select>
			</div>
			<div class="col-lg-4 control-label no-padding">
				<label class="checkbox unknown-hr">
					<input type="checkbox" value="-1" name="hour"/> Unknown
				</label>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-lg-3 no-padding control-label">Birth place</div>
			<div class="col-lg-5 no-padding-right">
				<input class="form-control" type="text" id="town" name="town" placeholder="Town/City"/>
			</div>
			<div class="col-lg-4">
				<input class="form-control" readonly type="text" name="country" placeholder="Country"/>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-lg-3 no-padding"></div>
			<div class="col-lg-9 birth-place-info"></div>
			<div class="clearfix"></div>
		</div>
		<input type="hidden" name="long_deg"/>
		<input type="hidden" name="long_min"/>
		<input type="hidden" name="ew"/>
		<input type="hidden" name="lat_deg"/>
		<input type="hidden" name="lat_min"/>
		<input type="hidden" name="ns"/>
		<input type="hidden" name="timezone"/>
