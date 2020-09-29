$(document).ready(function() {
	// App.init();
	$('.table-datatable').DataTable();

    $('.table-datatable-button').DataTable({
			
		// "pageLength": 10,
		// "scrollX": true,
		"select": true,
		"dom": 'Bfrtip',
		// "dom": 'lfrtip',
		"lengthMenu" : [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
		"columnDefs": [
			{
				// targets: 1,
				className: 'noVis',
				visible: false
			}
		],
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
	});


	
	$(".clear-search").on("click touch" , function (event) {
		
		$(".search_table_check").prop("checked", false);
		$(".search_table_select").prop('selectedIndex',0);
		$(".search_table").val("");
	});
	
	$(".checkbox-checkall").on("click touch" , function (event) {
		var modal = $(this);
		if(modal.data('checked')=="no"){
			$(".checkbox-table").prop("checked", true);
			$(".checkbox-checkall").data("checked", "yes");
		}else if(modal.data('checked')=="yes"){
			$(".checkbox-table").prop("checked", false);
			$(".checkbox-checkall").data("checked", "no");
		}
		
	});
	window.addEventListener('click', function() {
					// Fetch all the forms we want to apply custom Bootstrap validation styles to
					var forms = document.getElementsByClassName('needs-validation');
					// Loop over them and prevent submission
					var validation = Array.prototype.filter.call(forms, function(form) {
						form.addEventListener('submit', function(event) {
							if (form.checkValidity() === false) {
								event.preventDefault();
								event.stopPropagation();
							}
							form.classList.add('was-validated');
						}, false);
					});
				}, false);
});