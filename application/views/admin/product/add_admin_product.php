<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?=ROOTPATH?>tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?=ROOTPATH?>tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
   <!-- BEGIN: Subheader -->
   <div class="m-subheader ">
      <div class="d-flex align-items-center">
         <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">New Product</h3>
         </div>
      </div>
   </div>
   <!-- END: Subheader -->
   <div class="m-content">
      <!--begin::Portlet-->
      <div class="m-portlet">
         <!--begin::Form-->
         <form action="../add_new_admin_product" method="post" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data">
           
            <div class="m-portlet__body">
               <div class="form-group m-form__group row">
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">Product Name *</label>
                     <input type="text" class="form-control m-input" name="product_name" required placeholder="Enter product name" value="">
                  </div>
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">Price *</label>
                     <input type="text" class="form-control m-input" name="price" required placeholder="Enter price" value="">
                  </div>
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">sku </label>
                     <input type="text" class="form-control m-input" name="product_Sku" placeholder="Enter Sku" value="">
                  </div>
                  <div class="col-md-3 m-form__group-sub form-group m-form__group">
                     <label class="form-control-label">Product type *</label>							
                     <select class="form-control m-input" required name="product_type">
                        <option value="">--Select Product Type--</option>
                        <option value="used">Used</option>
                        <option value="new">New</option>
                     </select>
                  </div>
				  
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">user type *</label>						
                     <select class="form-control m-input" required name="user_type">
                        <option value="">--Select User Type--</option>
                        <option value="By Admin">By Admin</option>
                        <option value="free">Free</option>
                        <option value="premium">Premium</option>
                     </select>
                  </div>
				  
				
				  
				  
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">user email *</label>
                     <input type="text" class="form-control m-input" name="user_email" required placeholder="Enter User Email" value="">
                  </div>
                  <div class="col-md-3 m-form__group-sub form-group m-form__group ">
                     <label class="form-control-label">address *</label>
                     <textarea required="" cols="37" rows="2" name="Address"></textarea>
                  </div>
              
				  
					<div class="form-group m-form__group row col-md-5">
					<div class="col-md-12 m-form__group-sub"> <label class="form-control-label">Product Short Desc *</label> <textarea class="form-control" style="height: 100px;" name="product_Short" required ></textarea> </div>
					</div>
				  		
				  
					<div class="form-group m-form__group row col-md-7 form-group m-form__group">
					<div class="col-md-12 m-form__group-sub"> <label class="form-control-label">Product long Desc *</label> <textarea class="form-control" style="height: 100px;" name="product_Long" required ></textarea> </div>
					</div>
				  
				  
                  <div class="col-md-6 m-form__group-sub">
                     <label class="form-control-label">city *</label>
                     <select class="form-control m-input" name="user_city" required>
                        <option value="">--Select City--</option>
                        <?php 
                           foreach($get_product_city as $city){?>
                        <option value="<?php echo $city->city_name;?>"><?php echo $city->city_name;?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">state *</label>
                     <select class="form-control m-input" name="user_state" required>
                        <option value="">--Select State--</option>
                        <?php 
                           foreach($states as $statesname){?>
                        <option value="<?php echo $statesname->stateCode;?>"><?php echo $statesname->stateName;?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-3 m-form__group-sub form-group m-form__group ">
                     <label class="form-control-label">country *</label>
                     <select class="form-control m-input" name="user_country" required>
                        <option value="">--Select Country--</option>
                        <?php foreach($get_product_country as $country){?>
                        <option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">Category *</label>
                     <select class="form-control m-input" name="product_categorys" required>
                        <option value="">Select</option>
                        <?php foreach($categories as $category) { ?>
                        <option value="<?=$category->categoryIdx?>"><?=$category->categoryName?></option>
                        <?php  } ?>
                     </select>
                  </div>
                  <div class="col-md-3 m-form__group-sub">
                     <label class="form-control-label">Sub Category</label>
                     <select class="form-control m-input" name="product_categorys" required>
                        <option value="">Select</option>
                        <?php foreach($categories as $category) { 
                           foreach($category->children as $sub_category) { ?>
                        <option value="<?=$sub_category->categoryIdx?>"><?=$sub_category->categoryName?></option>
                        <?php } } ?>
                     </select>
                  </div>
				  
				     <div class="form-group m-form__group row col-md-3">
                  <div class="m-form__group-sub">
                     <label class="form-control-label">Product Feature Image</label>
                     <input type="file" name="product_image_url" accept=".gif,.jpg,.jpeg,.png">
                  </div>
               </div>
               <div class="form-group m-form__group row col-md-3">
                  <div class="m-form__group-sub">
                     <label class="form-control-label">Product gallary Images</label>
                     <input type="file" name="userfile[]" accept=".gif,.jpg,.jpeg,.png" multiple="">
                  </div>
               </div>
				  
               </div>
            
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
               <div class="m-form__actions m-form__actions">
                  <div class="row">
                     <div class="col-lg-9 ml-lg-auto">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products" class="btn btn-secondary">Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
      <!--end::Portlet-->
   </div>
</div>
<script>
   tinymce.init({
     selector: '#product_long_desc',
       plugins: [
           "advlist autolink lists link image charmap print preview anchor",
           "searchreplace visualblocks code fullscreen",
           "insertdatetime media table contextmenu paste imagetools wordcount"
       ],
       toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | table",
     // enable title field in the Image dialog
     image_title: true, 
     // enable automatic uploads of images represented by blob or data URIs
     automatic_uploads: true,
     // add custom filepicker only to Image dialog
     file_picker_types: 'image',
     file_picker_callback: function(cb, value, meta) {
       var input = document.createElement('input');
       input.setAttribute('type', 'file');
       input.setAttribute('accept', 'image/*');
   
       input.onchange = function() {
         var file = this.files[0];
         var reader = new FileReader();
         
         reader.onload = function () {
           var id = 'blobid' + (new Date()).getTime();
           var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
           var base64 = reader.result.split(',')[1];
           var blobInfo = blobCache.create(id, file, base64);
           blobCache.add(blobInfo);
   
           // call the callback and populate the Title field with the file name
           cb(blobInfo.blobUri(), { title: file.name });
         };
         reader.readAsDataURL(file);
       };
       
       input.click();
     }
   });
</script>