<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<div class="row">
		<div class="col-xl-6">
			<h1>Reportes</h1>
			<!-- <div class="bar_chart">
			</div> -->
			<div id="locationField">
				<input id="autocomplete" class="form-control" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
			</div>

			<table id="address" class="table table-bordered">
				<tr>
					<td class="label">Street address</td>
					<td class="slimField"><input class="field" id="street_number"
								disabled="true"></input></td>
					<td class="wideField" colspan="2"><input class="field" id="route"
								disabled="true"></input></td>
				</tr>
				<tr>
					<td class="label">City</td>
					<!-- Note: Selection of address components in this example is typical.
							You may need to adjust it for the locations relevant to your app. See
							https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
					-->
					<td class="wideField" colspan="3"><input class="field" id="locality"
								disabled="true"></input></td>
				</tr>
				<tr>
					<td class="label">State</td>
					<td class="slimField"><input class="field"
								id="administrative_area_level_1" disabled="true"></input></td>
					<td class="label">Zip code</td>
					<td class="wideField"><input class="field" id="postal_code"
								disabled="true"></input></td>
				</tr>
				<tr>
					<td class="label">Country</td>
					<td class="wideField" colspan="3"><input class="field"
								id="country" disabled="true"></input></td>
				</tr>
			</table>

		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES . 'footer.php' ?>