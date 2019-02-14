
<!-- Content
============================================= -->
<section id="content">


    <div class="gpe_contents">
    <!--XE컨텐츠-->
        <div class="gpe_contents_xecon">
            <section class="xm">
                <div class="signin">
                    <div class="login-header">
                        <h1><i class="icon-user"></i> 회원가입</h1>
                    </div>
                    <div class="login-body">
                        <div class="alert alert-danger alert-dismissible fade display-none" role="alert">
                            <span class="msgContent"></span>
                        </div>
                        <div class="alert alert-success alert-dismissible fade display-none" role="alert">
                            <span class="msgContent"></span>
                        </div>
                        <form method="post" id="register-form" name="register-form" >
                            <fieldset>
                                <div class="control-group">
                                    <input type="text" class="form-control not-dark" name="user_id" id="user_id" required="" placeholder="아이디" title="아이디">
                                    <input type="text" class="form-control not-dark" name="user_email" id="user_email" required="" placeholder="이-메일" title="이-메일">
                                    <input type="password" class="form-control not-dark" name="user_password" id="user_password" required="" placeholder="비밀번호" title="비밀번호">
                                    <input type="password" class="form-control not-dark" name="confirm_password" id="confirm_password" required="" placeholder="비밀번호 확인" title="비밀번호 확인">
                                </div>
                                <div class="control-group">
                                    <label for="keepid_opt">
                                        				
                                    </label>
                                    <input type="button"  id="register-form-submit" value="회원가입" name="register-form-submit" class="submit btn">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="login-footer">
                        <a href="<?php echo FRONTEND_LOGIN_PUBLIC_DIR;?>">로그인</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section><!-- #content end -->
