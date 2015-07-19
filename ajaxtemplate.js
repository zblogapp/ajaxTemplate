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
	function ajaxTemplate(callback) {
		var isThisPage = false;
		console.log($.type(options.replaceSelector));
		if ($.type(options.replaceSelector) != 'array') {
			return false;
		}
		page.base(options.host);
		page("*", function(pageObject) {
			if (isThisPage) {
				$.get(pageObject.canonicalPath, function(data) {
					var domParser = new DOMParser();
					var $parsed = $(domParser.parseFromString(data, "text/html"));
					$.each(options.replaceSelector, function(index, value) {
						$parsed.find(value).replaceAll(value);
					});
					callback(pageObject);
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
		var callback = null;

		if (arguments.length === 1) {
			if ($.type(options) === "function") {
				callback = arguments[0];
			} else {
				optionsByUser = arguments[0];
			}
		} else {
			optionsByUser = arguments[0];
			callback = arguments[1];
		}

		$.extend(options, optionsByUser);
		ajaxTemplate.call(this, callback);

		return this;
	};

})(jQuery);