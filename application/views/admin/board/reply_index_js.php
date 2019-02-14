<script type="text/javascript">
var board_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#board_table');

        var settings = {
            responsive: true,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 2, "desc" ]
            ],

            columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
						return `
                        <span class="dropdown">
                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" onclick="registerReply('`+data+`');"><i class="la la-edit"></i> Reply to reply</a>
                                <a class="dropdown-item" href="#" onclick="removeReply('`+data+`');"><i class="la la-remove"></i> Remove reply</a>
                            </div>
                        </span>
                        <a href="#" onclick="updateReply('`+data+`');" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                          <i class="la la-edit"></i>
                        </a>`;
					},
				},
			],
        };

        board_data_table = table.dataTable(settings);
    }

    initTableWithDynamicRows();

    $("#save-reply-article").click(function(){
        if(!($("#reply_content").prop("value"))) {
            $("#reply_content").focus();
            return false;
        }
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/reply_reply", $("#reply_article_form").serialize(), function(data){
            $("#reply_content").prop("value", "");
            $("#parent_id").prop("value", "");
            $("#replyArticleAppModal").modal('hide'); 
            toastr.info("Reply registered");
            ReloadDataTable();
        });
    });

    $("#update-reply-article").click(function(){
        if(!($("#reply_content2").prop("value"))) {
            $("#reply_content2").focus();
            return false;
        }
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/update_reply", $("#update_article_form").serialize(), function(data){
            $("#reply_content2").prop("value", "");
            $("#id").prop("value", "");
            $("#updateArticleAppModal").modal('hide'); 
            toastr.info("Reply updated");
            ReloadDataTable();
        });
    });

})(window.jQuery);

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

function ReloadDataTable()
{
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/list_reply", { articleIdx: "<?=$articleIdx?>" }, function(data){
        board_data_table.api().clear();
        board_data_table.api().rows.add( JSON.parse(data) ).draw();
    });
}

function removeReply(__id) {
  if(confirm("Are you sure remove this reply?")) { 
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/remove_reply", { articleIdx: "<?=$articleIdx?>", id: __id }, function(data){
        ReloadDataTable();
    });   
  }
}

function registerReply(__id) {
    $("#parent_id").prop("value", __id);
    
    $("#replyArticleAppModal").modal('show');
}

function updateReply(__id) {
    $("#id").prop("value", __id);
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/get_reply", { articleIdx: "<?=$articleIdx?>", id: __id }, function(data){
        $("#reply_content2").prop("value", data);
        $("#updateArticleAppModal").modal('show');
    });
}

</script>