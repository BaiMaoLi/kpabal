
<!-- Content
============================================= -->
<section id="content">

    <!-- <div class="content-wrap nopadding">

        <div class="section nopadding nomargin" 
        style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background-size: cover;"></div>

        <div class="section nobg full-screen nopadding nomargin">
            <div class="container-fluid vertical-middle divcenter clearfix">
                <div class="card divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                    <div class="card-body" style="padding: 40px;">
                        <form id="login-form" name="login-form" class="formGPE_login nobottommargin validate-form" method="post">
                            <h3>Login to your Account</h3>
                                <div class="alert alert-danger alert-dismissible fade display-none" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    <span class="msgContent"></span>
                                </div>
                            <div class="col_full">
                                <label for="user_id">Username:</label>
                                <input type="text" name="user_id" value="" class="form-control not-dark user_id" />
                            </div>

                            <div class="col_full">
                                <label for="user_password">Password:</label>
                                <input type="password" name="user_password" value="" class="form-control not-dark user_password" />
                            </div>

                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin login-form-submit" name="login-form-submit" value="login" type="button">Login</button>
                                <a href="<?php echo FRONTEND_USER_FORGOT_PASS_DIR;?>" class="fright">Forgot Password?</a>
                            </div>
                        </form>

                        <div class="line line-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="gpe_contents">
    <!--XE컨텐츠-->
        <div class="gpe_contents_xecon">
            <section class="xm">
                <div class="signin">
                    <div class="login-header">
                        <h1><i class="icon-user"></i> 로그인</h1>
                    </div>
                    <div class="login-body">
                        <div class="alert alert-danger alert-dismissible fade display-none" role="alert">
                            <span class="msgContent"></span>
                        </div>
                        <form method="post" id="login-form">
                            <fieldset>
                                <div class="control-group">
                                    <input type="text" class="form-control not-dark user_id" name="user_id" id="uid" required="" placeholder="아이디" title="아이디">
                                    <input type="password" class="form-control not-dark user_password" name="user_password" id="upw" required="" placeholder="비밀번호" title="비밀번호">
                                </div>
                                <div class="control-group">
                                    <label for="keepid_opt">
                                        <input type="checkbox" name="keep_signed" id="keepid_opt" value="Y">
                                        로그인 유지					
                                    </label>
                                    <div id="warning" style="display: none;">
                                        <p>브라우저를 닫더라도 로그인이 계속 유지될 수 있습니다. 로그인 유지 기능을 사용할 경우 다음 접속부터는 로그인할 필요가 없습니다. 단, 게임방, 학교 등 공공장소에서 이용 시 개인정보가 유출될 수 있으니 꼭 로그아웃을 해주세요.</p>
                                    </div>
                                    <input type="button" value="로그인" name="login-form-submit" class="submit btn btn-inverse login-form-submit">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="login-footer">
                        <a href="<?php echo FRONTEND_USER_FORGOT_PASS_DIR;?>">PW 찾기</a>
                        |
                        <a href="<?php echo FRONTEND_REGISTER_PUBLIC_DIR;?>">회원가입</a>
                    </div>
                </div>
                <script>
                jQuery(function($){
                    var keep_msg = $('#warning');
                    keep_msg.hide();
                    $('#keepid_opt').change(function(){
                        if($(this).is(':checked')){
                            keep_msg.slideDown(200);
                        } else {
                            keep_msg.slideUp(200);
                        }
                    });
                });
                </script>
            </section>
        </div>
    </div>
</section><!-- #content end -->
