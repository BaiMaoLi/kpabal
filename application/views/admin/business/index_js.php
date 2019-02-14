<script type="text/javascript">
var business_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#business_table');

        var settings = {
            serverSide: true,

            ajax: function ( data, callback, settings ) {
                jQuery.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/list_data/<?=$categoryIdx?>", {"order_id": data.order[0].column, "order_dir": data.order[0].dir, "limit": data.length, "offset": data.start, "search": data.search.value, "draw": data.draw}, function(response){
                    let records = JSON.parse(response);
                    var businesses = records.businesses;
                    var out = [];
                    for(let i=0; i<businesses.length; i++) {
                        out.push([
                            businesses[i].business_name_ko,
                            businesses[i].image_path,
                            businesses[i].email,
                            businesses[i].phone1,
                            businesses[i].fax,
                            businesses[i].stateCode,
                            businesses[i].categoryName,
                            businesses[i].is_display,
                            businesses[i].memberName,
                            businesses[i].regDate,
                            businesses[i].id,
                        ]);
                    }
                    callback( {
                        draw: records.draw,
                        data: out,
                        recordsTotal: records.total,
                        recordsFiltered: records.total
                    } );
                });
            },

            responsive: true,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 9, "desc" ]
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
                                <a class="dropdown-item" href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/edit_option/`+data+`"><i class="la la-leaf"></i> Edit Option</a>
                            </div>
                        </span>
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                          <i class="la la-edit"></i>
                        </a>
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="attach_record('`+data+`');"><i class="la la-image" title="Attach Image"></i>
                        </a>`;
					},
				},
                {
                    targets: -4,
                    render: function(data, type, full, meta) {
                        var status = {
                            0: {'title': 'Hide', 'class': ' m-badge--warning'},
                            1: {'title': 'Show', 'class': 'm-badge--success'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
			],
        };

        business_data_table = table.dataTable(settings);
    }

    initTableWithDynamicRows();

})(window.jQuery);

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
    objXhr.open("POST", "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/business/upload_attach/" + attach_record_idx);
    objXhr.send(data);
});

</script>