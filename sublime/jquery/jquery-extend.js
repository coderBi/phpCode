/**
 * 这里是我自己为jquery进行的扩展
 */

$.fn.extend( {
	consolePrint : function(str) {
		console.log(str);
	},
} );

$.extend( {
	consolePrint : function(str) {
		console.log(str);
	},
} );

//添加table隔行换色功能
$.fn.setTableColor = function() {
	var th = arguments[0] ? arguments[0] : 'gold';
	var tr = arguments[1] ? arguments[1] : 'lightblue';
	this.find('tr:first').css('backgroundColor',th);
	this.find('tr:gt(0):even').css('backgroundColor',tr);
}