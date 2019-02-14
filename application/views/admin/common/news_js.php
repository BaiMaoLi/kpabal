<script>

            $(document).ready(function() {
            // alert('data');
                var product_data_table;
                 $('#table_data').DataTable({
                    "responsive": true,
                    "pageLength" : 5,
                    "ajax": {
                        url : "<?=base_url()?>admin_video/news_pageData",
                        type : 'GET'
                    },
                });
        
            });
        
</script>