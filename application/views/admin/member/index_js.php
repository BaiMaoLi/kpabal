<script type="text/javascript">
var member_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#member_table');

        var settings = {
            responsive: true,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 6, "desc" ]
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
                                <a class="dropdown-item" href="#" onclick="editMemberStatus(`+data+`, `+full[7]+`);"><i class="la la-leaf"></i> Update Status</a>
                                <a class="dropdown-item" href="#" onclick="resetMemberPassword(`+data+`);"><i class="la la-lock"></i> Reset Password</a>
                            </div>
                        </span>
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                          <i class="la la-edit"></i>
                        </a>`;
					},
				},
                {
                    targets: -2,
                    render: function(data, type, full, meta) {
                        var status = {
                            0: {'title': 'User', 'class': 'm-badge--success'},
                            1: {'title': 'Manager', 'class': ' m-badge--danger'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
                {
                    targets: -3,
                    render: function(data, type, full, meta) {
                        var status = {
							0: {'title': 'Pending', 'class': 'm-badge--info'},
							1: {'title': 'Normal', 'class': ' m-badge--success'},
							2: {'title': 'Prepared', 'class': 'm-badge--primary'},
							3: {'title': 'Locked', 'class': 'm-badge--warning'},
							4: {'title': 'Blocked', 'class': ' m-badge--danger'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
			],
        };

        member_data_table = table.dataTable(settings);
    }

    initTableWithDynamicRows();

    $("#edit-member-status").click(function(){
    	$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/save", {"memberIdx": $("#memberIdx").prop("value"), "member_status": $("#member_status").prop("value")}, function(data){
    		toastr.success("Member Status has been updated");
            ReloadDataTable();
			$("#editStatusAppModal").modal('hide');
    	});
    });

    $("#reset-member-password").click(function(){
    	if($("#new-password").prop("value") != $("#new-password2").prop("value")) {
    		toastr.error("Please enter Passwords correctly.");
    		return false;
    	}
    	if($("#new-password").prop("value") == "") {
    		toastr.error("Please enter new Password");
    		$("#new-password").focus();
    		return false;
    	}
    	var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    	if(!(strongRegex.test($("#new-password").prop("value")))) {
    		toastr.error("Password strength is weak. Password must be eight characters or longer, and contain at least one lowercase & uppercase alphabetical character, numeric, special character.");
    		$("#new-password").focus();
    		return false;
    	}
    	$.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/save", {"memberIdx": $("#reset-memberIdx").prop("value"), "user_password": $("#new-password").prop("value")}, function(data){
    		toastr.success("Member Password has been reset");
			$("#resetPasswordAppModal").modal('hide');
    	});
    });

})(window.jQuery);

function ReloadDataTable()
{
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/list", {}, function(data){
        member_data_table.api().clear();
        member_data_table.api().rows.add( JSON.parse(data) ).draw();
    });
}

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

function editMemberStatus(__memberIdx, __memberStatus) {
	$("#memberIdx").prop("value", __memberIdx);
	$("#member_status").prop("value", __memberStatus);
	
	$("#editStatusAppModal").modal('show');
}

function resetMemberPassword(__memberIdx) {
	$("#reset-memberIdx").prop("value", __memberIdx);
	$("#resetPasswordAppModal").modal('show');
}

</script>