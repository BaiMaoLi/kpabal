

 <div class="container-fluid-wrapper">
<div class="container" style=" margin-top:20px;">
  <div class="row">
<h2 class="head_prodip">Add Your Blog</h2>
   <div class="wrapper-form">
   
		<div class="sucsss"><?php echo $this->session->flashdata('response'); ?></div>
        
          <form action="<?=site_url('Ourblogs/save_blog'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
          <fieldset>
           
     
            <!-- Name input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="Product Name">Blog Title<span>*</span></label>
              <div class="col-md-9">
                <input id="prodcut" name="title" required type="text"  class="form-control">
              </div>
            </div>
                     
            <div class="form-group Long-description">
              <label class="col-md-3 control-label" for="Short">Blog description*</label>
              <div class="col-md-9">
                <textarea class="form-control" required id="editor1" name="content" rows="5"></textarea>
              </div> 
            </div>
           
           
           
            <div class="form-group">
              <label class="col-md-3 control-label" for="Communication">Feature Image Upload<span>*</span> </label>
              <div class="col-md-9">
                <div class="choose_file"><span>Choose Image </span>
            <input type="file" name="image" required>
          </div>
              </div>
            </div>
               
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg customcss">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
       
     
   </div>
  
    
  
  </div>
  
  
    
    
    
    
    
    </div>
  </div>
  
  <script src="http://kpabal.com/CI/tinymce/tinymce.min.js" type="text/javascript"></script>
<script>
   tinymce.init({
     selector: '#editor1',
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