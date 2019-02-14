<script type="text/javascript">
    var product_data_table;

    (function($) {

        // Initialize datatable with ability to add rows dynamically
        var initTableWithDynamicRows = function() {
            var table = $('.table');

            var settings = {
                responsive: true,

                lengthMenu: [5, 10, 25, 50],

                pageLength: 10,

                language: {
                    'lengthMenu': 'Display _MENU_',
                },

            };

            product_data_table = table.dataTable(settings);
        }

        initTableWithDynamicRows();

    })(window.jQuery);

</script>