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
                [ 4, "desc" ]
            ],

            columnDefs: [
        {
          targets: 1,
          orderable: false,
          render: function(data, type, full, meta) {
            return `
                        <img src="`+data+`" style="height: 40px;">`;
          },
        },
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
                                <a class="dropdown-item" href="#" onclick="registerReply(`+data+`);"><i class="la la-edit"></i> Reply</a>
                                <a class="dropdown-item" href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/reply_list/`+data+`"><i class="la la-leaf"></i> Manage Replies</a>
                                <a class="dropdown-item" href="#" onclick="removeArticle('`+data+`');"><i class="la la-remove"></i> Remove article</a>
                            </div>
                        </span>
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                          <i class="la la-edit"></i>
                        </a>
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="attach_record('`+data+`');"><i class="la la-image" title="Attach Image"></i>
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
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/reply", $("#reply_article_form").serialize(), function(data){
            $("#reply_content").prop("value", "");
            $("#replyArticleAppModal").modal('hide'); 
            toastr.info("Reply registered");
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
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/list_article", { category: "<?=$categoryIdx?>" }, function(data){
        board_data_table.api().clear();
        board_data_table.api().rows.add( JSON.parse(data) ).draw();
    });
}

function removeArticle(__id) {
  if(confirm("Are you sure remove this reply?")) { 
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/remove_article", { articleIdx: __id }, function(data){
        ReloadDataTable();
    });   
  }
}

function registerReply(__id) {
    $("#articleIdx").prop("value", __id);
    
    $("#replyArticleAppModal").modal('show');
}

var attach_record_idx;

function attach_record(record_idx) {
    attach_record_idx = record_idx;
    $("#upload_attach").click();
}

transferComplete = function(e) {
    window.location.reload(true);
}

$("#upload_attach").change(function(event){
    var file = event.target.files[0];       
    var data = new FormData();
    data.append("uploadedFile", file);
    var objXhr = new XMLHttpRequest();
    objXhr.addEventListener("load", transferComplete, false);
    objXhr.open("POST", "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/boards/upload_attach/" + attach_record_idx);
    objXhr.send(data);
});

</script>