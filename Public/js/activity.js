/*
 * 首页全局js
 * author：zy
 * email: 1016366921@qq.com
 */

 $(document).ready(function () {
	$('#activitytab a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	})


});