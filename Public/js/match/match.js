//namespace命名空间
$.namespace = function() {
	var a=arguments, o=null, i, j, d;    
	for(i=0; i<a.length; i=i+1){        
		d=a[i].split(".");        
		o=jQuery;        
		for (j=(d[0] == "jQuery") ? 1 : 0; j<d.length; j=j+1) {            
			o[d[j]]=o[d[j]] || {};            
			o=o[d[j]];        
		}    
	}    
	return o;
};
//UI控制器
$.namespace('index.ui.box');
$.index.ui.box = {
	index:function(){
		this.bindEvent();
		this.defaultVal();
	},
	bindEvent:function(){
		var _T = this;
		//tips
		$('#tips a').click(function(){
			var s = $(this).find('span');
			$('#tips_con').toggle('slow',function(){
				if(s.hasClass('glyphicon-resize-full')){
					s.removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
				}else{
					s.removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
				}
			});		
		});
		//cookie设置返还率
		$('#setrn').click(function(){
			var rnrate = $('#rnrate').val();
			$.cookie('rnrate', rnrate);			
		});
		//设置下注和返利
		$('#dosub').click(function(){
			var betmoney = $('#betmoney').val(), rebate = $('#rebate').val();
			$.cookie('betmoney', betmoney);
			$.cookie('rebate', rebate);
			_T.dosub();
		});
	},
	defaultVal:function(){
		//设置默认返还率，投注，回报
		var ck = '', arr = {'rnrate':$('#rnrate'),'betmoney':$('#betmoney'),'rebate':$('#rebate')};
		$.each(arr,function(i,e){
			ck = $.cookie(i);
			if(ck && typeof(ck) != 'undefined'){
				e.val(ck);
			}		
		});	
	},
	dosub:function(){
		var form = $('#dosubform');
		form.submit();
	
	}
};
$(document).ready(function(){
	$.index.ui.box.index();

});