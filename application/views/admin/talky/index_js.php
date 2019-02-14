<script type="text/javascript">
    var talky_data_table;

    (function($) {

        // Initialize datatable with ability to add rows dynamically
        var initTableWithDynamicRows = function() {
            var table = $('#talky_table');

            var settings = {
                responsive: true,

                lengthMenu: [5, 10, 25, 50],

                pageLength: 10,

                language: {
                    'lengthMenu': 'Display _MENU_',
                },

            };

            talky_data_table = table.dataTable(settings);
        }

        initTableWithDynamicRows();

    })(window.jQuery);

</script>