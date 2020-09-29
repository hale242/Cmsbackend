<div class="card-body">
    <div class="table-responsive">
        <table id="Amphures" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amphures Name</th>
                    <th>Amphures Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($amphures as $val_amphures) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>{{ $val_amphures->amphures_name }}</td>
                        <td>{{ $val_amphures->amphures_code }}</td>
                        <td><button type="button" name="Districts" id="{{ $val_amphures->amphures_id }}"class="btn-districts btn btn-info">Districts</button></td>
                    </tr>
                    <?php $i++; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <script>
   $(document).ready(function() {
		$('#Amphures').DataTable({
            "select": true,
			"dom": 'Bfrtip',
			"lengthMenu": [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			"columnDefs": [{
				// targets: 1,
				className: 'noVis',
				visible: false
			}],
			"buttons": [
				'pageLength',
				'colvis',
				{
					extend: 'copy',
					exportOptions: {
						columns: ':visible'
					},
				},
				{
					extend: 'csv',
					exportOptions: {
						columns: ':visible'
					},
				},
				{
					extend: 'excel',
					exportOptions: {
						columns: ':visible'
					},
				},
				{
					extend: 'print',
					exportOptions: {
						columns: ':visible'
					},
				},

				{
					extend: 'pdf',
					exportOptions: {
						columns: ':visible'
					},
				},
			],
        })
			
    });
</script> -->