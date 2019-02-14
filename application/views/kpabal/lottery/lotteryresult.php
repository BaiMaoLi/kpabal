
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?=$log_title?></h3>
            </div>
        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">

                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table id="lotto_table" class="table table-striped- table-bordered table-hover table-checkable job_table">
                    <thead>
                        <tr class="th" align="center">
                            <th style="width: 20px;">No</th>                           
                            <th>Title</th>
                            <th>date</th>
                            <th>picks</th>                                                                                   
                        </tr>
                    </thead>
                    <?php if(count($myLogs)!=0){ ?>                                               
                        <tbody>                            
                            <?php
                                $counter=1;
                            foreach($myLogs as $v){                                
                                $title=$v['game_name'];
                                $date=$v['result_date'];
                                $picks=$v.['result'];
                                ?>
                                <tr align="center" >
                                    <td><?=$counter?></td>                                    
                                    <td><?=$title?></td>
                                    <td><?=$date?></td>
                                    <td>
                                        <ul class="draw-result">                                            
                                            <?php foreach($picks as $item_cell){ ?>
                                                <li><?=$item_cell?></li>                                                
                                            <?php } ?>
                                        </ul>                                            
                                    </td>                                    
                                </tr>
                            <?php 
                            $counter++; 
                            } ?>
                        </tbody>
                    <?php }else{ ?>
                        <h3>There is no any logs!</h3>
                   <?php } ?>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

 