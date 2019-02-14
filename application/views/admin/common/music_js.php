<script>

    $(document).ready(function() {
         $('#table_data').DataTable({
            "responsive": true,
            "pageLength" : 5,
            "ajax": {
                url : "<?=base_url()?>admin_video/music_pageData",
                type : 'GET'
            },
        });

    });
        
</script>