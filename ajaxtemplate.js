(function($) {
	/**
	 * 配置
	 * @type {Object}
	 */
	var options = {
		host: "/",
		replaceSelector: []
	};
	/**
	 * 主程序函数
	 */
	function ajaxTemplate(callbacking, callbacked) {
		var isThisPage = false;
		console.log($.type(options.replaceSelector));
		if ($.type(options.replaceSelector) != 'array') {
			return false;
		}
		page.base(options.host);
		page("*", function(pageObject) {
			if (isThisPage) {
				callbacking(pageObject);
				$.get(pageObject.canonicalPath, function(data) {
					var domParser = new DOMParser();
					var $parsed = $(domParser.parseFromString(data, "text/html"));
					$.each(options.replaceSelector, function(index, value) {
						$parsed.find(value).replaceAll(value);
					});
					callbacked(pageObject, data);
				});
			};
			isThisPage = true;
		});
		page();
		return true;
	};
	/**
	 * ajaxTemplate
	 */
	$.ajaxTemplate = $.fn.ajaxTemplate = function() {

		var optionsByUser = {};
		var callbacking = null;
		var callbacked = null;

		if (arguments.length === 2) {
			callbacking = arguments[0];
			callbacked = arguments[1];
		} else if (arguments.length === 1) {
			options = arguments[0];
		} else {
			optionsByUser = arguments[0];
			callbacking = arguments[1];
			callbacked = arguments[2];
		}

		$.extend(options, optionsByUser);
		ajaxTemplate.call(this, callbacking, callbacked);

		return this;
	};

})(jQuery);