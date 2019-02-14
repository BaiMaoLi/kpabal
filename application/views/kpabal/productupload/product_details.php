 <div class="container-fluid-wrapper">
<div class="container" style=" margin-top:20px;">
  <div class="row">

  <div class="col-md-6">
  <div class="products-images-wrapper"><img src="<?php echo site_url();?><?php echo $product_details->product_image_url;?>"  class="img-fluid" alt=""></div>
  
  
  </div>
  
  
  <div class="col-md-6">
  
  
  <div class="products-detail-wrapper">
  <h3><?php echo $product_details->product_name;?> </h3>
  
  <div class="products-price"> $<?php echo $product_details->price;?></div>
  <span class="sksu">Sku : </span><div class="products-sku-code"><?php echo $product_details->product_Sku;?></div>
  <div class="products-used-code"><?php echo $product_details->product_type;?></div>
  
  <div class="short-description"><p><?php echo $product_details->product_Short;?></p></div>
 
  
  
  <div class="tabs-wrapper">
  
  
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Product Description</a></li>
 
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
    
      <p><?php echo $product_details->product_Long;?></p>
    </div>
    
    
  </div>
   
 
 
 
 
 
 
 
</div>


 <div class="contact-wrapper">
 
 
 <div class="admin"><img src="<?php echo site_url();?>/assets/images/admin.png"  class="img-fluid" alt=""><span>Contact Us</span></div>
 
 
 
 <div class="contact-btn">
 <a href="#" class="contact" data-toggle="modal" data-target="#messageModal" data_author_email="<?=$details['email']?>"><strong>Contact</strong></a>
<div id="messageModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="margin-top: 20vh;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4>문의하기</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <form action="<?=ROOTPATH?>housing/author/1" method="post">
                        <div class="col-sm-12" style="padding-bottom: 10px;">
                            <input name="contact_name" id="agent_contact_name" type="text" placeholder="이름" required class="form-control">
                        </div>
                        <div class="col-sm-12" style="padding-bottom: 10px;">
                            <input type="text" name="email" class="form-control" id="agent_user_email" placeholder="이메일" required>
                        </div>
                        <div class="col-sm-12" style="padding-bottom: 10px;">
                            <input type="text" name="phone" class="form-control" id="agent_phone" placeholder="핸드폰 번호">
                        </div>
                        <div class="col-sm-12" style="padding-bottom: 10px;">
                            <textarea id="message_content" name="message_content" class="form-control" cols="45" rows="8" placeholder="나의 메세지" required></textarea>
                        </div>
                        <div class="col-sm-12" style="padding-bottom: 10px;">
                            <input type="hidden" name="author_email" id="author_email" value="<?=$member->user_email?>">
                            <button class="btn btn-primary" id="captcha-send-message">메세지 전송</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
  
</div>
 
 
 
 
 
 </div>


  

  </div>
  
  
  
  
  
  
  </div>
  
  
  </div>
  
  
    
    
    
    
    
    </div>
  </div>
