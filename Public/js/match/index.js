//jquery扩展
$.extend({
	//命名空间
	namespace:function(){		
		var a = arguments, o = null, i, j, d;    
		for(i = 0; i < a.length; i = i+1){
			d = a[i].split(".");
			o = jQuery;
			for(j = (d[0] == "jQuery") ? 1 : 0; j < d.length; j = j+1){
				o[d[j]] = o[d[j]] || {};
				o = o[d[j]];
	        }
	    }
	    return o;
	},
	//全局变量设置	
	C:function(k,v){
		if(arguments.length == 1){
			if($.data(window,k))
				return $.data(window,k);
			else
				return '';					
		}else{
			$.data(window,k,v);
		}
	},
	//重构html
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
	//确认弹窗
	confirm: function(c){
		return confirm(c);
	}
});
//全局变量设置
$.C('expires',1*60*60*1000); //cookie过期时间
//web_alert页面告警框(i:页面绑定ID;t:告警类型(warning);c:告警内容)
/*$.namespace('dlg');
$.dlg = {
	//初始化绑定ID
	index: function(i,t,c){
		$(i).html()
	},
	//告警框
	alert: function(t, c){
	
	
	}

	<div class="alert alert-warning alert-dismissible fade in" role="alert" id="alert-warning" style="display:none;">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		<div class="content">&nbsp;</div>
	</div>
	html.push($.tpl(str,{
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
};*/
//进度条
$.namespace('bar');
$.bar = {
	init: function(){
		this.bar = $('#progress');
		this.val = 0;
	},
	process: function(t){
		var _T = this;
		t = t === undefined ? 1000 : t;
		this.val += 10;
		if(this.val >= 99){
			this.val = 99;
			clearTimeout(this.ct);
		}
		this.bar.find('div.progress-bar').css({"width":this.val+"%"}).attr('aria-valuenow',this.val);		
		this.ct = setTimeout(function(){
			_T.process();
		},t);	
	},
	stop: function(){
		clearTimeout(this.ct);
	},
	end: function(){
		var _T = this;
		clearTimeout(this.ct);
		this.val = 100;
		this.bar.find('div.progress-bar').css({"width":this.val+"%"}).attr('aria-valuenow',this.val);
		setTimeout(function(){
			_T.val = 0;
			_T.bar.find('div.progress-bar').css({"width":_T.val+"%"}).attr('aria-valuenow',_T.val);
		},2000);
		
	}
};
//后台设置匹配场次 /Home/Admin/index.html
$.namespace('admin.box');
$.admin.box = {
	index:function(){
		this.bindEvent();
		//this.autoUp();		
	},
	bindEvent:function(){
		var _T = this, warning = $('#alert-warning').find('.content');		
		//重新载入竞彩xml
		$('#getdata .updataC').click(function(){
			var url = $(this).attr('data-url'), c = $(this).find('font').html();
			if($.confirm("确定"+c+"？该功能清空当前匹配的竞彩数据，请谨慎操作！")){
				warning.html('<strong>提示！</strong>正在载入数据...');
				$.post(url,function(data, textStatus){
					var res = $.parseJSON(data);
					if(res < 0){
						warning.html('<strong>警告！</strong>'+res.msg);
					}else{
						warning.html('&nbsp;');	
						location.reload();
					}
				});
			}
		});		
		//更新赔率
		$('#getdata .updataD').click(function(){
			var url = $(this).attr('data-url');
			warning.html('<strong>提示！</strong>正在更新赔率...');
			$.post(url,function(data, textStatus){
				var res = $.parseJSON(data);
				if(res < 0){
					warning.html('<strong>警告！</strong>'+res.msg);
				}else{
					warning.html('&nbsp;');	
					location.reload();
				}				
			});
		});
		//修改主、客队匹配
		$('#allsptab tr.data').dblclick(function(){
			var ismod = $(this).attr('ismod');
			if(ismod == '0'){
				_T.modUi(this);
			}else{
				_T.modUp(this);
			}
		});
		//切换是否匹配
		$('#allsptab tr.data>td.offset').click(function(){
			var T = this, offset = $(this).attr('data-offset'), mid = $(this).parent().attr('id'), url = $('#modupurl').val(), homesp = $(this).parent().find('td.homesp').attr('data-homesp'), awaysp = $(this).parent().find('td.awaysp').attr('data-awaysp');
			offset = offset == '0'?'1':'0';
			offstr = offset == '0'?'<span class="label label-warning">不匹配</span>':'<span class="label label-success">匹配</span>';
			para = { mid: mid, homesp: homesp, awaysp: awaysp, offset: offset };
			warning.html('<strong>提示！</strong>正在切换，请稍后...');
			$.post(url, para, function(data, textStatus){
				var res = $.parseJSON(data);
				if(res.code < 0){
					warning.html('<strong>警告！</strong>'+res.msg);
				}else{
					warning.html('&nbsp;');	
					$(T).attr('data-offset',offset).html(offstr);		
				}
			});
		});
		//修改主客队匹配/Home/Match/team.html
		$('#oddsteam tr.data').dblclick(function(){
			var ismod = $(this).attr('ismod'), tid = $(this).attr('data-id'), oddname = $(this).find('td.oddsname'), url = $('#modteamurl').val(), o_n;
			if(ismod == '0'){
				o_n = $.trim(oddname.html());
				oddname.html('<input type="text" class="form-control input-sm" name="o_n" value="'+o_n+'">');
				$(this).attr('ismod','1'); //修改标记值
			}else{
				o_n = $.trim(oddname.find('input[name="o_n"]').val());
				para = { tid:tid, team:o_n };
				warning.html('<strong>提示！</strong>正在保存修改，请稍后...');
				$.post(url, para, function(data, textStatus){
					var res = $.parseJSON(data);
					if(res.code < 0){
						warning.html('<strong>警告！</strong>'+res.msg);
					}else{
						warning.html('&nbsp;');
						oddname.html(o_n);						
						$(this).attr('ismod','0'); //修改标记值
					}
				});	
			}		
		});
		//新增主客队匹配
		$('#addteamform #addOneTd').click(function(){
			var tr = '<tr><td><input type="text" class="form-control input-sm" name="tid[]" value=""></td><td><input type="text" class="form-control input-sm" name="tname[]" value=""></td><td><input type="text" class="form-control input-sm" name="oname[]" value=""></td></tr>';
			$('#addteamform').find('tbody.tbody').append(tr);		
		});
		//新增主客队匹配
		$('#addteamform #addteamup').click(function(){
			var url = $('#addteamform').attr('action'), para = $('#addteamform').serialize();
			warning.html('<strong>提示！</strong>正在保存修改，请稍后...');
			$.post(url, para, function(data, textStatus){
				var res = $.parseJSON(data);
				if(res.code < 0){
					warning.html('<strong>警告！</strong>'+res.msg);
				}else{
					warning.html('&nbsp;');
					location.reload();
				}
			});	
		});
		//删除主客队匹配
		$('#oddsteam .delteam').click(function(){
			var url = $('#delteamurl').val(), tid = $(this).parents('tr.data').attr('data-id');
			if($.confirm("是否删除该匹配：队名ID（"+tid+"）")){
				warning.html('<strong>提示！</strong>正在保存修改，请稍后...');
				$.post(url, {tid:tid}, function(data, textStatus){
					var res = $.parseJSON(data);
					if(res.code < 0){
						warning.html('<strong>警告！</strong>'+res.msg);
					}else{
						warning.html('&nbsp;');
						location.reload();
					}
				});	
			}
		});
		//开始更新数据
		/*$('#autoup').click(function(){
			_T.autoUp();
		});*/
		//停止更新数据
		/*$('#stopup').click(function(){
			_T.stopUp();
		});*/
	},
	//修改主客队
	modUi:function(T){
		var team_op = $(T).find('td.team_op'), t_h, t_o, h;
		team = team_op.html().split('VS');
		t_h = team[0];
		t_o = team[1];
		h = '<input type="text" class="form-control input-sm" name="t_h" value="'+t_h+'">VS<input type="text" class="form-control input-sm" name="t_o" value="'+t_o+'">'
		$(T).attr('ismod','1'); //修改标记值
		team_op.html(h);
	},
	//保存主客队修改
	modUp:function(T){
		var team_op = $(T).find('td.team_op'),
			hid = $(T).find('td.team').attr('data-hid'),
			aid = $(T).find('td.team').attr('data-aid'),
			homename = $(T).find('td.team').attr('data-homename'),
			awayname = $(T).find('td.team').attr('data-awayname'),
			t_h = $.trim($(T).find('td.team_op').find('input[name="t_h"]').val()),
			t_o = $.trim($(T).find('td.team_op').find('input[name="t_o"]').val()),
			url = $('#modupurl').val(), 
			warning = $('#alert-warning').find('.content'), 
			para, h;			
		$(T).attr('ismod','0'); //修改标记值
		h = t_h+'VS'+t_o;
		team_op.html(h);
		para = { mod:hid+':'+encodeURI(homename)+':'+encodeURI(t_h)+';'+aid+':'+encodeURI(awayname)+':'+encodeURI(t_o) };
		warning.html('<strong>提示！</strong>正在保存修改，请稍后...');
		$.post(url, para, function(data, textStatus){
			var res = $.parseJSON(data);
			if(res.code < 0){
				warning.html('<strong>警告！</strong>'+res.msg);
			}else{
				warning.html(' ');		
			}
		});
	},
	//自动更新
	autoUp:function(){
		clearInterval(this.u_sp1);
		clearInterval(this.u_allm);
		this.u_sp1 = setInterval(function(){$("#getallsp1").trigger("click");},2000);
		this.u_allm = setInterval(function(){$("#upallsp").trigger("click");},5000);
	},
	//停止自动更新
	stopUp:function(){
		clearInterval(this.u_sp1);
		clearInterval(this.u_allm);
	}
};
//外围数据列表 /Home/MatAdmin/showSpLs.html
$.namespace('showspls.box');
$.showspls.box = {
	index:function(){
		this.bindEvent();	
	},
	bindEvent:function(){
		var _T = this, warning = $('#alert-warning');				
		//清空外围数据
		$('#clearsp').click(function(){
			var url = $(this).attr('data-url');
			if($.confirm("确定清空外围数据？该功能将删除外围数据，请谨慎操作！")){
				warning.find('.content').html('<strong>提示！</strong>正在清空数据...').parent().show();
				$.post(url,function(data, textStatus){
					var res = $.parseJSON(data);
					if(res.code < 0){
						warning.find('.content').html('<strong>警告！</strong>'+res.msg).parent().show();
					}else{
						warning.hide();	
						location.reload();
					}
				});
			}
		});
		//更新外围数据sp
		$('#getsp').click(function(){
			var url = $(this).attr('data-url');
			warning.find('.content').html('<strong>提示！</strong>正在更新数据...').parent().show();
			$.post(url,function(data, textStatus){
				var res = $.parseJSON(data);
				if(res.code < 0){
					warning.find('.content').html('<strong>警告！</strong>'+res.msg).parent().show();
				}else{
					warning.hide();	
					location.reload();
				}
			});
		});
	}
};

//首页设置赔率和返还率 /Home/Index/index.html
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
		//设置返还率、下注、返利、显示记录条数
		$('#dosub').click(function(){
			var rnrate = $('#rnrate').val(), betmoney = $('#betmoney').val(), rebate = $('#rebate').val();
			$.cookie('rnrate', rnrate, $.C('expires'));
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

//计算比赛列表  /Home/Index/matching.html
$.namespace('match.box');
$.match.box = {
	index: function(){
		this.list = '';
		this.mlist = {};		
		this.prolist = {};
		this.betmoney = parseFloat($('#matching').attr('data-betmoney'));
		this.rebate = parseFloat($('#matching').attr('data-rebate'));
		
		this.bindEvent();
		this.readCookie();
	},
	bindEvent: function(){
		var _T = this;
		//监听鼠标滚动
		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			$.match.box.scrollTop(scrollTop);
		});
		//ajax刷新
		$('#relup').click(function(){
			_T.getAjaxList();
		});
		//显示详情
		$('#matching').find('td.tobox').live('click',function(){
			var s1, s2, s3, s4, vs, rate, prize, profit, in1, in2, rebate = _T.rebate, betmoney = _T.betmoney;
			_T.mlist = eval('('+$(this).parent().attr('data')+')');
			_T.mlist['betmoney'] = betmoney; //下注金额
			_T.mlist['rebate'] = rebate; //返利
			_T.mlist['mid'] = $(this).parent().attr('mid'); //mid方案标示
			_T.mlist['vs'] = $(this).parent().attr('vs'); //对阵信息
			_T.mlist['rate'] = parseFloat($(this).parent().attr('rate')); //赔率	
			console.log(_T.mlist);
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
			_T.reCountDetail();	 //重新获取表单值，重新计算		
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
		//修改方案
		$('#tableProList a.mod').live('click',function(){
			var mid = $(this).attr('data-mid'), ml;
			ml = $.pub.getObj(_T.prolist,'mid',mid);
			_T.mlist = ml[mid];
			_T.showDetail();
		});	
		//定时刷新 10s
		clearTimeout(_T.t_a);
		_T.t_a = setTimeout(function(){
			_T.getAjaxList();
		},5000);	
	},
	//ajax获取list
	getAjaxList: function(){
		var _T = this, url = $('#relup').attr('data-url'), rnrate = $('#matching').attr('data-irate'), para;
		$.bar.process();
		//ajax ,设置请求超时时间
		$.ajax({
			url:url,
			timeout: 5000, //超时时间设置，单位毫秒
			type:'post',
			data:{rnrate:rnrate},
			dataType:'json',//返回的数据格式			
			success:function(list){ //请求成功的回调函数
				//console.log(list);
				if(list.length > 0){
			　　　　//刷新成功			
					_T.list = list;
					_T.createList();
					$.bar.end();
					//定时刷新 5s
					clearTimeout(_T.t_a);
					_T.t_a = setTimeout(function(){
						_T.getAjaxList();
					},5000);
				}else{
					$.bar.end();
				}
		　　},
			complete:function(XMLHttpRequest,status){ //请求完成后最终执行参数
				//console.log(XMLHttpRequest,status);
		　　　　if(status == 'timeout'){//超时,status还有success,error等值的情况
					// var irate = parseFloat($('#matching').attr('data-irate')),
						// betmoney = parseFloat($('#matching').attr('data-betmoney')),
						// rebate = parseFloat($('#matching').attr('data-rebate'));
					// location = location.href+'?irate='+irate+'&betmoney='+betmoney+'&rebate='+rebate;
					$.bar.end();
		　　　　}
		　　}
		});
		// post提交请求
		// $.post(url, {rnrate:rnrate}, function(data, textStatus){
			// var list = $.parseJSON(data);			
			// if(textStatus == "success" && list.length > 0){
				// //刷新成功			
				// _T.list = list;
				// _T.createList();
				// $.bar.end();
				// //定时刷新 10s
				// clearTimeout(_T.t_a);
				// _T.t_a = setTimeout(function(){
					// _T.getAjaxList();
				// },5000);				
			// }else{
				// $.bar.end();
			// }
		// });
	},
	//ajax刷新比赛列表
	createList: function(){
		var list = this.list, html = [], listTable = $('#mlist_show'), 
			strhtml = '<tr class="data {$cl}" id="m{$key}" mid="m{$key}" data="{$data}" vs="{$vs}" rate="{$rnrate}">'+
						'<td rowspan="2" class="tobox"><a href="javascript:;">{$key}</a></td><td>{$m1_id}</td><td>{$m1_matchtime}</td><td>{$m1_simpleleague}</td><td>{$m1_homename}</td><td>{$m1_awayname}</td><td>{$m1_w}</td><td>{$m1_op}</td><td>{$m1_rate}</td><td rowspan="2" class="tobox">{$rnrate}&nbsp;<a href="javascript:;">详情</a></td></tr>'+
					  '<tr class="data {$cl}">'+		'<td>{$m2_id}</td><td>{$m2_matchtime}</td><td>{$m2_simpleleague}</td><td>{$m2_homename}</td><td>{$m2_awayname}</td><td>{$m2_w}</td><td>{$m2_op}</td><td>{$m2_rate}</td></tr>';
		$.each(list,function(i,e){
			html.push($.tpl(strhtml,{
				key: i+1,
				cl: (i+1)%2 == 0 ? 'success' : '',
				data: '{s1:'+e.m1.w+',s2:'+e.m2.w+',s3:'+e.m1.fun+',s4:'+e.m2.fun+'}',
				vs: '['+e.m1.homename+'vs'+e.m1.awayname+']/['+e.m2.homename+'vs'+e.m2.awayname+']',
				rnrate: e.rnrate,
				m1_id: e.m1.id,
				m1_matchtime: e.m1.matchtime,
				m1_simpleleague: e.m1.simpleleague,
				m1_homename: e.m1.homename,
				m1_awayname: e.m1.awayname,
				m1_w: e.m1.w,
				m1_op: e.m1.fun+'(乐天堂)',
				m1_rate: e.m1.rate,
				m2_id: e.m2.id,
				m2_matchtime: e.m2.matchtime,
				m2_simpleleague: e.m2.simpleleague,
				m2_homename: e.m2.homename,
				m2_awayname: e.m2.awayname,
				m2_w: e.m2.w,
				m2_op: e.m2.fun+'(乐天堂)',
				m2_rate: e.m2.rate
			}));			
		});
		listTable.html(html.join(''));
	},
	//重新计算
	reCountDetail: function(){
		var s1, s2, s3, s4, betmoney, rebate, mid, vs, rate, tableDetail = $('#tableDetail');
		this.mlist['s1'] = parseFloat(tableDetail.find('input[name="s1"]').val());
		this.mlist['s2'] = parseFloat(tableDetail.find('input[name="s2"]').val());
		this.mlist['s3'] = parseFloat(tableDetail.find('input[name="s3"]').val());
		this.mlist['s4'] = parseFloat(tableDetail.find('input[name="s4"]').val());
		this.mlist['betmoney'] = parseFloat(tableDetail.find('input[name="betmoney"]').val());
		this.mlist['rebate'] = parseFloat(tableDetail.find('input[name="rebate"]').val());
		this.mlist['mid'] = tableDetail.find('input[name="mid"]').val();
		this.mlist['vs'] = tableDetail.find('input[name="vs"]').val();
		this.mlist['rate'] = parseFloat(tableDetail.find('input[name="rnrate"]').val());		
		this.countDetail();
	},
	//计算下注金额
	countDetail: function(){
		var _T = this;
		s1 = _T.mlist.s1;
		s2 = _T.mlist.s2;
		betmoney = _T.mlist.betmoney;
		rebate = _T.mlist.rebate;		
		prize = parseFloat((s1*s2*betmoney).toFixed(2)); 
		_T.mlist['prize'] = prize; //预计奖金
		s3 = _T.mlist.s3;
		s4 = _T.mlist.s4; 
		in1 = parseFloat(((betmoney - rebate)/(s3-1)).toFixed(2));			
		_T.mlist['in1'] = in1; //首场下注金额
		in2 = parseFloat((prize+rebate-betmoney-in1).toFixed(2));
		_T.mlist['in2'] = in2; //末场下注金额
		profit = parseFloat((in2*s4+rebate-betmoney-in1-in2).toFixed(2)); 
		_T.mlist['profit'] = profit; //盈利	
	},
	//显示下注详情
	showDetail: function(){
		var _T = this, tableDetail = $('#tableDetail'), area = ['s1','s2','betmoney','prize','rebate','in1','s3','s4','profit','in2'];
		if(!$.pub.isEmptyObj(this.mlist)){
			//标示对阵
			tableDetail.find('input#mid').val(_T.mlist.mid);
			tableDetail.find('input#rnrate').val(_T.mlist.rate);
			tableDetail.find('input#vs').val(_T.mlist.vs);
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
		$.cookie('match.box.mlist', JSON.stringify(_T.mlist), $.C('expires'));		
	},
	//显示保存方案
	showProList: function(){
		var _T = this, html = [], tableProList = $('#tableProList'),
			str = '<tr class="danger"><td colspan="5" class="left">{$vs}</td><td width="18%"><a href="javascript:;" class="del" data-mid="{$mid}">删除</a>&nbsp;&nbsp;<a href="javascript:;" class="mod" data-mid="{$mid}">修改</a></td></tr>'+
				'<tr><th colspan="2">水位1</th><th>下注</th><th>预计</th><th>返利</th><th class="red">1下注金额</th></tr>'+
				'<tr><td>{$s1}</td><td>{$s2}</td><td>{$betmoney}</td><td>{$prize}</td><td>{$rebate}</td><td>{$in1}</td></tr>'+
				'<tr><th>水位2</th><th>水位3</th><th><font color="red">X</font>&nbsp;&nbsp;<font color="red">X</font></th><th>V&nbsp;&nbsp;V</th><th>V&nbsp;&nbsp;<font color="red">X</font></th><th class="red">2下注金额</th></tr>'+
				'<tr><td>{$s3}</td><td>{$s4}</td><td>0.00</td><td>0.00</td><td>{$profit}</td><td>{$in2}</td></tr>';
		$.each(_T.prolist,function(i,e){
			html.push($.tpl(str,{
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
		$.cookie('match.box.prolist', JSON.stringify(_T.prolist), $.C('expires'));
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
	}
};