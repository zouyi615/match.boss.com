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
//全局变量设置
$.extend($.sysini,{
	C:function(k,v){
		if(arguments.length == 1){
			if($.isString(k)){
				return $.sysini[k]
			} else {
				$.extend($.sysini, k)
			}
		}else{
			$.sysini[k] = v
		}
	}
});
//$.C('expires',60);
//expires: 1*60*60*1000, //cookie过期时间

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
		//监听鼠标滚动
		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			$.match.box.scrollTop(scrollTop);
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
		this.readCookie();
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
			if(!$.pub.isEmptyObj(_T.mlist)){
				_T.prolist[_T.mlist.mid] = _T.mlist;
				_T.showProList(); //显示保存方案				
			}
		});
		//清空方案
		$('#clearpro').click(function(){
			_T.prolist = {};
			_T.showProList();
			$.cookie('match.box.prolist','');
		});
		//删除方案
		$('#tableProList a.del').live('click',function(){
			var mid = $(this).attr('data-mid');			
			_T.prolist = $.pub.removeObj(_T.prolist,'mid',mid);
			_T.showProList();
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
		s4 = _T.mlist.s4; 
		in1 = ((betmoney - rebate)/(s3-1)).toFixed(2);			
		_T.mlist['in1'] = in1; //首场下注金额
		in2 = (prize+rebate-betmoney-in1).toFixed(2);
		_T.mlist['in2'] = in2; //末场下注金额
		profit = (in2*s4+rebate-betmoney-in1-in2).toFixed(2); 
		_T.mlist['profit'] = profit; //盈利	
	},
	//显示下注详情
	showDetail: function(){
		var _T = this, tableDetail = $('#tableDetail'), area = ['s1','s2','betmoney','prize','rebate','in1','s3','s4','profit','in2'];
		if(!$.pub.isEmptyObj(this.mlist)){
			//标示对阵
			tableDetail.find('input#mid').val(_T.mlist.mid);
			tableDetail.find('input#rnrate').val(_T.mlist.rate);
			tableDetail.find('td.vs').html(_T.mlist.mid+'-'+_T.mlist.vs+'('+_T.mlist.rate+')');
			//填充值
			$.each(area,function(i,e){
				if(_T.mlist[e]){
					tableDetail.find('input[name="'+e+'"]').val(_T.mlist[e]);
				}
			});
		}else{
			//清空数据
			tableDetail.find('input#mid').val('');
			tableDetail.find('input#rnrate').val('');
			tableDetail.find('td.vs').html('');
			//填充空值
			$.each(area,function(i,e){				
				tableDetail.find('input[name="'+e+'"]').val('');
			});
		}
		//JSON.stringify(_T.prolist)json转字符串写cookie
		$.cookie('match.box.mlist', JSON.stringify(_T.mlist)); 
	},
	//显示保存方案
	showProList: function(){
		var _T = this, html = [], tableProList = $('#tableProList'),
			str = '<tr class="danger"><td colspan="5">{$vs}</td><td><a href="javascript:;" class="del" data-mid="{$mid}">删除</a>&nbsp;&nbsp;<a href="javascript:;" calss="mod" data-mid="{$mid}">修改</a></td></tr>'+
				'<tr><th colspan="2">水位1</th><th>下注</th><th>预计</th><th>返利</th><th class="red">1下注金额</th></tr>'+
				'<tr><td>{$s1}</td><td>{$s2}</td><td>{$betmoney}</td><td>{$prize}</td><td>{$rebate}</td><td>{$in1}</td></tr>'+
				'<tr><th>水位2</th><th>水位3</th><th><font color="red">X</font>&nbsp;&nbsp;<font color="red">X</font></th><th>V&nbsp;&nbsp;V</th><th>V&nbsp;&nbsp;<font color="red">X</font></th><th class="red">2下注金额</th></tr>'+
				'<tr><td>{$s3}</td><td>{$s4}</td><td>0.00</td><td>0.00</td><td>{$profit}</td><td>{$in2}</td></tr>';
		$.each(_T.prolist,function(i,e){
			html.push($.pub.tpl(str,{
				mid: i,
				vs: i+'-'+e.vs+'('+e.rate+')',
				s1: e.s1,
				s2: e.s2,
				s3: e.s3,
				s4: e.s4,
				betmoney: e.betmoney,
				prize: e.prize,
				rebate: e.rebate,
				profit: e.profit,
				in1: e.in1,
				in2: e.in2
			}));
		});
		tableProList.html(html.join(''));
		//JSON.stringify(_T.prolist)json转字符串写cookie
		$.cookie('match.box.prolist', JSON.stringify(_T.prolist));
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
	scrollTop: function(top){
		$('#tableDetail').animate({"top":top},0);	
	}
};
//公用函数
$.namespace('pub');
$.pub = {
	//判断obj是否为空
	isEmptyObj: function(obj){
		for(var name in obj){
		return false; 
		} 
		return true; 
	},
	//html显示
	tpl: function(s, o, def){
		def = def === undefined ? '' : def;
		return s.replace(/\{\$([^$\}]+?)\}/g, function(all, ns){
			ns = ns.trim().split('.');
			var prop = o;
			try{
				while(ns.length){
					prop = prop[ns.shift()];
				}
			}catch(e){
				prop = def;
			}
			return prop === undefined ? def : prop;
		});
	},
	//从对象数组中删除属性为objPropery，值为objValue元素的对象
	//arrPerson数组对象,objPropery对象的属性,objValue对象的值
	removeObj: function(arrPerson,objPropery,objValue){
		var arr = {};
		$.each(arrPerson,function(i,cur){
			if(cur[objPropery] != objValue){
				arr[cur[objPropery]] = cur;
			}
		});
		return arr;
		// $.grep(arrPerson, function(cur,i){
			// cur[objPropery] != objValue;
		// });
	},
	//从对象数组中获取属性为objPropery，值为objValue元素的对象
	//arrPerson数组对象,objPropery对象的属性,objValue对象的值
	getObj: function(arrPerson,objPropery,objValue){
		var arr = {};
		$.each(arrPerson,function(i,cur){
			if(cur[objPropery] == objValue){
				arr[cur[objPropery]] = cur;
			}
		});
		return arr;
		// return $.grep(arrPerson, function(cur,i){
			// return cur[objPropery] == objValue;
		// });
	}
};
$(document).ready(function(){
	$.index.ui.box.index();
	$.match.box.index();			
});