/**
  * 登录功能
  *
  * @author xiaxianlin
  * @since 2014-6-23
  */
(function($){
	/*
	 * 登录窗口的里面的文字信息
	 */	
	var obj = {
		title : '', //标题
		tips : '', //登陆提示
		placeholder : '', //文本框输入提示
		phoneTips : '', //验证码发送或者倒计时提示
		btnTips : '' //按钮文字
	};
	/*
	 * 登录窗口的弹层
	 */	
	var loginWin = {
		/*
	 	 * 设置弹层文字信息
		 */	
		_set : function(para, isShowPhoneTips, callback,ticker){
			$(".J_LoginTitle").text(para.title);
			$(".J_LoginTips").html(para.tips);
			$(".J_LoginBtnTips").text(para.btnTips);
			$(".J_LoginInp").attr("placeholder",para.placeholder);
			$(".J_LoginInp").val('');
			//验证码步骤多出发送验证码的提示
			if(isShowPhoneTips){
				$(".J_LoginPhoneTips").html(para.phoneTips);
				$(".J_LoginPhoneTips").show();
				$(".J_LoginInp").addClass('inp-small');
			}else{
				$(".J_LoginPhoneTips").hide();
				$(".J_LoginInp").removeClass('inp-small');
			}
			//发送验证码倒计时
			if(ticker) ticker();
			//点击按钮事件回调函数
			$(".J_LoginBtnTips").bind(eventType,function(){
				if(callback) callback();
			});
		},
		_setCaptchaObj : function(phoneNum){
			obj.title = '请输入校验码';
			obj.tips = '我们已发送验证码短信到这个号码<br><font color="#000">' + phoneNum + '</font>';
			obj.placeholder = '请输入验证码';
			obj.btnTips = '确定';
		},
		_setInpPwd : function(type){
			$(".J_LoginInp").attr('type', type);
		},
		/*
	 	 * 初始化弹窗模版
		 */	
		init : function(){
			$(".J_Login").removeClass('hide');
			$(".J_LoginClose").bind(eventType,function(){
				$(".J_Login").hide();
			});
			$(".J_LoginInp").bind(eventType,function(){
				this.focus();
			});
			this.inputCaptcha(111);
		},
		/*
	 	 * 登录第一步
		 */		
		first : function(){
			var self = this;
			obj.title = '登录B座12楼';
			obj.tips = '请输入您的手机号码进行登录';
			obj.placeholder = '请输入手机号码';
			obj.btnTips = '登陆';
			self._setInpPwd('text');
			self._set(obj, false, function(){
				self.login($(".J_LoginInp").val());
			});
		},
		/*
	 	 * 登录第二步
		 */
		login : function(phoneNum){
			var self = this;
			obj.title = '登录B座12楼';
			obj.tips = "请输入<font color='#000'>" + phoneNum + "</font>的登录密码";
			obj.placeholder = '请输入登陆密码';
			obj.btnTips = '提交';
			self._setInpPwd('password');
			self._set(obj, false, function(root){ 
				self.inputCaptcha(phoneNum);
			});
		},
		/*
	 	 * 设置初始密码
		 */
		setPwd : function(){
			obj.title = '请设置登录密码';
			obj.tips = '初次用手机号码登录，请设置登录密码';
			obj.placeholder = '请输入登陆密码';
			obj.btnTips = '提交';
			self._setInpPwd('password');
			this._set(obj, false, function(){

			});
		},
		/*
	 	 * 输入验证码
		 */
		inputCaptcha : function(phoneNum){
			var self = this;
			self._setCaptchaObj(phoneNum);
			obj.phoneTips = '接收短信约还需<font color="#00b4bf" id="J_LoginTicker">5</font>秒';
			self._setInpPwd('text');
			self._set(obj, true, 
				function(){

				},
				function(){
					var node = $("#J_LoginTicker");
					var s = parseInt(node.text(), 10);
					window.timer = setInterval(function(){
						if(s <= 0){
							clearInterval(window.timer);
							self.sendCaptcha(phoneNum);
						}else{
							node.text(s);
						}
						s--;
					}, 1000);
				}
			);
		},
		/*
	 	 * 发送验证码
		 */
		sendCaptcha : function(phoneNum) {
			var self = this;
			self._setCaptchaObj(phoneNum);
			obj.phoneTips = '<a href="#">重新发送校验码>></a>';
			self._setInpPwd('text');
			self._set(obj, true, function(){

			});
		}
	};

	window.LOGIN_WIN = loginWin;
})(Zepto);