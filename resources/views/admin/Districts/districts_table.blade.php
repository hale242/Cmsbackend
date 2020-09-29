<div class="card-body">
	<div class="table-responsive">
		<table id="Districts" class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Districts Name</th>
					<th>Districts Code</th>
					<th>Zipcode</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($districts as $val_districts) { ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>{{ $val_districts->districts_name }}</td>
						<td>{{ $val_districts->districts_code }}</td>
						<td>{{ $val_districts->zipcodes_name }}</td>
					</tr>
					<?php $i++; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<!-- <script>
		var tableDistricts = $('#Districts').dataTable({

	
	})
</script> -->
