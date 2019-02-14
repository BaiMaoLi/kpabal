<script type="text/javascript">
(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#tableWithDynamicRows');

        var settings = {
            responsive: true,
            //== DOM Layout settings
            dom: `<'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },
            order: [
                [ <?=$order_num?>, "asc" ]
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
                                <a class="dropdown-item" href="#" onclick="edit_record('`+data+`');"><i class="la la-edit"></i> Edit Record</a>
                                <a class="dropdown-item" href="#" onclick="remove_record('`+data+`');"><i class="la la-remove"></i> Remove Record</a>
                            </div>
                        </span>
                        <?php if($dispCaption_fld):?>
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/category/<?=$tbl_name?>/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Children">
                          <i class="la la-book"></i>
                        </a><?php endif ?>`;
                    },
                },
            <?php 
            $target = -1;
            foreach($columns as $column_arr) {
            foreach($column_arr as $column) {
                if($column["type"] == "hidden") continue;
                $target++;
                if($column["type"] == "onoff"):
            ?>
                {
                    targets: <?=$target?>,
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
            <?php endif; } } ?>
            <?php 
            $target = -1;
            foreach($columns as $column_arr) {
            foreach($column_arr as $column) {
                if($column["type"] == "hidden") continue;
                $target++;
                if($column["name"] == "menuIcon"):
            ?>
                {
                    targets: <?=$target?>,
                    title: 'Menu Icon',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '<i class="' + data + '"></i>';
                    },
                },
            <?php endif; } } ?>
            ]
        };

        table.dataTable(settings);

        $('#show-modal').click(function() {
            $('#<?=$pri_fld?>').prop("value", "");
            category_form.reset();
            $('#addNewAppModal').modal('show');
        });

        $('#add-category').click(function() {
            if(check_validate()) return false;
            var category_form = $("#category_form").serialize();
            $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/category/save/<?=$tbl_name?>/<?=$parentIdx?>", category_form, function(data){
                window.location.reload(true);
            });
        });
    }

    initTableWithDynamicRows();

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

function check_validate() {
    <?php foreach($columns as $column_arr) {
    foreach($column_arr as $column) {
        $column_name = $column["name"];
        if(isset($column["required"])) {
    ?>
        if(!($('#<?=$column_name?>').prop("value"))) {
            toastr.error("<?=$column["caption"]?> can't be empty'!");
            $('#<?=$column_name?>').focus();
            return true;
        }
    <?php } } } ?>
    return false;
}

function remove_record(record_idx) {
    if(confirm("Are you sure to remove record ?")) {
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/category/remove/<?=$tbl_name?>/<?=$parentIdx?>", {record_idx: record_idx}, function(data){
            window.location.reload(true);
        });
    }
}

function edit_record(record_idx) {
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/category/get/<?=$tbl_name?>/<?=$parentIdx?>", {record_idx: record_idx}, function(data){
        record = JSON.parse(data);
        <?php foreach($columns as $column_arr) {
        foreach($column_arr as $column) {
          $column_name = $column["name"];
          if($column["type"] == "onoff") {
        ?>
            if(record.<?=$column_name?> == 1) $('#<?=$column_name?>').prop("checked", record.<?=$column_name?>);
            else $('#<?=$column_name?>').prop("checked", false);
        <?php
          } else {
        ?>
        $('#<?=$column_name?>').prop("value", record.<?=$column_name?>);
        <?php  } } }?>
        $('#addNewAppModal').modal('show');
    });
}
</script>