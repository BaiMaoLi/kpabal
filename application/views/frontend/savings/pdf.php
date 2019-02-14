<?php
$html='<style>
    .item {
        margin: 10px;
    }
    .products{
        width:100%;
        padding: 10px;;
    }
    #header, #footer{
        display:none;
    }
</style>
<section id="content">
    <div class="content-wrap" style="padding-top: 10px;">
        <div class="container clearfix">
            <div class="row product_container">';
                foreach ($categories as $category) {

                    $html.='<div class="products" id="cat_'.$category['id'].'">';

                        foreach ($categoryData[$category['id']] as $data){
                            $html.='
                            <span class="item" style="float: left;">
                                <img src="'.ROOTPATH.$data['logo'].'" style="height: 200px;width:auto;"/>
                            </span>';
                        }
                    $html.='</div>';
                }
$html.='</div>
        </div>
    </div>
</section>
';
ob_start();
require_once(dirname(__FILE__)."/../../../../mpdf/mpdf.php");
$mpdf=new mPDF('utf-8','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

$mpdf->WriteHTML($html);
$mpdf->Output();
?>