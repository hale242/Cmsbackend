<div class="card-body">
    <div class="table-responsive">
        <table id="Provinces" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Provinces Name</th>
                    <th>Provinces Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($provinces as $val_provinces) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>{{ $val_provinces->provinces_name }}</td>
                        <td>{{ $val_provinces->provinces_code }}</td>
                        <td><button type="button" name="Amphures" id="{{ $val_provinces->provinces_id }}"class="btn-amphures btn btn-info">Amphures</button></td>
                    </tr>
                    <?php $i++; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <script>
	$(function() {
            var table = $('#Provinces').DataTable();
    });
</script> -->