<table>
	<tr>
		<td>Card Type :</td>
		<td>
			<select name="cc_type" id="cc_type">
				<option value="Visa">Visa</option>
				<option value="MasterCard">MasterCard</option>
				<option value="Amex">Amex</option>
				<option value="Maestro">Maestro</option>
				<option value="Solo">Solo</option>
				<option value="Discover">Discover</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Card Number :</td>
		<td>
			<input type="text" style="" value="4111111111111111" name="cc_num" id="cc_num">
		</td>
	</tr>
	<tr>
		<td>CVV Code :</td>
		<td>
			<input type="text" style="" value="123" name="cc_cvv" id="cc_cvv">
		</td>
	</tr>
	<tr>
		<td>Valid from :</td>
		<td>
			<select name="cc_valid_month" id="cc_valid_month">
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select>
			<select name="cc_valid_year" id="cc_valid_year">
				<option value="2001">2001</option>
				<option value="2002">2002</option>
				<option value="2003">2003</option>
				<option value="2004">2004</option>
				<option value="2005">2005</option>
				<option value="2006">2006</option>
				<option value="2007">2007</option>
				<option value="2008">2008</option>
				<option value="2009">2009</option>
				<option value="2010">2010</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Expiration Date :</td>
		<td>
			<select name="cc_exp_month" id="cc_exp_month">
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select> <select name="cc_exp_year" id="cc_exp_year">
				<option value="2010">2010</option>
				<option value="2011">2011</option>
				<option value="2012">2012</option>
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
				<option value="2016">2016</option>
				<option value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>IssueNumber :</td>
		<td>
			<input type="text" style="" value="aaa" name="cc_issue" id="cc_issue">
		</td>
	</tr>
</table>
<hr>
			Your Billing Address
<hr>
<table>
	<tr>
		<td>First Name :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="aaaa" name="billing_firstname" id="billing_firstname">
		</td>
	</tr>
	<tr>
		<td>Last Name :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="bbb" name="billing_lastname" id="billing_lastname">
		</td>
	</tr>
	<tr>
		<td>Address :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="asdfasdf" id="billing_address" name="billing_address">
		</td>
	</tr>
	<tr>
		<td>City :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="asdfsdafsadf" id="billing_city" name="billing_city">
		</td>
	</tr>
	<tr>
		<td>State :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="saaa" id="billing_state" name="billing_state">
		</td>
	</tr>
	<tr>
		<td>Country :</td>
		<td>
			<select class="allSelect" name="billing_country" id="billing_country">
				<option temp="2" value="US">UNITED STATES</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Zip code :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="aaa" id="billing_zip" name="billing_zip">
		</td>
	</tr>
	<tr>
		<td>Phone :</td>
		<td>
			<input type="text" class="allInput" maxlength="250" value="111" id="billing_phone" name="billing_phone">
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="SUBMIT" /></td>
	</tr>
</table>