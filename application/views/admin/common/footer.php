            </div>
            <!-- end:: Body -->
        </div>
        <!-- end:: Page -->

        <!--begin::Base Scripts -->
        <script src="<?=ADMIN_ASSETS_DIR?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="<?=ADMIN_ASSETS_DIR?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
        <!--end::Base Scripts -->

        <!--begin::Page Snippets -->
        <?php 
          if(isset($additional_js)):
            foreach($additional_js as $js) {
        ?>
        <script src="<?=ADMIN_ASSETS_DIR?><?=$js?>" type="text/javascript"></script>
        <?php } endif ?>
        <!--end::Page Snippets -->
       
    </body>
    
    <!-- end::Body -->
</html>