
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
                <table  id="lotto_table" class="table table-striped- table-bordered table-hover table-checkable job_table">
                    <thead>
                        <tr class="th" align="center">
                            <th style="width: 20px;">No</th>
                            <th>UserName</th>
                            <th>Title</th>
                            <th>date</th>
                            <!--<th>picks</th>-->
                            <th>price</th>
                            <th>Game Price</th>
                            <th>View Lottery Data</th>                            
                        </tr>
                    </thead>
                    <?php if(count($myLogs)!=0){ ?>
                        <?php 
                            $total_amount_tot = 0;
                            $path = ROOTPATH."adminpanel/";
                            $i =1; 
                        ?>
                        <tbody>                            
                            <?php
                                foreach($myLogs as $v){
                                    $username = $v.user_name;
                                    $title = $v.lotteryTitle;
                                    $date = $v.lotteryDate;
                                    $picks = $v.lotteryData;
                                    $price = $v.lotteryPrice;
                                    $gamePrice = $v.lotteryAllPrice;
                                                                
                                    $total_amount_tot = $total_amount_tot + $price;
                                    ?>
                                
                                <tr align="center" >
                                    <td><?=$i?></td> 
                                    <td><?=$username?></td>
                                    <td><?=$title?></td>
                                    <td><?=$date?></td>
                                    <!--<td>{$picks}</td>-->
                                    <td>$<?=$price?></td>
                                    <td><?=$gamePrice?></td>
                                    <td>
                                        <a class="btn-view btn btn-xs btn-link panel-config" href="#" data-toggle="modal" data-lottery-data="<?=$v.lotteryData?>" style='color:#C48189;'>View</a>
                                    </td>
                                </tr>
                                <?php
								$i = $i + 1;
                            }                           
                            ?>
                            
                            <tr class="total" align="center" >
                                <td><b></b></td>
                                <td><b></b></td>
                                <td><b></b></td>
                                <!--<td><b></b></td>-->
                                <td><b>Total</b></td>
                                <td><b>$<?=$total_amount_tot?></b></td>
                                <td><b></b></td>
                                <td><b></b></td>
                            </tr>
                        </tbody>
                        <?php
                    }else{
                    ?>
                        <h3>There is no any logs!</h3>
                    <?php } ?>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>