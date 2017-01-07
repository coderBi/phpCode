( function() {
	 jQuery = function( selector ) {
	 	return  new jQuery.fn.init(selector);
	 }

	 jQuery.fn = {
	    init : function(selector) {
	 		if( typeof selector === 'string' ) {
	 			if( selector.indexOf( '#' ) == 0 ) {
	 				//id选择器
	 				this[0] = document.getElementById( selector.slice( 1, selector.length ) );
	 				this.length = 1;
	 			}
	 			else {
	 				var nodes = document.getElementsByTagName(selector);
	 				this.length = nodes.length;
	 				for( var i = 0; i < nodes.length; ++i ) {
	 					this[i] = nodes[i];
	 				}
	 			}
	 		}
	 		else {
	 			if( selector && selector.nodeType ) {
	 				this[0] = selector;
	 				this.length = 1;
	 			}
	 			else {
	 				return this;
	 			}
	 		}
	 	},
	 	css : function( k, v ) {
	 		if( !arguments[0] ) return {};
	 		if( !arguments[1] ) {
	 			var arr = new Array();
	 			for( var i = 0; i < this.length; ++i ) {
	 				arr[i] = this[i].style[k];
	 			}
	 			if( arr.length == 1 ) {
	 				//如果数组里面只有一个元素，就返回这个元素，而不是直接返回这个数组
	 				return arr[0];
	 			}
	 			return arr;
	 		}
	 		for( var i = 0; i < this.length; ++i ) {
	 			this[i].style[k] = v;  ///这里不能写作 style.k 因为这会造成歧义，是给style下面的 ‘k’ 设置
	 		}
	 	},
	 	attr : function( k, v ) {
	 		if( !arguments[0] ) return {};
	 		if( !arguments[1] ) {
	 			var arr = new Array();
	 			for( var i = 0; i < this.length; ++i) {
	 				arr[i] = this[i].getAttribute(k);
	 			}
	 			if( arr.length == 1 ) {
	 				//如果数组里面只有一个元素，就返回这个元素，而不是直接返回这个数组
	 				return arr[0];
	 			}
	 			return arr;
	 		}
	 		for( var i = 0; i < this.length; ++i ) {
	 			this[i].setAttribute(k,v);
	 		}
	 	},
	 	each : function(callback) {
	 		for( var i = 0; i < this.length; ++i ) {
	 			callback.call(this[i]);  //调用callback，指定this引用是 this[i]
	 		}
	 	},
	 }

	 window.$ = jQuery;
	 jQuery.fn.init.prototype = jQuery.fn;
} )();