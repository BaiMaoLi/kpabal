<script type="text/javascript">
var merchants_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#merchants_table');

        var settings = {
            serverSide: true,

            ajax: function ( data, callback, settings ) {
                jQuery.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/merchants/list_data/<?=$categoryIdx?>", {"order_id": data.order[0].column, "order_dir": data.order[0].dir, "limit": data.length, "offset": data.start, "search": data.search.value, "draw": data.draw}, function(response){
                    let records = JSON.parse(response);
                    var merchants = records.merchants;
                    var out = [];
                    for(let i=0; i<merchants.length; i++) {
                        out.push([
                            merchants[i].cName,
                            merchants[i].nMerchantID,
                            merchants[i].image_path,
                            merchants[i].cashback,
                            merchants[i].is_selection,
                            merchants[i].nMerchantID,
                            merchants[i].orderNum,
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
                [ 4, "desc" ]
            ],

            columnDefs: [
                {
                  targets: 2,
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
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="toggle_selection('`+data+`', '`+full[6]+`', `+(full[4] == 1)+`);"><i class="la la-leaf" title="Toggle Selection"></i>
                        </a>
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="update_cashback('`+data+`', '`+full[3]+`');"><i class="la la-edit" title="Update CashBack"></i>
                        </a>`;
					},
				},
                {
                    targets: -2,
                    render: function(data, type, full, meta) {
                        var status = {
                            0: {'title': 'Off', 'class': ' m-badge--warning'},
                            1: {'title': 'On', 'class': 'm-badge--success'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="m-badge ' + status[data].class + ' m-badge--wide">' + status[data].title + '</span>';
                    },
                },
			],
        };

        merchants_data_table = table.dataTable(settings);

        $(".dataTables_filter input")
        .unbind()
        .bind("input", function(e) {
            if(this.value.length >= 3 || e.keyCode == 13) {
                merchants_data_table.api().search(this.value).draw();
            }
            if(this.value == "") {
                merchants_data_table.api().search("").draw();
            }
            return;
        });
    }

    initTableWithDynamicRows();

    $("#toggle-selection").click(function(){
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/merchants/selection_update/<?=$categoryIdx?>/" + $("#merchantID1").prop("value"), {"orderNum": $("#orderNum").prop("value"), "is_display": $("#is_display").prop("checked")}, function(data){
            merchants_data_table.api().search($(".dataTables_filter input").prop("value")).draw();
            jQuery("#toggleSelectionAppModal").modal('hide');
        });
    });

    $("#cashback-update").click(function(){
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/merchants/cashback_update/" + $("#merchantID2").prop("value"), {"cashback": $("#cashback").prop("value")}, function(data){
            merchants_data_table.api().search($(".dataTables_filter input").prop("value")).draw();
            jQuery("#cashbackAppModal").modal('hide');
        });
    });

})(window.jQuery);

function toggle_selection(nMerchantID, nOrderNum, n_is_display) {
    $("#merchantID1").prop("value", nMerchantID);
    $("#orderNum").prop("value", nOrderNum);
    $('#is_display').prop("checked", n_is_display);
    jQuery("#toggleSelectionAppModal").modal('show');
}

function update_cashback(nMerchantID, n_cashback) {
    $("#merchantID2").prop("value", nMerchantID);
    $("#cashback").prop("value", n_cashback);
    jQuery("#cashbackAppModal").modal('show');
}

</script>