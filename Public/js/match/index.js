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
//比赛列表
$.namespace('match.box');
$.match.box = {
	index: function(){
		this.betmoney = $('#matching').attr('data-betmoney');
		this.rebate = $('#matching').attr('data-rebate');
		this.mlist = {};
		this.prolist = {};
		this.bindEvent();
		//this.readCookie();
	},
	bindEvent: function(){
		var _T = this;
		//显示详情
		$('#matching').find('td.tobox').on('click',function(){
			var s1, s2, s3, s4, vs, rate, prize, profit, in1, in2, rebate = _T.rebate, betmoney = _T.betmoney;
			_T.mlist = eval('('+$(this).parent().attr('data')+')');
			_T.mlist['betmoney'] = betmoney; //下注金额
			_T.mlist['rebate'] = rebate; //返利
			_T.mlist['mid'] = $(this).parent().attr('mid'); //mid方案标示
			_T.mlist['vs'] = $(this).parent().attr('vs'); //对阵信息
			_T.mlist['rate'] = $(this).parent().attr('rate'); //赔率
			_T.countDetail(); //计算下注金额
			_T.showDetail(); //显示下注详情
			$.cookie('match.box.mlist', JSON.stringify(_T.mlist));
		});
		//清空
		$('#clear').click(function(){
			_T.mlist = {};
			_T.showDetail(); //显示下注详情
			$.cookie('match.box.mlist','');
		});
		//重新计算
		$('#recount').click(function(){
			
			_T.showDetail(); //显示下注详情
		});
		//保存方案
		$('#savepro').click(function(){
			//console.log(JSON.stringify(_T.prolist),JSON.parse(JSON.stringify(_T.prolist)));
			if(!$.pub.fun.isEmptyObj(_T.mlist)){
				_T.prolist[_T.mlist.mid] = _T.mlist;
				_T.showProList(); //显示保存方案
				$.cookie('match.box.prolist', JSON.stringify(_T.prolist));
			}			
			console.log(_T.prolist);
		});
		//清空方案
		$('#clearpro').click(function(){
			_T.prolist = {};
			_T.showProList();
			$.cookie('match.box.prolist','');
		});
	},
	//计算下注金额
	countDetail: function(){
		var _T = this;
		s1 = _T.mlist.s1;
		s2 = _T.mlist.s2;
		betmoney = _T.mlist.betmoney;
		rebate = _T.mlist.rebate;
		prize = (s1*s2*betmoney).toFixed(2); 
		_T.mlist['prize'] = prize; //预计奖金
		s3 = _T.mlist.s3; 
		in1 = ((betmoney - rebate)/(s3-1)).toFixed(2);			
		_T.mlist['in1'] = in1; //首场下注金额
		in2 = (prize+rebate-betmoney-in1).toFixed(2);
		_T.mlist['in2'] = in2; //末场下注金额
		profit = 3000;
		_T.mlist['profit'] = profit; //盈利	
	},
	//显示下注详情
	showDetail: function(){
		var _T = this, tabcompute = $('#tableCompute'), area = ['s1','s2','betmoney','prize','rebate','in1','s3','s4','profit','in2'];
		console.log(this.mlist);
		if(!$.pub.fun.isEmptyObj(this.mlist)){
			//标示对阵
			tabcompute.find('input#mid').val(_T.mlist.mid);
			tabcompute.find('input#rnrate').val(_T.mlist.rate);
			tabcompute.find('td.vs').html(_T.mlist.mid+'-'+_T.mlist.vs+'('+_T.mlist.rate+')');
			//填充值
			$.each(area,function(i,e){				
				if(_T.mlist[e]){
					tabcompute.find('input[name="'+e+'"]').val(_T.mlist[e]);
				}
			});
		}else{
			//清空数据
			tabcompute.find('input#mid').val('');
			tabcompute.find('input#rnrate').val('');
			tabcompute.find('td.vs').html('');
			//填充空值
			$.each(area,function(i,e){				
				tabcompute.find('input[name="'+e+'"]').val('');
			});
		}
	},
	//显示保存方案
	showProList: function(){
	
	},
	//第一次加载读取cookie
	readCookie: function(){
		//设置默认返还率，投注，回报
		var _T = this, ck = '', arr = ['match.box.mlist','match.box.prolist'];
		$.each(arr,function(i,e){
			ck = $.cookie(e);
			if(ck && typeof(ck) != 'undefined'){				
				if(e == 'match.box.mlist'){
					_T.mlist = JSON.parse(ck);
					_T.showDetail(); //显示下注详情
				}else if(e == 'match.box.prolist'){
					_T.prolist = JSON.parse(ck);
					_T.showProList(); //显示保存方案				
				}				
			}		
		});		
	},
};
//公用函数
$.namespace('pub.fun');
$.pub.fun = {
	isEmptyObj: function(obj){
		for(var name in obj){
		return false; 
		} 
		return true; 
	}
};
$(document).ready(function(){
	$.index.ui.box.index();
	$.match.box.index();
});