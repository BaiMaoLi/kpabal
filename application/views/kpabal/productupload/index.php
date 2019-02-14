

 <div class="container-fluid-wrapper">
<div class="container" style=" margin-top:20px;">
  <div class="row">
<h2 class="head_prodip">Product Upload</h2>
   <div class="wrapper-form">
   
		<div class="sucsss"><?php echo $this->session->flashdata('response'); ?></div>
        
          <form action="<?=site_url('Productupload/get_data'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
          <fieldset>
           
     
            <!-- Name input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="Product Name">Product Name<span>*</span></label>
              <div class="col-md-9">
                <input id="prodcut" name="product_name" required type="text"  class="form-control">
              </div>
            </div>
    
            <!-- Email input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="Price">Price<span>*</span> </label>
              <div class="col-md-9">
                <input id="Price" name="price" required type="text"  class="form-control">
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-md-3 control-label" for="Sku">Sku<span>*</span> </label>
              <div class="col-md-9">
                <input id="Sku" name="product_Sku" required type="text"  class="form-control">
              </div>
            </div>
            
            
            <div class="form-group">
             <div class="form-group-tow">
              <label class="col-md-3 control-label" for="Sku">Product condition<span>*</span> </label>
              <div class="col-md-12">
              
              <select required name="product_type">
   <option value="">--Select Product Type--</option>
   <option value="used">Used</option>
  <option value="new">New</option>
</select>
                
                
                
              </div>
              
              
              
            <div class="col-md-12">
				<select required name="user_type">
				<option value="">--Select User Type--</option>
				<option value="free">Free</option>
				<option value="premium">Premium</option>
				</select>                
            
            </div>
            </div>
              
              
            </div>
            
			<div class="form-group">
            <div class="form-group-tow">
            
				<label class="col-md-3 control-label" for="category">Product Category<span>*</span> </label>
				<div class="col-md-12">
              
			 
			  
				<select required name="product_categorys">
					<option value="">Select</option>
								<?php foreach($categories as $category) { ?>
		                      <option value="<?=$category->categoryIdx?>"<?php if(($product) && ($product->category == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
		                      <?php foreach($category->children as $sub_category) { ?>
		                      <option value="<?=$sub_category->categoryIdx?>"<?php if(($product) && ($product->category == $sub_category->categoryIdx)) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
		                      <?php } } ?>
				</select>
                                          
				</div>
			
			
			</div>
			</div>
            
            
            <div class="form-group">
              <label class="col-md-3 control-label" for="Email">Email<span>*</span> </label>
              <div class="col-md-9">
                <input id="Email" name="user_email" type="email" required class="form-control">
              </div>
            </div>
            
            
            <!--div class="form-group">
              <label class="col-md-3 control-label" for="Communication">Communication<span>*</span> </label>
              <div class="col-md-9">
                <input id="Communication" name="Communication" type="text" required class="form-control">
              </div>
            </div-->
                        
    
            <!-- Message body -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="Address">Address*</label>
              <div class="col-md-9">
                <textarea class="form-control" required id="Address" name="Address" rows="5"></textarea>
              </div>
            </div>
            
            
			
				<div class="form-group">
				<div class="form-group-tow">
				<label class="col-md-3 control-label" for="Sku">Location Details<span>*</span> </label>
				
				<div class="col-md-9">
					<select required name="user_country">
						<option value="">Select Country</option>
						<option value="united state">United State</option>
						<option value="united kingdom">United Kingdom</option>
						<option value="india">India</option>
					</select>                
            
				</div>
				
				
				<div class="col-md-9">
              
				<select required name="user_state">
					<option value="">Select State</option>
					<option value="newyork">New York</option>
					<option value="sidney">Sidney</option>
					<option value="washigton">Washigton</option>
				</select>
                           
				</div>
              
              
              
				<div class="col-md-9">
					<select required name="user_city">
						<option value="">Select City</option>
						<option value="juneau">Juneau</option>
						<option value="phoenix">Phoenix</option>
						<option value="Sacramento">Sacramento</option>
					</select>                
            
				</div>
				
				
				</div>
              
               
				</div>
			
			
			
            
            <div class="form-group Short-Description">
				<label class="col-md-3 control-label" for="Short">Short Description*</label>
				<div class="col-md-9">
                <textarea class="form-control" required id="Short" name="product_Short" rows="5"></textarea>
				</div>
            </div>
            
            <div class="form-group Long-description">
              <label class="col-md-3 control-label" for="Short">Long description*</label>
              <div class="col-md-9">
                <textarea class="form-control" required id="Long" name="product_Long" rows="5"></textarea>
              </div> 
            </div>
           
           
           
            <div class="form-group">
              <label class="col-md-3 control-label" for="Communication">Image Upload<span>*</span> </label>
              <div class="col-md-9">
                <div class="choose_file"><span>Choose File </span>
            <input type="file" name="product_image_url" required>
          </div>
              </div>
            </div>
               
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
       
     
   </div>
  
    
  
  </div>
  
  
    
    
    
    
    
    </div>
  </div>