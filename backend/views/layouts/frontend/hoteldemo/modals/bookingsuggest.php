<!-- line modal -->
<div class="modal fade" id="bookingsuggest" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel">Suggested Rooms for this day</h3>
		</div>
		<div class="modal-body">
			<table class="table tbl-fix bodytable table-hover">
				<thead>
				<tr>
					<th class="col-min aimslabel">Options</th>
					<th class="col-min aimslabel">Date</th>
					<th class="col-description aimslabel">Room Type</th>
					<th class="col-currency aimslabel">Rate</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td class="col-min aimslabel">
							<button id="stockvoid" class="stockvoidbtn btn btn-primary" style="width:60px;height:18px;">
								<span style="font-size:12px;margin-top:-10px;font-weight:bold;">Void</span>
							</button>
						</td>
						<td class="col-min aimslabel">2017-12-01</td>
						<td class="col-description aimslabel">Batcave of Seduction</td>
						<td class="col-currency aimslabel">69.00</td>
					</tr>
					<tr>
						<td class="col-min aimslabel">options</td>
						<td class="col-min aimslabel">2017-12-01</td>
						<td class="col-description aimslabel">Batcave of Seduction</td>
						<td class="col-currency aimslabel">69.00</td>
					</tr>
					<tr>
						<td class="col-min aimslabel">options</td>
						<td class="col-min aimslabel">2017-12-01</td>
						<td class="col-description aimslabel">Batcave of Seduction</td>
						<td class="col-currency aimslabel">69.00</td>
					</tr>
					<tr>
						<td class="col-min aimslabel">options</td>
						<td class="col-min aimslabel">2017-12-01</td>
						<td class="col-description aimslabel">Batcave of Seduction</td>
						<td class="col-currency aimslabel">69.00</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
				</div>
				<div class="btn-group btn-delete hidden" role="group">
					<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
				</div>
				<div class="btn-group" role="group">
					<button type="button" id="saveImage" class="btn btn-default btn-hover-green" data-action="save" role="button">Save</button>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>