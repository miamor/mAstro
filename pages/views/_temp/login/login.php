<style>.idpico{cursor:pointer;cursor:hand}
#openidm{margin:7px}
.statu{margin:20px 0}
.social-login{position:relative;margin-bottom:30px}
.social-login .genbig{margin-bottom:5px}
a.btn:not(.login-button){max-height:39px!important;padding:10px 12px 9px!important;*line-height:20px!important}
a.btn .fa{font-size:18px}
input.text-input{padding:12px!important;max-height:38px!important;line-height:30px!important;margin-top:4px}
.text-input[type="password"]{padding:5px 12px!important;height:38px!important;line-height:16px!important}
.login-button{line-height:37px!important;padding:0 15px 1px!important;font-family:'Lato';font-size:16px!important;margin-top:4px!important;max-height:39px!important}
h2{padding-left:0}
.form-bottom{background:#fafafa;margin:15px -20px -15px;padding:10px 20px;border-radius:0 0 3px 3px;border-top:1px solid #f7f7f7}
.forgot-password{margin-top:3px;display:block;float:left}
.form-bottom .btn{margin-top:0!important}
.login-button{width:30%;*padding:11px 14px}
.front-login h2{border-bottom:1px solid #f9f9f9;margin:0 0 20px!important;padding:3px 10px 2px!important}
.copyright a:hover{text-decoration:underline}
.c-links a{margin:0 3px}
	</style>

<div class="alerts alert-info">
	<? echo $lang['mAstro is a totally free astrology tool, but requires an account for furthur usage. <br/>We provide some services to give you the best look on astrology, but decision to use it or not is all up to you. <br/>We do not require any credit accounts, we do not auto-charge by any circumstances. <br/>Please, be free to enjoy.'] ?> <a href="#" title="<? echo $lang['Privacy Policy'] ?>"><? echo $lang['Get to know more?'] ?></a>
</div>

<div class="col-lg-6">
	<div class="alerts alert-warning no-margin"><? echo $lang['We have disabled sign-up form since 19/12/2016. <i>Old accounts are not affected.</i><br/>Please sync with your facebook account using <i>Login with social network</i> form (your account/password to access your Facebook is no need) or login using a previous-created account to start experimenting.'].'<br/>'.$lang['<b>* Note</b>: Since <b>20/02/2017</b>, login form will be closed. From then on, all accounts created using mAstro register form will be deactivated (accounts synced with Facebook work normally)'] ?></div>

<form action="<? echo MAIN_URL ?>/login?do=login" class="login">
	<h3 class="bor"><? echo $lang['Login'] ?></h3>
	<div class="form-group">
		<div class="col-lg-3 control-label"><? echo $lang['Username'] ?></div>
		<div class="col-lg-9">
			<input type="text" name="username" class="form-control"/>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-lg-3 control-label"><? echo $lang['Password'] ?></div>
		<div class="col-lg-9">
			<input type="password" name="password" class="form-control"/>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="add-form-submit center">
		<input type="reset" value="Reset"/>
		<input type="submit" value="Submit"/>
	</div>
</form>
</div>

<div class="col-lg-6">
	<div class="alerts alert-warning no-margin"><? echo $lang['We highly recommend you use <b>Login with social network</b> form to log in, since we\'re currently working on <span class="italic">friends</span> section on mAstro, therefore, friends list will only be extracted from your Facebook account, which means you must <a>login with Facebook</a> to have friends list updated.'] ?></div>

<form action="<? echo MAIN_URL ?>/login?do=login_social" class="login-social">
<div class="social-login" id="idps">
	<h3 class="bor"><? echo $lang['Login with social network'] ?></h3>
	<div class="col-lg-12">
		<a idp="facebook" id="login-facebook" href="<? echo MAIN_URL ?>/login/facebook" class="btn btn-facebook idpicos"><i class="fa fa-facebook"></i></a> 
	</div>
	<div class="clearfix"></div>
</div>
</form>
</div>
<div class="clearfix"></div>
