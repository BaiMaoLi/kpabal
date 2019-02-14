<script type="text/javascript">
var product_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#product_table');

        var settings = {
            responsive: true,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            // columnDefs: [
				// {
					// targets: -1,
					// title: 'Actions',
					// orderable: false,
					// render: function(data, type, full, meta) {
						// return;
					// },
				// },
			// ],
        };

        product_data_table = table.dataTable(settings);
    }

    initTableWithDynamicRows();

})(window.jQuery);

</script>