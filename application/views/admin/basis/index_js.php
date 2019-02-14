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
            <?php if(isset($order_num)){ ?>
            order: [
                [ <?=$order_num?>, "asc" ]
            ],
            <?php }?>
            columnDefs: [<?php if(($tbl_name == "site_contents") || ($tbl_name == "news")):?>
                {
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return `
                            <img src="<?=ROOTPATH?><?=PROJECT_MEDIA_DIR?>/<?=$tbl_name?>_`+full[full.length - 1]+`.jpg" alt="`+data+`" style="height: 60px;">
                            `;
                    },
                },<?php endif?>
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="edit_record('`+data+`');"><i class="la la-edit" title="Edit Record"></i>
                            </a>
                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="remove_record('`+data+`');"><i class="la la-remove" title="Remove Record"></i>
                            </a>
                            <?php if(($tbl_name == "site_contents") || ($tbl_name == "news")):?>
                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" onclick="attach_record('`+data+`');"><i class="la la-image" title="Attach Image"></i>
                            </a>
                            <?php endif?>
                            `;
                    },
                },
            <?php 
            $target = -1;
            foreach($columns as $column_arr) {
            foreach($column_arr as $column) {
                if($column["type"] == "hidden") continue;
                if($column["type"] == "textarea") continue;
                if($column["type"] == "contents") continue;
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
            ]
        };

        table.dataTable(settings);

        $("#categories").select2({
            placeholder: "Select a category"
        });

        $('#show-modal').click(function() {
            $('#<?=$pri_fld?>').prop("value", "");
            category_form.reset();
            <?php foreach($columns as $column_arr) {
            foreach($column_arr as $column) {
              $column_name = $column["name"];
              if($column["type"] == "contents") { ?>
            $('#<?=$column_name?>').summernote("code", "");
            <?php } } }?>
            $('#addNewAppModal').modal('show');
        });

        $('#add-category').click(function() {
            if(check_validate()) return false;
            var category_form = $("#category_form").serialize();
            $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/basis/save/<?=$tbl_name?>/<?=$categoryIdx?>", category_form, function(data){
                window.location.reload(true);
            });
        });
    }

    initTableWithDynamicRows();
    $(".summernote").summernote({height: 200});

    <?php if(isset($categories_data)){ ?>
    $("#categories").change(function(){
        if($("#categories").prop("value") && $("#categories").prop("value") != "00")
            window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/basis/<?=$tbl_name?>/" + $("#categories").prop("value");
        else
            window.location.href = "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/basis/<?=$tbl_name?>";
    });
    <?php }?>

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
            if($column["type"] == "contents") { ?>
        $('#<?=$column_name?>').prop("value", $('#<?=$column_name?>').summernote("code"));
        if(!($('#<?=$column_name?>').summernote("code"))) {
            toastr.error("<?=$column["caption"]?> can't be empty'!");
            $('#<?=$column_name?>').parent().find(".note-editable").focus();
            return true;
        }
    <?php } else { ?>
        if(!($('#<?=$column_name?>').prop("value"))) {
            toastr.error("<?=$column["caption"]?> can't be empty'!");
            $('#<?=$column_name?>').focus();
            return true;
        }
    <?php } } } } ?>
    return false;
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
    objXhr.open("POST", "<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/basis/upload_attach/<?=$tbl_name?>/" + attach_record_idx);
    objXhr.send(data);
});

function remove_record(record_idx) {
    if(confirm("Are you sure to remove record ?")) {
        $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/basis/remove/<?=$tbl_name?>", {record_idx: record_idx}, function(data){
            window.location.reload(true);
        });
    }
}

function edit_record(record_idx) {
    $.post("<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/basis/get/<?=$tbl_name?>", {record_idx: record_idx}, function(data){
        record = JSON.parse(data);
        <?php foreach($columns as $column_arr) {
        foreach($column_arr as $column) {
          $column_name = $column["name"];
          if($column["type"] == "onoff") {
        ?>
        if(record.<?=$column_name?> == 1) $('#<?=$column_name?>').prop("checked", true);
        else $('#<?=$column_name?>').prop("checked", false);
        <?php } else if($column["type"] == "contents") { ?>
        $('#<?=$column_name?>').summernote("code", record.<?=$column_name?>);
        <?php } else { ?>
        $('#<?=$column_name?>').prop("value", record.<?=$column_name?>);
        <?php  } } }?>
        $('#addNewAppModal').modal('show');
    });
}
</script>