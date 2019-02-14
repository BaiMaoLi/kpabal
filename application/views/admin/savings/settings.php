
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Savings</h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Settings</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <form method="post">
                    <table class="table table-striped- table-bordered table-hover table-checkable">
                        <tr>
                            <td style="width: 200px;">Google Maps API Key</td><td><input type="text" name="gmapi" class="form-control" value="<?=$gmapi?>" /> </td>
                        </tr>
                        <tr>
                            <td style="width: 200px;">Max Distance(mile)</td><td><input type="text" name="distance" class="form-control" value="<?=$distance?>" /> </td>
                        </tr>
                    </table>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>