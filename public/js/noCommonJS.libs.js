/*
 * bootstrap-tagsinput v0.7.1 by Tim Schlechter
 * 
 */

!function(a){"use strict";function b(b,c){this.isInit=!0,this.itemsArray=[],this.$element=a(b),this.$element.hide(),this.isSelect="SELECT"===b.tagName,this.multiple=this.isSelect&&b.hasAttribute("multiple"),this.objectItems=c&&c.itemValue,this.placeholderText=b.hasAttribute("placeholder")?this.$element.attr("placeholder"):"",this.inputSize=Math.max(1,this.placeholderText.length),this.$container=a('<div class="bootstrap-tagsinput"></div>'),this.$input=a('<input type="text" placeholder="'+this.placeholderText+'"/>').appendTo(this.$container),this.$element.before(this.$container),this.build(c),this.isInit=!1}function c(a,b){if("function"!=typeof a[b]){var c=a[b];a[b]=function(a){return a[c]}}}function d(a,b){if("function"!=typeof a[b]){var c=a[b];a[b]=function(){return c}}}function e(a){return a?i.text(a).html():""}function f(a){var b=0;if(document.selection){a.focus();var c=document.selection.createRange();c.moveStart("character",-a.value.length),b=c.text.length}else(a.selectionStart||"0"==a.selectionStart)&&(b=a.selectionStart);return b}function g(b,c){var d=!1;return a.each(c,function(a,c){if("number"==typeof c&&b.which===c)return d=!0,!1;if(b.which===c.which){var e=!c.hasOwnProperty("altKey")||b.altKey===c.altKey,f=!c.hasOwnProperty("shiftKey")||b.shiftKey===c.shiftKey,g=!c.hasOwnProperty("ctrlKey")||b.ctrlKey===c.ctrlKey;if(e&&f&&g)return d=!0,!1}}),d}var h={tagClass:function(a){return"label label-info"},itemValue:function(a){return a?a.toString():a},itemText:function(a){return this.itemValue(a)},itemTitle:function(a){return null},freeInput:!0,addOnBlur:!0,maxTags:void 0,maxChars:void 0,confirmKeys:[13,44],delimiter:",",delimiterRegex:null,cancelConfirmKeysOnEmpty:!1,onTagExists:function(a,b){b.hide().fadeIn()},trimValue:!1,allowDuplicates:!1};b.prototype={constructor:b,add:function(b,c,d){var f=this;if(!(f.options.maxTags&&f.itemsArray.length>=f.options.maxTags)&&(b===!1||b)){if("string"==typeof b&&f.options.trimValue&&(b=a.trim(b)),"object"==typeof b&&!f.objectItems)throw"Can't add objects when itemValue option is not set";if(!b.toString().match(/^\s*$/)){if(f.isSelect&&!f.multiple&&f.itemsArray.length>0&&f.remove(f.itemsArray[0]),"string"==typeof b&&"INPUT"===this.$element[0].tagName){var g=f.options.delimiterRegex?f.options.delimiterRegex:f.options.delimiter,h=b.split(g);if(h.length>1){for(var i=0;i<h.length;i++)this.add(h[i],!0);return void(c||f.pushVal())}}var j=f.options.itemValue(b),k=f.options.itemText(b),l=f.options.tagClass(b),m=f.options.itemTitle(b),n=a.grep(f.itemsArray,function(a){return f.options.itemValue(a)===j})[0];if(!n||f.options.allowDuplicates){if(!(f.items().toString().length+b.length+1>f.options.maxInputLength)){var o=a.Event("beforeItemAdd",{item:b,cancel:!1,options:d});if(f.$element.trigger(o),!o.cancel){f.itemsArray.push(b);var p=a('<span class="tag '+e(l)+(null!==m?'" title="'+m:"")+'">'+e(k)+'<span data-role="remove"></span></span>');p.data("item",b),f.findInputWrapper().before(p),p.after(" ");var q=a('option[value="'+encodeURIComponent(j)+'"]',f.$element).length||a('option[value="'+e(j)+'"]',f.$element).length;if(f.isSelect&&!q){var r=a("<option selected>"+e(k)+"</option>");r.data("item",b),r.attr("value",j),f.$element.append(r)}c||f.pushVal(),(f.options.maxTags===f.itemsArray.length||f.items().toString().length===f.options.maxInputLength)&&f.$container.addClass("bootstrap-tagsinput-max"),a(".typeahead, .twitter-typeahead",f.$container).length&&f.$input.typeahead("val",""),this.isInit?f.$element.trigger(a.Event("itemAddedOnInit",{item:b,options:d})):f.$element.trigger(a.Event("itemAdded",{item:b,options:d}))}}}else if(f.options.onTagExists){var s=a(".tag",f.$container).filter(function(){return a(this).data("item")===n});f.options.onTagExists(b,s)}}}},remove:function(b,c,d){var e=this;if(e.objectItems&&(b="object"==typeof b?a.grep(e.itemsArray,function(a){return e.options.itemValue(a)==e.options.itemValue(b)}):a.grep(e.itemsArray,function(a){return e.options.itemValue(a)==b}),b=b[b.length-1]),b){var f=a.Event("beforeItemRemove",{item:b,cancel:!1,options:d});if(e.$element.trigger(f),f.cancel)return;a(".tag",e.$container).filter(function(){return a(this).data("item")===b}).remove(),a("option",e.$element).filter(function(){return a(this).data("item")===b}).remove(),-1!==a.inArray(b,e.itemsArray)&&e.itemsArray.splice(a.inArray(b,e.itemsArray),1)}c||e.pushVal(),e.options.maxTags>e.itemsArray.length&&e.$container.removeClass("bootstrap-tagsinput-max"),e.$element.trigger(a.Event("itemRemoved",{item:b,options:d}))},removeAll:function(){var b=this;for(a(".tag",b.$container).remove(),a("option",b.$element).remove();b.itemsArray.length>0;)b.itemsArray.pop();b.pushVal()},refresh:function(){var b=this;a(".tag",b.$container).each(function(){var c=a(this),d=c.data("item"),f=b.options.itemValue(d),g=b.options.itemText(d),h=b.options.tagClass(d);if(c.attr("class",null),c.addClass("tag "+e(h)),c.contents().filter(function(){return 3==this.nodeType})[0].nodeValue=e(g),b.isSelect){var i=a("option",b.$element).filter(function(){return a(this).data("item")===d});i.attr("value",f)}})},items:function(){return this.itemsArray},pushVal:function(){var b=this,c=a.map(b.items(),function(a){return b.options.itemValue(a).toString()});b.$element.val(c,!0).trigger("change")},build:function(b){var e=this;if(e.options=a.extend({},h,b),e.objectItems&&(e.options.freeInput=!1),c(e.options,"itemValue"),c(e.options,"itemText"),d(e.options,"tagClass"),e.options.typeahead){var i=e.options.typeahead||{};d(i,"source"),e.$input.typeahead(a.extend({},i,{source:function(b,c){function d(a){for(var b=[],d=0;d<a.length;d++){var g=e.options.itemText(a[d]);f[g]=a[d],b.push(g)}c(b)}this.map={};var f=this.map,g=i.source(b);a.isFunction(g.success)?g.success(d):a.isFunction(g.then)?g.then(d):a.when(g).then(d)},updater:function(a){return e.add(this.map[a]),this.map[a]},matcher:function(a){return-1!==a.toLowerCase().indexOf(this.query.trim().toLowerCase())},sorter:function(a){return a.sort()},highlighter:function(a){var b=new RegExp("("+this.query+")","gi");return a.replace(b,"<strong>$1</strong>")}}))}if(e.options.typeaheadjs){var j=null,k={},l=e.options.typeaheadjs;a.isArray(l)?(j=l[0],k=l[1]):k=l,e.$input.typeahead(j,k).on("typeahead:selected",a.proxy(function(a,b){k.valueKey?e.add(b[k.valueKey]):e.add(b),e.$input.typeahead("val","")},e))}e.$container.on("click",a.proxy(function(a){e.$element.attr("disabled")||e.$input.removeAttr("disabled"),e.$input.focus()},e)),e.options.addOnBlur&&e.options.freeInput&&e.$input.on("focusout",a.proxy(function(b){0===a(".typeahead, .twitter-typeahead",e.$container).length&&(e.add(e.$input.val()),e.$input.val(""))},e)),e.$container.on("keydown","input",a.proxy(function(b){var c=a(b.target),d=e.findInputWrapper();if(e.$element.attr("disabled"))return void e.$input.attr("disabled","disabled");switch(b.which){case 8:if(0===f(c[0])){var g=d.prev();g.length&&e.remove(g.data("item"))}break;case 46:if(0===f(c[0])){var h=d.next();h.length&&e.remove(h.data("item"))}break;case 37:var i=d.prev();0===c.val().length&&i[0]&&(i.before(d),c.focus());break;case 39:var j=d.next();0===c.val().length&&j[0]&&(j.after(d),c.focus())}var k=c.val().length;Math.ceil(k/5);c.attr("size",Math.max(this.inputSize,c.val().length))},e)),e.$container.on("keypress","input",a.proxy(function(b){var c=a(b.target);if(e.$element.attr("disabled"))return void e.$input.attr("disabled","disabled");var d=c.val(),f=e.options.maxChars&&d.length>=e.options.maxChars;e.options.freeInput&&(g(b,e.options.confirmKeys)||f)&&(0!==d.length&&(e.add(f?d.substr(0,e.options.maxChars):d),c.val("")),e.options.cancelConfirmKeysOnEmpty===!1&&b.preventDefault());var h=c.val().length;Math.ceil(h/5);c.attr("size",Math.max(this.inputSize,c.val().length))},e)),e.$container.on("click","[data-role=remove]",a.proxy(function(b){e.$element.attr("disabled")||e.remove(a(b.target).closest(".tag").data("item"))},e)),e.options.itemValue===h.itemValue&&("INPUT"===e.$element[0].tagName?e.add(e.$element.val()):a("option",e.$element).each(function(){e.add(a(this).attr("value"),!0)}))},destroy:function(){var a=this;a.$container.off("keypress","input"),a.$container.off("click","[role=remove]"),a.$container.remove(),a.$element.removeData("tagsinput"),a.$element.show()},focus:function(){this.$input.focus()},input:function(){return this.$input},findInputWrapper:function(){for(var b=this.$input[0],c=this.$container[0];b&&b.parentNode!==c;)b=b.parentNode;return a(b)}},a.fn.tagsinput=function(c,d,e){var f=[];return this.each(function(){var g=a(this).data("tagsinput");if(g)if(c||d){if(void 0!==g[c]){if(3===g[c].length&&void 0!==e)var h=g[c](d,null,e);else var h=g[c](d);void 0!==h&&f.push(h)}}else f.push(g);else g=new b(this,c),a(this).data("tagsinput",g),f.push(g),"SELECT"===this.tagName&&a("option",a(this)).attr("selected","selected"),a(this).val(a(this).val())}),"string"==typeof c?f.length>1?f:f[0]:f},a.fn.tagsinput.Constructor=b;var i=a("<div />");a(function(){a("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput()})}(window.jQuery);
//# sourceMappingURL=bootstrap-tagsinput.min.js.map
/**!

 @license
 handlebars v4.1.1

Copyright (C) 2011-2017 by Yehuda Katz

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["Handlebars"] = factory();
	else
		root["Handlebars"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _handlebarsRuntime = __webpack_require__(2);

	var _handlebarsRuntime2 = _interopRequireDefault(_handlebarsRuntime);

	// Compiler imports

	var _handlebarsCompilerAst = __webpack_require__(35);

	var _handlebarsCompilerAst2 = _interopRequireDefault(_handlebarsCompilerAst);

	var _handlebarsCompilerBase = __webpack_require__(36);

	var _handlebarsCompilerCompiler = __webpack_require__(41);

	var _handlebarsCompilerJavascriptCompiler = __webpack_require__(42);

	var _handlebarsCompilerJavascriptCompiler2 = _interopRequireDefault(_handlebarsCompilerJavascriptCompiler);

	var _handlebarsCompilerVisitor = __webpack_require__(39);

	var _handlebarsCompilerVisitor2 = _interopRequireDefault(_handlebarsCompilerVisitor);

	var _handlebarsNoConflict = __webpack_require__(34);

	var _handlebarsNoConflict2 = _interopRequireDefault(_handlebarsNoConflict);

	var _create = _handlebarsRuntime2['default'].create;
	function create() {
	  var hb = _create();

	  hb.compile = function (input, options) {
	    return _handlebarsCompilerCompiler.compile(input, options, hb);
	  };
	  hb.precompile = function (input, options) {
	    return _handlebarsCompilerCompiler.precompile(input, options, hb);
	  };

	  hb.AST = _handlebarsCompilerAst2['default'];
	  hb.Compiler = _handlebarsCompilerCompiler.Compiler;
	  hb.JavaScriptCompiler = _handlebarsCompilerJavascriptCompiler2['default'];
	  hb.Parser = _handlebarsCompilerBase.parser;
	  hb.parse = _handlebarsCompilerBase.parse;

	  return hb;
	}

	var inst = create();
	inst.create = create;

	_handlebarsNoConflict2['default'](inst);

	inst.Visitor = _handlebarsCompilerVisitor2['default'];

	inst['default'] = inst;

	exports['default'] = inst;
	module.exports = exports['default'];

/***/ }),
/* 1 */
/***/ (function(module, exports) {

	"use strict";

	exports["default"] = function (obj) {
	  return obj && obj.__esModule ? obj : {
	    "default": obj
	  };
	};

	exports.__esModule = true;

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireWildcard = __webpack_require__(3)['default'];

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _handlebarsBase = __webpack_require__(4);

	var base = _interopRequireWildcard(_handlebarsBase);

	// Each of these augment the Handlebars object. No need to setup here.
	// (This is done to easily share code between commonjs and browse envs)

	var _handlebarsSafeString = __webpack_require__(21);

	var _handlebarsSafeString2 = _interopRequireDefault(_handlebarsSafeString);

	var _handlebarsException = __webpack_require__(6);

	var _handlebarsException2 = _interopRequireDefault(_handlebarsException);

	var _handlebarsUtils = __webpack_require__(5);

	var Utils = _interopRequireWildcard(_handlebarsUtils);

	var _handlebarsRuntime = __webpack_require__(22);

	var runtime = _interopRequireWildcard(_handlebarsRuntime);

	var _handlebarsNoConflict = __webpack_require__(34);

	var _handlebarsNoConflict2 = _interopRequireDefault(_handlebarsNoConflict);

	// For compatibility and usage outside of module systems, make the Handlebars object a namespace
	function create() {
	  var hb = new base.HandlebarsEnvironment();

	  Utils.extend(hb, base);
	  hb.SafeString = _handlebarsSafeString2['default'];
	  hb.Exception = _handlebarsException2['default'];
	  hb.Utils = Utils;
	  hb.escapeExpression = Utils.escapeExpression;

	  hb.VM = runtime;
	  hb.template = function (spec) {
	    return runtime.template(spec, hb);
	  };

	  return hb;
	}

	var inst = create();
	inst.create = create;

	_handlebarsNoConflict2['default'](inst);

	inst['default'] = inst;

	exports['default'] = inst;
	module.exports = exports['default'];

/***/ }),
/* 3 */
/***/ (function(module, exports) {

	"use strict";

	exports["default"] = function (obj) {
	  if (obj && obj.__esModule) {
	    return obj;
	  } else {
	    var newObj = {};

	    if (obj != null) {
	      for (var key in obj) {
	        if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
	      }
	    }

	    newObj["default"] = obj;
	    return newObj;
	  }
	};

	exports.__esModule = true;

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;
	exports.HandlebarsEnvironment = HandlebarsEnvironment;

	var _utils = __webpack_require__(5);

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	var _helpers = __webpack_require__(10);

	var _decorators = __webpack_require__(18);

	var _logger = __webpack_require__(20);

	var _logger2 = _interopRequireDefault(_logger);

	var VERSION = '4.1.1';
	exports.VERSION = VERSION;
	var COMPILER_REVISION = 7;

	exports.COMPILER_REVISION = COMPILER_REVISION;
	var REVISION_CHANGES = {
	  1: '<= 1.0.rc.2', // 1.0.rc.2 is actually rev2 but doesn't report it
	  2: '== 1.0.0-rc.3',
	  3: '== 1.0.0-rc.4',
	  4: '== 1.x.x',
	  5: '== 2.0.0-alpha.x',
	  6: '>= 2.0.0-beta.1',
	  7: '>= 4.0.0'
	};

	exports.REVISION_CHANGES = REVISION_CHANGES;
	var objectType = '[object Object]';

	function HandlebarsEnvironment(helpers, partials, decorators) {
	  this.helpers = helpers || {};
	  this.partials = partials || {};
	  this.decorators = decorators || {};

	  _helpers.registerDefaultHelpers(this);
	  _decorators.registerDefaultDecorators(this);
	}

	HandlebarsEnvironment.prototype = {
	  constructor: HandlebarsEnvironment,

	  logger: _logger2['default'],
	  log: _logger2['default'].log,

	  registerHelper: function registerHelper(name, fn) {
	    if (_utils.toString.call(name) === objectType) {
	      if (fn) {
	        throw new _exception2['default']('Arg not supported with multiple helpers');
	      }
	      _utils.extend(this.helpers, name);
	    } else {
	      this.helpers[name] = fn;
	    }
	  },
	  unregisterHelper: function unregisterHelper(name) {
	    delete this.helpers[name];
	  },

	  registerPartial: function registerPartial(name, partial) {
	    if (_utils.toString.call(name) === objectType) {
	      _utils.extend(this.partials, name);
	    } else {
	      if (typeof partial === 'undefined') {
	        throw new _exception2['default']('Attempting to register a partial called "' + name + '" as undefined');
	      }
	      this.partials[name] = partial;
	    }
	  },
	  unregisterPartial: function unregisterPartial(name) {
	    delete this.partials[name];
	  },

	  registerDecorator: function registerDecorator(name, fn) {
	    if (_utils.toString.call(name) === objectType) {
	      if (fn) {
	        throw new _exception2['default']('Arg not supported with multiple decorators');
	      }
	      _utils.extend(this.decorators, name);
	    } else {
	      this.decorators[name] = fn;
	    }
	  },
	  unregisterDecorator: function unregisterDecorator(name) {
	    delete this.decorators[name];
	  }
	};

	var log = _logger2['default'].log;

	exports.log = log;
	exports.createFrame = _utils.createFrame;
	exports.logger = _logger2['default'];

/***/ }),
/* 5 */
/***/ (function(module, exports) {

	'use strict';

	exports.__esModule = true;
	exports.extend = extend;
	exports.indexOf = indexOf;
	exports.escapeExpression = escapeExpression;
	exports.isEmpty = isEmpty;
	exports.createFrame = createFrame;
	exports.blockParams = blockParams;
	exports.appendContextPath = appendContextPath;
	var escape = {
	  '&': '&amp;',
	  '<': '&lt;',
	  '>': '&gt;',
	  '"': '&quot;',
	  "'": '&#x27;',
	  '`': '&#x60;',
	  '=': '&#x3D;'
	};

	var badChars = /[&<>"'`=]/g,
	    possible = /[&<>"'`=]/;

	function escapeChar(chr) {
	  return escape[chr];
	}

	function extend(obj /* , ...source */) {
	  for (var i = 1; i < arguments.length; i++) {
	    for (var key in arguments[i]) {
	      if (Object.prototype.hasOwnProperty.call(arguments[i], key)) {
	        obj[key] = arguments[i][key];
	      }
	    }
	  }

	  return obj;
	}

	var toString = Object.prototype.toString;

	exports.toString = toString;
	// Sourced from lodash
	// https://github.com/bestiejs/lodash/blob/master/LICENSE.txt
	/* eslint-disable func-style */
	var isFunction = function isFunction(value) {
	  return typeof value === 'function';
	};
	// fallback for older versions of Chrome and Safari
	/* istanbul ignore next */
	if (isFunction(/x/)) {
	  exports.isFunction = isFunction = function (value) {
	    return typeof value === 'function' && toString.call(value) === '[object Function]';
	  };
	}
	exports.isFunction = isFunction;

	/* eslint-enable func-style */

	/* istanbul ignore next */
	var isArray = Array.isArray || function (value) {
	  return value && typeof value === 'object' ? toString.call(value) === '[object Array]' : false;
	};

	exports.isArray = isArray;
	// Older IE versions do not directly support indexOf so we must implement our own, sadly.

	function indexOf(array, value) {
	  for (var i = 0, len = array.length; i < len; i++) {
	    if (array[i] === value) {
	      return i;
	    }
	  }
	  return -1;
	}

	function escapeExpression(string) {
	  if (typeof string !== 'string') {
	    // don't escape SafeStrings, since they're already safe
	    if (string && string.toHTML) {
	      return string.toHTML();
	    } else if (string == null) {
	      return '';
	    } else if (!string) {
	      return string + '';
	    }

	    // Force a string conversion as this will be done by the append regardless and
	    // the regex test will do this transparently behind the scenes, causing issues if
	    // an object's to string has escaped characters in it.
	    string = '' + string;
	  }

	  if (!possible.test(string)) {
	    return string;
	  }
	  return string.replace(badChars, escapeChar);
	}

	function isEmpty(value) {
	  if (!value && value !== 0) {
	    return true;
	  } else if (isArray(value) && value.length === 0) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function createFrame(object) {
	  var frame = extend({}, object);
	  frame._parent = object;
	  return frame;
	}

	function blockParams(params, ids) {
	  params.path = ids;
	  return params;
	}

	function appendContextPath(contextPath, id) {
	  return (contextPath ? contextPath + '.' : '') + id;
	}

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _Object$defineProperty = __webpack_require__(7)['default'];

	exports.__esModule = true;

	var errorProps = ['description', 'fileName', 'lineNumber', 'message', 'name', 'number', 'stack'];

	function Exception(message, node) {
	  var loc = node && node.loc,
	      line = undefined,
	      column = undefined;
	  if (loc) {
	    line = loc.start.line;
	    column = loc.start.column;

	    message += ' - ' + line + ':' + column;
	  }

	  var tmp = Error.prototype.constructor.call(this, message);

	  // Unfortunately errors are not enumerable in Chrome (at least), so `for prop in tmp` doesn't work.
	  for (var idx = 0; idx < errorProps.length; idx++) {
	    this[errorProps[idx]] = tmp[errorProps[idx]];
	  }

	  /* istanbul ignore else */
	  if (Error.captureStackTrace) {
	    Error.captureStackTrace(this, Exception);
	  }

	  try {
	    if (loc) {
	      this.lineNumber = line;

	      // Work around issue under safari where we can't directly set the column value
	      /* istanbul ignore next */
	      if (_Object$defineProperty) {
	        Object.defineProperty(this, 'column', {
	          value: column,
	          enumerable: true
	        });
	      } else {
	        this.column = column;
	      }
	    }
	  } catch (nop) {
	    /* Ignore if the browser is very particular */
	  }
	}

	Exception.prototype = new Error();

	exports['default'] = Exception;
	module.exports = exports['default'];

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(8), __esModule: true };

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

	var $ = __webpack_require__(9);
	module.exports = function defineProperty(it, key, desc){
	  return $.setDesc(it, key, desc);
	};

/***/ }),
/* 9 */
/***/ (function(module, exports) {

	var $Object = Object;
	module.exports = {
	  create:     $Object.create,
	  getProto:   $Object.getPrototypeOf,
	  isEnum:     {}.propertyIsEnumerable,
	  getDesc:    $Object.getOwnPropertyDescriptor,
	  setDesc:    $Object.defineProperty,
	  setDescs:   $Object.defineProperties,
	  getKeys:    $Object.keys,
	  getNames:   $Object.getOwnPropertyNames,
	  getSymbols: $Object.getOwnPropertySymbols,
	  each:       [].forEach
	};

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;
	exports.registerDefaultHelpers = registerDefaultHelpers;

	var _helpersBlockHelperMissing = __webpack_require__(11);

	var _helpersBlockHelperMissing2 = _interopRequireDefault(_helpersBlockHelperMissing);

	var _helpersEach = __webpack_require__(12);

	var _helpersEach2 = _interopRequireDefault(_helpersEach);

	var _helpersHelperMissing = __webpack_require__(13);

	var _helpersHelperMissing2 = _interopRequireDefault(_helpersHelperMissing);

	var _helpersIf = __webpack_require__(14);

	var _helpersIf2 = _interopRequireDefault(_helpersIf);

	var _helpersLog = __webpack_require__(15);

	var _helpersLog2 = _interopRequireDefault(_helpersLog);

	var _helpersLookup = __webpack_require__(16);

	var _helpersLookup2 = _interopRequireDefault(_helpersLookup);

	var _helpersWith = __webpack_require__(17);

	var _helpersWith2 = _interopRequireDefault(_helpersWith);

	function registerDefaultHelpers(instance) {
	  _helpersBlockHelperMissing2['default'](instance);
	  _helpersEach2['default'](instance);
	  _helpersHelperMissing2['default'](instance);
	  _helpersIf2['default'](instance);
	  _helpersLog2['default'](instance);
	  _helpersLookup2['default'](instance);
	  _helpersWith2['default'](instance);
	}

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	exports['default'] = function (instance) {
	  instance.registerHelper('blockHelperMissing', function (context, options) {
	    var inverse = options.inverse,
	        fn = options.fn;

	    if (context === true) {
	      return fn(this);
	    } else if (context === false || context == null) {
	      return inverse(this);
	    } else if (_utils.isArray(context)) {
	      if (context.length > 0) {
	        if (options.ids) {
	          options.ids = [options.name];
	        }

	        return instance.helpers.each(context, options);
	      } else {
	        return inverse(this);
	      }
	    } else {
	      if (options.data && options.ids) {
	        var data = _utils.createFrame(options.data);
	        data.contextPath = _utils.appendContextPath(options.data.contextPath, options.name);
	        options = { data: data };
	      }

	      return fn(context, options);
	    }
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	exports['default'] = function (instance) {
	  instance.registerHelper('each', function (context, options) {
	    if (!options) {
	      throw new _exception2['default']('Must pass iterator to #each');
	    }

	    var fn = options.fn,
	        inverse = options.inverse,
	        i = 0,
	        ret = '',
	        data = undefined,
	        contextPath = undefined;

	    if (options.data && options.ids) {
	      contextPath = _utils.appendContextPath(options.data.contextPath, options.ids[0]) + '.';
	    }

	    if (_utils.isFunction(context)) {
	      context = context.call(this);
	    }

	    if (options.data) {
	      data = _utils.createFrame(options.data);
	    }

	    function execIteration(field, index, last) {
	      if (data) {
	        data.key = field;
	        data.index = index;
	        data.first = index === 0;
	        data.last = !!last;

	        if (contextPath) {
	          data.contextPath = contextPath + field;
	        }
	      }

	      ret = ret + fn(context[field], {
	        data: data,
	        blockParams: _utils.blockParams([context[field], field], [contextPath + field, null])
	      });
	    }

	    if (context && typeof context === 'object') {
	      if (_utils.isArray(context)) {
	        for (var j = context.length; i < j; i++) {
	          if (i in context) {
	            execIteration(i, i, i === context.length - 1);
	          }
	        }
	      } else {
	        var priorKey = undefined;

	        for (var key in context) {
	          if (context.hasOwnProperty(key)) {
	            // We're running the iterations one step out of sync so we can detect
	            // the last iteration without have to scan the object twice and create
	            // an itermediate keys array.
	            if (priorKey !== undefined) {
	              execIteration(priorKey, i - 1);
	            }
	            priorKey = key;
	            i++;
	          }
	        }
	        if (priorKey !== undefined) {
	          execIteration(priorKey, i - 1, true);
	        }
	      }
	    }

	    if (i === 0) {
	      ret = inverse(this);
	    }

	    return ret;
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	exports['default'] = function (instance) {
	  instance.registerHelper('helperMissing', function () /* [args, ]options */{
	    if (arguments.length === 1) {
	      // A missing field in a {{foo}} construct.
	      return undefined;
	    } else {
	      // Someone is actually trying to call something, blow up.
	      throw new _exception2['default']('Missing helper: "' + arguments[arguments.length - 1].name + '"');
	    }
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	exports['default'] = function (instance) {
	  instance.registerHelper('if', function (conditional, options) {
	    if (_utils.isFunction(conditional)) {
	      conditional = conditional.call(this);
	    }

	    // Default behavior is to render the positive path if the value is truthy and not empty.
	    // The `includeZero` option may be set to treat the condtional as purely not empty based on the
	    // behavior of isEmpty. Effectively this determines if 0 is handled by the positive path or negative.
	    if (!options.hash.includeZero && !conditional || _utils.isEmpty(conditional)) {
	      return options.inverse(this);
	    } else {
	      return options.fn(this);
	    }
	  });

	  instance.registerHelper('unless', function (conditional, options) {
	    return instance.helpers['if'].call(this, conditional, { fn: options.inverse, inverse: options.fn, hash: options.hash });
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 15 */
/***/ (function(module, exports) {

	'use strict';

	exports.__esModule = true;

	exports['default'] = function (instance) {
	  instance.registerHelper('log', function () /* message, options */{
	    var args = [undefined],
	        options = arguments[arguments.length - 1];
	    for (var i = 0; i < arguments.length - 1; i++) {
	      args.push(arguments[i]);
	    }

	    var level = 1;
	    if (options.hash.level != null) {
	      level = options.hash.level;
	    } else if (options.data && options.data.level != null) {
	      level = options.data.level;
	    }
	    args[0] = level;

	    instance.log.apply(instance, args);
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 16 */
/***/ (function(module, exports) {

	'use strict';

	exports.__esModule = true;

	exports['default'] = function (instance) {
	  instance.registerHelper('lookup', function (obj, field) {
	    return obj && obj[field];
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	exports['default'] = function (instance) {
	  instance.registerHelper('with', function (context, options) {
	    if (_utils.isFunction(context)) {
	      context = context.call(this);
	    }

	    var fn = options.fn;

	    if (!_utils.isEmpty(context)) {
	      var data = options.data;
	      if (options.data && options.ids) {
	        data = _utils.createFrame(options.data);
	        data.contextPath = _utils.appendContextPath(options.data.contextPath, options.ids[0]);
	      }

	      return fn(context, {
	        data: data,
	        blockParams: _utils.blockParams([context], [data && data.contextPath])
	      });
	    } else {
	      return options.inverse(this);
	    }
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;
	exports.registerDefaultDecorators = registerDefaultDecorators;

	var _decoratorsInline = __webpack_require__(19);

	var _decoratorsInline2 = _interopRequireDefault(_decoratorsInline);

	function registerDefaultDecorators(instance) {
	  _decoratorsInline2['default'](instance);
	}

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	exports['default'] = function (instance) {
	  instance.registerDecorator('inline', function (fn, props, container, options) {
	    var ret = fn;
	    if (!props.partials) {
	      props.partials = {};
	      ret = function (context, options) {
	        // Create a new partials stack frame prior to exec.
	        var original = container.partials;
	        container.partials = _utils.extend({}, original, props.partials);
	        var ret = fn(context, options);
	        container.partials = original;
	        return ret;
	      };
	    }

	    props.partials[options.args[0]] = options.fn;

	    return ret;
	  });
	};

	module.exports = exports['default'];

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	var logger = {
	  methodMap: ['debug', 'info', 'warn', 'error'],
	  level: 'info',

	  // Maps a given level value to the `methodMap` indexes above.
	  lookupLevel: function lookupLevel(level) {
	    if (typeof level === 'string') {
	      var levelMap = _utils.indexOf(logger.methodMap, level.toLowerCase());
	      if (levelMap >= 0) {
	        level = levelMap;
	      } else {
	        level = parseInt(level, 10);
	      }
	    }

	    return level;
	  },

	  // Can be overridden in the host environment
	  log: function log(level) {
	    level = logger.lookupLevel(level);

	    if (typeof console !== 'undefined' && logger.lookupLevel(logger.level) <= level) {
	      var method = logger.methodMap[level];
	      if (!console[method]) {
	        // eslint-disable-line no-console
	        method = 'log';
	      }

	      for (var _len = arguments.length, message = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
	        message[_key - 1] = arguments[_key];
	      }

	      console[method].apply(console, message); // eslint-disable-line no-console
	    }
	  }
	};

	exports['default'] = logger;
	module.exports = exports['default'];

/***/ }),
/* 21 */
/***/ (function(module, exports) {

	// Build out our basic SafeString type
	'use strict';

	exports.__esModule = true;
	function SafeString(string) {
	  this.string = string;
	}

	SafeString.prototype.toString = SafeString.prototype.toHTML = function () {
	  return '' + this.string;
	};

	exports['default'] = SafeString;
	module.exports = exports['default'];

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _Object$seal = __webpack_require__(23)['default'];

	var _interopRequireWildcard = __webpack_require__(3)['default'];

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;
	exports.checkRevision = checkRevision;
	exports.template = template;
	exports.wrapProgram = wrapProgram;
	exports.resolvePartial = resolvePartial;
	exports.invokePartial = invokePartial;
	exports.noop = noop;

	var _utils = __webpack_require__(5);

	var Utils = _interopRequireWildcard(_utils);

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	var _base = __webpack_require__(4);

	function checkRevision(compilerInfo) {
	  var compilerRevision = compilerInfo && compilerInfo[0] || 1,
	      currentRevision = _base.COMPILER_REVISION;

	  if (compilerRevision !== currentRevision) {
	    if (compilerRevision < currentRevision) {
	      var runtimeVersions = _base.REVISION_CHANGES[currentRevision],
	          compilerVersions = _base.REVISION_CHANGES[compilerRevision];
	      throw new _exception2['default']('Template was precompiled with an older version of Handlebars than the current runtime. ' + 'Please update your precompiler to a newer version (' + runtimeVersions + ') or downgrade your runtime to an older version (' + compilerVersions + ').');
	    } else {
	      // Use the embedded version info since the runtime doesn't know about this revision yet
	      throw new _exception2['default']('Template was precompiled with a newer version of Handlebars than the current runtime. ' + 'Please update your runtime to a newer version (' + compilerInfo[1] + ').');
	    }
	  }
	}

	function template(templateSpec, env) {
	  /* istanbul ignore next */
	  if (!env) {
	    throw new _exception2['default']('No environment passed to template');
	  }
	  if (!templateSpec || !templateSpec.main) {
	    throw new _exception2['default']('Unknown template object: ' + typeof templateSpec);
	  }

	  templateSpec.main.decorator = templateSpec.main_d;

	  // Note: Using env.VM references rather than local var references throughout this section to allow
	  // for external users to override these as psuedo-supported APIs.
	  env.VM.checkRevision(templateSpec.compiler);

	  function invokePartialWrapper(partial, context, options) {
	    if (options.hash) {
	      context = Utils.extend({}, context, options.hash);
	      if (options.ids) {
	        options.ids[0] = true;
	      }
	    }

	    partial = env.VM.resolvePartial.call(this, partial, context, options);
	    var result = env.VM.invokePartial.call(this, partial, context, options);

	    if (result == null && env.compile) {
	      options.partials[options.name] = env.compile(partial, templateSpec.compilerOptions, env);
	      result = options.partials[options.name](context, options);
	    }
	    if (result != null) {
	      if (options.indent) {
	        var lines = result.split('\n');
	        for (var i = 0, l = lines.length; i < l; i++) {
	          if (!lines[i] && i + 1 === l) {
	            break;
	          }

	          lines[i] = options.indent + lines[i];
	        }
	        result = lines.join('\n');
	      }
	      return result;
	    } else {
	      throw new _exception2['default']('The partial ' + options.name + ' could not be compiled when running in runtime-only mode');
	    }
	  }

	  // Just add water
	  var container = {
	    strict: function strict(obj, name) {
	      if (!(name in obj)) {
	        throw new _exception2['default']('"' + name + '" not defined in ' + obj);
	      }
	      return obj[name];
	    },
	    lookup: function lookup(depths, name) {
	      var len = depths.length;
	      for (var i = 0; i < len; i++) {
	        if (depths[i] && depths[i][name] != null) {
	          return depths[i][name];
	        }
	      }
	    },
	    lambda: function lambda(current, context) {
	      return typeof current === 'function' ? current.call(context) : current;
	    },

	    escapeExpression: Utils.escapeExpression,
	    invokePartial: invokePartialWrapper,

	    fn: function fn(i) {
	      var ret = templateSpec[i];
	      ret.decorator = templateSpec[i + '_d'];
	      return ret;
	    },

	    programs: [],
	    program: function program(i, data, declaredBlockParams, blockParams, depths) {
	      var programWrapper = this.programs[i],
	          fn = this.fn(i);
	      if (data || depths || blockParams || declaredBlockParams) {
	        programWrapper = wrapProgram(this, i, fn, data, declaredBlockParams, blockParams, depths);
	      } else if (!programWrapper) {
	        programWrapper = this.programs[i] = wrapProgram(this, i, fn);
	      }
	      return programWrapper;
	    },

	    data: function data(value, depth) {
	      while (value && depth--) {
	        value = value._parent;
	      }
	      return value;
	    },
	    merge: function merge(param, common) {
	      var obj = param || common;

	      if (param && common && param !== common) {
	        obj = Utils.extend({}, common, param);
	      }

	      return obj;
	    },
	    // An empty object to use as replacement for null-contexts
	    nullContext: _Object$seal({}),

	    noop: env.VM.noop,
	    compilerInfo: templateSpec.compiler
	  };

	  function ret(context) {
	    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	    var data = options.data;

	    ret._setup(options);
	    if (!options.partial && templateSpec.useData) {
	      data = initData(context, data);
	    }
	    var depths = undefined,
	        blockParams = templateSpec.useBlockParams ? [] : undefined;
	    if (templateSpec.useDepths) {
	      if (options.depths) {
	        depths = context != options.depths[0] ? [context].concat(options.depths) : options.depths;
	      } else {
	        depths = [context];
	      }
	    }

	    function main(context /*, options*/) {
	      return '' + templateSpec.main(container, context, container.helpers, container.partials, data, blockParams, depths);
	    }
	    main = executeDecorators(templateSpec.main, main, container, options.depths || [], data, blockParams);
	    return main(context, options);
	  }
	  ret.isTop = true;

	  ret._setup = function (options) {
	    if (!options.partial) {
	      container.helpers = container.merge(options.helpers, env.helpers);

	      if (templateSpec.usePartial) {
	        container.partials = container.merge(options.partials, env.partials);
	      }
	      if (templateSpec.usePartial || templateSpec.useDecorators) {
	        container.decorators = container.merge(options.decorators, env.decorators);
	      }
	    } else {
	      container.helpers = options.helpers;
	      container.partials = options.partials;
	      container.decorators = options.decorators;
	    }
	  };

	  ret._child = function (i, data, blockParams, depths) {
	    if (templateSpec.useBlockParams && !blockParams) {
	      throw new _exception2['default']('must pass block params');
	    }
	    if (templateSpec.useDepths && !depths) {
	      throw new _exception2['default']('must pass parent depths');
	    }

	    return wrapProgram(container, i, templateSpec[i], data, 0, blockParams, depths);
	  };
	  return ret;
	}

	function wrapProgram(container, i, fn, data, declaredBlockParams, blockParams, depths) {
	  function prog(context) {
	    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	    var currentDepths = depths;
	    if (depths && context != depths[0] && !(context === container.nullContext && depths[0] === null)) {
	      currentDepths = [context].concat(depths);
	    }

	    return fn(container, context, container.helpers, container.partials, options.data || data, blockParams && [options.blockParams].concat(blockParams), currentDepths);
	  }

	  prog = executeDecorators(fn, prog, container, depths, data, blockParams);

	  prog.program = i;
	  prog.depth = depths ? depths.length : 0;
	  prog.blockParams = declaredBlockParams || 0;
	  return prog;
	}

	function resolvePartial(partial, context, options) {
	  if (!partial) {
	    if (options.name === '@partial-block') {
	      partial = options.data['partial-block'];
	    } else {
	      partial = options.partials[options.name];
	    }
	  } else if (!partial.call && !options.name) {
	    // This is a dynamic partial that returned a string
	    options.name = partial;
	    partial = options.partials[partial];
	  }
	  return partial;
	}

	function invokePartial(partial, context, options) {
	  // Use the current closure context to save the partial-block if this partial
	  var currentPartialBlock = options.data && options.data['partial-block'];
	  options.partial = true;
	  if (options.ids) {
	    options.data.contextPath = options.ids[0] || options.data.contextPath;
	  }

	  var partialBlock = undefined;
	  if (options.fn && options.fn !== noop) {
	    (function () {
	      options.data = _base.createFrame(options.data);
	      // Wrapper function to get access to currentPartialBlock from the closure
	      var fn = options.fn;
	      partialBlock = options.data['partial-block'] = function partialBlockWrapper(context) {
	        var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	        // Restore the partial-block from the closure for the execution of the block
	        // i.e. the part inside the block of the partial call.
	        options.data = _base.createFrame(options.data);
	        options.data['partial-block'] = currentPartialBlock;
	        return fn(context, options);
	      };
	      if (fn.partials) {
	        options.partials = Utils.extend({}, options.partials, fn.partials);
	      }
	    })();
	  }

	  if (partial === undefined && partialBlock) {
	    partial = partialBlock;
	  }

	  if (partial === undefined) {
	    throw new _exception2['default']('The partial ' + options.name + ' could not be found');
	  } else if (partial instanceof Function) {
	    return partial(context, options);
	  }
	}

	function noop() {
	  return '';
	}

	function initData(context, data) {
	  if (!data || !('root' in data)) {
	    data = data ? _base.createFrame(data) : {};
	    data.root = context;
	  }
	  return data;
	}

	function executeDecorators(fn, prog, container, depths, data, blockParams) {
	  if (fn.decorator) {
	    var props = {};
	    prog = fn.decorator(prog, props, container, depths && depths[0], data, blockParams, depths);
	    Utils.extend(prog, props);
	  }
	  return prog;
	}

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(24), __esModule: true };

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(25);
	module.exports = __webpack_require__(30).Object.seal;

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.17 Object.seal(O)
	var isObject = __webpack_require__(26);

	__webpack_require__(27)('seal', function($seal){
	  return function seal(it){
	    return $seal && isObject(it) ? $seal(it) : it;
	  };
	});

/***/ }),
/* 26 */
/***/ (function(module, exports) {

	module.exports = function(it){
	  return typeof it === 'object' ? it !== null : typeof it === 'function';
	};

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

	// most Object methods by ES6 should accept primitives
	var $export = __webpack_require__(28)
	  , core    = __webpack_require__(30)
	  , fails   = __webpack_require__(33);
	module.exports = function(KEY, exec){
	  var fn  = (core.Object || {})[KEY] || Object[KEY]
	    , exp = {};
	  exp[KEY] = exec(fn);
	  $export($export.S + $export.F * fails(function(){ fn(1); }), 'Object', exp);
	};

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

	var global    = __webpack_require__(29)
	  , core      = __webpack_require__(30)
	  , ctx       = __webpack_require__(31)
	  , PROTOTYPE = 'prototype';

	var $export = function(type, name, source){
	  var IS_FORCED = type & $export.F
	    , IS_GLOBAL = type & $export.G
	    , IS_STATIC = type & $export.S
	    , IS_PROTO  = type & $export.P
	    , IS_BIND   = type & $export.B
	    , IS_WRAP   = type & $export.W
	    , exports   = IS_GLOBAL ? core : core[name] || (core[name] = {})
	    , target    = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE]
	    , key, own, out;
	  if(IS_GLOBAL)source = name;
	  for(key in source){
	    // contains in native
	    own = !IS_FORCED && target && key in target;
	    if(own && key in exports)continue;
	    // export native or passed
	    out = own ? target[key] : source[key];
	    // prevent global pollution for namespaces
	    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
	    // bind timers to global for call from export context
	    : IS_BIND && own ? ctx(out, global)
	    // wrap global constructors for prevent change them in library
	    : IS_WRAP && target[key] == out ? (function(C){
	      var F = function(param){
	        return this instanceof C ? new C(param) : C(param);
	      };
	      F[PROTOTYPE] = C[PROTOTYPE];
	      return F;
	    // make static versions for prototype methods
	    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
	    if(IS_PROTO)(exports[PROTOTYPE] || (exports[PROTOTYPE] = {}))[key] = out;
	  }
	};
	// type bitmap
	$export.F = 1;  // forced
	$export.G = 2;  // global
	$export.S = 4;  // static
	$export.P = 8;  // proto
	$export.B = 16; // bind
	$export.W = 32; // wrap
	module.exports = $export;

/***/ }),
/* 29 */
/***/ (function(module, exports) {

	// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
	var global = module.exports = typeof window != 'undefined' && window.Math == Math
	  ? window : typeof self != 'undefined' && self.Math == Math ? self : Function('return this')();
	if(typeof __g == 'number')__g = global; // eslint-disable-line no-undef

/***/ }),
/* 30 */
/***/ (function(module, exports) {

	var core = module.exports = {version: '1.2.6'};
	if(typeof __e == 'number')__e = core; // eslint-disable-line no-undef

/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

	// optional / simple context binding
	var aFunction = __webpack_require__(32);
	module.exports = function(fn, that, length){
	  aFunction(fn);
	  if(that === undefined)return fn;
	  switch(length){
	    case 1: return function(a){
	      return fn.call(that, a);
	    };
	    case 2: return function(a, b){
	      return fn.call(that, a, b);
	    };
	    case 3: return function(a, b, c){
	      return fn.call(that, a, b, c);
	    };
	  }
	  return function(/* ...args */){
	    return fn.apply(that, arguments);
	  };
	};

/***/ }),
/* 32 */
/***/ (function(module, exports) {

	module.exports = function(it){
	  if(typeof it != 'function')throw TypeError(it + ' is not a function!');
	  return it;
	};

/***/ }),
/* 33 */
/***/ (function(module, exports) {

	module.exports = function(exec){
	  try {
	    return !!exec();
	  } catch(e){
	    return true;
	  }
	};

/***/ }),
/* 34 */
/***/ (function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/* global window */
	'use strict';

	exports.__esModule = true;

	exports['default'] = function (Handlebars) {
	  /* istanbul ignore next */
	  var root = typeof global !== 'undefined' ? global : window,
	      $Handlebars = root.Handlebars;
	  /* istanbul ignore next */
	  Handlebars.noConflict = function () {
	    if (root.Handlebars === Handlebars) {
	      root.Handlebars = $Handlebars;
	    }
	    return Handlebars;
	  };
	};

	module.exports = exports['default'];
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 35 */
/***/ (function(module, exports) {

	'use strict';

	exports.__esModule = true;
	var AST = {
	  // Public API used to evaluate derived attributes regarding AST nodes
	  helpers: {
	    // a mustache is definitely a helper if:
	    // * it is an eligible helper, and
	    // * it has at least one parameter or hash segment
	    helperExpression: function helperExpression(node) {
	      return node.type === 'SubExpression' || (node.type === 'MustacheStatement' || node.type === 'BlockStatement') && !!(node.params && node.params.length || node.hash);
	    },

	    scopedId: function scopedId(path) {
	      return (/^\.|this\b/.test(path.original)
	      );
	    },

	    // an ID is simple if it only has one part, and that part is not
	    // `..` or `this`.
	    simpleId: function simpleId(path) {
	      return path.parts.length === 1 && !AST.helpers.scopedId(path) && !path.depth;
	    }
	  }
	};

	// Must be exported as an object rather than the root of the module as the jison lexer
	// must modify the object to operate properly.
	exports['default'] = AST;
	module.exports = exports['default'];

/***/ }),
/* 36 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	var _interopRequireWildcard = __webpack_require__(3)['default'];

	exports.__esModule = true;
	exports.parse = parse;

	var _parser = __webpack_require__(37);

	var _parser2 = _interopRequireDefault(_parser);

	var _whitespaceControl = __webpack_require__(38);

	var _whitespaceControl2 = _interopRequireDefault(_whitespaceControl);

	var _helpers = __webpack_require__(40);

	var Helpers = _interopRequireWildcard(_helpers);

	var _utils = __webpack_require__(5);

	exports.parser = _parser2['default'];

	var yy = {};
	_utils.extend(yy, Helpers);

	function parse(input, options) {
	  // Just return if an already-compiled AST was passed in.
	  if (input.type === 'Program') {
	    return input;
	  }

	  _parser2['default'].yy = yy;

	  // Altering the shared object here, but this is ok as parser is a sync operation
	  yy.locInfo = function (locInfo) {
	    return new yy.SourceLocation(options && options.srcName, locInfo);
	  };

	  var strip = new _whitespaceControl2['default'](options);
	  return strip.accept(_parser2['default'].parse(input));
	}

/***/ }),
/* 37 */
/***/ (function(module, exports) {

	// File ignored in coverage tests via setting in .istanbul.yml
	/* Jison generated parser */
	"use strict";

	exports.__esModule = true;
	var handlebars = (function () {
	    var parser = { trace: function trace() {},
	        yy: {},
	        symbols_: { "error": 2, "root": 3, "program": 4, "EOF": 5, "program_repetition0": 6, "statement": 7, "mustache": 8, "block": 9, "rawBlock": 10, "partial": 11, "partialBlock": 12, "content": 13, "COMMENT": 14, "CONTENT": 15, "openRawBlock": 16, "rawBlock_repetition_plus0": 17, "END_RAW_BLOCK": 18, "OPEN_RAW_BLOCK": 19, "helperName": 20, "openRawBlock_repetition0": 21, "openRawBlock_option0": 22, "CLOSE_RAW_BLOCK": 23, "openBlock": 24, "block_option0": 25, "closeBlock": 26, "openInverse": 27, "block_option1": 28, "OPEN_BLOCK": 29, "openBlock_repetition0": 30, "openBlock_option0": 31, "openBlock_option1": 32, "CLOSE": 33, "OPEN_INVERSE": 34, "openInverse_repetition0": 35, "openInverse_option0": 36, "openInverse_option1": 37, "openInverseChain": 38, "OPEN_INVERSE_CHAIN": 39, "openInverseChain_repetition0": 40, "openInverseChain_option0": 41, "openInverseChain_option1": 42, "inverseAndProgram": 43, "INVERSE": 44, "inverseChain": 45, "inverseChain_option0": 46, "OPEN_ENDBLOCK": 47, "OPEN": 48, "mustache_repetition0": 49, "mustache_option0": 50, "OPEN_UNESCAPED": 51, "mustache_repetition1": 52, "mustache_option1": 53, "CLOSE_UNESCAPED": 54, "OPEN_PARTIAL": 55, "partialName": 56, "partial_repetition0": 57, "partial_option0": 58, "openPartialBlock": 59, "OPEN_PARTIAL_BLOCK": 60, "openPartialBlock_repetition0": 61, "openPartialBlock_option0": 62, "param": 63, "sexpr": 64, "OPEN_SEXPR": 65, "sexpr_repetition0": 66, "sexpr_option0": 67, "CLOSE_SEXPR": 68, "hash": 69, "hash_repetition_plus0": 70, "hashSegment": 71, "ID": 72, "EQUALS": 73, "blockParams": 74, "OPEN_BLOCK_PARAMS": 75, "blockParams_repetition_plus0": 76, "CLOSE_BLOCK_PARAMS": 77, "path": 78, "dataName": 79, "STRING": 80, "NUMBER": 81, "BOOLEAN": 82, "UNDEFINED": 83, "NULL": 84, "DATA": 85, "pathSegments": 86, "SEP": 87, "$accept": 0, "$end": 1 },
	        terminals_: { 2: "error", 5: "EOF", 14: "COMMENT", 15: "CONTENT", 18: "END_RAW_BLOCK", 19: "OPEN_RAW_BLOCK", 23: "CLOSE_RAW_BLOCK", 29: "OPEN_BLOCK", 33: "CLOSE", 34: "OPEN_INVERSE", 39: "OPEN_INVERSE_CHAIN", 44: "INVERSE", 47: "OPEN_ENDBLOCK", 48: "OPEN", 51: "OPEN_UNESCAPED", 54: "CLOSE_UNESCAPED", 55: "OPEN_PARTIAL", 60: "OPEN_PARTIAL_BLOCK", 65: "OPEN_SEXPR", 68: "CLOSE_SEXPR", 72: "ID", 73: "EQUALS", 75: "OPEN_BLOCK_PARAMS", 77: "CLOSE_BLOCK_PARAMS", 80: "STRING", 81: "NUMBER", 82: "BOOLEAN", 83: "UNDEFINED", 84: "NULL", 85: "DATA", 87: "SEP" },
	        productions_: [0, [3, 2], [4, 1], [7, 1], [7, 1], [7, 1], [7, 1], [7, 1], [7, 1], [7, 1], [13, 1], [10, 3], [16, 5], [9, 4], [9, 4], [24, 6], [27, 6], [38, 6], [43, 2], [45, 3], [45, 1], [26, 3], [8, 5], [8, 5], [11, 5], [12, 3], [59, 5], [63, 1], [63, 1], [64, 5], [69, 1], [71, 3], [74, 3], [20, 1], [20, 1], [20, 1], [20, 1], [20, 1], [20, 1], [20, 1], [56, 1], [56, 1], [79, 2], [78, 1], [86, 3], [86, 1], [6, 0], [6, 2], [17, 1], [17, 2], [21, 0], [21, 2], [22, 0], [22, 1], [25, 0], [25, 1], [28, 0], [28, 1], [30, 0], [30, 2], [31, 0], [31, 1], [32, 0], [32, 1], [35, 0], [35, 2], [36, 0], [36, 1], [37, 0], [37, 1], [40, 0], [40, 2], [41, 0], [41, 1], [42, 0], [42, 1], [46, 0], [46, 1], [49, 0], [49, 2], [50, 0], [50, 1], [52, 0], [52, 2], [53, 0], [53, 1], [57, 0], [57, 2], [58, 0], [58, 1], [61, 0], [61, 2], [62, 0], [62, 1], [66, 0], [66, 2], [67, 0], [67, 1], [70, 1], [70, 2], [76, 1], [76, 2]],
	        performAction: function anonymous(yytext, yyleng, yylineno, yy, yystate, $$, _$) {

	            var $0 = $$.length - 1;
	            switch (yystate) {
	                case 1:
	                    return $$[$0 - 1];
	                    break;
	                case 2:
	                    this.$ = yy.prepareProgram($$[$0]);
	                    break;
	                case 3:
	                    this.$ = $$[$0];
	                    break;
	                case 4:
	                    this.$ = $$[$0];
	                    break;
	                case 5:
	                    this.$ = $$[$0];
	                    break;
	                case 6:
	                    this.$ = $$[$0];
	                    break;
	                case 7:
	                    this.$ = $$[$0];
	                    break;
	                case 8:
	                    this.$ = $$[$0];
	                    break;
	                case 9:
	                    this.$ = {
	                        type: 'CommentStatement',
	                        value: yy.stripComment($$[$0]),
	                        strip: yy.stripFlags($$[$0], $$[$0]),
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 10:
	                    this.$ = {
	                        type: 'ContentStatement',
	                        original: $$[$0],
	                        value: $$[$0],
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 11:
	                    this.$ = yy.prepareRawBlock($$[$0 - 2], $$[$0 - 1], $$[$0], this._$);
	                    break;
	                case 12:
	                    this.$ = { path: $$[$0 - 3], params: $$[$0 - 2], hash: $$[$0 - 1] };
	                    break;
	                case 13:
	                    this.$ = yy.prepareBlock($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0], false, this._$);
	                    break;
	                case 14:
	                    this.$ = yy.prepareBlock($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0], true, this._$);
	                    break;
	                case 15:
	                    this.$ = { open: $$[$0 - 5], path: $$[$0 - 4], params: $$[$0 - 3], hash: $$[$0 - 2], blockParams: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 5], $$[$0]) };
	                    break;
	                case 16:
	                    this.$ = { path: $$[$0 - 4], params: $$[$0 - 3], hash: $$[$0 - 2], blockParams: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 5], $$[$0]) };
	                    break;
	                case 17:
	                    this.$ = { path: $$[$0 - 4], params: $$[$0 - 3], hash: $$[$0 - 2], blockParams: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 5], $$[$0]) };
	                    break;
	                case 18:
	                    this.$ = { strip: yy.stripFlags($$[$0 - 1], $$[$0 - 1]), program: $$[$0] };
	                    break;
	                case 19:
	                    var inverse = yy.prepareBlock($$[$0 - 2], $$[$0 - 1], $$[$0], $$[$0], false, this._$),
	                        program = yy.prepareProgram([inverse], $$[$0 - 1].loc);
	                    program.chained = true;

	                    this.$ = { strip: $$[$0 - 2].strip, program: program, chain: true };

	                    break;
	                case 20:
	                    this.$ = $$[$0];
	                    break;
	                case 21:
	                    this.$ = { path: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 2], $$[$0]) };
	                    break;
	                case 22:
	                    this.$ = yy.prepareMustache($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0 - 4], yy.stripFlags($$[$0 - 4], $$[$0]), this._$);
	                    break;
	                case 23:
	                    this.$ = yy.prepareMustache($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0 - 4], yy.stripFlags($$[$0 - 4], $$[$0]), this._$);
	                    break;
	                case 24:
	                    this.$ = {
	                        type: 'PartialStatement',
	                        name: $$[$0 - 3],
	                        params: $$[$0 - 2],
	                        hash: $$[$0 - 1],
	                        indent: '',
	                        strip: yy.stripFlags($$[$0 - 4], $$[$0]),
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 25:
	                    this.$ = yy.preparePartialBlock($$[$0 - 2], $$[$0 - 1], $$[$0], this._$);
	                    break;
	                case 26:
	                    this.$ = { path: $$[$0 - 3], params: $$[$0 - 2], hash: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 4], $$[$0]) };
	                    break;
	                case 27:
	                    this.$ = $$[$0];
	                    break;
	                case 28:
	                    this.$ = $$[$0];
	                    break;
	                case 29:
	                    this.$ = {
	                        type: 'SubExpression',
	                        path: $$[$0 - 3],
	                        params: $$[$0 - 2],
	                        hash: $$[$0 - 1],
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 30:
	                    this.$ = { type: 'Hash', pairs: $$[$0], loc: yy.locInfo(this._$) };
	                    break;
	                case 31:
	                    this.$ = { type: 'HashPair', key: yy.id($$[$0 - 2]), value: $$[$0], loc: yy.locInfo(this._$) };
	                    break;
	                case 32:
	                    this.$ = yy.id($$[$0 - 1]);
	                    break;
	                case 33:
	                    this.$ = $$[$0];
	                    break;
	                case 34:
	                    this.$ = $$[$0];
	                    break;
	                case 35:
	                    this.$ = { type: 'StringLiteral', value: $$[$0], original: $$[$0], loc: yy.locInfo(this._$) };
	                    break;
	                case 36:
	                    this.$ = { type: 'NumberLiteral', value: Number($$[$0]), original: Number($$[$0]), loc: yy.locInfo(this._$) };
	                    break;
	                case 37:
	                    this.$ = { type: 'BooleanLiteral', value: $$[$0] === 'true', original: $$[$0] === 'true', loc: yy.locInfo(this._$) };
	                    break;
	                case 38:
	                    this.$ = { type: 'UndefinedLiteral', original: undefined, value: undefined, loc: yy.locInfo(this._$) };
	                    break;
	                case 39:
	                    this.$ = { type: 'NullLiteral', original: null, value: null, loc: yy.locInfo(this._$) };
	                    break;
	                case 40:
	                    this.$ = $$[$0];
	                    break;
	                case 41:
	                    this.$ = $$[$0];
	                    break;
	                case 42:
	                    this.$ = yy.preparePath(true, $$[$0], this._$);
	                    break;
	                case 43:
	                    this.$ = yy.preparePath(false, $$[$0], this._$);
	                    break;
	                case 44:
	                    $$[$0 - 2].push({ part: yy.id($$[$0]), original: $$[$0], separator: $$[$0 - 1] });this.$ = $$[$0 - 2];
	                    break;
	                case 45:
	                    this.$ = [{ part: yy.id($$[$0]), original: $$[$0] }];
	                    break;
	                case 46:
	                    this.$ = [];
	                    break;
	                case 47:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 48:
	                    this.$ = [$$[$0]];
	                    break;
	                case 49:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 50:
	                    this.$ = [];
	                    break;
	                case 51:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 58:
	                    this.$ = [];
	                    break;
	                case 59:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 64:
	                    this.$ = [];
	                    break;
	                case 65:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 70:
	                    this.$ = [];
	                    break;
	                case 71:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 78:
	                    this.$ = [];
	                    break;
	                case 79:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 82:
	                    this.$ = [];
	                    break;
	                case 83:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 86:
	                    this.$ = [];
	                    break;
	                case 87:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 90:
	                    this.$ = [];
	                    break;
	                case 91:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 94:
	                    this.$ = [];
	                    break;
	                case 95:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 98:
	                    this.$ = [$$[$0]];
	                    break;
	                case 99:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 100:
	                    this.$ = [$$[$0]];
	                    break;
	                case 101:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	            }
	        },
	        table: [{ 3: 1, 4: 2, 5: [2, 46], 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 1: [3] }, { 5: [1, 4] }, { 5: [2, 2], 7: 5, 8: 6, 9: 7, 10: 8, 11: 9, 12: 10, 13: 11, 14: [1, 12], 15: [1, 20], 16: 17, 19: [1, 23], 24: 15, 27: 16, 29: [1, 21], 34: [1, 22], 39: [2, 2], 44: [2, 2], 47: [2, 2], 48: [1, 13], 51: [1, 14], 55: [1, 18], 59: 19, 60: [1, 24] }, { 1: [2, 1] }, { 5: [2, 47], 14: [2, 47], 15: [2, 47], 19: [2, 47], 29: [2, 47], 34: [2, 47], 39: [2, 47], 44: [2, 47], 47: [2, 47], 48: [2, 47], 51: [2, 47], 55: [2, 47], 60: [2, 47] }, { 5: [2, 3], 14: [2, 3], 15: [2, 3], 19: [2, 3], 29: [2, 3], 34: [2, 3], 39: [2, 3], 44: [2, 3], 47: [2, 3], 48: [2, 3], 51: [2, 3], 55: [2, 3], 60: [2, 3] }, { 5: [2, 4], 14: [2, 4], 15: [2, 4], 19: [2, 4], 29: [2, 4], 34: [2, 4], 39: [2, 4], 44: [2, 4], 47: [2, 4], 48: [2, 4], 51: [2, 4], 55: [2, 4], 60: [2, 4] }, { 5: [2, 5], 14: [2, 5], 15: [2, 5], 19: [2, 5], 29: [2, 5], 34: [2, 5], 39: [2, 5], 44: [2, 5], 47: [2, 5], 48: [2, 5], 51: [2, 5], 55: [2, 5], 60: [2, 5] }, { 5: [2, 6], 14: [2, 6], 15: [2, 6], 19: [2, 6], 29: [2, 6], 34: [2, 6], 39: [2, 6], 44: [2, 6], 47: [2, 6], 48: [2, 6], 51: [2, 6], 55: [2, 6], 60: [2, 6] }, { 5: [2, 7], 14: [2, 7], 15: [2, 7], 19: [2, 7], 29: [2, 7], 34: [2, 7], 39: [2, 7], 44: [2, 7], 47: [2, 7], 48: [2, 7], 51: [2, 7], 55: [2, 7], 60: [2, 7] }, { 5: [2, 8], 14: [2, 8], 15: [2, 8], 19: [2, 8], 29: [2, 8], 34: [2, 8], 39: [2, 8], 44: [2, 8], 47: [2, 8], 48: [2, 8], 51: [2, 8], 55: [2, 8], 60: [2, 8] }, { 5: [2, 9], 14: [2, 9], 15: [2, 9], 19: [2, 9], 29: [2, 9], 34: [2, 9], 39: [2, 9], 44: [2, 9], 47: [2, 9], 48: [2, 9], 51: [2, 9], 55: [2, 9], 60: [2, 9] }, { 20: 25, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 36, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 4: 37, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 39: [2, 46], 44: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 4: 38, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 44: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 13: 40, 15: [1, 20], 17: 39 }, { 20: 42, 56: 41, 64: 43, 65: [1, 44], 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 4: 45, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 5: [2, 10], 14: [2, 10], 15: [2, 10], 18: [2, 10], 19: [2, 10], 29: [2, 10], 34: [2, 10], 39: [2, 10], 44: [2, 10], 47: [2, 10], 48: [2, 10], 51: [2, 10], 55: [2, 10], 60: [2, 10] }, { 20: 46, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 47, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 48, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 42, 56: 49, 64: 43, 65: [1, 44], 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 33: [2, 78], 49: 50, 65: [2, 78], 72: [2, 78], 80: [2, 78], 81: [2, 78], 82: [2, 78], 83: [2, 78], 84: [2, 78], 85: [2, 78] }, { 23: [2, 33], 33: [2, 33], 54: [2, 33], 65: [2, 33], 68: [2, 33], 72: [2, 33], 75: [2, 33], 80: [2, 33], 81: [2, 33], 82: [2, 33], 83: [2, 33], 84: [2, 33], 85: [2, 33] }, { 23: [2, 34], 33: [2, 34], 54: [2, 34], 65: [2, 34], 68: [2, 34], 72: [2, 34], 75: [2, 34], 80: [2, 34], 81: [2, 34], 82: [2, 34], 83: [2, 34], 84: [2, 34], 85: [2, 34] }, { 23: [2, 35], 33: [2, 35], 54: [2, 35], 65: [2, 35], 68: [2, 35], 72: [2, 35], 75: [2, 35], 80: [2, 35], 81: [2, 35], 82: [2, 35], 83: [2, 35], 84: [2, 35], 85: [2, 35] }, { 23: [2, 36], 33: [2, 36], 54: [2, 36], 65: [2, 36], 68: [2, 36], 72: [2, 36], 75: [2, 36], 80: [2, 36], 81: [2, 36], 82: [2, 36], 83: [2, 36], 84: [2, 36], 85: [2, 36] }, { 23: [2, 37], 33: [2, 37], 54: [2, 37], 65: [2, 37], 68: [2, 37], 72: [2, 37], 75: [2, 37], 80: [2, 37], 81: [2, 37], 82: [2, 37], 83: [2, 37], 84: [2, 37], 85: [2, 37] }, { 23: [2, 38], 33: [2, 38], 54: [2, 38], 65: [2, 38], 68: [2, 38], 72: [2, 38], 75: [2, 38], 80: [2, 38], 81: [2, 38], 82: [2, 38], 83: [2, 38], 84: [2, 38], 85: [2, 38] }, { 23: [2, 39], 33: [2, 39], 54: [2, 39], 65: [2, 39], 68: [2, 39], 72: [2, 39], 75: [2, 39], 80: [2, 39], 81: [2, 39], 82: [2, 39], 83: [2, 39], 84: [2, 39], 85: [2, 39] }, { 23: [2, 43], 33: [2, 43], 54: [2, 43], 65: [2, 43], 68: [2, 43], 72: [2, 43], 75: [2, 43], 80: [2, 43], 81: [2, 43], 82: [2, 43], 83: [2, 43], 84: [2, 43], 85: [2, 43], 87: [1, 51] }, { 72: [1, 35], 86: 52 }, { 23: [2, 45], 33: [2, 45], 54: [2, 45], 65: [2, 45], 68: [2, 45], 72: [2, 45], 75: [2, 45], 80: [2, 45], 81: [2, 45], 82: [2, 45], 83: [2, 45], 84: [2, 45], 85: [2, 45], 87: [2, 45] }, { 52: 53, 54: [2, 82], 65: [2, 82], 72: [2, 82], 80: [2, 82], 81: [2, 82], 82: [2, 82], 83: [2, 82], 84: [2, 82], 85: [2, 82] }, { 25: 54, 38: 56, 39: [1, 58], 43: 57, 44: [1, 59], 45: 55, 47: [2, 54] }, { 28: 60, 43: 61, 44: [1, 59], 47: [2, 56] }, { 13: 63, 15: [1, 20], 18: [1, 62] }, { 15: [2, 48], 18: [2, 48] }, { 33: [2, 86], 57: 64, 65: [2, 86], 72: [2, 86], 80: [2, 86], 81: [2, 86], 82: [2, 86], 83: [2, 86], 84: [2, 86], 85: [2, 86] }, { 33: [2, 40], 65: [2, 40], 72: [2, 40], 80: [2, 40], 81: [2, 40], 82: [2, 40], 83: [2, 40], 84: [2, 40], 85: [2, 40] }, { 33: [2, 41], 65: [2, 41], 72: [2, 41], 80: [2, 41], 81: [2, 41], 82: [2, 41], 83: [2, 41], 84: [2, 41], 85: [2, 41] }, { 20: 65, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 26: 66, 47: [1, 67] }, { 30: 68, 33: [2, 58], 65: [2, 58], 72: [2, 58], 75: [2, 58], 80: [2, 58], 81: [2, 58], 82: [2, 58], 83: [2, 58], 84: [2, 58], 85: [2, 58] }, { 33: [2, 64], 35: 69, 65: [2, 64], 72: [2, 64], 75: [2, 64], 80: [2, 64], 81: [2, 64], 82: [2, 64], 83: [2, 64], 84: [2, 64], 85: [2, 64] }, { 21: 70, 23: [2, 50], 65: [2, 50], 72: [2, 50], 80: [2, 50], 81: [2, 50], 82: [2, 50], 83: [2, 50], 84: [2, 50], 85: [2, 50] }, { 33: [2, 90], 61: 71, 65: [2, 90], 72: [2, 90], 80: [2, 90], 81: [2, 90], 82: [2, 90], 83: [2, 90], 84: [2, 90], 85: [2, 90] }, { 20: 75, 33: [2, 80], 50: 72, 63: 73, 64: 76, 65: [1, 44], 69: 74, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 72: [1, 80] }, { 23: [2, 42], 33: [2, 42], 54: [2, 42], 65: [2, 42], 68: [2, 42], 72: [2, 42], 75: [2, 42], 80: [2, 42], 81: [2, 42], 82: [2, 42], 83: [2, 42], 84: [2, 42], 85: [2, 42], 87: [1, 51] }, { 20: 75, 53: 81, 54: [2, 84], 63: 82, 64: 76, 65: [1, 44], 69: 83, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 26: 84, 47: [1, 67] }, { 47: [2, 55] }, { 4: 85, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 39: [2, 46], 44: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 47: [2, 20] }, { 20: 86, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 4: 87, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 26: 88, 47: [1, 67] }, { 47: [2, 57] }, { 5: [2, 11], 14: [2, 11], 15: [2, 11], 19: [2, 11], 29: [2, 11], 34: [2, 11], 39: [2, 11], 44: [2, 11], 47: [2, 11], 48: [2, 11], 51: [2, 11], 55: [2, 11], 60: [2, 11] }, { 15: [2, 49], 18: [2, 49] }, { 20: 75, 33: [2, 88], 58: 89, 63: 90, 64: 76, 65: [1, 44], 69: 91, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 65: [2, 94], 66: 92, 68: [2, 94], 72: [2, 94], 80: [2, 94], 81: [2, 94], 82: [2, 94], 83: [2, 94], 84: [2, 94], 85: [2, 94] }, { 5: [2, 25], 14: [2, 25], 15: [2, 25], 19: [2, 25], 29: [2, 25], 34: [2, 25], 39: [2, 25], 44: [2, 25], 47: [2, 25], 48: [2, 25], 51: [2, 25], 55: [2, 25], 60: [2, 25] }, { 20: 93, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 31: 94, 33: [2, 60], 63: 95, 64: 76, 65: [1, 44], 69: 96, 70: 77, 71: 78, 72: [1, 79], 75: [2, 60], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 33: [2, 66], 36: 97, 63: 98, 64: 76, 65: [1, 44], 69: 99, 70: 77, 71: 78, 72: [1, 79], 75: [2, 66], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 22: 100, 23: [2, 52], 63: 101, 64: 76, 65: [1, 44], 69: 102, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 33: [2, 92], 62: 103, 63: 104, 64: 76, 65: [1, 44], 69: 105, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 33: [1, 106] }, { 33: [2, 79], 65: [2, 79], 72: [2, 79], 80: [2, 79], 81: [2, 79], 82: [2, 79], 83: [2, 79], 84: [2, 79], 85: [2, 79] }, { 33: [2, 81] }, { 23: [2, 27], 33: [2, 27], 54: [2, 27], 65: [2, 27], 68: [2, 27], 72: [2, 27], 75: [2, 27], 80: [2, 27], 81: [2, 27], 82: [2, 27], 83: [2, 27], 84: [2, 27], 85: [2, 27] }, { 23: [2, 28], 33: [2, 28], 54: [2, 28], 65: [2, 28], 68: [2, 28], 72: [2, 28], 75: [2, 28], 80: [2, 28], 81: [2, 28], 82: [2, 28], 83: [2, 28], 84: [2, 28], 85: [2, 28] }, { 23: [2, 30], 33: [2, 30], 54: [2, 30], 68: [2, 30], 71: 107, 72: [1, 108], 75: [2, 30] }, { 23: [2, 98], 33: [2, 98], 54: [2, 98], 68: [2, 98], 72: [2, 98], 75: [2, 98] }, { 23: [2, 45], 33: [2, 45], 54: [2, 45], 65: [2, 45], 68: [2, 45], 72: [2, 45], 73: [1, 109], 75: [2, 45], 80: [2, 45], 81: [2, 45], 82: [2, 45], 83: [2, 45], 84: [2, 45], 85: [2, 45], 87: [2, 45] }, { 23: [2, 44], 33: [2, 44], 54: [2, 44], 65: [2, 44], 68: [2, 44], 72: [2, 44], 75: [2, 44], 80: [2, 44], 81: [2, 44], 82: [2, 44], 83: [2, 44], 84: [2, 44], 85: [2, 44], 87: [2, 44] }, { 54: [1, 110] }, { 54: [2, 83], 65: [2, 83], 72: [2, 83], 80: [2, 83], 81: [2, 83], 82: [2, 83], 83: [2, 83], 84: [2, 83], 85: [2, 83] }, { 54: [2, 85] }, { 5: [2, 13], 14: [2, 13], 15: [2, 13], 19: [2, 13], 29: [2, 13], 34: [2, 13], 39: [2, 13], 44: [2, 13], 47: [2, 13], 48: [2, 13], 51: [2, 13], 55: [2, 13], 60: [2, 13] }, { 38: 56, 39: [1, 58], 43: 57, 44: [1, 59], 45: 112, 46: 111, 47: [2, 76] }, { 33: [2, 70], 40: 113, 65: [2, 70], 72: [2, 70], 75: [2, 70], 80: [2, 70], 81: [2, 70], 82: [2, 70], 83: [2, 70], 84: [2, 70], 85: [2, 70] }, { 47: [2, 18] }, { 5: [2, 14], 14: [2, 14], 15: [2, 14], 19: [2, 14], 29: [2, 14], 34: [2, 14], 39: [2, 14], 44: [2, 14], 47: [2, 14], 48: [2, 14], 51: [2, 14], 55: [2, 14], 60: [2, 14] }, { 33: [1, 114] }, { 33: [2, 87], 65: [2, 87], 72: [2, 87], 80: [2, 87], 81: [2, 87], 82: [2, 87], 83: [2, 87], 84: [2, 87], 85: [2, 87] }, { 33: [2, 89] }, { 20: 75, 63: 116, 64: 76, 65: [1, 44], 67: 115, 68: [2, 96], 69: 117, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 33: [1, 118] }, { 32: 119, 33: [2, 62], 74: 120, 75: [1, 121] }, { 33: [2, 59], 65: [2, 59], 72: [2, 59], 75: [2, 59], 80: [2, 59], 81: [2, 59], 82: [2, 59], 83: [2, 59], 84: [2, 59], 85: [2, 59] }, { 33: [2, 61], 75: [2, 61] }, { 33: [2, 68], 37: 122, 74: 123, 75: [1, 121] }, { 33: [2, 65], 65: [2, 65], 72: [2, 65], 75: [2, 65], 80: [2, 65], 81: [2, 65], 82: [2, 65], 83: [2, 65], 84: [2, 65], 85: [2, 65] }, { 33: [2, 67], 75: [2, 67] }, { 23: [1, 124] }, { 23: [2, 51], 65: [2, 51], 72: [2, 51], 80: [2, 51], 81: [2, 51], 82: [2, 51], 83: [2, 51], 84: [2, 51], 85: [2, 51] }, { 23: [2, 53] }, { 33: [1, 125] }, { 33: [2, 91], 65: [2, 91], 72: [2, 91], 80: [2, 91], 81: [2, 91], 82: [2, 91], 83: [2, 91], 84: [2, 91], 85: [2, 91] }, { 33: [2, 93] }, { 5: [2, 22], 14: [2, 22], 15: [2, 22], 19: [2, 22], 29: [2, 22], 34: [2, 22], 39: [2, 22], 44: [2, 22], 47: [2, 22], 48: [2, 22], 51: [2, 22], 55: [2, 22], 60: [2, 22] }, { 23: [2, 99], 33: [2, 99], 54: [2, 99], 68: [2, 99], 72: [2, 99], 75: [2, 99] }, { 73: [1, 109] }, { 20: 75, 63: 126, 64: 76, 65: [1, 44], 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 5: [2, 23], 14: [2, 23], 15: [2, 23], 19: [2, 23], 29: [2, 23], 34: [2, 23], 39: [2, 23], 44: [2, 23], 47: [2, 23], 48: [2, 23], 51: [2, 23], 55: [2, 23], 60: [2, 23] }, { 47: [2, 19] }, { 47: [2, 77] }, { 20: 75, 33: [2, 72], 41: 127, 63: 128, 64: 76, 65: [1, 44], 69: 129, 70: 77, 71: 78, 72: [1, 79], 75: [2, 72], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 5: [2, 24], 14: [2, 24], 15: [2, 24], 19: [2, 24], 29: [2, 24], 34: [2, 24], 39: [2, 24], 44: [2, 24], 47: [2, 24], 48: [2, 24], 51: [2, 24], 55: [2, 24], 60: [2, 24] }, { 68: [1, 130] }, { 65: [2, 95], 68: [2, 95], 72: [2, 95], 80: [2, 95], 81: [2, 95], 82: [2, 95], 83: [2, 95], 84: [2, 95], 85: [2, 95] }, { 68: [2, 97] }, { 5: [2, 21], 14: [2, 21], 15: [2, 21], 19: [2, 21], 29: [2, 21], 34: [2, 21], 39: [2, 21], 44: [2, 21], 47: [2, 21], 48: [2, 21], 51: [2, 21], 55: [2, 21], 60: [2, 21] }, { 33: [1, 131] }, { 33: [2, 63] }, { 72: [1, 133], 76: 132 }, { 33: [1, 134] }, { 33: [2, 69] }, { 15: [2, 12] }, { 14: [2, 26], 15: [2, 26], 19: [2, 26], 29: [2, 26], 34: [2, 26], 47: [2, 26], 48: [2, 26], 51: [2, 26], 55: [2, 26], 60: [2, 26] }, { 23: [2, 31], 33: [2, 31], 54: [2, 31], 68: [2, 31], 72: [2, 31], 75: [2, 31] }, { 33: [2, 74], 42: 135, 74: 136, 75: [1, 121] }, { 33: [2, 71], 65: [2, 71], 72: [2, 71], 75: [2, 71], 80: [2, 71], 81: [2, 71], 82: [2, 71], 83: [2, 71], 84: [2, 71], 85: [2, 71] }, { 33: [2, 73], 75: [2, 73] }, { 23: [2, 29], 33: [2, 29], 54: [2, 29], 65: [2, 29], 68: [2, 29], 72: [2, 29], 75: [2, 29], 80: [2, 29], 81: [2, 29], 82: [2, 29], 83: [2, 29], 84: [2, 29], 85: [2, 29] }, { 14: [2, 15], 15: [2, 15], 19: [2, 15], 29: [2, 15], 34: [2, 15], 39: [2, 15], 44: [2, 15], 47: [2, 15], 48: [2, 15], 51: [2, 15], 55: [2, 15], 60: [2, 15] }, { 72: [1, 138], 77: [1, 137] }, { 72: [2, 100], 77: [2, 100] }, { 14: [2, 16], 15: [2, 16], 19: [2, 16], 29: [2, 16], 34: [2, 16], 44: [2, 16], 47: [2, 16], 48: [2, 16], 51: [2, 16], 55: [2, 16], 60: [2, 16] }, { 33: [1, 139] }, { 33: [2, 75] }, { 33: [2, 32] }, { 72: [2, 101], 77: [2, 101] }, { 14: [2, 17], 15: [2, 17], 19: [2, 17], 29: [2, 17], 34: [2, 17], 39: [2, 17], 44: [2, 17], 47: [2, 17], 48: [2, 17], 51: [2, 17], 55: [2, 17], 60: [2, 17] }],
	        defaultActions: { 4: [2, 1], 55: [2, 55], 57: [2, 20], 61: [2, 57], 74: [2, 81], 83: [2, 85], 87: [2, 18], 91: [2, 89], 102: [2, 53], 105: [2, 93], 111: [2, 19], 112: [2, 77], 117: [2, 97], 120: [2, 63], 123: [2, 69], 124: [2, 12], 136: [2, 75], 137: [2, 32] },
	        parseError: function parseError(str, hash) {
	            throw new Error(str);
	        },
	        parse: function parse(input) {
	            var self = this,
	                stack = [0],
	                vstack = [null],
	                lstack = [],
	                table = this.table,
	                yytext = "",
	                yylineno = 0,
	                yyleng = 0,
	                recovering = 0,
	                TERROR = 2,
	                EOF = 1;
	            this.lexer.setInput(input);
	            this.lexer.yy = this.yy;
	            this.yy.lexer = this.lexer;
	            this.yy.parser = this;
	            if (typeof this.lexer.yylloc == "undefined") this.lexer.yylloc = {};
	            var yyloc = this.lexer.yylloc;
	            lstack.push(yyloc);
	            var ranges = this.lexer.options && this.lexer.options.ranges;
	            if (typeof this.yy.parseError === "function") this.parseError = this.yy.parseError;
	            function popStack(n) {
	                stack.length = stack.length - 2 * n;
	                vstack.length = vstack.length - n;
	                lstack.length = lstack.length - n;
	            }
	            function lex() {
	                var token;
	                token = self.lexer.lex() || 1;
	                if (typeof token !== "number") {
	                    token = self.symbols_[token] || token;
	                }
	                return token;
	            }
	            var symbol,
	                preErrorSymbol,
	                state,
	                action,
	                a,
	                r,
	                yyval = {},
	                p,
	                len,
	                newState,
	                expected;
	            while (true) {
	                state = stack[stack.length - 1];
	                if (this.defaultActions[state]) {
	                    action = this.defaultActions[state];
	                } else {
	                    if (symbol === null || typeof symbol == "undefined") {
	                        symbol = lex();
	                    }
	                    action = table[state] && table[state][symbol];
	                }
	                if (typeof action === "undefined" || !action.length || !action[0]) {
	                    var errStr = "";
	                    if (!recovering) {
	                        expected = [];
	                        for (p in table[state]) if (this.terminals_[p] && p > 2) {
	                            expected.push("'" + this.terminals_[p] + "'");
	                        }
	                        if (this.lexer.showPosition) {
	                            errStr = "Parse error on line " + (yylineno + 1) + ":\n" + this.lexer.showPosition() + "\nExpecting " + expected.join(", ") + ", got '" + (this.terminals_[symbol] || symbol) + "'";
	                        } else {
	                            errStr = "Parse error on line " + (yylineno + 1) + ": Unexpected " + (symbol == 1 ? "end of input" : "'" + (this.terminals_[symbol] || symbol) + "'");
	                        }
	                        this.parseError(errStr, { text: this.lexer.match, token: this.terminals_[symbol] || symbol, line: this.lexer.yylineno, loc: yyloc, expected: expected });
	                    }
	                }
	                if (action[0] instanceof Array && action.length > 1) {
	                    throw new Error("Parse Error: multiple actions possible at state: " + state + ", token: " + symbol);
	                }
	                switch (action[0]) {
	                    case 1:
	                        stack.push(symbol);
	                        vstack.push(this.lexer.yytext);
	                        lstack.push(this.lexer.yylloc);
	                        stack.push(action[1]);
	                        symbol = null;
	                        if (!preErrorSymbol) {
	                            yyleng = this.lexer.yyleng;
	                            yytext = this.lexer.yytext;
	                            yylineno = this.lexer.yylineno;
	                            yyloc = this.lexer.yylloc;
	                            if (recovering > 0) recovering--;
	                        } else {
	                            symbol = preErrorSymbol;
	                            preErrorSymbol = null;
	                        }
	                        break;
	                    case 2:
	                        len = this.productions_[action[1]][1];
	                        yyval.$ = vstack[vstack.length - len];
	                        yyval._$ = { first_line: lstack[lstack.length - (len || 1)].first_line, last_line: lstack[lstack.length - 1].last_line, first_column: lstack[lstack.length - (len || 1)].first_column, last_column: lstack[lstack.length - 1].last_column };
	                        if (ranges) {
	                            yyval._$.range = [lstack[lstack.length - (len || 1)].range[0], lstack[lstack.length - 1].range[1]];
	                        }
	                        r = this.performAction.call(yyval, yytext, yyleng, yylineno, this.yy, action[1], vstack, lstack);
	                        if (typeof r !== "undefined") {
	                            return r;
	                        }
	                        if (len) {
	                            stack = stack.slice(0, -1 * len * 2);
	                            vstack = vstack.slice(0, -1 * len);
	                            lstack = lstack.slice(0, -1 * len);
	                        }
	                        stack.push(this.productions_[action[1]][0]);
	                        vstack.push(yyval.$);
	                        lstack.push(yyval._$);
	                        newState = table[stack[stack.length - 2]][stack[stack.length - 1]];
	                        stack.push(newState);
	                        break;
	                    case 3:
	                        return true;
	                }
	            }
	            return true;
	        }
	    };
	    /* Jison generated lexer */
	    var lexer = (function () {
	        var lexer = { EOF: 1,
	            parseError: function parseError(str, hash) {
	                if (this.yy.parser) {
	                    this.yy.parser.parseError(str, hash);
	                } else {
	                    throw new Error(str);
	                }
	            },
	            setInput: function setInput(input) {
	                this._input = input;
	                this._more = this._less = this.done = false;
	                this.yylineno = this.yyleng = 0;
	                this.yytext = this.matched = this.match = '';
	                this.conditionStack = ['INITIAL'];
	                this.yylloc = { first_line: 1, first_column: 0, last_line: 1, last_column: 0 };
	                if (this.options.ranges) this.yylloc.range = [0, 0];
	                this.offset = 0;
	                return this;
	            },
	            input: function input() {
	                var ch = this._input[0];
	                this.yytext += ch;
	                this.yyleng++;
	                this.offset++;
	                this.match += ch;
	                this.matched += ch;
	                var lines = ch.match(/(?:\r\n?|\n).*/g);
	                if (lines) {
	                    this.yylineno++;
	                    this.yylloc.last_line++;
	                } else {
	                    this.yylloc.last_column++;
	                }
	                if (this.options.ranges) this.yylloc.range[1]++;

	                this._input = this._input.slice(1);
	                return ch;
	            },
	            unput: function unput(ch) {
	                var len = ch.length;
	                var lines = ch.split(/(?:\r\n?|\n)/g);

	                this._input = ch + this._input;
	                this.yytext = this.yytext.substr(0, this.yytext.length - len - 1);
	                //this.yyleng -= len;
	                this.offset -= len;
	                var oldLines = this.match.split(/(?:\r\n?|\n)/g);
	                this.match = this.match.substr(0, this.match.length - 1);
	                this.matched = this.matched.substr(0, this.matched.length - 1);

	                if (lines.length - 1) this.yylineno -= lines.length - 1;
	                var r = this.yylloc.range;

	                this.yylloc = { first_line: this.yylloc.first_line,
	                    last_line: this.yylineno + 1,
	                    first_column: this.yylloc.first_column,
	                    last_column: lines ? (lines.length === oldLines.length ? this.yylloc.first_column : 0) + oldLines[oldLines.length - lines.length].length - lines[0].length : this.yylloc.first_column - len
	                };

	                if (this.options.ranges) {
	                    this.yylloc.range = [r[0], r[0] + this.yyleng - len];
	                }
	                return this;
	            },
	            more: function more() {
	                this._more = true;
	                return this;
	            },
	            less: function less(n) {
	                this.unput(this.match.slice(n));
	            },
	            pastInput: function pastInput() {
	                var past = this.matched.substr(0, this.matched.length - this.match.length);
	                return (past.length > 20 ? '...' : '') + past.substr(-20).replace(/\n/g, "");
	            },
	            upcomingInput: function upcomingInput() {
	                var next = this.match;
	                if (next.length < 20) {
	                    next += this._input.substr(0, 20 - next.length);
	                }
	                return (next.substr(0, 20) + (next.length > 20 ? '...' : '')).replace(/\n/g, "");
	            },
	            showPosition: function showPosition() {
	                var pre = this.pastInput();
	                var c = new Array(pre.length + 1).join("-");
	                return pre + this.upcomingInput() + "\n" + c + "^";
	            },
	            next: function next() {
	                if (this.done) {
	                    return this.EOF;
	                }
	                if (!this._input) this.done = true;

	                var token, match, tempMatch, index, col, lines;
	                if (!this._more) {
	                    this.yytext = '';
	                    this.match = '';
	                }
	                var rules = this._currentRules();
	                for (var i = 0; i < rules.length; i++) {
	                    tempMatch = this._input.match(this.rules[rules[i]]);
	                    if (tempMatch && (!match || tempMatch[0].length > match[0].length)) {
	                        match = tempMatch;
	                        index = i;
	                        if (!this.options.flex) break;
	                    }
	                }
	                if (match) {
	                    lines = match[0].match(/(?:\r\n?|\n).*/g);
	                    if (lines) this.yylineno += lines.length;
	                    this.yylloc = { first_line: this.yylloc.last_line,
	                        last_line: this.yylineno + 1,
	                        first_column: this.yylloc.last_column,
	                        last_column: lines ? lines[lines.length - 1].length - lines[lines.length - 1].match(/\r?\n?/)[0].length : this.yylloc.last_column + match[0].length };
	                    this.yytext += match[0];
	                    this.match += match[0];
	                    this.matches = match;
	                    this.yyleng = this.yytext.length;
	                    if (this.options.ranges) {
	                        this.yylloc.range = [this.offset, this.offset += this.yyleng];
	                    }
	                    this._more = false;
	                    this._input = this._input.slice(match[0].length);
	                    this.matched += match[0];
	                    token = this.performAction.call(this, this.yy, this, rules[index], this.conditionStack[this.conditionStack.length - 1]);
	                    if (this.done && this._input) this.done = false;
	                    if (token) return token;else return;
	                }
	                if (this._input === "") {
	                    return this.EOF;
	                } else {
	                    return this.parseError('Lexical error on line ' + (this.yylineno + 1) + '. Unrecognized text.\n' + this.showPosition(), { text: "", token: null, line: this.yylineno });
	                }
	            },
	            lex: function lex() {
	                var r = this.next();
	                if (typeof r !== 'undefined') {
	                    return r;
	                } else {
	                    return this.lex();
	                }
	            },
	            begin: function begin(condition) {
	                this.conditionStack.push(condition);
	            },
	            popState: function popState() {
	                return this.conditionStack.pop();
	            },
	            _currentRules: function _currentRules() {
	                return this.conditions[this.conditionStack[this.conditionStack.length - 1]].rules;
	            },
	            topState: function topState() {
	                return this.conditionStack[this.conditionStack.length - 2];
	            },
	            pushState: function begin(condition) {
	                this.begin(condition);
	            } };
	        lexer.options = {};
	        lexer.performAction = function anonymous(yy, yy_, $avoiding_name_collisions, YY_START) {

	            function strip(start, end) {
	                return yy_.yytext = yy_.yytext.substring(start, yy_.yyleng - end + start);
	            }

	            var YYSTATE = YY_START;
	            switch ($avoiding_name_collisions) {
	                case 0:
	                    if (yy_.yytext.slice(-2) === "\\\\") {
	                        strip(0, 1);
	                        this.begin("mu");
	                    } else if (yy_.yytext.slice(-1) === "\\") {
	                        strip(0, 1);
	                        this.begin("emu");
	                    } else {
	                        this.begin("mu");
	                    }
	                    if (yy_.yytext) return 15;

	                    break;
	                case 1:
	                    return 15;
	                    break;
	                case 2:
	                    this.popState();
	                    return 15;

	                    break;
	                case 3:
	                    this.begin('raw');return 15;
	                    break;
	                case 4:
	                    this.popState();
	                    // Should be using `this.topState()` below, but it currently
	                    // returns the second top instead of the first top. Opened an
	                    // issue about it at https://github.com/zaach/jison/issues/291
	                    if (this.conditionStack[this.conditionStack.length - 1] === 'raw') {
	                        return 15;
	                    } else {
	                        strip(5, 9);
	                        return 'END_RAW_BLOCK';
	                    }

	                    break;
	                case 5:
	                    return 15;
	                    break;
	                case 6:
	                    this.popState();
	                    return 14;

	                    break;
	                case 7:
	                    return 65;
	                    break;
	                case 8:
	                    return 68;
	                    break;
	                case 9:
	                    return 19;
	                    break;
	                case 10:
	                    this.popState();
	                    this.begin('raw');
	                    return 23;

	                    break;
	                case 11:
	                    return 55;
	                    break;
	                case 12:
	                    return 60;
	                    break;
	                case 13:
	                    return 29;
	                    break;
	                case 14:
	                    return 47;
	                    break;
	                case 15:
	                    this.popState();return 44;
	                    break;
	                case 16:
	                    this.popState();return 44;
	                    break;
	                case 17:
	                    return 34;
	                    break;
	                case 18:
	                    return 39;
	                    break;
	                case 19:
	                    return 51;
	                    break;
	                case 20:
	                    return 48;
	                    break;
	                case 21:
	                    this.unput(yy_.yytext);
	                    this.popState();
	                    this.begin('com');

	                    break;
	                case 22:
	                    this.popState();
	                    return 14;

	                    break;
	                case 23:
	                    return 48;
	                    break;
	                case 24:
	                    return 73;
	                    break;
	                case 25:
	                    return 72;
	                    break;
	                case 26:
	                    return 72;
	                    break;
	                case 27:
	                    return 87;
	                    break;
	                case 28:
	                    // ignore whitespace
	                    break;
	                case 29:
	                    this.popState();return 54;
	                    break;
	                case 30:
	                    this.popState();return 33;
	                    break;
	                case 31:
	                    yy_.yytext = strip(1, 2).replace(/\\"/g, '"');return 80;
	                    break;
	                case 32:
	                    yy_.yytext = strip(1, 2).replace(/\\'/g, "'");return 80;
	                    break;
	                case 33:
	                    return 85;
	                    break;
	                case 34:
	                    return 82;
	                    break;
	                case 35:
	                    return 82;
	                    break;
	                case 36:
	                    return 83;
	                    break;
	                case 37:
	                    return 84;
	                    break;
	                case 38:
	                    return 81;
	                    break;
	                case 39:
	                    return 75;
	                    break;
	                case 40:
	                    return 77;
	                    break;
	                case 41:
	                    return 72;
	                    break;
	                case 42:
	                    yy_.yytext = yy_.yytext.replace(/\\([\\\]])/g, '$1');return 72;
	                    break;
	                case 43:
	                    return 'INVALID';
	                    break;
	                case 44:
	                    return 5;
	                    break;
	            }
	        };
	        lexer.rules = [/^(?:[^\x00]*?(?=(\{\{)))/, /^(?:[^\x00]+)/, /^(?:[^\x00]{2,}?(?=(\{\{|\\\{\{|\\\\\{\{|$)))/, /^(?:\{\{\{\{(?=[^\/]))/, /^(?:\{\{\{\{\/[^\s!"#%-,\.\/;->@\[-\^`\{-~]+(?=[=}\s\/.])\}\}\}\})/, /^(?:[^\x00]*?(?=(\{\{\{\{)))/, /^(?:[\s\S]*?--(~)?\}\})/, /^(?:\()/, /^(?:\))/, /^(?:\{\{\{\{)/, /^(?:\}\}\}\})/, /^(?:\{\{(~)?>)/, /^(?:\{\{(~)?#>)/, /^(?:\{\{(~)?#\*?)/, /^(?:\{\{(~)?\/)/, /^(?:\{\{(~)?\^\s*(~)?\}\})/, /^(?:\{\{(~)?\s*else\s*(~)?\}\})/, /^(?:\{\{(~)?\^)/, /^(?:\{\{(~)?\s*else\b)/, /^(?:\{\{(~)?\{)/, /^(?:\{\{(~)?&)/, /^(?:\{\{(~)?!--)/, /^(?:\{\{(~)?![\s\S]*?\}\})/, /^(?:\{\{(~)?\*?)/, /^(?:=)/, /^(?:\.\.)/, /^(?:\.(?=([=~}\s\/.)|])))/, /^(?:[\/.])/, /^(?:\s+)/, /^(?:\}(~)?\}\})/, /^(?:(~)?\}\})/, /^(?:"(\\["]|[^"])*")/, /^(?:'(\\[']|[^'])*')/, /^(?:@)/, /^(?:true(?=([~}\s)])))/, /^(?:false(?=([~}\s)])))/, /^(?:undefined(?=([~}\s)])))/, /^(?:null(?=([~}\s)])))/, /^(?:-?[0-9]+(?:\.[0-9]+)?(?=([~}\s)])))/, /^(?:as\s+\|)/, /^(?:\|)/, /^(?:([^\s!"#%-,\.\/;->@\[-\^`\{-~]+(?=([=~}\s\/.)|]))))/, /^(?:\[(\\\]|[^\]])*\])/, /^(?:.)/, /^(?:$)/];
	        lexer.conditions = { "mu": { "rules": [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44], "inclusive": false }, "emu": { "rules": [2], "inclusive": false }, "com": { "rules": [6], "inclusive": false }, "raw": { "rules": [3, 4, 5], "inclusive": false }, "INITIAL": { "rules": [0, 1, 44], "inclusive": true } };
	        return lexer;
	    })();
	    parser.lexer = lexer;
	    function Parser() {
	        this.yy = {};
	    }Parser.prototype = parser;parser.Parser = Parser;
	    return new Parser();
	})();exports["default"] = handlebars;
	module.exports = exports["default"];

/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _visitor = __webpack_require__(39);

	var _visitor2 = _interopRequireDefault(_visitor);

	function WhitespaceControl() {
	  var options = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];

	  this.options = options;
	}
	WhitespaceControl.prototype = new _visitor2['default']();

	WhitespaceControl.prototype.Program = function (program) {
	  var doStandalone = !this.options.ignoreStandalone;

	  var isRoot = !this.isRootSeen;
	  this.isRootSeen = true;

	  var body = program.body;
	  for (var i = 0, l = body.length; i < l; i++) {
	    var current = body[i],
	        strip = this.accept(current);

	    if (!strip) {
	      continue;
	    }

	    var _isPrevWhitespace = isPrevWhitespace(body, i, isRoot),
	        _isNextWhitespace = isNextWhitespace(body, i, isRoot),
	        openStandalone = strip.openStandalone && _isPrevWhitespace,
	        closeStandalone = strip.closeStandalone && _isNextWhitespace,
	        inlineStandalone = strip.inlineStandalone && _isPrevWhitespace && _isNextWhitespace;

	    if (strip.close) {
	      omitRight(body, i, true);
	    }
	    if (strip.open) {
	      omitLeft(body, i, true);
	    }

	    if (doStandalone && inlineStandalone) {
	      omitRight(body, i);

	      if (omitLeft(body, i)) {
	        // If we are on a standalone node, save the indent info for partials
	        if (current.type === 'PartialStatement') {
	          // Pull out the whitespace from the final line
	          current.indent = /([ \t]+$)/.exec(body[i - 1].original)[1];
	        }
	      }
	    }
	    if (doStandalone && openStandalone) {
	      omitRight((current.program || current.inverse).body);

	      // Strip out the previous content node if it's whitespace only
	      omitLeft(body, i);
	    }
	    if (doStandalone && closeStandalone) {
	      // Always strip the next node
	      omitRight(body, i);

	      omitLeft((current.inverse || current.program).body);
	    }
	  }

	  return program;
	};

	WhitespaceControl.prototype.BlockStatement = WhitespaceControl.prototype.DecoratorBlock = WhitespaceControl.prototype.PartialBlockStatement = function (block) {
	  this.accept(block.program);
	  this.accept(block.inverse);

	  // Find the inverse program that is involed with whitespace stripping.
	  var program = block.program || block.inverse,
	      inverse = block.program && block.inverse,
	      firstInverse = inverse,
	      lastInverse = inverse;

	  if (inverse && inverse.chained) {
	    firstInverse = inverse.body[0].program;

	    // Walk the inverse chain to find the last inverse that is actually in the chain.
	    while (lastInverse.chained) {
	      lastInverse = lastInverse.body[lastInverse.body.length - 1].program;
	    }
	  }

	  var strip = {
	    open: block.openStrip.open,
	    close: block.closeStrip.close,

	    // Determine the standalone candiacy. Basically flag our content as being possibly standalone
	    // so our parent can determine if we actually are standalone
	    openStandalone: isNextWhitespace(program.body),
	    closeStandalone: isPrevWhitespace((firstInverse || program).body)
	  };

	  if (block.openStrip.close) {
	    omitRight(program.body, null, true);
	  }

	  if (inverse) {
	    var inverseStrip = block.inverseStrip;

	    if (inverseStrip.open) {
	      omitLeft(program.body, null, true);
	    }

	    if (inverseStrip.close) {
	      omitRight(firstInverse.body, null, true);
	    }
	    if (block.closeStrip.open) {
	      omitLeft(lastInverse.body, null, true);
	    }

	    // Find standalone else statments
	    if (!this.options.ignoreStandalone && isPrevWhitespace(program.body) && isNextWhitespace(firstInverse.body)) {
	      omitLeft(program.body);
	      omitRight(firstInverse.body);
	    }
	  } else if (block.closeStrip.open) {
	    omitLeft(program.body, null, true);
	  }

	  return strip;
	};

	WhitespaceControl.prototype.Decorator = WhitespaceControl.prototype.MustacheStatement = function (mustache) {
	  return mustache.strip;
	};

	WhitespaceControl.prototype.PartialStatement = WhitespaceControl.prototype.CommentStatement = function (node) {
	  /* istanbul ignore next */
	  var strip = node.strip || {};
	  return {
	    inlineStandalone: true,
	    open: strip.open,
	    close: strip.close
	  };
	};

	function isPrevWhitespace(body, i, isRoot) {
	  if (i === undefined) {
	    i = body.length;
	  }

	  // Nodes that end with newlines are considered whitespace (but are special
	  // cased for strip operations)
	  var prev = body[i - 1],
	      sibling = body[i - 2];
	  if (!prev) {
	    return isRoot;
	  }

	  if (prev.type === 'ContentStatement') {
	    return (sibling || !isRoot ? /\r?\n\s*?$/ : /(^|\r?\n)\s*?$/).test(prev.original);
	  }
	}
	function isNextWhitespace(body, i, isRoot) {
	  if (i === undefined) {
	    i = -1;
	  }

	  var next = body[i + 1],
	      sibling = body[i + 2];
	  if (!next) {
	    return isRoot;
	  }

	  if (next.type === 'ContentStatement') {
	    return (sibling || !isRoot ? /^\s*?\r?\n/ : /^\s*?(\r?\n|$)/).test(next.original);
	  }
	}

	// Marks the node to the right of the position as omitted.
	// I.e. {{foo}}' ' will mark the ' ' node as omitted.
	//
	// If i is undefined, then the first child will be marked as such.
	//
	// If mulitple is truthy then all whitespace will be stripped out until non-whitespace
	// content is met.
	function omitRight(body, i, multiple) {
	  var current = body[i == null ? 0 : i + 1];
	  if (!current || current.type !== 'ContentStatement' || !multiple && current.rightStripped) {
	    return;
	  }

	  var original = current.value;
	  current.value = current.value.replace(multiple ? /^\s+/ : /^[ \t]*\r?\n?/, '');
	  current.rightStripped = current.value !== original;
	}

	// Marks the node to the left of the position as omitted.
	// I.e. ' '{{foo}} will mark the ' ' node as omitted.
	//
	// If i is undefined then the last child will be marked as such.
	//
	// If mulitple is truthy then all whitespace will be stripped out until non-whitespace
	// content is met.
	function omitLeft(body, i, multiple) {
	  var current = body[i == null ? body.length - 1 : i - 1];
	  if (!current || current.type !== 'ContentStatement' || !multiple && current.leftStripped) {
	    return;
	  }

	  // We omit the last node if it's whitespace only and not preceeded by a non-content node.
	  var original = current.value;
	  current.value = current.value.replace(multiple ? /\s+$/ : /[ \t]+$/, '');
	  current.leftStripped = current.value !== original;
	  return current.leftStripped;
	}

	exports['default'] = WhitespaceControl;
	module.exports = exports['default'];

/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	function Visitor() {
	  this.parents = [];
	}

	Visitor.prototype = {
	  constructor: Visitor,
	  mutating: false,

	  // Visits a given value. If mutating, will replace the value if necessary.
	  acceptKey: function acceptKey(node, name) {
	    var value = this.accept(node[name]);
	    if (this.mutating) {
	      // Hacky sanity check: This may have a few false positives for type for the helper
	      // methods but will generally do the right thing without a lot of overhead.
	      if (value && !Visitor.prototype[value.type]) {
	        throw new _exception2['default']('Unexpected node type "' + value.type + '" found when accepting ' + name + ' on ' + node.type);
	      }
	      node[name] = value;
	    }
	  },

	  // Performs an accept operation with added sanity check to ensure
	  // required keys are not removed.
	  acceptRequired: function acceptRequired(node, name) {
	    this.acceptKey(node, name);

	    if (!node[name]) {
	      throw new _exception2['default'](node.type + ' requires ' + name);
	    }
	  },

	  // Traverses a given array. If mutating, empty respnses will be removed
	  // for child elements.
	  acceptArray: function acceptArray(array) {
	    for (var i = 0, l = array.length; i < l; i++) {
	      this.acceptKey(array, i);

	      if (!array[i]) {
	        array.splice(i, 1);
	        i--;
	        l--;
	      }
	    }
	  },

	  accept: function accept(object) {
	    if (!object) {
	      return;
	    }

	    /* istanbul ignore next: Sanity code */
	    if (!this[object.type]) {
	      throw new _exception2['default']('Unknown type: ' + object.type, object);
	    }

	    if (this.current) {
	      this.parents.unshift(this.current);
	    }
	    this.current = object;

	    var ret = this[object.type](object);

	    this.current = this.parents.shift();

	    if (!this.mutating || ret) {
	      return ret;
	    } else if (ret !== false) {
	      return object;
	    }
	  },

	  Program: function Program(program) {
	    this.acceptArray(program.body);
	  },

	  MustacheStatement: visitSubExpression,
	  Decorator: visitSubExpression,

	  BlockStatement: visitBlock,
	  DecoratorBlock: visitBlock,

	  PartialStatement: visitPartial,
	  PartialBlockStatement: function PartialBlockStatement(partial) {
	    visitPartial.call(this, partial);

	    this.acceptKey(partial, 'program');
	  },

	  ContentStatement: function ContentStatement() /* content */{},
	  CommentStatement: function CommentStatement() /* comment */{},

	  SubExpression: visitSubExpression,

	  PathExpression: function PathExpression() /* path */{},

	  StringLiteral: function StringLiteral() /* string */{},
	  NumberLiteral: function NumberLiteral() /* number */{},
	  BooleanLiteral: function BooleanLiteral() /* bool */{},
	  UndefinedLiteral: function UndefinedLiteral() /* literal */{},
	  NullLiteral: function NullLiteral() /* literal */{},

	  Hash: function Hash(hash) {
	    this.acceptArray(hash.pairs);
	  },
	  HashPair: function HashPair(pair) {
	    this.acceptRequired(pair, 'value');
	  }
	};

	function visitSubExpression(mustache) {
	  this.acceptRequired(mustache, 'path');
	  this.acceptArray(mustache.params);
	  this.acceptKey(mustache, 'hash');
	}
	function visitBlock(block) {
	  visitSubExpression.call(this, block);

	  this.acceptKey(block, 'program');
	  this.acceptKey(block, 'inverse');
	}
	function visitPartial(partial) {
	  this.acceptRequired(partial, 'name');
	  this.acceptArray(partial.params);
	  this.acceptKey(partial, 'hash');
	}

	exports['default'] = Visitor;
	module.exports = exports['default'];

/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;
	exports.SourceLocation = SourceLocation;
	exports.id = id;
	exports.stripFlags = stripFlags;
	exports.stripComment = stripComment;
	exports.preparePath = preparePath;
	exports.prepareMustache = prepareMustache;
	exports.prepareRawBlock = prepareRawBlock;
	exports.prepareBlock = prepareBlock;
	exports.prepareProgram = prepareProgram;
	exports.preparePartialBlock = preparePartialBlock;

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	function validateClose(open, close) {
	  close = close.path ? close.path.original : close;

	  if (open.path.original !== close) {
	    var errorNode = { loc: open.path.loc };

	    throw new _exception2['default'](open.path.original + " doesn't match " + close, errorNode);
	  }
	}

	function SourceLocation(source, locInfo) {
	  this.source = source;
	  this.start = {
	    line: locInfo.first_line,
	    column: locInfo.first_column
	  };
	  this.end = {
	    line: locInfo.last_line,
	    column: locInfo.last_column
	  };
	}

	function id(token) {
	  if (/^\[.*\]$/.test(token)) {
	    return token.substring(1, token.length - 1);
	  } else {
	    return token;
	  }
	}

	function stripFlags(open, close) {
	  return {
	    open: open.charAt(2) === '~',
	    close: close.charAt(close.length - 3) === '~'
	  };
	}

	function stripComment(comment) {
	  return comment.replace(/^\{\{~?!-?-?/, '').replace(/-?-?~?\}\}$/, '');
	}

	function preparePath(data, parts, loc) {
	  loc = this.locInfo(loc);

	  var original = data ? '@' : '',
	      dig = [],
	      depth = 0;

	  for (var i = 0, l = parts.length; i < l; i++) {
	    var part = parts[i].part,

	    // If we have [] syntax then we do not treat path references as operators,
	    // i.e. foo.[this] resolves to approximately context.foo['this']
	    isLiteral = parts[i].original !== part;
	    original += (parts[i].separator || '') + part;

	    if (!isLiteral && (part === '..' || part === '.' || part === 'this')) {
	      if (dig.length > 0) {
	        throw new _exception2['default']('Invalid path: ' + original, { loc: loc });
	      } else if (part === '..') {
	        depth++;
	      }
	    } else {
	      dig.push(part);
	    }
	  }

	  return {
	    type: 'PathExpression',
	    data: data,
	    depth: depth,
	    parts: dig,
	    original: original,
	    loc: loc
	  };
	}

	function prepareMustache(path, params, hash, open, strip, locInfo) {
	  // Must use charAt to support IE pre-10
	  var escapeFlag = open.charAt(3) || open.charAt(2),
	      escaped = escapeFlag !== '{' && escapeFlag !== '&';

	  var decorator = /\*/.test(open);
	  return {
	    type: decorator ? 'Decorator' : 'MustacheStatement',
	    path: path,
	    params: params,
	    hash: hash,
	    escaped: escaped,
	    strip: strip,
	    loc: this.locInfo(locInfo)
	  };
	}

	function prepareRawBlock(openRawBlock, contents, close, locInfo) {
	  validateClose(openRawBlock, close);

	  locInfo = this.locInfo(locInfo);
	  var program = {
	    type: 'Program',
	    body: contents,
	    strip: {},
	    loc: locInfo
	  };

	  return {
	    type: 'BlockStatement',
	    path: openRawBlock.path,
	    params: openRawBlock.params,
	    hash: openRawBlock.hash,
	    program: program,
	    openStrip: {},
	    inverseStrip: {},
	    closeStrip: {},
	    loc: locInfo
	  };
	}

	function prepareBlock(openBlock, program, inverseAndProgram, close, inverted, locInfo) {
	  if (close && close.path) {
	    validateClose(openBlock, close);
	  }

	  var decorator = /\*/.test(openBlock.open);

	  program.blockParams = openBlock.blockParams;

	  var inverse = undefined,
	      inverseStrip = undefined;

	  if (inverseAndProgram) {
	    if (decorator) {
	      throw new _exception2['default']('Unexpected inverse block on decorator', inverseAndProgram);
	    }

	    if (inverseAndProgram.chain) {
	      inverseAndProgram.program.body[0].closeStrip = close.strip;
	    }

	    inverseStrip = inverseAndProgram.strip;
	    inverse = inverseAndProgram.program;
	  }

	  if (inverted) {
	    inverted = inverse;
	    inverse = program;
	    program = inverted;
	  }

	  return {
	    type: decorator ? 'DecoratorBlock' : 'BlockStatement',
	    path: openBlock.path,
	    params: openBlock.params,
	    hash: openBlock.hash,
	    program: program,
	    inverse: inverse,
	    openStrip: openBlock.strip,
	    inverseStrip: inverseStrip,
	    closeStrip: close && close.strip,
	    loc: this.locInfo(locInfo)
	  };
	}

	function prepareProgram(statements, loc) {
	  if (!loc && statements.length) {
	    var firstLoc = statements[0].loc,
	        lastLoc = statements[statements.length - 1].loc;

	    /* istanbul ignore else */
	    if (firstLoc && lastLoc) {
	      loc = {
	        source: firstLoc.source,
	        start: {
	          line: firstLoc.start.line,
	          column: firstLoc.start.column
	        },
	        end: {
	          line: lastLoc.end.line,
	          column: lastLoc.end.column
	        }
	      };
	    }
	  }

	  return {
	    type: 'Program',
	    body: statements,
	    strip: {},
	    loc: loc
	  };
	}

	function preparePartialBlock(open, program, close, locInfo) {
	  validateClose(open, close);

	  return {
	    type: 'PartialBlockStatement',
	    name: open.path,
	    params: open.params,
	    hash: open.hash,
	    program: program,
	    openStrip: open.strip,
	    closeStrip: close && close.strip,
	    loc: this.locInfo(locInfo)
	  };
	}

/***/ }),
/* 41 */
/***/ (function(module, exports, __webpack_require__) {

	/* eslint-disable new-cap */

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;
	exports.Compiler = Compiler;
	exports.precompile = precompile;
	exports.compile = compile;

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	var _utils = __webpack_require__(5);

	var _ast = __webpack_require__(35);

	var _ast2 = _interopRequireDefault(_ast);

	var slice = [].slice;

	function Compiler() {}

	// the foundHelper register will disambiguate helper lookup from finding a
	// function in a context. This is necessary for mustache compatibility, which
	// requires that context functions in blocks are evaluated by blockHelperMissing,
	// and then proceed as if the resulting value was provided to blockHelperMissing.

	Compiler.prototype = {
	  compiler: Compiler,

	  equals: function equals(other) {
	    var len = this.opcodes.length;
	    if (other.opcodes.length !== len) {
	      return false;
	    }

	    for (var i = 0; i < len; i++) {
	      var opcode = this.opcodes[i],
	          otherOpcode = other.opcodes[i];
	      if (opcode.opcode !== otherOpcode.opcode || !argEquals(opcode.args, otherOpcode.args)) {
	        return false;
	      }
	    }

	    // We know that length is the same between the two arrays because they are directly tied
	    // to the opcode behavior above.
	    len = this.children.length;
	    for (var i = 0; i < len; i++) {
	      if (!this.children[i].equals(other.children[i])) {
	        return false;
	      }
	    }

	    return true;
	  },

	  guid: 0,

	  compile: function compile(program, options) {
	    this.sourceNode = [];
	    this.opcodes = [];
	    this.children = [];
	    this.options = options;
	    this.stringParams = options.stringParams;
	    this.trackIds = options.trackIds;

	    options.blockParams = options.blockParams || [];

	    // These changes will propagate to the other compiler components
	    var knownHelpers = options.knownHelpers;
	    options.knownHelpers = {
	      'helperMissing': true,
	      'blockHelperMissing': true,
	      'each': true,
	      'if': true,
	      'unless': true,
	      'with': true,
	      'log': true,
	      'lookup': true
	    };
	    if (knownHelpers) {
	      // the next line should use "Object.keys", but the code has been like this a long time and changing it, might
	      // cause backwards-compatibility issues... It's an old library...
	      // eslint-disable-next-line guard-for-in
	      for (var _name in knownHelpers) {
	        this.options.knownHelpers[_name] = knownHelpers[_name];
	      }
	    }

	    return this.accept(program);
	  },

	  compileProgram: function compileProgram(program) {
	    var childCompiler = new this.compiler(),
	        // eslint-disable-line new-cap
	    result = childCompiler.compile(program, this.options),
	        guid = this.guid++;

	    this.usePartial = this.usePartial || result.usePartial;

	    this.children[guid] = result;
	    this.useDepths = this.useDepths || result.useDepths;

	    return guid;
	  },

	  accept: function accept(node) {
	    /* istanbul ignore next: Sanity code */
	    if (!this[node.type]) {
	      throw new _exception2['default']('Unknown type: ' + node.type, node);
	    }

	    this.sourceNode.unshift(node);
	    var ret = this[node.type](node);
	    this.sourceNode.shift();
	    return ret;
	  },

	  Program: function Program(program) {
	    this.options.blockParams.unshift(program.blockParams);

	    var body = program.body,
	        bodyLength = body.length;
	    for (var i = 0; i < bodyLength; i++) {
	      this.accept(body[i]);
	    }

	    this.options.blockParams.shift();

	    this.isSimple = bodyLength === 1;
	    this.blockParams = program.blockParams ? program.blockParams.length : 0;

	    return this;
	  },

	  BlockStatement: function BlockStatement(block) {
	    transformLiteralToPath(block);

	    var program = block.program,
	        inverse = block.inverse;

	    program = program && this.compileProgram(program);
	    inverse = inverse && this.compileProgram(inverse);

	    var type = this.classifySexpr(block);

	    if (type === 'helper') {
	      this.helperSexpr(block, program, inverse);
	    } else if (type === 'simple') {
	      this.simpleSexpr(block);

	      // now that the simple mustache is resolved, we need to
	      // evaluate it by executing `blockHelperMissing`
	      this.opcode('pushProgram', program);
	      this.opcode('pushProgram', inverse);
	      this.opcode('emptyHash');
	      this.opcode('blockValue', block.path.original);
	    } else {
	      this.ambiguousSexpr(block, program, inverse);

	      // now that the simple mustache is resolved, we need to
	      // evaluate it by executing `blockHelperMissing`
	      this.opcode('pushProgram', program);
	      this.opcode('pushProgram', inverse);
	      this.opcode('emptyHash');
	      this.opcode('ambiguousBlockValue');
	    }

	    this.opcode('append');
	  },

	  DecoratorBlock: function DecoratorBlock(decorator) {
	    var program = decorator.program && this.compileProgram(decorator.program);
	    var params = this.setupFullMustacheParams(decorator, program, undefined),
	        path = decorator.path;

	    this.useDecorators = true;
	    this.opcode('registerDecorator', params.length, path.original);
	  },

	  PartialStatement: function PartialStatement(partial) {
	    this.usePartial = true;

	    var program = partial.program;
	    if (program) {
	      program = this.compileProgram(partial.program);
	    }

	    var params = partial.params;
	    if (params.length > 1) {
	      throw new _exception2['default']('Unsupported number of partial arguments: ' + params.length, partial);
	    } else if (!params.length) {
	      if (this.options.explicitPartialContext) {
	        this.opcode('pushLiteral', 'undefined');
	      } else {
	        params.push({ type: 'PathExpression', parts: [], depth: 0 });
	      }
	    }

	    var partialName = partial.name.original,
	        isDynamic = partial.name.type === 'SubExpression';
	    if (isDynamic) {
	      this.accept(partial.name);
	    }

	    this.setupFullMustacheParams(partial, program, undefined, true);

	    var indent = partial.indent || '';
	    if (this.options.preventIndent && indent) {
	      this.opcode('appendContent', indent);
	      indent = '';
	    }

	    this.opcode('invokePartial', isDynamic, partialName, indent);
	    this.opcode('append');
	  },
	  PartialBlockStatement: function PartialBlockStatement(partialBlock) {
	    this.PartialStatement(partialBlock);
	  },

	  MustacheStatement: function MustacheStatement(mustache) {
	    this.SubExpression(mustache);

	    if (mustache.escaped && !this.options.noEscape) {
	      this.opcode('appendEscaped');
	    } else {
	      this.opcode('append');
	    }
	  },
	  Decorator: function Decorator(decorator) {
	    this.DecoratorBlock(decorator);
	  },

	  ContentStatement: function ContentStatement(content) {
	    if (content.value) {
	      this.opcode('appendContent', content.value);
	    }
	  },

	  CommentStatement: function CommentStatement() {},

	  SubExpression: function SubExpression(sexpr) {
	    transformLiteralToPath(sexpr);
	    var type = this.classifySexpr(sexpr);

	    if (type === 'simple') {
	      this.simpleSexpr(sexpr);
	    } else if (type === 'helper') {
	      this.helperSexpr(sexpr);
	    } else {
	      this.ambiguousSexpr(sexpr);
	    }
	  },
	  ambiguousSexpr: function ambiguousSexpr(sexpr, program, inverse) {
	    var path = sexpr.path,
	        name = path.parts[0],
	        isBlock = program != null || inverse != null;

	    this.opcode('getContext', path.depth);

	    this.opcode('pushProgram', program);
	    this.opcode('pushProgram', inverse);

	    path.strict = true;
	    this.accept(path);

	    this.opcode('invokeAmbiguous', name, isBlock);
	  },

	  simpleSexpr: function simpleSexpr(sexpr) {
	    var path = sexpr.path;
	    path.strict = true;
	    this.accept(path);
	    this.opcode('resolvePossibleLambda');
	  },

	  helperSexpr: function helperSexpr(sexpr, program, inverse) {
	    var params = this.setupFullMustacheParams(sexpr, program, inverse),
	        path = sexpr.path,
	        name = path.parts[0];

	    if (this.options.knownHelpers[name]) {
	      this.opcode('invokeKnownHelper', params.length, name);
	    } else if (this.options.knownHelpersOnly) {
	      throw new _exception2['default']('You specified knownHelpersOnly, but used the unknown helper ' + name, sexpr);
	    } else {
	      path.strict = true;
	      path.falsy = true;

	      this.accept(path);
	      this.opcode('invokeHelper', params.length, path.original, _ast2['default'].helpers.simpleId(path));
	    }
	  },

	  PathExpression: function PathExpression(path) {
	    this.addDepth(path.depth);
	    this.opcode('getContext', path.depth);

	    var name = path.parts[0],
	        scoped = _ast2['default'].helpers.scopedId(path),
	        blockParamId = !path.depth && !scoped && this.blockParamIndex(name);

	    if (blockParamId) {
	      this.opcode('lookupBlockParam', blockParamId, path.parts);
	    } else if (!name) {
	      // Context reference, i.e. `{{foo .}}` or `{{foo ..}}`
	      this.opcode('pushContext');
	    } else if (path.data) {
	      this.options.data = true;
	      this.opcode('lookupData', path.depth, path.parts, path.strict);
	    } else {
	      this.opcode('lookupOnContext', path.parts, path.falsy, path.strict, scoped);
	    }
	  },

	  StringLiteral: function StringLiteral(string) {
	    this.opcode('pushString', string.value);
	  },

	  NumberLiteral: function NumberLiteral(number) {
	    this.opcode('pushLiteral', number.value);
	  },

	  BooleanLiteral: function BooleanLiteral(bool) {
	    this.opcode('pushLiteral', bool.value);
	  },

	  UndefinedLiteral: function UndefinedLiteral() {
	    this.opcode('pushLiteral', 'undefined');
	  },

	  NullLiteral: function NullLiteral() {
	    this.opcode('pushLiteral', 'null');
	  },

	  Hash: function Hash(hash) {
	    var pairs = hash.pairs,
	        i = 0,
	        l = pairs.length;

	    this.opcode('pushHash');

	    for (; i < l; i++) {
	      this.pushParam(pairs[i].value);
	    }
	    while (i--) {
	      this.opcode('assignToHash', pairs[i].key);
	    }
	    this.opcode('popHash');
	  },

	  // HELPERS
	  opcode: function opcode(name) {
	    this.opcodes.push({ opcode: name, args: slice.call(arguments, 1), loc: this.sourceNode[0].loc });
	  },

	  addDepth: function addDepth(depth) {
	    if (!depth) {
	      return;
	    }

	    this.useDepths = true;
	  },

	  classifySexpr: function classifySexpr(sexpr) {
	    var isSimple = _ast2['default'].helpers.simpleId(sexpr.path);

	    var isBlockParam = isSimple && !!this.blockParamIndex(sexpr.path.parts[0]);

	    // a mustache is an eligible helper if:
	    // * its id is simple (a single part, not `this` or `..`)
	    var isHelper = !isBlockParam && _ast2['default'].helpers.helperExpression(sexpr);

	    // if a mustache is an eligible helper but not a definite
	    // helper, it is ambiguous, and will be resolved in a later
	    // pass or at runtime.
	    var isEligible = !isBlockParam && (isHelper || isSimple);

	    // if ambiguous, we can possibly resolve the ambiguity now
	    // An eligible helper is one that does not have a complex path, i.e. `this.foo`, `../foo` etc.
	    if (isEligible && !isHelper) {
	      var _name2 = sexpr.path.parts[0],
	          options = this.options;

	      if (options.knownHelpers[_name2]) {
	        isHelper = true;
	      } else if (options.knownHelpersOnly) {
	        isEligible = false;
	      }
	    }

	    if (isHelper) {
	      return 'helper';
	    } else if (isEligible) {
	      return 'ambiguous';
	    } else {
	      return 'simple';
	    }
	  },

	  pushParams: function pushParams(params) {
	    for (var i = 0, l = params.length; i < l; i++) {
	      this.pushParam(params[i]);
	    }
	  },

	  pushParam: function pushParam(val) {
	    var value = val.value != null ? val.value : val.original || '';

	    if (this.stringParams) {
	      if (value.replace) {
	        value = value.replace(/^(\.?\.\/)*/g, '').replace(/\//g, '.');
	      }

	      if (val.depth) {
	        this.addDepth(val.depth);
	      }
	      this.opcode('getContext', val.depth || 0);
	      this.opcode('pushStringParam', value, val.type);

	      if (val.type === 'SubExpression') {
	        // SubExpressions get evaluated and passed in
	        // in string params mode.
	        this.accept(val);
	      }
	    } else {
	      if (this.trackIds) {
	        var blockParamIndex = undefined;
	        if (val.parts && !_ast2['default'].helpers.scopedId(val) && !val.depth) {
	          blockParamIndex = this.blockParamIndex(val.parts[0]);
	        }
	        if (blockParamIndex) {
	          var blockParamChild = val.parts.slice(1).join('.');
	          this.opcode('pushId', 'BlockParam', blockParamIndex, blockParamChild);
	        } else {
	          value = val.original || value;
	          if (value.replace) {
	            value = value.replace(/^this(?:\.|$)/, '').replace(/^\.\//, '').replace(/^\.$/, '');
	          }

	          this.opcode('pushId', val.type, value);
	        }
	      }
	      this.accept(val);
	    }
	  },

	  setupFullMustacheParams: function setupFullMustacheParams(sexpr, program, inverse, omitEmpty) {
	    var params = sexpr.params;
	    this.pushParams(params);

	    this.opcode('pushProgram', program);
	    this.opcode('pushProgram', inverse);

	    if (sexpr.hash) {
	      this.accept(sexpr.hash);
	    } else {
	      this.opcode('emptyHash', omitEmpty);
	    }

	    return params;
	  },

	  blockParamIndex: function blockParamIndex(name) {
	    for (var depth = 0, len = this.options.blockParams.length; depth < len; depth++) {
	      var blockParams = this.options.blockParams[depth],
	          param = blockParams && _utils.indexOf(blockParams, name);
	      if (blockParams && param >= 0) {
	        return [depth, param];
	      }
	    }
	  }
	};

	function precompile(input, options, env) {
	  if (input == null || typeof input !== 'string' && input.type !== 'Program') {
	    throw new _exception2['default']('You must pass a string or Handlebars AST to Handlebars.precompile. You passed ' + input);
	  }

	  options = options || {};
	  if (!('data' in options)) {
	    options.data = true;
	  }
	  if (options.compat) {
	    options.useDepths = true;
	  }

	  var ast = env.parse(input, options),
	      environment = new env.Compiler().compile(ast, options);
	  return new env.JavaScriptCompiler().compile(environment, options);
	}

	function compile(input, options, env) {
	  if (options === undefined) options = {};

	  if (input == null || typeof input !== 'string' && input.type !== 'Program') {
	    throw new _exception2['default']('You must pass a string or Handlebars AST to Handlebars.compile. You passed ' + input);
	  }

	  options = _utils.extend({}, options);
	  if (!('data' in options)) {
	    options.data = true;
	  }
	  if (options.compat) {
	    options.useDepths = true;
	  }

	  var compiled = undefined;

	  function compileInput() {
	    var ast = env.parse(input, options),
	        environment = new env.Compiler().compile(ast, options),
	        templateSpec = new env.JavaScriptCompiler().compile(environment, options, undefined, true);
	    return env.template(templateSpec);
	  }

	  // Template is only compiled on first use and cached after that point.
	  function ret(context, execOptions) {
	    if (!compiled) {
	      compiled = compileInput();
	    }
	    return compiled.call(this, context, execOptions);
	  }
	  ret._setup = function (setupOptions) {
	    if (!compiled) {
	      compiled = compileInput();
	    }
	    return compiled._setup(setupOptions);
	  };
	  ret._child = function (i, data, blockParams, depths) {
	    if (!compiled) {
	      compiled = compileInput();
	    }
	    return compiled._child(i, data, blockParams, depths);
	  };
	  return ret;
	}

	function argEquals(a, b) {
	  if (a === b) {
	    return true;
	  }

	  if (_utils.isArray(a) && _utils.isArray(b) && a.length === b.length) {
	    for (var i = 0; i < a.length; i++) {
	      if (!argEquals(a[i], b[i])) {
	        return false;
	      }
	    }
	    return true;
	  }
	}

	function transformLiteralToPath(sexpr) {
	  if (!sexpr.path.parts) {
	    var literal = sexpr.path;
	    // Casting to string here to make false and 0 literal values play nicely with the rest
	    // of the system.
	    sexpr.path = {
	      type: 'PathExpression',
	      data: false,
	      depth: 0,
	      parts: [literal.original + ''],
	      original: literal.original + '',
	      loc: literal.loc
	    };
	  }
	}

/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(1)['default'];

	exports.__esModule = true;

	var _base = __webpack_require__(4);

	var _exception = __webpack_require__(6);

	var _exception2 = _interopRequireDefault(_exception);

	var _utils = __webpack_require__(5);

	var _codeGen = __webpack_require__(43);

	var _codeGen2 = _interopRequireDefault(_codeGen);

	function Literal(value) {
	  this.value = value;
	}

	function JavaScriptCompiler() {}

	JavaScriptCompiler.prototype = {
	  // PUBLIC API: You can override these methods in a subclass to provide
	  // alternative compiled forms for name lookup and buffering semantics
	  nameLookup: function nameLookup(parent, name /* , type*/) {
	    if (name === 'constructor') {
	      return ['(', parent, '.propertyIsEnumerable(\'constructor\') ? ', parent, '.constructor : undefined', ')'];
	    }
	    if (JavaScriptCompiler.isValidJavaScriptVariableName(name)) {
	      return [parent, '.', name];
	    } else {
	      return [parent, '[', JSON.stringify(name), ']'];
	    }
	  },
	  depthedLookup: function depthedLookup(name) {
	    return [this.aliasable('container.lookup'), '(depths, "', name, '")'];
	  },

	  compilerInfo: function compilerInfo() {
	    var revision = _base.COMPILER_REVISION,
	        versions = _base.REVISION_CHANGES[revision];
	    return [revision, versions];
	  },

	  appendToBuffer: function appendToBuffer(source, location, explicit) {
	    // Force a source as this simplifies the merge logic.
	    if (!_utils.isArray(source)) {
	      source = [source];
	    }
	    source = this.source.wrap(source, location);

	    if (this.environment.isSimple) {
	      return ['return ', source, ';'];
	    } else if (explicit) {
	      // This is a case where the buffer operation occurs as a child of another
	      // construct, generally braces. We have to explicitly output these buffer
	      // operations to ensure that the emitted code goes in the correct location.
	      return ['buffer += ', source, ';'];
	    } else {
	      source.appendToBuffer = true;
	      return source;
	    }
	  },

	  initializeBuffer: function initializeBuffer() {
	    return this.quotedString('');
	  },
	  // END PUBLIC API

	  compile: function compile(environment, options, context, asObject) {
	    this.environment = environment;
	    this.options = options;
	    this.stringParams = this.options.stringParams;
	    this.trackIds = this.options.trackIds;
	    this.precompile = !asObject;

	    this.name = this.environment.name;
	    this.isChild = !!context;
	    this.context = context || {
	      decorators: [],
	      programs: [],
	      environments: []
	    };

	    this.preamble();

	    this.stackSlot = 0;
	    this.stackVars = [];
	    this.aliases = {};
	    this.registers = { list: [] };
	    this.hashes = [];
	    this.compileStack = [];
	    this.inlineStack = [];
	    this.blockParams = [];

	    this.compileChildren(environment, options);

	    this.useDepths = this.useDepths || environment.useDepths || environment.useDecorators || this.options.compat;
	    this.useBlockParams = this.useBlockParams || environment.useBlockParams;

	    var opcodes = environment.opcodes,
	        opcode = undefined,
	        firstLoc = undefined,
	        i = undefined,
	        l = undefined;

	    for (i = 0, l = opcodes.length; i < l; i++) {
	      opcode = opcodes[i];

	      this.source.currentLocation = opcode.loc;
	      firstLoc = firstLoc || opcode.loc;
	      this[opcode.opcode].apply(this, opcode.args);
	    }

	    // Flush any trailing content that might be pending.
	    this.source.currentLocation = firstLoc;
	    this.pushSource('');

	    /* istanbul ignore next */
	    if (this.stackSlot || this.inlineStack.length || this.compileStack.length) {
	      throw new _exception2['default']('Compile completed with content left on stack');
	    }

	    if (!this.decorators.isEmpty()) {
	      this.useDecorators = true;

	      this.decorators.prepend('var decorators = container.decorators;\n');
	      this.decorators.push('return fn;');

	      if (asObject) {
	        this.decorators = Function.apply(this, ['fn', 'props', 'container', 'depth0', 'data', 'blockParams', 'depths', this.decorators.merge()]);
	      } else {
	        this.decorators.prepend('function(fn, props, container, depth0, data, blockParams, depths) {\n');
	        this.decorators.push('}\n');
	        this.decorators = this.decorators.merge();
	      }
	    } else {
	      this.decorators = undefined;
	    }

	    var fn = this.createFunctionContext(asObject);
	    if (!this.isChild) {
	      var ret = {
	        compiler: this.compilerInfo(),
	        main: fn
	      };

	      if (this.decorators) {
	        ret.main_d = this.decorators; // eslint-disable-line camelcase
	        ret.useDecorators = true;
	      }

	      var _context = this.context;
	      var programs = _context.programs;
	      var decorators = _context.decorators;

	      for (i = 0, l = programs.length; i < l; i++) {
	        if (programs[i]) {
	          ret[i] = programs[i];
	          if (decorators[i]) {
	            ret[i + '_d'] = decorators[i];
	            ret.useDecorators = true;
	          }
	        }
	      }

	      if (this.environment.usePartial) {
	        ret.usePartial = true;
	      }
	      if (this.options.data) {
	        ret.useData = true;
	      }
	      if (this.useDepths) {
	        ret.useDepths = true;
	      }
	      if (this.useBlockParams) {
	        ret.useBlockParams = true;
	      }
	      if (this.options.compat) {
	        ret.compat = true;
	      }

	      if (!asObject) {
	        ret.compiler = JSON.stringify(ret.compiler);

	        this.source.currentLocation = { start: { line: 1, column: 0 } };
	        ret = this.objectLiteral(ret);

	        if (options.srcName) {
	          ret = ret.toStringWithSourceMap({ file: options.destName });
	          ret.map = ret.map && ret.map.toString();
	        } else {
	          ret = ret.toString();
	        }
	      } else {
	        ret.compilerOptions = this.options;
	      }

	      return ret;
	    } else {
	      return fn;
	    }
	  },

	  preamble: function preamble() {
	    // track the last context pushed into place to allow skipping the
	    // getContext opcode when it would be a noop
	    this.lastContext = 0;
	    this.source = new _codeGen2['default'](this.options.srcName);
	    this.decorators = new _codeGen2['default'](this.options.srcName);
	  },

	  createFunctionContext: function createFunctionContext(asObject) {
	    var varDeclarations = '';

	    var locals = this.stackVars.concat(this.registers.list);
	    if (locals.length > 0) {
	      varDeclarations += ', ' + locals.join(', ');
	    }

	    // Generate minimizer alias mappings
	    //
	    // When using true SourceNodes, this will update all references to the given alias
	    // as the source nodes are reused in situ. For the non-source node compilation mode,
	    // aliases will not be used, but this case is already being run on the client and
	    // we aren't concern about minimizing the template size.
	    var aliasCount = 0;
	    for (var alias in this.aliases) {
	      // eslint-disable-line guard-for-in
	      var node = this.aliases[alias];

	      if (this.aliases.hasOwnProperty(alias) && node.children && node.referenceCount > 1) {
	        varDeclarations += ', alias' + ++aliasCount + '=' + alias;
	        node.children[0] = 'alias' + aliasCount;
	      }
	    }

	    var params = ['container', 'depth0', 'helpers', 'partials', 'data'];

	    if (this.useBlockParams || this.useDepths) {
	      params.push('blockParams');
	    }
	    if (this.useDepths) {
	      params.push('depths');
	    }

	    // Perform a second pass over the output to merge content when possible
	    var source = this.mergeSource(varDeclarations);

	    if (asObject) {
	      params.push(source);

	      return Function.apply(this, params);
	    } else {
	      return this.source.wrap(['function(', params.join(','), ') {\n  ', source, '}']);
	    }
	  },
	  mergeSource: function mergeSource(varDeclarations) {
	    var isSimple = this.environment.isSimple,
	        appendOnly = !this.forceBuffer,
	        appendFirst = undefined,
	        sourceSeen = undefined,
	        bufferStart = undefined,
	        bufferEnd = undefined;
	    this.source.each(function (line) {
	      if (line.appendToBuffer) {
	        if (bufferStart) {
	          line.prepend('  + ');
	        } else {
	          bufferStart = line;
	        }
	        bufferEnd = line;
	      } else {
	        if (bufferStart) {
	          if (!sourceSeen) {
	            appendFirst = true;
	          } else {
	            bufferStart.prepend('buffer += ');
	          }
	          bufferEnd.add(';');
	          bufferStart = bufferEnd = undefined;
	        }

	        sourceSeen = true;
	        if (!isSimple) {
	          appendOnly = false;
	        }
	      }
	    });

	    if (appendOnly) {
	      if (bufferStart) {
	        bufferStart.prepend('return ');
	        bufferEnd.add(';');
	      } else if (!sourceSeen) {
	        this.source.push('return "";');
	      }
	    } else {
	      varDeclarations += ', buffer = ' + (appendFirst ? '' : this.initializeBuffer());

	      if (bufferStart) {
	        bufferStart.prepend('return buffer + ');
	        bufferEnd.add(';');
	      } else {
	        this.source.push('return buffer;');
	      }
	    }

	    if (varDeclarations) {
	      this.source.prepend('var ' + varDeclarations.substring(2) + (appendFirst ? '' : ';\n'));
	    }

	    return this.source.merge();
	  },

	  // [blockValue]
	  //
	  // On stack, before: hash, inverse, program, value
	  // On stack, after: return value of blockHelperMissing
	  //
	  // The purpose of this opcode is to take a block of the form
	  // `{{#this.foo}}...{{/this.foo}}`, resolve the value of `foo`, and
	  // replace it on the stack with the result of properly
	  // invoking blockHelperMissing.
	  blockValue: function blockValue(name) {
	    var blockHelperMissing = this.aliasable('helpers.blockHelperMissing'),
	        params = [this.contextName(0)];
	    this.setupHelperArgs(name, 0, params);

	    var blockName = this.popStack();
	    params.splice(1, 0, blockName);

	    this.push(this.source.functionCall(blockHelperMissing, 'call', params));
	  },

	  // [ambiguousBlockValue]
	  //
	  // On stack, before: hash, inverse, program, value
	  // Compiler value, before: lastHelper=value of last found helper, if any
	  // On stack, after, if no lastHelper: same as [blockValue]
	  // On stack, after, if lastHelper: value
	  ambiguousBlockValue: function ambiguousBlockValue() {
	    // We're being a bit cheeky and reusing the options value from the prior exec
	    var blockHelperMissing = this.aliasable('helpers.blockHelperMissing'),
	        params = [this.contextName(0)];
	    this.setupHelperArgs('', 0, params, true);

	    this.flushInline();

	    var current = this.topStack();
	    params.splice(1, 0, current);

	    this.pushSource(['if (!', this.lastHelper, ') { ', current, ' = ', this.source.functionCall(blockHelperMissing, 'call', params), '}']);
	  },

	  // [appendContent]
	  //
	  // On stack, before: ...
	  // On stack, after: ...
	  //
	  // Appends the string value of `content` to the current buffer
	  appendContent: function appendContent(content) {
	    if (this.pendingContent) {
	      content = this.pendingContent + content;
	    } else {
	      this.pendingLocation = this.source.currentLocation;
	    }

	    this.pendingContent = content;
	  },

	  // [append]
	  //
	  // On stack, before: value, ...
	  // On stack, after: ...
	  //
	  // Coerces `value` to a String and appends it to the current buffer.
	  //
	  // If `value` is truthy, or 0, it is coerced into a string and appended
	  // Otherwise, the empty string is appended
	  append: function append() {
	    if (this.isInline()) {
	      this.replaceStack(function (current) {
	        return [' != null ? ', current, ' : ""'];
	      });

	      this.pushSource(this.appendToBuffer(this.popStack()));
	    } else {
	      var local = this.popStack();
	      this.pushSource(['if (', local, ' != null) { ', this.appendToBuffer(local, undefined, true), ' }']);
	      if (this.environment.isSimple) {
	        this.pushSource(['else { ', this.appendToBuffer("''", undefined, true), ' }']);
	      }
	    }
	  },

	  // [appendEscaped]
	  //
	  // On stack, before: value, ...
	  // On stack, after: ...
	  //
	  // Escape `value` and append it to the buffer
	  appendEscaped: function appendEscaped() {
	    this.pushSource(this.appendToBuffer([this.aliasable('container.escapeExpression'), '(', this.popStack(), ')']));
	  },

	  // [getContext]
	  //
	  // On stack, before: ...
	  // On stack, after: ...
	  // Compiler value, after: lastContext=depth
	  //
	  // Set the value of the `lastContext` compiler value to the depth
	  getContext: function getContext(depth) {
	    this.lastContext = depth;
	  },

	  // [pushContext]
	  //
	  // On stack, before: ...
	  // On stack, after: currentContext, ...
	  //
	  // Pushes the value of the current context onto the stack.
	  pushContext: function pushContext() {
	    this.pushStackLiteral(this.contextName(this.lastContext));
	  },

	  // [lookupOnContext]
	  //
	  // On stack, before: ...
	  // On stack, after: currentContext[name], ...
	  //
	  // Looks up the value of `name` on the current context and pushes
	  // it onto the stack.
	  lookupOnContext: function lookupOnContext(parts, falsy, strict, scoped) {
	    var i = 0;

	    if (!scoped && this.options.compat && !this.lastContext) {
	      // The depthed query is expected to handle the undefined logic for the root level that
	      // is implemented below, so we evaluate that directly in compat mode
	      this.push(this.depthedLookup(parts[i++]));
	    } else {
	      this.pushContext();
	    }

	    this.resolvePath('context', parts, i, falsy, strict);
	  },

	  // [lookupBlockParam]
	  //
	  // On stack, before: ...
	  // On stack, after: blockParam[name], ...
	  //
	  // Looks up the value of `parts` on the given block param and pushes
	  // it onto the stack.
	  lookupBlockParam: function lookupBlockParam(blockParamId, parts) {
	    this.useBlockParams = true;

	    this.push(['blockParams[', blockParamId[0], '][', blockParamId[1], ']']);
	    this.resolvePath('context', parts, 1);
	  },

	  // [lookupData]
	  //
	  // On stack, before: ...
	  // On stack, after: data, ...
	  //
	  // Push the data lookup operator
	  lookupData: function lookupData(depth, parts, strict) {
	    if (!depth) {
	      this.pushStackLiteral('data');
	    } else {
	      this.pushStackLiteral('container.data(data, ' + depth + ')');
	    }

	    this.resolvePath('data', parts, 0, true, strict);
	  },

	  resolvePath: function resolvePath(type, parts, i, falsy, strict) {
	    // istanbul ignore next

	    var _this = this;

	    if (this.options.strict || this.options.assumeObjects) {
	      this.push(strictLookup(this.options.strict && strict, this, parts, type));
	      return;
	    }

	    var len = parts.length;
	    for (; i < len; i++) {
	      /* eslint-disable no-loop-func */
	      this.replaceStack(function (current) {
	        var lookup = _this.nameLookup(current, parts[i], type);
	        // We want to ensure that zero and false are handled properly if the context (falsy flag)
	        // needs to have the special handling for these values.
	        if (!falsy) {
	          return [' != null ? ', lookup, ' : ', current];
	        } else {
	          // Otherwise we can use generic falsy handling
	          return [' && ', lookup];
	        }
	      });
	      /* eslint-enable no-loop-func */
	    }
	  },

	  // [resolvePossibleLambda]
	  //
	  // On stack, before: value, ...
	  // On stack, after: resolved value, ...
	  //
	  // If the `value` is a lambda, replace it on the stack by
	  // the return value of the lambda
	  resolvePossibleLambda: function resolvePossibleLambda() {
	    this.push([this.aliasable('container.lambda'), '(', this.popStack(), ', ', this.contextName(0), ')']);
	  },

	  // [pushStringParam]
	  //
	  // On stack, before: ...
	  // On stack, after: string, currentContext, ...
	  //
	  // This opcode is designed for use in string mode, which
	  // provides the string value of a parameter along with its
	  // depth rather than resolving it immediately.
	  pushStringParam: function pushStringParam(string, type) {
	    this.pushContext();
	    this.pushString(type);

	    // If it's a subexpression, the string result
	    // will be pushed after this opcode.
	    if (type !== 'SubExpression') {
	      if (typeof string === 'string') {
	        this.pushString(string);
	      } else {
	        this.pushStackLiteral(string);
	      }
	    }
	  },

	  emptyHash: function emptyHash(omitEmpty) {
	    if (this.trackIds) {
	      this.push('{}'); // hashIds
	    }
	    if (this.stringParams) {
	      this.push('{}'); // hashContexts
	      this.push('{}'); // hashTypes
	    }
	    this.pushStackLiteral(omitEmpty ? 'undefined' : '{}');
	  },
	  pushHash: function pushHash() {
	    if (this.hash) {
	      this.hashes.push(this.hash);
	    }
	    this.hash = { values: [], types: [], contexts: [], ids: [] };
	  },
	  popHash: function popHash() {
	    var hash = this.hash;
	    this.hash = this.hashes.pop();

	    if (this.trackIds) {
	      this.push(this.objectLiteral(hash.ids));
	    }
	    if (this.stringParams) {
	      this.push(this.objectLiteral(hash.contexts));
	      this.push(this.objectLiteral(hash.types));
	    }

	    this.push(this.objectLiteral(hash.values));
	  },

	  // [pushString]
	  //
	  // On stack, before: ...
	  // On stack, after: quotedString(string), ...
	  //
	  // Push a quoted version of `string` onto the stack
	  pushString: function pushString(string) {
	    this.pushStackLiteral(this.quotedString(string));
	  },

	  // [pushLiteral]
	  //
	  // On stack, before: ...
	  // On stack, after: value, ...
	  //
	  // Pushes a value onto the stack. This operation prevents
	  // the compiler from creating a temporary variable to hold
	  // it.
	  pushLiteral: function pushLiteral(value) {
	    this.pushStackLiteral(value);
	  },

	  // [pushProgram]
	  //
	  // On stack, before: ...
	  // On stack, after: program(guid), ...
	  //
	  // Push a program expression onto the stack. This takes
	  // a compile-time guid and converts it into a runtime-accessible
	  // expression.
	  pushProgram: function pushProgram(guid) {
	    if (guid != null) {
	      this.pushStackLiteral(this.programExpression(guid));
	    } else {
	      this.pushStackLiteral(null);
	    }
	  },

	  // [registerDecorator]
	  //
	  // On stack, before: hash, program, params..., ...
	  // On stack, after: ...
	  //
	  // Pops off the decorator's parameters, invokes the decorator,
	  // and inserts the decorator into the decorators list.
	  registerDecorator: function registerDecorator(paramSize, name) {
	    var foundDecorator = this.nameLookup('decorators', name, 'decorator'),
	        options = this.setupHelperArgs(name, paramSize);

	    this.decorators.push(['fn = ', this.decorators.functionCall(foundDecorator, '', ['fn', 'props', 'container', options]), ' || fn;']);
	  },

	  // [invokeHelper]
	  //
	  // On stack, before: hash, inverse, program, params..., ...
	  // On stack, after: result of helper invocation
	  //
	  // Pops off the helper's parameters, invokes the helper,
	  // and pushes the helper's return value onto the stack.
	  //
	  // If the helper is not found, `helperMissing` is called.
	  invokeHelper: function invokeHelper(paramSize, name, isSimple) {
	    var nonHelper = this.popStack(),
	        helper = this.setupHelper(paramSize, name),
	        simple = isSimple ? [helper.name, ' || '] : '';

	    var lookup = ['('].concat(simple, nonHelper);
	    if (!this.options.strict) {
	      lookup.push(' || ', this.aliasable('helpers.helperMissing'));
	    }
	    lookup.push(')');

	    this.push(this.source.functionCall(lookup, 'call', helper.callParams));
	  },

	  // [invokeKnownHelper]
	  //
	  // On stack, before: hash, inverse, program, params..., ...
	  // On stack, after: result of helper invocation
	  //
	  // This operation is used when the helper is known to exist,
	  // so a `helperMissing` fallback is not required.
	  invokeKnownHelper: function invokeKnownHelper(paramSize, name) {
	    var helper = this.setupHelper(paramSize, name);
	    this.push(this.source.functionCall(helper.name, 'call', helper.callParams));
	  },

	  // [invokeAmbiguous]
	  //
	  // On stack, before: hash, inverse, program, params..., ...
	  // On stack, after: result of disambiguation
	  //
	  // This operation is used when an expression like `{{foo}}`
	  // is provided, but we don't know at compile-time whether it
	  // is a helper or a path.
	  //
	  // This operation emits more code than the other options,
	  // and can be avoided by passing the `knownHelpers` and
	  // `knownHelpersOnly` flags at compile-time.
	  invokeAmbiguous: function invokeAmbiguous(name, helperCall) {
	    this.useRegister('helper');

	    var nonHelper = this.popStack();

	    this.emptyHash();
	    var helper = this.setupHelper(0, name, helperCall);

	    var helperName = this.lastHelper = this.nameLookup('helpers', name, 'helper');

	    var lookup = ['(', '(helper = ', helperName, ' || ', nonHelper, ')'];
	    if (!this.options.strict) {
	      lookup[0] = '(helper = ';
	      lookup.push(' != null ? helper : ', this.aliasable('helpers.helperMissing'));
	    }

	    this.push(['(', lookup, helper.paramsInit ? ['),(', helper.paramsInit] : [], '),', '(typeof helper === ', this.aliasable('"function"'), ' ? ', this.source.functionCall('helper', 'call', helper.callParams), ' : helper))']);
	  },

	  // [invokePartial]
	  //
	  // On stack, before: context, ...
	  // On stack after: result of partial invocation
	  //
	  // This operation pops off a context, invokes a partial with that context,
	  // and pushes the result of the invocation back.
	  invokePartial: function invokePartial(isDynamic, name, indent) {
	    var params = [],
	        options = this.setupParams(name, 1, params);

	    if (isDynamic) {
	      name = this.popStack();
	      delete options.name;
	    }

	    if (indent) {
	      options.indent = JSON.stringify(indent);
	    }
	    options.helpers = 'helpers';
	    options.partials = 'partials';
	    options.decorators = 'container.decorators';

	    if (!isDynamic) {
	      params.unshift(this.nameLookup('partials', name, 'partial'));
	    } else {
	      params.unshift(name);
	    }

	    if (this.options.compat) {
	      options.depths = 'depths';
	    }
	    options = this.objectLiteral(options);
	    params.push(options);

	    this.push(this.source.functionCall('container.invokePartial', '', params));
	  },

	  // [assignToHash]
	  //
	  // On stack, before: value, ..., hash, ...
	  // On stack, after: ..., hash, ...
	  //
	  // Pops a value off the stack and assigns it to the current hash
	  assignToHash: function assignToHash(key) {
	    var value = this.popStack(),
	        context = undefined,
	        type = undefined,
	        id = undefined;

	    if (this.trackIds) {
	      id = this.popStack();
	    }
	    if (this.stringParams) {
	      type = this.popStack();
	      context = this.popStack();
	    }

	    var hash = this.hash;
	    if (context) {
	      hash.contexts[key] = context;
	    }
	    if (type) {
	      hash.types[key] = type;
	    }
	    if (id) {
	      hash.ids[key] = id;
	    }
	    hash.values[key] = value;
	  },

	  pushId: function pushId(type, name, child) {
	    if (type === 'BlockParam') {
	      this.pushStackLiteral('blockParams[' + name[0] + '].path[' + name[1] + ']' + (child ? ' + ' + JSON.stringify('.' + child) : ''));
	    } else if (type === 'PathExpression') {
	      this.pushString(name);
	    } else if (type === 'SubExpression') {
	      this.pushStackLiteral('true');
	    } else {
	      this.pushStackLiteral('null');
	    }
	  },

	  // HELPERS

	  compiler: JavaScriptCompiler,

	  compileChildren: function compileChildren(environment, options) {
	    var children = environment.children,
	        child = undefined,
	        compiler = undefined;

	    for (var i = 0, l = children.length; i < l; i++) {
	      child = children[i];
	      compiler = new this.compiler(); // eslint-disable-line new-cap

	      var existing = this.matchExistingProgram(child);

	      if (existing == null) {
	        this.context.programs.push(''); // Placeholder to prevent name conflicts for nested children
	        var index = this.context.programs.length;
	        child.index = index;
	        child.name = 'program' + index;
	        this.context.programs[index] = compiler.compile(child, options, this.context, !this.precompile);
	        this.context.decorators[index] = compiler.decorators;
	        this.context.environments[index] = child;

	        this.useDepths = this.useDepths || compiler.useDepths;
	        this.useBlockParams = this.useBlockParams || compiler.useBlockParams;
	        child.useDepths = this.useDepths;
	        child.useBlockParams = this.useBlockParams;
	      } else {
	        child.index = existing.index;
	        child.name = 'program' + existing.index;

	        this.useDepths = this.useDepths || existing.useDepths;
	        this.useBlockParams = this.useBlockParams || existing.useBlockParams;
	      }
	    }
	  },
	  matchExistingProgram: function matchExistingProgram(child) {
	    for (var i = 0, len = this.context.environments.length; i < len; i++) {
	      var environment = this.context.environments[i];
	      if (environment && environment.equals(child)) {
	        return environment;
	      }
	    }
	  },

	  programExpression: function programExpression(guid) {
	    var child = this.environment.children[guid],
	        programParams = [child.index, 'data', child.blockParams];

	    if (this.useBlockParams || this.useDepths) {
	      programParams.push('blockParams');
	    }
	    if (this.useDepths) {
	      programParams.push('depths');
	    }

	    return 'container.program(' + programParams.join(', ') + ')';
	  },

	  useRegister: function useRegister(name) {
	    if (!this.registers[name]) {
	      this.registers[name] = true;
	      this.registers.list.push(name);
	    }
	  },

	  push: function push(expr) {
	    if (!(expr instanceof Literal)) {
	      expr = this.source.wrap(expr);
	    }

	    this.inlineStack.push(expr);
	    return expr;
	  },

	  pushStackLiteral: function pushStackLiteral(item) {
	    this.push(new Literal(item));
	  },

	  pushSource: function pushSource(source) {
	    if (this.pendingContent) {
	      this.source.push(this.appendToBuffer(this.source.quotedString(this.pendingContent), this.pendingLocation));
	      this.pendingContent = undefined;
	    }

	    if (source) {
	      this.source.push(source);
	    }
	  },

	  replaceStack: function replaceStack(callback) {
	    var prefix = ['('],
	        stack = undefined,
	        createdStack = undefined,
	        usedLiteral = undefined;

	    /* istanbul ignore next */
	    if (!this.isInline()) {
	      throw new _exception2['default']('replaceStack on non-inline');
	    }

	    // We want to merge the inline statement into the replacement statement via ','
	    var top = this.popStack(true);

	    if (top instanceof Literal) {
	      // Literals do not need to be inlined
	      stack = [top.value];
	      prefix = ['(', stack];
	      usedLiteral = true;
	    } else {
	      // Get or create the current stack name for use by the inline
	      createdStack = true;
	      var _name = this.incrStack();

	      prefix = ['((', this.push(_name), ' = ', top, ')'];
	      stack = this.topStack();
	    }

	    var item = callback.call(this, stack);

	    if (!usedLiteral) {
	      this.popStack();
	    }
	    if (createdStack) {
	      this.stackSlot--;
	    }
	    this.push(prefix.concat(item, ')'));
	  },

	  incrStack: function incrStack() {
	    this.stackSlot++;
	    if (this.stackSlot > this.stackVars.length) {
	      this.stackVars.push('stack' + this.stackSlot);
	    }
	    return this.topStackName();
	  },
	  topStackName: function topStackName() {
	    return 'stack' + this.stackSlot;
	  },
	  flushInline: function flushInline() {
	    var inlineStack = this.inlineStack;
	    this.inlineStack = [];
	    for (var i = 0, len = inlineStack.length; i < len; i++) {
	      var entry = inlineStack[i];
	      /* istanbul ignore if */
	      if (entry instanceof Literal) {
	        this.compileStack.push(entry);
	      } else {
	        var stack = this.incrStack();
	        this.pushSource([stack, ' = ', entry, ';']);
	        this.compileStack.push(stack);
	      }
	    }
	  },
	  isInline: function isInline() {
	    return this.inlineStack.length;
	  },

	  popStack: function popStack(wrapped) {
	    var inline = this.isInline(),
	        item = (inline ? this.inlineStack : this.compileStack).pop();

	    if (!wrapped && item instanceof Literal) {
	      return item.value;
	    } else {
	      if (!inline) {
	        /* istanbul ignore next */
	        if (!this.stackSlot) {
	          throw new _exception2['default']('Invalid stack pop');
	        }
	        this.stackSlot--;
	      }
	      return item;
	    }
	  },

	  topStack: function topStack() {
	    var stack = this.isInline() ? this.inlineStack : this.compileStack,
	        item = stack[stack.length - 1];

	    /* istanbul ignore if */
	    if (item instanceof Literal) {
	      return item.value;
	    } else {
	      return item;
	    }
	  },

	  contextName: function contextName(context) {
	    if (this.useDepths && context) {
	      return 'depths[' + context + ']';
	    } else {
	      return 'depth' + context;
	    }
	  },

	  quotedString: function quotedString(str) {
	    return this.source.quotedString(str);
	  },

	  objectLiteral: function objectLiteral(obj) {
	    return this.source.objectLiteral(obj);
	  },

	  aliasable: function aliasable(name) {
	    var ret = this.aliases[name];
	    if (ret) {
	      ret.referenceCount++;
	      return ret;
	    }

	    ret = this.aliases[name] = this.source.wrap(name);
	    ret.aliasable = true;
	    ret.referenceCount = 1;

	    return ret;
	  },

	  setupHelper: function setupHelper(paramSize, name, blockHelper) {
	    var params = [],
	        paramsInit = this.setupHelperArgs(name, paramSize, params, blockHelper);
	    var foundHelper = this.nameLookup('helpers', name, 'helper'),
	        callContext = this.aliasable(this.contextName(0) + ' != null ? ' + this.contextName(0) + ' : (container.nullContext || {})');

	    return {
	      params: params,
	      paramsInit: paramsInit,
	      name: foundHelper,
	      callParams: [callContext].concat(params)
	    };
	  },

	  setupParams: function setupParams(helper, paramSize, params) {
	    var options = {},
	        contexts = [],
	        types = [],
	        ids = [],
	        objectArgs = !params,
	        param = undefined;

	    if (objectArgs) {
	      params = [];
	    }

	    options.name = this.quotedString(helper);
	    options.hash = this.popStack();

	    if (this.trackIds) {
	      options.hashIds = this.popStack();
	    }
	    if (this.stringParams) {
	      options.hashTypes = this.popStack();
	      options.hashContexts = this.popStack();
	    }

	    var inverse = this.popStack(),
	        program = this.popStack();

	    // Avoid setting fn and inverse if neither are set. This allows
	    // helpers to do a check for `if (options.fn)`
	    if (program || inverse) {
	      options.fn = program || 'container.noop';
	      options.inverse = inverse || 'container.noop';
	    }

	    // The parameters go on to the stack in order (making sure that they are evaluated in order)
	    // so we need to pop them off the stack in reverse order
	    var i = paramSize;
	    while (i--) {
	      param = this.popStack();
	      params[i] = param;

	      if (this.trackIds) {
	        ids[i] = this.popStack();
	      }
	      if (this.stringParams) {
	        types[i] = this.popStack();
	        contexts[i] = this.popStack();
	      }
	    }

	    if (objectArgs) {
	      options.args = this.source.generateArray(params);
	    }

	    if (this.trackIds) {
	      options.ids = this.source.generateArray(ids);
	    }
	    if (this.stringParams) {
	      options.types = this.source.generateArray(types);
	      options.contexts = this.source.generateArray(contexts);
	    }

	    if (this.options.data) {
	      options.data = 'data';
	    }
	    if (this.useBlockParams) {
	      options.blockParams = 'blockParams';
	    }
	    return options;
	  },

	  setupHelperArgs: function setupHelperArgs(helper, paramSize, params, useRegister) {
	    var options = this.setupParams(helper, paramSize, params);
	    options = this.objectLiteral(options);
	    if (useRegister) {
	      this.useRegister('options');
	      params.push('options');
	      return ['options=', options];
	    } else if (params) {
	      params.push(options);
	      return '';
	    } else {
	      return options;
	    }
	  }
	};

	(function () {
	  var reservedWords = ('break else new var' + ' case finally return void' + ' catch for switch while' + ' continue function this with' + ' default if throw' + ' delete in try' + ' do instanceof typeof' + ' abstract enum int short' + ' boolean export interface static' + ' byte extends long super' + ' char final native synchronized' + ' class float package throws' + ' const goto private transient' + ' debugger implements protected volatile' + ' double import public let yield await' + ' null true false').split(' ');

	  var compilerWords = JavaScriptCompiler.RESERVED_WORDS = {};

	  for (var i = 0, l = reservedWords.length; i < l; i++) {
	    compilerWords[reservedWords[i]] = true;
	  }
	})();

	JavaScriptCompiler.isValidJavaScriptVariableName = function (name) {
	  return !JavaScriptCompiler.RESERVED_WORDS[name] && /^[a-zA-Z_$][0-9a-zA-Z_$]*$/.test(name);
	};

	function strictLookup(requireTerminal, compiler, parts, type) {
	  var stack = compiler.popStack(),
	      i = 0,
	      len = parts.length;
	  if (requireTerminal) {
	    len--;
	  }

	  for (; i < len; i++) {
	    stack = compiler.nameLookup(stack, parts[i], type);
	  }

	  if (requireTerminal) {
	    return [compiler.aliasable('container.strict'), '(', stack, ', ', compiler.quotedString(parts[i]), ')'];
	  } else {
	    return stack;
	  }
	}

	exports['default'] = JavaScriptCompiler;
	module.exports = exports['default'];

/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

	/* global define */
	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(5);

	var SourceNode = undefined;

	try {
	  /* istanbul ignore next */
	  if (false) {
	    // We don't support this in AMD environments. For these environments, we asusme that
	    // they are running on the browser and thus have no need for the source-map library.
	    var SourceMap = require('source-map');
	    SourceNode = SourceMap.SourceNode;
	  }
	} catch (err) {}
	/* NOP */

	/* istanbul ignore if: tested but not covered in istanbul due to dist build  */
	if (!SourceNode) {
	  SourceNode = function (line, column, srcFile, chunks) {
	    this.src = '';
	    if (chunks) {
	      this.add(chunks);
	    }
	  };
	  /* istanbul ignore next */
	  SourceNode.prototype = {
	    add: function add(chunks) {
	      if (_utils.isArray(chunks)) {
	        chunks = chunks.join('');
	      }
	      this.src += chunks;
	    },
	    prepend: function prepend(chunks) {
	      if (_utils.isArray(chunks)) {
	        chunks = chunks.join('');
	      }
	      this.src = chunks + this.src;
	    },
	    toStringWithSourceMap: function toStringWithSourceMap() {
	      return { code: this.toString() };
	    },
	    toString: function toString() {
	      return this.src;
	    }
	  };
	}

	function castChunk(chunk, codeGen, loc) {
	  if (_utils.isArray(chunk)) {
	    var ret = [];

	    for (var i = 0, len = chunk.length; i < len; i++) {
	      ret.push(codeGen.wrap(chunk[i], loc));
	    }
	    return ret;
	  } else if (typeof chunk === 'boolean' || typeof chunk === 'number') {
	    // Handle primitives that the SourceNode will throw up on
	    return chunk + '';
	  }
	  return chunk;
	}

	function CodeGen(srcFile) {
	  this.srcFile = srcFile;
	  this.source = [];
	}

	CodeGen.prototype = {
	  isEmpty: function isEmpty() {
	    return !this.source.length;
	  },
	  prepend: function prepend(source, loc) {
	    this.source.unshift(this.wrap(source, loc));
	  },
	  push: function push(source, loc) {
	    this.source.push(this.wrap(source, loc));
	  },

	  merge: function merge() {
	    var source = this.empty();
	    this.each(function (line) {
	      source.add(['  ', line, '\n']);
	    });
	    return source;
	  },

	  each: function each(iter) {
	    for (var i = 0, len = this.source.length; i < len; i++) {
	      iter(this.source[i]);
	    }
	  },

	  empty: function empty() {
	    var loc = this.currentLocation || { start: {} };
	    return new SourceNode(loc.start.line, loc.start.column, this.srcFile);
	  },
	  wrap: function wrap(chunk) {
	    var loc = arguments.length <= 1 || arguments[1] === undefined ? this.currentLocation || { start: {} } : arguments[1];

	    if (chunk instanceof SourceNode) {
	      return chunk;
	    }

	    chunk = castChunk(chunk, this, loc);

	    return new SourceNode(loc.start.line, loc.start.column, this.srcFile, chunk);
	  },

	  functionCall: function functionCall(fn, type, params) {
	    params = this.generateList(params);
	    return this.wrap([fn, type ? '.' + type + '(' : '(', params, ')']);
	  },

	  quotedString: function quotedString(str) {
	    return '"' + (str + '').replace(/\\/g, '\\\\').replace(/"/g, '\\"').replace(/\n/g, '\\n').replace(/\r/g, '\\r').replace(/\u2028/g, '\\u2028') // Per Ecma-262 7.3 + 7.8.4
	    .replace(/\u2029/g, '\\u2029') + '"';
	  },

	  objectLiteral: function objectLiteral(obj) {
	    var pairs = [];

	    for (var key in obj) {
	      if (obj.hasOwnProperty(key)) {
	        var value = castChunk(obj[key], this);
	        if (value !== 'undefined') {
	          pairs.push([this.quotedString(key), ':', value]);
	        }
	      }
	    }

	    var ret = this.generateList(pairs);
	    ret.prepend('{');
	    ret.add('}');
	    return ret;
	  },

	  generateList: function generateList(entries) {
	    var ret = this.empty();

	    for (var i = 0, len = entries.length; i < len; i++) {
	      if (i) {
	        ret.add(',');
	      }

	      ret.add(castChunk(entries[i], this));
	    }

	    return ret;
	  },

	  generateArray: function generateArray(entries) {
	    var ret = this.generateList(entries);
	    ret.prepend('[');
	    ret.add(']');

	    return ret;
	  }
	};

	exports['default'] = CodeGen;
	module.exports = exports['default'];

/***/ })
/******/ ])
});
;
var gj={};gj.widget=function(){var a=this;a.xhr=null,a.generateGUID=function(){function a(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return a()+a()+"-"+a()+"-"+a()+"-"+a()+"-"+a()+a()+a()},a.mouseX=function(a){if(a){if(a.pageX)return a.pageX;if(a.clientX)return a.clientX+(document.documentElement.scrollLeft?document.documentElement.scrollLeft:document.body.scrollLeft);if(a.touches&&a.touches.length)return a.touches[0].pageX;if(a.changedTouches&&a.changedTouches.length)return a.changedTouches[0].pageX;if(a.originalEvent&&a.originalEvent.touches&&a.originalEvent.touches.length)return a.originalEvent.touches[0].pageX;if(a.originalEvent&&a.originalEvent.changedTouches&&a.originalEvent.changedTouches.length)return a.originalEvent.touches[0].pageX}return null},a.mouseY=function(a){if(a){if(a.pageY)return a.pageY;if(a.clientY)return a.clientY+(document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop);if(a.touches&&a.touches.length)return a.touches[0].pageY;if(a.changedTouches&&a.changedTouches.length)return a.changedTouches[0].pageY;if(a.originalEvent&&a.originalEvent.touches&&a.originalEvent.touches.length)return a.originalEvent.touches[0].pageY;if(a.originalEvent&&a.originalEvent.changedTouches&&a.originalEvent.changedTouches.length)return a.originalEvent.touches[0].pageY}return null}},gj.widget.prototype.init=function(a,b){var c,d,e;this.attr("data-type",b),d=$.extend(!0,{},this.getHTMLConfig()||{}),$.extend(!0,d,a||{}),e=this.getConfig(d,b),this.attr("data-guid",e.guid),this.data(e);for(c in e)gj[b].events.hasOwnProperty(c)&&(this.on(c,e[c]),delete e[c]);for(plugin in gj[b].plugins)gj[b].plugins.hasOwnProperty(plugin)&&gj[b].plugins[plugin].configure(this,e,d);return this},gj.widget.prototype.getConfig=function(a,b){var c,d,e,f;c=$.extend(!0,{},gj[b].config.base),d=a.hasOwnProperty("uiLibrary")?a.uiLibrary:c.uiLibrary,gj[b].config[d]&&$.extend(!0,c,gj[b].config[d]),e=a.hasOwnProperty("iconsLibrary")?a.iconsLibrary:c.iconsLibrary,gj[b].config[e]&&$.extend(!0,c,gj[b].config[e]);for(f in gj[b].plugins)gj[b].plugins.hasOwnProperty(f)&&($.extend(!0,c,gj[b].plugins[f].config.base),gj[b].plugins[f].config[d]&&$.extend(!0,c,gj[b].plugins[f].config[d]),gj[b].plugins[f].config[e]&&$.extend(!0,c,gj[b].plugins[f].config[e]));return $.extend(!0,c,a),c.guid||(c.guid=this.generateGUID()),c},gj.widget.prototype.getHTMLConfig=function(){var a=this.data(),b=this[0].attributes;return b.width&&(a.width=b.width.value),b.height&&(a.height=b.height.value),b.value&&(a.value=b.value.value),b.align&&(a.align=b.align.value),a&&a.source&&(a.dataSource=a.source,delete a.source),a},gj.widget.prototype.createDoneHandler=function(){var a=this;return function(b){"string"==typeof b&&JSON&&(b=JSON.parse(b)),gj[a.data("type")].methods.render(a,b)}},gj.widget.prototype.createErrorHandler=function(){return function(a){a&&a.statusText&&"abort"!==a.statusText&&alert(a.statusText)}},gj.widget.prototype.reload=function(a){var b,c,d=this.data(),e=this.data("type");return void 0===d.dataSource&&gj[e].methods.useHtmlDataSource(this,d),$.extend(d.params,a),$.isArray(d.dataSource)?(c=gj[e].methods.filter(this),gj[e].methods.render(this,c)):"string"==typeof d.dataSource?(b={url:d.dataSource,data:d.params},this.xhr&&this.xhr.abort(),this.xhr=$.ajax(b).done(this.createDoneHandler()).fail(this.createErrorHandler())):"object"==typeof d.dataSource&&(d.dataSource.data||(d.dataSource.data={}),$.extend(d.dataSource.data,d.params),b=$.extend(!0,{},d.dataSource),"json"===b.dataType&&"object"==typeof b.data&&(b.data=JSON.stringify(b.data)),b.success||(b.success=this.createDoneHandler()),b.error||(b.error=this.createErrorHandler()),this.xhr&&this.xhr.abort(),this.xhr=$.ajax(b)),this},gj.documentManager={events:{},subscribeForEvent:function(a,b,c){if(gj.documentManager.events[a]&&0!==gj.documentManager.events[a].length){if(gj.documentManager.events[a][b])throw"Event "+a+' for widget with guid="'+b+'" is already attached.';gj.documentManager.events[a].push({widgetId:b,callback:c})}else gj.documentManager.events[a]=[{widgetId:b,callback:c}],$(document).on(a,gj.documentManager.executeCallbacks)},executeCallbacks:function(a){var b=gj.documentManager.events[a.type];if(b)for(var c=0;c<b.length;c++)b[c].callback(a)},unsubscribeForEvent:function(a,b){var c=!1,d=gj.documentManager.events[a];if(d)for(var e=0;e<d.length;e++)d[e].widgetId===b&&(d.splice(e,1),c=!0,0===d.length&&($(document).off(a),delete gj.documentManager.events[a]));if(!c)throw'The "'+a+'" for widget with guid="'+b+"\" can't be removed."}},gj.core={messages:{"en-us":{monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],monthShortNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],weekDaysMin:["S","M","T","W","T","F","S"],weekDaysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],weekDays:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],am:"AM",pm:"PM",ok:"Ok",cancel:"Cancel",titleFormat:"mmmm yyyy"}},parseDate:function(a,b,c){var d,e,f,g,h=0,i=0,j=1,k=0,l=0;if(a&&"string"==typeof a){if(/^\d+$/.test(a))g=new Date(a);else if(a.indexOf("/Date(")>-1)g=new Date(parseInt(a.substr(6),10));else if(a){for(f=b.split(/[\s,-\.\/\/\:]+/),e=a.split(/[\s]+/),e.length!=f.length&&(e=a.split(/[\s,-\.\/\/\:]+/)),d=0;d<f.length;d++)["d","dd"].indexOf(f[d])>-1?j=parseInt(e[d],10):["m","mm"].indexOf(f[d])>-1?i=parseInt(e[d],10)-1:"mmm"===f[d]?i=gj.core.messages[c||"en-us"].monthShortNames.indexOf(e[d]):"mmmm"===f[d]?i=gj.core.messages[c||"en-us"].monthNames.indexOf(e[d]):["yy","yyyy"].indexOf(f[d])>-1?(h=parseInt(e[d],10),"yy"===f[d]&&(h+=2e3)):["h","hh","H","HH"].indexOf(f[d])>-1?k=parseInt(e[d],10):["M","MM"].indexOf(f[d])>-1&&(l=parseInt(e[d],10));g=new Date(h,i,j,k,l)}}else"number"==typeof a?g=new Date(a):a instanceof Date&&(g=a);return g},formatDate:function(a,b,c){var d,e,f="",g=b.split(/[\s,-\.\/\/\:]+/),h=b.split(/s+|M+|H+|h+|t+|T+|d+|m+|y+/);for(h=h.splice(1,h.length-2),i=0;i<g.length;i++)switch(d=h[i]||"",g[i]){case"s":f+=a.getSeconds()+d;break;case"ss":f+=gj.core.pad(a.getSeconds())+d;break;case"M":f+=a.getMinutes()+d;break;case"MM":f+=gj.core.pad(a.getMinutes())+d;break;case"H":f+=a.getHours()+d;break;case"HH":f+=gj.core.pad(a.getHours())+d;break;case"h":e=a.getHours()>12?a.getHours()%12:a.getHours(),f+=e+d;break;case"hh":e=a.getHours()>12?a.getHours()%12:a.getHours(),f+=gj.core.pad(e)+d;break;case"tt":f+=(a.getHours()>=12?"pm":"am")+d;break;case"TT":f+=(a.getHours()>=12?"PM":"AM")+d;break;case"d":f+=a.getDate()+d;break;case"dd":f+=gj.core.pad(a.getDate())+d;break;case"ddd":f+=gj.core.messages[c||"en-us"].weekDaysShort[a.getDay()]+d;break;case"dddd":f+=gj.core.messages[c||"en-us"].weekDays[a.getDay()]+d;break;case"m":f+=a.getMonth()+1+d;break;case"mm":f+=gj.core.pad(a.getMonth()+1)+d;break;case"mmm":f+=gj.core.messages[c||"en-us"].monthShortNames[a.getMonth()]+d;break;case"mmmm":f+=gj.core.messages[c||"en-us"].monthNames[a.getMonth()]+d;break;case"yy":f+=a.getFullYear().toString().substr(2)+d;break;case"yyyy":f+=a.getFullYear()+d}return f},pad:function(a,b){for(a=String(a),b=b||2;a.length<b;)a="0"+a;return a},center:function(a){var b=$(window).width()/2-a.width()/2,c=$(window).height()/2-a.height()/2;a.css("position","absolute"),a.css("left",b>0?b:0),a.css("top",c>0?c:0)},isIE:function(){return!!navigator.userAgent.match(/Trident/g)||!!navigator.userAgent.match(/MSIE/g)},setChildPosition:function(a,b){var c=a.getBoundingClientRect(),d=gj.core.height(a,!0),e=gj.core.height(b,!0),f=gj.core.width(a,!0),g=gj.core.width(b,!0),h=window.scrollY||window.pageYOffset||0,i=window.scrollX||window.pageXOffset||0;c.top+d+e>window.innerHeight&&c.top>e?b.style.top=Math.round(c.top+h-e-3)+"px":b.style.top=Math.round(c.top+h+d+3)+"px",c.left+g>document.body.clientWidth?b.style.left=Math.round(c.left+i+f-g)+"px":b.style.left=Math.round(c.left+i)+"px"},height:function(a,b){var c,d=window.getComputedStyle(a);return"border-box"===d.boxSizing?(c=parseInt(d.height,10),gj.core.isIE()&&(c+=parseInt(d.paddingTop||0,10)+parseInt(d.paddingBottom||0,10),c+=parseInt(d.borderTopWidth||0,10)+parseInt(d.borderBottomWidth||0,10))):(c=parseInt(d.height,10),c+=parseInt(d.paddingTop||0,10)+parseInt(d.paddingBottom||0,10),c+=parseInt(d.borderTopWidth||0,10)+parseInt(d.borderBottomWidth||0,10)),b&&(c+=parseInt(d.marginTop||0,10)+parseInt(d.marginBottom||0,10)),c},width:function(a,b){var c,d=window.getComputedStyle(a);return"border-box"===d.boxSizing?c=parseInt(d.width,10):(c=parseInt(d.width,10),c+=parseInt(d.paddingLeft||0,10)+parseInt(d.paddingRight||0,10),c+=parseInt(d.borderLeftWidth||0,10)+parseInt(d.borderRightWidth||0,10)),b&&(c+=parseInt(d.marginLeft||0,10)+parseInt(d.marginRight||0,10)),c},addClasses:function(a,b){var c,d;if(b)for(d=b.split(" "),c=0;c<d.length;c++)a.classList.add(d[c])},position:function(a){for(var b,c,d=0,e=0,f=gj.core.height(a),g=gj.core.width(a);a;)"BODY"==a.tagName?(b=a.scrollLeft||document.documentElement.scrollLeft,c=a.scrollTop||document.documentElement.scrollTop,d+=a.offsetLeft-b,e+=a.offsetTop-c):(d+=a.offsetLeft-a.scrollLeft,e+=a.offsetTop-a.scrollTop),a=a.offsetParent;return{top:e,left:d,bottom:e+f,right:d+g}},setCaretAtEnd:function(a){var b;if(a)if(b=a.value.length,document.selection){a.focus();var c=document.selection.createRange();c.moveStart("character",-b),c.moveStart("character",b),c.moveEnd("character",0),c.select()}else(a.selectionStart||"0"==a.selectionStart)&&(a.selectionStart=b,a.selectionEnd=b,a.focus())},getScrollParent:function(a){return null==a?null:a.scrollHeight>a.clientHeight?a:gj.core.getScrollParent(a.parentNode)}},gj.picker={messages:{"en-us":{}}},gj.picker.methods={initialize:function(a,b,c){var d,e=c.createPicker(a,b),f=a.parent('div[role="wrapper"]');d="bootstrap"===b.uiLibrary?$('<span class="input-group-addon">'+b.icons.rightIcon+"</span>"):"bootstrap4"===b.uiLibrary?$('<span class="input-group-append"><button class="btn btn-outline-secondary border-left-0" type="button">'+b.icons.rightIcon+"</button></span>"):$(b.icons.rightIcon),d.attr("role","right-icon"),0===f.length?(f=$('<div role="wrapper" />').addClass(b.style.wrapper),a.wrap(f)):f.addClass(b.style.wrapper),f=a.parent('div[role="wrapper"]'),b.width&&f.css("width",b.width),a.val(b.value).addClass(b.style.input).attr("role","input"),b.fontSize&&a.css("font-size",b.fontSize),"bootstrap"===b.uiLibrary||"bootstrap4"===b.uiLibrary?"small"===b.size?(f.addClass("input-group-sm"),a.addClass("form-control-sm")):"large"===b.size&&(f.addClass("input-group-lg"),a.addClass("form-control-lg")):"small"===b.size?f.addClass("small"):"large"===b.size&&f.addClass("large"),d.on("click",function(b){e.is(":visible")?a.close():a.open()}),f.append(d),!0!==b.footer&&(a.on("blur",function(){a.timeout=setTimeout(function(){a.close()},500)}),e.mousedown(function(){return clearTimeout(a.timeout),a.focus(),!1}),e.on("click",function(){clearTimeout(a.timeout),a.focus()}))}},gj.picker.widget=function(a,b){var c=this,d=gj.picker.methods;return c.destroy=function(){return d.destroy(this)},a},gj.picker.widget.prototype=new gj.widget,gj.picker.widget.constructor=gj.picker.widget,gj.picker.widget.prototype.init=function(a,b,c){return gj.widget.prototype.init.call(this,a,b),this.attr("data-"+b,"true"),gj.picker.methods.initialize(this,this.data(),gj[b].methods),this},gj.picker.widget.prototype.open=function(a){var b=this.data(),c=$("body").find('[role="picker"][guid="'+this.attr("data-guid")+'"]');return c.show(),c.closest('div[role="modal"]').show(),b.modal?gj.core.center(c):(gj.core.setChildPosition(this[0],c[0]),this.focus()),clearTimeout(this.timeout),gj[a].events.open(this),this},gj.picker.widget.prototype.close=function(a){var b=$("body").find('[role="picker"][guid="'+this.attr("data-guid")+'"]');return b.hide(),b.closest('div[role="modal"]').hide(),gj[a].events.close(this),this},gj.picker.widget.prototype.destroy=function(a){var b=this.data(),c=this.parent(),d=$("body").find('[role="picker"][guid="'+this.attr("data-guid")+'"]');return b&&(this.off(),d.parent('[role="modal"]').length>0&&d.unwrap(),d.remove(),this.removeData(),this.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-"+a),this.removeClass(),c.children('[role="right-icon"]').remove(),this.unwrap()),this},gj.dialog={plugins:{},messages:{}},gj.dialog.config={base:{autoOpen:!0,closeButtonInHeader:!0,closeOnEscape:!0,draggable:!0,height:"auto",locale:"en-us",maxHeight:void 0,maxWidth:void 0,minHeight:void 0,minWidth:void 0,modal:!1,resizable:!1,scrollable:!1,title:void 0,uiLibrary:void 0,width:300,style:{modal:"gj-modal",content:"gj-dialog-md",header:"gj-dialog-md-header gj-unselectable",headerTitle:"gj-dialog-md-title",headerCloseButton:"gj-dialog-md-close",body:"gj-dialog-md-body",footer:"gj-dialog-footer gj-dialog-md-footer"}},bootstrap:{style:{modal:"modal",content:"modal-content gj-dialog-bootstrap",header:"modal-header",headerTitle:"modal-title",headerCloseButton:"close",body:"modal-body",footer:"gj-dialog-footer modal-footer"}},bootstrap4:{style:{modal:"modal",content:"modal-content gj-dialog-bootstrap4",header:"modal-header",headerTitle:"modal-title",headerCloseButton:"close",body:"modal-body",footer:"gj-dialog-footer modal-footer"}}},gj.dialog.events={initialized:function(a){a.trigger("initialized")},opening:function(a){a.trigger("opening")},opened:function(a){a.trigger("opened")},closing:function(a){a.trigger("closing")},closed:function(a){a.trigger("closed")},drag:function(a){a.trigger("drag")},dragStart:function(a){a.trigger("dragStart")},dragStop:function(a){a.trigger("dragStop")},resize:function(a){a.trigger("resize")},resizeStart:function(a){a.trigger("resizeStart")},resizeStop:function(a){a.trigger("resizeStop")}},gj.dialog.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"dialog"),gj.dialog.methods.localization(this),gj.dialog.methods.initialize(this),gj.dialog.events.initialized(this),this},localization:function(a){var b=a.data();void 0===b.title&&(b.title=gj.dialog.messages[b.locale].DefaultTitle)},getHTMLConfig:function(){var a=gj.widget.prototype.getHTMLConfig.call(this),b=this[0].attributes;return b.title&&(a.title=b.title.value),a},initialize:function(a){var b,c,d,e=a.data();a.addClass(e.style.content),gj.dialog.methods.setSize(a),e.closeOnEscape&&$(document).keyup(function(b){27===b.keyCode&&a.close()}),c=a.children('div[data-role="body"]'),0===c.length?(c=$('<div data-role="body"/>').addClass(e.style.body),a.wrapInner(c)):c.addClass(e.style.body),b=gj.dialog.methods.renderHeader(a),d=a.children('div[data-role="footer"]').addClass(e.style.footer),a.find('[data-role="close"]').on("click",function(){a.close()}),gj.draggable&&(e.draggable&&gj.dialog.methods.draggable(a,b),e.resizable&&gj.dialog.methods.resizable(a)),e.scrollable&&e.height&&(a.addClass("gj-dialog-scrollable"),a.on("opened",function(){a.children('div[data-role="body"]').css("height",e.height-b.outerHeight()-(d.length?d.outerHeight():0))})),gj.core.center(a),e.modal&&a.wrapAll('<div data-role="modal" class="'+e.style.modal+'"/>'),e.autoOpen&&a.open()},setSize:function(a){var b=a.data();b.width&&a.css("width",b.width),b.height&&a.css("height",b.height)},renderHeader:function(a){var b,c,d,e=a.data();return b=a.children('div[data-role="header"]'),0===b.length&&(b=$('<div data-role="header" />'),a.prepend(b)),b.addClass(e.style.header),c=b.find('[data-role="title"]'),0===c.length&&(c=$('<h4 data-role="title">'+e.title+"</h4>"),b.append(c)),c.addClass(e.style.headerTitle),d=b.find('[data-role="close"]'),0===d.length&&e.closeButtonInHeader?(d=$('<button type="button" data-role="close" title="'+gj.dialog.messages[e.locale].Close+'"><span>×</span></button>'),d.addClass(e.style.headerCloseButton),b.append(d)):d.length>0&&!1===e.closeButtonInHeader?d.hide():d.addClass(e.style.headerCloseButton),b},draggable:function(a,b){a.appendTo("body"),b.addClass("gj-draggable"),a.draggable({handle:b,start:function(){a.addClass("gj-unselectable"),gj.dialog.events.dragStart(a)},stop:function(){a.removeClass("gj-unselectable"),gj.dialog.events.dragStop(a)}})},resizable:function(a){var b={drag:gj.dialog.methods.resize,start:function(){a.addClass("gj-unselectable"),gj.dialog.events.resizeStart(a)},stop:function(){this.removeAttribute("style"),a.removeClass("gj-unselectable"),gj.dialog.events.resizeStop(a)}};a.append($('<div class="gj-resizable-handle gj-resizable-n"></div>').draggable($.extend(!0,{horizontal:!1},b))),a.append($('<div class="gj-resizable-handle gj-resizable-e"></div>').draggable($.extend(!0,{vertical:!1},b))),a.append($('<div class="gj-resizable-handle gj-resizable-s"></div>').draggable($.extend(!0,{horizontal:!1},b))),a.append($('<div class="gj-resizable-handle gj-resizable-w"></div>').draggable($.extend(!0,{vertical:!1},b))),a.append($('<div class="gj-resizable-handle gj-resizable-ne"></div>').draggable($.extend(!0,{},b))),a.append($('<div class="gj-resizable-handle gj-resizable-nw"></div>').draggable($.extend(!0,{},b))),a.append($('<div class="gj-resizable-handle gj-resizable-sw"></div>').draggable($.extend(!0,{},b))),a.append($('<div class="gj-resizable-handle gj-resizable-se"></div>').draggable($.extend(!0,{},b)))},resize:function(a,b){var c,d,e,f,g,h,i,j,k=!1;return c=$(this),d=c.parent(),e=gj.core.position(this),offset={top:b.top-e.top,left:b.left-e.left},f=d.data(),c.hasClass("gj-resizable-n")?(g=d.height()-offset.top,i=d.offset().top+offset.top):c.hasClass("gj-resizable-e")?h=d.width()+offset.left:c.hasClass("gj-resizable-s")?g=d.height()+offset.top:c.hasClass("gj-resizable-w")?(h=d.width()-offset.left,j=d.offset().left+offset.left):c.hasClass("gj-resizable-ne")?(g=d.height()-offset.top,i=d.offset().top+offset.top,h=d.width()+offset.left):c.hasClass("gj-resizable-nw")?(g=d.height()-offset.top,i=d.offset().top+offset.top,h=d.width()-offset.left,j=d.offset().left+offset.left):c.hasClass("gj-resizable-se")?(g=d.height()+offset.top,h=d.width()+offset.left):c.hasClass("gj-resizable-sw")&&(g=d.height()+offset.top,h=d.width()-offset.left,j=d.offset().left+offset.left),g&&(!f.minHeight||g>=f.minHeight)&&(!f.maxHeight||g<=f.maxHeight)&&(d.height(g),i&&d.css("top",i),k=!0),h&&(!f.minWidth||h>=f.minWidth)&&(!f.maxWidth||h<=f.maxWidth)&&(d.width(h),j&&d.css("left",j),k=!0),k&&gj.dialog.events.resize(d),k},open:function(a,b){var c;return gj.dialog.events.opening(a),a.css("display","block"),a.closest('div[data-role="modal"]').css("display","block"),c=a.children('div[data-role="footer"]'),c.length&&c.outerHeight()&&a.children('div[data-role="body"]').css("margin-bottom",c.outerHeight()),void 0!==b&&a.find('[data-role="title"]').html(b),gj.dialog.events.opened(a),a},close:function(a){return a.is(":visible")&&(gj.dialog.events.closing(a),a.css("display","none"),a.closest('div[data-role="modal"]').css("display","none"),gj.dialog.events.closed(a)),a},isOpen:function(a){return a.is(":visible")},content:function(a,b){var c=a.children('div[data-role="body"]');return void 0===b?c.html():c.html(b)},destroy:function(a,b){var c=a.data();return c&&(!1===b?a.remove():(a.close(),a.off(),a.removeData(),a.removeAttr("data-type"),a.removeClass(c.style.content),a.find('[data-role="header"]').removeClass(c.style.header),a.find('[data-role="title"]').removeClass(c.style.headerTitle),a.find('[data-role="close"]').remove(),a.find('[data-role="body"]').removeClass(c.style.body),a.find('[data-role="footer"]').removeClass(c.style.footer))),a}},gj.dialog.widget=function(a,b){var c=this,d=gj.dialog.methods;return c.open=function(a){return d.open(this,a)},c.close=function(){return d.close(this)},c.isOpen=function(){return d.isOpen(this)},c.content=function(a){return d.content(this,a)},c.destroy=function(a){return d.destroy(this,a)},$.extend(a,c),"dialog"!==a.attr("data-type")&&d.init.call(a,b),a},gj.dialog.widget.prototype=new gj.widget,gj.dialog.widget.constructor=gj.dialog.widget,gj.dialog.widget.prototype.getHTMLConfig=gj.dialog.methods.getHTMLConfig,function(a){a.fn.dialog=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.dialog.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.dialog.widget(this,a)}}}(jQuery),gj.dialog.messages["en-us"]={Close:"Close",DefaultTitle:"Dialog"},gj.draggable={plugins:{}},gj.draggable.config={base:{handle:void 0,vertical:!0,horizontal:!0,containment:void 0}},gj.draggable.methods={init:function(a){var b,c,d=this;return gj.widget.prototype.init.call(this,a,"draggable"),c=this.data(),d.attr("data-draggable","true"),b=gj.draggable.methods.getHandleElement(d),b.on("touchstart mousedown",function(a){var e=gj.core.position(d[0]);d[0].style.top=e.top+"px",d[0].style.left=e.left+"px",d[0].style.position="fixed",d.attr("draggable-dragging",!0),d.removeAttr("draggable-x").removeAttr("draggable-y"),gj.documentManager.subscribeForEvent("touchmove",d.data("guid"),gj.draggable.methods.createMoveHandler(d,b,c)),gj.documentManager.subscribeForEvent("mousemove",d.data("guid"),gj.draggable.methods.createMoveHandler(d,b,c))}),gj.documentManager.subscribeForEvent("mouseup",d.data("guid"),gj.draggable.methods.createUpHandler(d)),gj.documentManager.subscribeForEvent("touchend",d.data("guid"),gj.draggable.methods.createUpHandler(d)),gj.documentManager.subscribeForEvent("touchcancel",d.data("guid"),gj.draggable.methods.createUpHandler(d)),d},getHandleElement:function(a){var b=a.data("handle");return b&&b.length?b:a},createUpHandler:function(a){return function(b){"true"===a.attr("draggable-dragging")&&(a.attr("draggable-dragging",!1),gj.documentManager.unsubscribeForEvent("mousemove",a.data("guid")),gj.documentManager.unsubscribeForEvent("touchmove",a.data("guid")),gj.draggable.events.stop(a,{x:a.mouseX(b),y:a.mouseY(b)}))}},createMoveHandler:function(a,b,c){return function(b){var d,e,f,g,h,i;"true"===a.attr("draggable-dragging")&&(d=Math.round(a.mouseX(b)),e=Math.round(a.mouseY(b)),h=a.attr("draggable-x"),i=a.attr("draggable-y"),h&&i?(f=c.horizontal?d-parseInt(h,10):0,g=c.vertical?e-parseInt(i,10):0,gj.draggable.methods.move(a[0],c,f,g,d,e)):gj.draggable.events.start(a,d,e),a.attr("draggable-x",d),a.attr("draggable-y",e))}},move:function(a,b,c,d,e,f){var g,h,i,j=gj.core.position(a),k=j.top+d,l=j.left+c;b.containment&&(g=gj.core.position(b.containment),h=g.top+gj.core.height(b.containment)-gj.core.height(a),i=g.left+gj.core.width(b.containment)-gj.core.width(a),k>g.top&&k<h?(g.top>=f||g.bottom<=f)&&(k=j.top):k=k<=g.top?g.top+1:h-1,l>g.left&&l<i?(g.left>=e||g.right<=e)&&(l=j.left):l=l<=g.left?g.left+1:i-1),!1!==gj.draggable.events.drag($(a),l,k,e,f)&&(a.style.top=k+"px",a.style.left=l+"px")},destroy:function(a){return"true"===a.attr("data-draggable")&&(gj.documentManager.unsubscribeForEvent("mouseup",a.data("guid")),a.removeData(),a.removeAttr("data-guid").removeAttr("data-type").removeAttr("data-draggable"),a.removeAttr("draggable-x").removeAttr("draggable-y").removeAttr("draggable-dragging"),a[0].style.top="",a[0].style.left="",a[0].style.position="",a.off("drag").off("start").off("stop"),gj.draggable.methods.getHandleElement(a).off("mousedown")),a}},gj.draggable.events={drag:function(a,b,c,d,e){return a.triggerHandler("drag",[{left:b,top:c},{x:d,y:e}])},start:function(a,b,c){a.triggerHandler("start",[{x:b,y:c}])},stop:function(a,b){a.triggerHandler("stop",[b])}},gj.draggable.widget=function(a,b){var c=this,d=gj.draggable.methods;return a.destroy||(c.destroy=function(){return d.destroy(this)}),$.extend(a,c),"true"!==a.attr("data-draggable")&&d.init.call(a,b),a},gj.draggable.widget.prototype=new gj.widget,gj.draggable.widget.constructor=gj.draggable.widget,function(a){a.fn.draggable=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.draggable.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.draggable.widget(this,a)}}}(jQuery),gj.droppable={plugins:{}},gj.droppable.config={hoverClass:void 0},gj.droppable.methods={init:function(a){var b=this;return gj.widget.prototype.init.call(this,a,"droppable"),b.attr("data-droppable","true"),gj.documentManager.subscribeForEvent("mousedown",b.data("guid"),gj.droppable.methods.createMouseDownHandler(b)),gj.documentManager.subscribeForEvent("mousemove",b.data("guid"),gj.droppable.methods.createMouseMoveHandler(b)),gj.documentManager.subscribeForEvent("mouseup",b.data("guid"),gj.droppable.methods.createMouseUpHandler(b)),b},createMouseDownHandler:function(a){return function(b){a.isDragging=!0}},createMouseMoveHandler:function(a){return function(b){if(a.isDragging){var c=a.data("hoverClass"),d={x:a.mouseX(b),y:a.mouseY(b)},e=gj.droppable.methods.isOver(a,d);e!=a.isOver&&(e?(c&&a.addClass(c),gj.droppable.events.over(a,d)):(c&&a.removeClass(c),gj.droppable.events.out(a))),a.isOver=e}}},createMouseUpHandler:function(a){return function(b){var c={left:a.mouseX(b),top:a.mouseY(b)};a.isDragging=!1,gj.droppable.methods.isOver(a,c)&&gj.droppable.events.drop(a)}},isOver:function(a,b){var c=a.offset().top,d=a.offset().left;return b.x>d&&b.x<d+a.outerWidth(!0)&&b.y>c&&b.y<c+a.outerHeight(!0)},destroy:function(a){return"true"===a.attr("data-droppable")&&(gj.documentManager.unsubscribeForEvent("mousedown",a.data("guid")),gj.documentManager.unsubscribeForEvent("mousemove",a.data("guid")),gj.documentManager.unsubscribeForEvent("mouseup",a.data("guid")),a.removeData(),a.removeAttr("data-guid"),a.removeAttr("data-droppable"),a.off("drop").off("over").off("out")),a}},gj.droppable.events={drop:function(a,b,c){a.trigger("drop",[{top:c,left:b}])},over:function(a,b){a.trigger("over",[b])},out:function(a){a.trigger("out")}},gj.droppable.widget=function(a,b){var c=this,d=gj.droppable.methods;return c.isOver=!1,c.isDragging=!1,c.destroy=function(){return d.destroy(this)},c.isOver=function(a){return d.isOver(this,a)},$.extend(a,c),"true"!==a.attr("data-droppable")&&d.init.call(a,b),a},gj.droppable.widget.prototype=new gj.widget,gj.droppable.widget.constructor=gj.droppable.widget,function(a){a.fn.droppable=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.droppable.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.droppable.widget(this,a)}}}(jQuery),gj.grid={plugins:{},messages:{}},gj.grid.config={base:{dataSource:void 0,columns:[],autoGenerateColumns:!1,defaultColumnSettings:{hidden:!1,width:void 0,sortable:!1,type:"text",title:void 0,field:void 0,align:void 0,cssClass:void 0,headerCssClass:void 0,tooltip:void 0,icon:void 0,events:void 0,format:"mm/dd/yyyy",decimalDigits:void 0,tmpl:void 0,stopPropagation:!1,renderer:void 0,filter:void 0},mapping:{dataField:"records",totalRecordsField:"total"},params:{},paramNames:{sortBy:"sortBy",direction:"direction"},uiLibrary:"materialdesign",iconsLibrary:"materialicons",selectionType:"single",selectionMethod:"basic",autoLoad:!0,notFoundText:void 0,width:void 0,minWidth:void 0,headerRowHeight:"fixed",bodyRowHeight:"autogrow",fontSize:void 0,primaryKey:void 0,locale:"en-us",defaultIconColumnWidth:70,defaultCheckBoxColumnWidth:70,style:{wrapper:"gj-grid-wrapper",table:"gj-grid gj-grid-md",loadingCover:"gj-grid-loading-cover",loadingText:"gj-grid-loading-text",header:{cell:void 0,sortable:"gj-cursor-pointer gj-unselectable"},content:{rowSelected:"gj-grid-md-select"}},icons:{asc:"▲",desc:"▼"}},bootstrap:{style:{wrapper:"gj-grid-wrapper",table:"gj-grid gj-grid-bootstrap gj-grid-bootstrap-3 table table-bordered table-hover",content:{rowSelected:"active"}},iconsLibrary:"glyphicons",defaultIconColumnWidth:34,defaultCheckBoxColumnWidth:36},bootstrap4:{style:{wrapper:"gj-grid-wrapper",table:"gj-grid gj-grid-bootstrap gj-grid-bootstrap-4 table table-bordered table-hover",content:{rowSelected:"active"}},defaultIconColumnWidth:42,defaultCheckBoxColumnWidth:44},materialicons:{icons:{asc:'<i class="gj-icon arrow-upward" />',desc:'<i class="gj-icon arrow-downward" />'}},fontawesome:{icons:{asc:'<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>',desc:'<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>'}},glyphicons:{icons:{asc:'<span class="glyphicon glyphicon-sort-by-alphabet" />',desc:'<span class="glyphicon glyphicon-sort-by-alphabet-alt" />'}}},gj.grid.events={beforeEmptyRowInsert:function(a,b){return a.triggerHandler("beforeEmptyRowInsert",[b])},dataBinding:function(a,b){return a.triggerHandler("dataBinding",[b])},dataBound:function(a,b,c){return a.triggerHandler("dataBound",[b,c])},rowDataBound:function(a,b,c,d){return a.triggerHandler("rowDataBound",[b,c,d])},cellDataBound:function(a,b,c,d,e){return a.triggerHandler("cellDataBound",[b,c,d,e])},rowSelect:function(a,b,c,d){return a.triggerHandler("rowSelect",[b,c,d])},rowUnselect:function(a,b,c,d){return a.triggerHandler("rowUnselect",[b,c,d])},rowRemoving:function(a,b,c,d){return a.triggerHandler("rowRemoving",[b,c,d])},destroying:function(a){return a.triggerHandler("destroying")},columnHide:function(a,b){return a.triggerHandler("columnHide",[b])},columnShow:function(a,b){return a.triggerHandler("columnShow",[b])},initialized:function(a){return a.triggerHandler("initialized")},dataFiltered:function(a,b){return a.triggerHandler("dataFiltered",[b])}},gj.grid.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"grid"),gj.grid.methods.initialize(this),this.data("autoLoad")&&this.reload(),this},getConfig:function(a,b){var c=gj.widget.prototype.getConfig.call(this,a,b);return gj.grid.methods.setDefaultColumnConfig(c.columns,c.defaultColumnSettings),c},setDefaultColumnConfig:function(a,b){var c,d;if(a&&a.length)for(d=0;d<a.length;d++)c=$.extend(!0,{},b),$.extend(!0,c,a[d]),a[d]=c},getHTMLConfig:function(){var a=gj.widget.prototype.getHTMLConfig.call(this);return a.columns=[],this.find("thead > tr > th").each(function(){var b=$(this),c=b.text(),d=gj.widget.prototype.getHTMLConfig.call(b);d.title=c,d.field||(d.field=c),d.events&&(d.events=gj.grid.methods.eventsParser(d.events)),a.columns.push(d)}),a},eventsParser:function(events){var result={},list,i,key,func,position;for(list=events.split(","),i=0;i<list.length;i++)(position=list[i].indexOf(":"))>0&&(key=$.trim(list[i].substr(0,position)),func=$.trim(list[i].substr(position+1,list[i].length)),result[key]=eval("window."+func));return result},initialize:function(a){var b=a.data(),c=a.parent('div[data-role="wrapper"]');gj.grid.methods.localization(b),0===c.length?(c=$('<div data-role="wrapper" />').addClass(b.style.wrapper),a.wrap(c)):c.addClass(b.style.wrapper),b.width&&a.parent().css("width",b.width),b.minWidth&&a.css("min-width",b.minWidth),b.fontSize&&a.css("font-size",b.fontSize),"autogrow"===b.headerRowHeight&&a.addClass("autogrow-header-row"),"fixed"===b.bodyRowHeight&&a.addClass("fixed-body-rows"),a.addClass(b.style.table),"checkbox"===b.selectionMethod&&b.columns.splice(gj.grid.methods.getColumnPositionNotInRole(a),0,{title:"",width:b.defaultCheckBoxColumnWidth,align:"center",type:"checkbox",role:"selectRow",events:{click:function(b){gj.grid.methods.setSelected(a,b.data.id,$(this).closest("tr"))}},headerCssClass:"gj-grid-select-all",stopPropagation:!0}),0===a.children("tbody").length&&a.append($("<tbody/>")),gj.grid.methods.renderHeader(a),gj.grid.methods.appendEmptyRow(a,"&nbsp;"),gj.grid.events.initialized(a)},localization:function(a){a.notFoundText||(a.notFoundText=gj.grid.messages[a.locale].NoRecordsFound)},renderHeader:function(a){var b,c,d,e,f,g,h,i,j;for(b=a.data(),c=b.columns,d=b.style.header,e=a.children("thead"),0===e.length&&(e=$("<thead />"),a.prepend(e)),f=$('<tr data-role="caption" />'),i=0;i<c.length;i+=1)g=$('<th data-field="'+(c[i].field||"")+'" />'),c[i].width?g.attr("width",c[i].width):"checkbox"===c[i].type&&g.attr("width",b.defaultIconColumnWidth),g.addClass(d.cell),c[i].headerCssClass&&g.addClass(c[i].headerCssClass),g.css("text-align",c[i].align||"left"),"checkbox"===b.selectionMethod&&"multiple"===b.selectionType&&"checkbox"===c[i].type&&"selectRow"===c[i].role?(j=g.find('input[data-role="selectAll"]'),0===j.length&&(j=$('<input type="checkbox" data-role="selectAll" />'),g.append(j),j.checkbox({uiLibrary:b.uiLibrary})),j.off("click").on("click",function(){this.checked?a.selectAll():a.unSelectAll()})):(h=$('<div data-role="title"/>').html(void 0===c[i].title?c[i].field:c[i].title),g.append(h),c[i].sortable&&(h.addClass(d.sortable),h.on("click",gj.grid.methods.createSortHandler(a,c[i])))),c[i].hidden&&g.hide(),f.append(g);e.empty().append(f)},createSortHandler:function(a,b){return function(){var c,d={};a.count()>0&&(c=a.data(),d[c.paramNames.sortBy]=b.field,b.direction="asc"===b.direction?"desc":"asc",d[c.paramNames.direction]=b.direction,a.reload(d))}},updateHeader:function(a){var b,c,d=a.data(),e=d.params[d.paramNames.sortBy],f=d.params[d.paramNames.direction];a.find('thead tr th [data-role="sorticon"]').remove(),e&&(position=gj.grid.methods.getColumnPosition(a.data("columns"),e),position>-1&&(c=a.find("thead tr th:eq("+position+') div[data-role="title"]'),b=$('<div data-role="sorticon" class="gj-unselectable" />').append("desc"===f?d.icons.desc:d.icons.asc),c.after(b)))},useHtmlDataSource:function(a,b){var c,d,e,f,g=[],h=a.find('tbody tr[data-role != "empty"]');for(c=0;c<h.length;c++){for(e=$(h[c]).find("td"),f={},d=0;d<e.length;d++)f[b.columns[d].field]=$(e[d]).html();g.push(f)}b.dataSource=g},startLoading:function(a){var b,c,d,e,f,g,h;gj.grid.methods.stopLoading(a),h=a.data(),0!==a.outerHeight()&&(b=a.children("tbody"),e=b.outerWidth(!1),f=b.outerHeight(!1),g=Math.abs(a.parent().offset().top-b.offset().top),c=$('<div data-role="loading-cover" />').addClass(h.style.loadingCover).css({width:e,height:f,top:g}),d=$('<div data-role="loading-text">'+gj.grid.messages[h.locale].Loading+"</div>").addClass(h.style.loadingText),d.insertAfter(a),c.insertAfter(a),d.css({top:g+f/2-d.outerHeight(!1)/2,left:e/2-d.outerWidth(!1)/2}))},stopLoading:function(a){a.parent().find('div[data-role="loading-cover"]').remove(),a.parent().find('div[data-role="loading-text"]').remove()},appendEmptyRow:function(a,b){var c,d,e,f;c=a.data(),d=$('<tr data-role="empty"/>'),e=$("<td/>").css({width:"100%","text-align":"center"}),e.attr("colspan",gj.grid.methods.countVisibleColumns(a)),f=$("<div />").html(b||c.notFoundText),e.append(f),d.append(e),gj.grid.events.beforeEmptyRowInsert(a,d),a.append(d)},autoGenerateColumns:function(a,b){var c,d,e,f,g=a.data();if(g.columns=[],b.length>0){for(c=Object.getOwnPropertyNames(b[0]),f=0;f<c.length;f++)d=b[0][c[f]],e="text",d&&("number"==typeof d?e="number":d.indexOf("/Date(")>-1&&(e="date")),g.columns.push({field:c[f],type:e});gj.grid.methods.setDefaultColumnConfig(g.columns,g.defaultColumnSettings)}gj.grid.methods.renderHeader(a)},loadData:function(a){var b,c,d,e,f,g,h,i;for(b=a.data(),c=a.getAll(),gj.grid.events.dataBinding(a,c),e=c.length,gj.grid.methods.stopLoading(a),b.autoGenerateColumns&&gj.grid.methods.autoGenerateColumns(a,c),g=a.children("tbody"),"checkbox"===b.selectionMethod&&"multiple"===b.selectionType&&a.find('thead input[data-role="selectAll"]').prop("checked",!1),g.children("tr").not('[data-role="row"]').remove(),0===e&&(g.empty(),gj.grid.methods.appendEmptyRow(a)),h=g.children("tr"),f=h.length,d=0;d<f;d++){if(!(d<e)){g.find('tr[data-role="row"]:gt('+(d-1)+")").remove();break}i=h.eq(d),gj.grid.methods.renderRow(a,i,c[d],d)}for(d=f;d<e;d++)gj.grid.methods.renderRow(a,null,c[d],d);gj.grid.events.dataBound(a,c,b.totalRecords)},getId:function(a,b,c){return b&&a[b]?a[b]:c},renderRow:function(a,b,c,d){var e,f,g,h,i;for(h=a.data(),b&&0!==b.length?(i="update",b.removeClass(h.style.content.rowSelected).removeAttr("data-selected").off("click")):(i="create",b=$('<tr data-role="row"/>'),a.children("tbody").append(b)),e=gj.grid.methods.getId(c,h.primaryKey,d+1),b.attr("data-position",d+1),"checkbox"!==h.selectionMethod&&b.on("click",gj.grid.methods.createRowClickHandler(a,e)),g=0;g<h.columns.length;g++)"update"===i?(f=b.find("td:eq("+g+")"),gj.grid.methods.renderCell(a,f,h.columns[g],c,e)):(f=gj.grid.methods.renderCell(a,null,h.columns[g],c,e),b.append(f));gj.grid.events.rowDataBound(a,b,e,c)},renderCell:function(a,b,c,d,e,f){var g,h;if(b&&0!==b.length?(g=b.find('div[data-role="display"]'),f="update"):(b=$("<td/>"),g=$('<div data-role="display" />'),c.align&&b.css("text-align",c.align),c.cssClass&&b.addClass(c.cssClass),b.append(g),f="create"),gj.grid.methods.renderDisplayElement(a,g,c,d,e,f),"update"===f&&(b.off(),g.off()),c.events)for(h in c.events)c.events.hasOwnProperty(h)&&b.on(h,{id:e,field:c.field,record:d},gj.grid.methods.createCellEventHandler(c,c.events[h]));return c.hidden&&b.hide(),gj.grid.events.cellDataBound(a,g,e,c,d),b},createCellEventHandler:function(a,b){return function(c){a.stopPropagation&&c.stopPropagation(),b.call(this,c)}},renderDisplayElement:function(a,b,c,d,e,f){var g,h;"checkbox"===c.type&&gj.checkbox?"create"===f?(h=$('<input type="checkbox" />').val(e).prop("checked",!!d[c.field]),c.role&&h.attr("data-role",c.role),b.append(h),h.checkbox({uiLibrary:a.data("uiLibrary")}),"selectRow"===c.role?h.on("click",function(){return!1}):h.prop("disabled",!0)):b.find('input[type="checkbox"]').val(e).prop("checked",!!d[c.field]):"icon"===c.type?"create"===f&&(b.append($("<span/>").addClass(c.icon).css({cursor:"pointer"})),"bootstrap"===a.data().uiLibrary&&b.children("span").addClass("glyphicon"),c.stopPropagation=!0):c.tmpl?(g=c.tmpl,c.tmpl.replace(/\{(.+?)\}/g,function(a,b){g=g.replace(a,gj.grid.methods.formatText(d[b],c))}),b.html(g)):c.renderer&&"function"==typeof c.renderer?(g=c.renderer(d[c.field],d,b.parent(),b,e,a))&&b.html(g):(d[c.field]=gj.grid.methods.formatText(d[c.field],c),!c.tooltip&&d[c.field]&&b.attr("title",d[c.field]),b.html(d[c.field])),c.tooltip&&"create"===f&&b.attr("title",c.tooltip)},formatText:function(a,b){return a=a&&["date","time","datetime"].indexOf(b.type)>-1?gj.core.formatDate(gj.core.parseDate(a,b.format),b.format):void 0===a||null===a?"":a.toString(),b.decimalDigits&&a&&(a=parseFloat(a).toFixed(b.decimalDigits)),a},setRecordsData:function(a,b){var c=[],d=0,e=a.data();return $.isArray(b)?(c=b,d=b.length):e&&e.mapping&&$.isArray(b[e.mapping.dataField])&&(c=b[e.mapping.dataField],(d=b[e.mapping.totalRecordsField])&&!isNaN(d)||(d=0)),a.data("records",c),a.data("totalRecords",d),c},createRowClickHandler:function(a,b){return function(){gj.grid.methods.setSelected(a,b,$(this))}},selectRow:function(a,b,c,d){var e;return c.addClass(b.style.content.rowSelected),c.attr("data-selected","true"),"checkbox"===b.selectionMethod&&(e=c.find('input[type="checkbox"][data-role="selectRow"]'),e.length&&!e.prop("checked")&&e.prop("checked",!0),"multiple"===b.selectionType&&a.getSelections().length===a.count(!1)&&a.find('thead input[data-role="selectAll"]').prop("checked",!0)),gj.grid.events.rowSelect(a,c,d,a.getById(d))},unselectRow:function(a,b,c,d){var e;if("true"===c.attr("data-selected"))return c.removeClass(b.style.content.rowSelected),"checkbox"===b.selectionMethod&&(e=c.find('td input[type="checkbox"][data-role="selectRow"]'),e.length&&e.prop("checked")&&e.prop("checked",!1),"multiple"===b.selectionType&&a.find('thead input[data-role="selectAll"]').prop("checked",!1)),c.removeAttr("data-selected"),gj.grid.events.rowUnselect(a,c,d,a.getById(d))},setSelected:function(a,b,c){var d=a.data();return c&&c.length||(c=gj.grid.methods.getRowById(a,b)),c&&("true"===c.attr("data-selected")?gj.grid.methods.unselectRow(a,d,c,b):("single"===d.selectionType&&c.siblings('[data-selected="true"]').each(function(){var b=$(this),c=gj.grid.methods.getId(b,d.primaryKey,b.data("position"));gj.grid.methods.unselectRow(a,d,b,c)}),gj.grid.methods.selectRow(a,d,c,b))),a},selectAll:function(a){var b=a.data();return a.find('tbody tr[data-role="row"]').each(function(){var c=$(this),d=c.data("position"),e=a.get(d),f=gj.grid.methods.getId(e,b.primaryKey,d);gj.grid.methods.selectRow(a,b,c,f)}),a.find('thead input[data-role="selectAll"]').prop("checked",!0),a},unSelectAll:function(a){var b=a.data();return a.find("tbody tr").each(function(){var c=$(this),d=c.data("position"),e=a.get(d),f=gj.grid.methods.getId(e,b.primaryKey,d);gj.grid.methods.unselectRow(a,b,c,f),c.find('input[type="checkbox"][data-role="selectRow"]').prop("checked",!1)}),a.find('thead input[data-role="selectAll"]').prop("checked",!1),a},getSelected:function(a){var b,c,d,e=null;return b=a.find('tbody>tr[data-selected="true"]'),b.length>0&&(d=$(b[0]).data("position"),c=a.get(d),e=gj.grid.methods.getId(c,a.data().primaryKey,d)),e},getSelectedRows:function(a){a.data();return a.find('tbody>tr[data-selected="true"]')},getSelections:function(a){var b,c,d=[],e=a.data(),f=gj.grid.methods.getSelectedRows(a);return 0<f.length&&f.each(function(){b=$(this).data("position"),c=a.get(b),d.push(gj.grid.methods.getId(c,e.primaryKey,b))}),d},getById:function(a,b){var c,d=null,e=a.data("primaryKey"),f=a.data("records");if(e){for(c=0;c<f.length;c++)if(f[c][e]==b){d=f[c];break}}else d=a.get(b);return d},getRecVPosById:function(a,b){var c,d=b,e=a.data();if(e.primaryKey)for(c=0;c<e.dataSource.length;c++)if(e.dataSource[c][e.primaryKey]==b){d=c;break}return d},getRowById:function(a,b){var c,d,e=a.getAll(!1),f=a.data("primaryKey"),g=void 0;if(f){for(d=0;d<e.length;d++)if(e[d][f]==b){c=d+1;break}}else c=b;return c&&(g=a.children("tbody").children('tr[data-position="'+c+'"]')),g},getByPosition:function(a,b){return a.getAll(!1)[b-1]},getColumnPosition:function(a,b){var c,d=-1;for(c=0;c<a.length;c++)if(a[c].field===b){d=c;break}return d},getColumnInfo:function(a,b){var c,d={},e=a.data();for(c=0;c<e.columns.length;c+=1)if(e.columns[c].field===b){d=e.columns[c];break}return d},getCell:function(a,b,c){var d,e,f=null;return d=gj.grid.methods.getColumnPosition(a.data("columns"),c),d>-1&&(e=gj.grid.methods.getRowById(a,b),f=e.find("td:eq("+d+') div[data-role="display"]')),f},setCellContent:function(a,b,c,d){var e,f=gj.grid.methods.getCell(a,b,c);f&&(f.empty(),"object"==typeof d?f.append(d):(e=gj.grid.methods.getColumnInfo(a,c),gj.grid.methods.renderDisplayElement(a,f,e,a.getById(b),b,"update")))},clone:function(a){var b=[];return $.each(a,function(){b.push(this.clone())}),b},getAll:function(a){return a.data("records")},countVisibleColumns:function(a){var b,c,d;for(b=a.data().columns,c=0,d=0;d<b.length;d++)!0!==b[d].hidden&&c++;return c},clear:function(a,b){var c=a.data();return a.xhr&&a.xhr.abort(),a.children("tbody").empty(),c.records=[],gj.grid.methods.stopLoading(a),gj.grid.methods.appendEmptyRow(a,b?c.notFoundText:"&nbsp;"),gj.grid.events.dataBound(a,[],0),a},render:function(a,b){return b&&(gj.grid.methods.setRecordsData(a,b),gj.grid.methods.updateHeader(a),gj.grid.methods.loadData(a)),a},filter:function(a){var b,c,d=a.data(),e=d.dataSource.slice();d.params[d.paramNames.sortBy]&&(c=gj.grid.methods.getColumnInfo(a,d.params[d.paramNames.sortBy]),e.sort(c.sortable.sorter?c.sortable.sorter(c.direction,c):gj.grid.methods.createDefaultSorter(c.direction,c.field)));for(b in d.params)d.params[b]&&!d.paramNames[b]&&(c=gj.grid.methods.getColumnInfo(a,b),e=$.grep(e,function(a){var e=a[b]||"",f=d.params[b]||"";return c&&"function"==typeof c.filter?c.filter(e,f):e.toUpperCase().indexOf(f.toUpperCase())>-1}));return gj.grid.events.dataFiltered(a,e),e},createDefaultSorter:function(a,b){return function(c,d){var e=(c[b]||"").toString(),f=(d[b]||"").toString();return"asc"===a?e.localeCompare(f):f.localeCompare(e)}},destroy:function(a,b,c){return a.data()&&(gj.grid.events.destroying(a),gj.grid.methods.stopLoading(a),a.xhr&&a.xhr.abort(),a.off(),!1===c&&a.parent('div[data-role="wrapper"]').length>0&&a.unwrap(),a.removeData(),!1===b?a.remove():a.removeClass().empty(),a.removeAttr("data-type")),a},showColumn:function(a,b){var c,d=a.data(),e=gj.grid.methods.getColumnPosition(d.columns,b);return e>-1&&(a.find("thead>tr").each(function(){$(this).children("th").eq(e).show()}),$.each(a.find("tbody>tr"),function(){$(this).children("td").eq(e).show()}),d.columns[e].hidden=!1,c=a.find('tbody > tr[data-role="empty"] > td'),c&&c.length&&c.attr("colspan",gj.grid.methods.countVisibleColumns(a)),gj.grid.events.columnShow(a,d.columns[e])),a},hideColumn:function(a,b){var c,d=a.data(),e=gj.grid.methods.getColumnPosition(d.columns,b);return e>-1&&(a.find("thead>tr").each(function(){$(this).children("th").eq(e).hide()}),$.each(a.find("tbody>tr"),function(){$(this).children("td").eq(e).hide()}),d.columns[e].hidden=!0,c=a.find('tbody > tr[data-role="empty"] > td'),c&&c.length&&c.attr("colspan",gj.grid.methods.countVisibleColumns(a)),gj.grid.events.columnHide(a,d.columns[e])),a},isLastRecordVisible:function(){return!0},addRow:function(a,b){var c=a.data();return c.totalRecords=a.data("totalRecords")+1,gj.grid.events.dataBinding(a,[b]),c.records.push(b),$.isArray(c.dataSource)&&c.dataSource.push(b),1===c.totalRecords&&a.children("tbody").empty(),gj.grid.methods.isLastRecordVisible(a)&&gj.grid.methods.renderRow(a,null,b,a.count()-1),gj.grid.events.dataBound(a,[b],c.totalRecords),a},updateRow:function(a,b,c){var d,e=gj.grid.methods.getRowById(a,b),f=a.data();return f.records[e.data("position")-1]=c,$.isArray(f.dataSource)&&(d=gj.grid.methods.getRecVPosById(a,b),f.dataSource[d]=c),gj.grid.methods.renderRow(a,e,c,e.index()),a},removeRow:function(a,b){var c,d=a.data(),e=gj.grid.methods.getRowById(a,b);return gj.grid.events.rowRemoving(a,e,b,a.getById(b)),$.isArray(d.dataSource)&&(c=gj.grid.methods.getRecVPosById(a,b),d.dataSource.splice(c,1)),a.reload(),a},count:function(a,b){return b?a.data().totalRecords:a.getAll().length},getColumnPositionByRole:function(a,b){var c,d,e=a.data("columns");for(c=0;c<e.length;c++)if(e[c].role===b){d=c;break}return d},getColumnPositionNotInRole:function(a){var b,c=0,d=a.data("columns");for(b=0;b<d.length;b++)if(!d[b].role){c=b;break}return c}},gj.grid.widget=function(a,b){var c=this,d=gj.grid.methods;return c.reload=function(a){return d.startLoading(this),gj.widget.prototype.reload.call(this,a)},c.clear=function(a){return d.clear(this,a)},c.count=function(a){return d.count(this,a)},c.render=function(b){return d.render(a,b)},c.destroy=function(a,b){return d.destroy(this,a,b)},c.setSelected=function(a){return d.setSelected(this,a)},c.getSelected=function(){return d.getSelected(this)},c.getSelections=function(){return d.getSelections(this)},c.selectAll=function(){return d.selectAll(this)},c.unSelectAll=function(){return d.unSelectAll(this)},c.getById=function(a){return d.getById(this,a)},c.get=function(a){return d.getByPosition(this,a)},c.getAll=function(a){return d.getAll(this,a)},c.showColumn=function(a){return d.showColumn(this,a)},c.hideColumn=function(a){return d.hideColumn(this,a)},c.addRow=function(a){return d.addRow(this,a)},c.updateRow=function(a,b){return d.updateRow(this,a,b)},c.setCellContent=function(a,b,c){d.setCellContent(this,a,b,c)},c.removeRow=function(a){return d.removeRow(this,a)},$.extend(a,c),"grid"!==a.attr("data-type")&&d.init.call(a,b),a},gj.grid.widget.prototype=new gj.widget,gj.grid.widget.constructor=gj.grid.widget,gj.grid.widget.prototype.getConfig=gj.grid.methods.getConfig,gj.grid.widget.prototype.getHTMLConfig=gj.grid.methods.getHTMLConfig,function(a){a.fn.grid=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.grid.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.grid.widget(this,a)}}}(jQuery),gj.grid.plugins.fixedHeader={config:{base:{fixedHeader:!1,height:300}},private:{init:function(a){var b=a.data(),c=a.children("tbody"),d=a.children("thead"),e=b.height-d.outerHeight()-(a.children("tfoot").outerHeight()||0);a.addClass("gj-grid-scrollable"),c.css("width",d.outerWidth()),c.height(e)},refresh:function(a){var b,c,d=(a.data(),a.children("tbody")),e=a.children("thead"),f=a.find('tbody tr[data-role="row"] td'),g=a.find('thead tr[data-role="caption"] th');for(a.children("tbody").height()<gj.grid.plugins.fixedHeader.private.getRowsHeight(a)?d.css("width",e.outerWidth()+gj.grid.plugins.fixedHeader.private.getScrollBarWidth()+(navigator.userAgent.toLowerCase().indexOf("firefox")>-1?1:0)):d.css("width",e.outerWidth()),b=0;b<g.length;b++)c=$(g[b]).outerWidth(),0===b&&gj.core.isIE()&&(c-=1),$(f[b]).attr("width",c)},getRowsHeight:function(a){var b=0;return a.find("tbody tr").each(function(){b+=$(this).height()}),b},getScrollBarWidth:function(){var a=document.createElement("p");a.style.width="100%",a.style.height="200px";var b=document.createElement("div");b.style.position="absolute",b.style.top="0px",b.style.left="0px",b.style.visibility="hidden",b.style.width="200px",b.style.height="150px",b.style.overflow="hidden",b.appendChild(a),document.body.appendChild(b);var c=a.offsetWidth;b.style.overflow="scroll";var d=a.offsetWidth;return c==d&&(d=b.clientWidth),document.body.removeChild(b),c-d}},public:{},events:{},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.fixedHeader.public);a.data();c.fixedHeader&&(a.on("initialized",function(){gj.grid.plugins.fixedHeader.private.init(a)}),a.on("dataBound",function(){gj.grid.plugins.fixedHeader.private.refresh(a)}),a.on("resize",function(){gj.grid.plugins.fixedHeader.private.refresh(a)}))}},gj.grid.plugins.expandCollapseRows={config:{base:{detailTemplate:void 0,keepExpandedRows:!0,expandedRows:[],icons:{expandRow:'<i class="gj-icon chevron-right" />',collapseRow:'<i class="gj-icon chevron-down" />'}},fontawesome:{icons:{expandRow:'<i class="fa fa-angle-right" aria-hidden="true"></i>',collapseRow:'<i class="fa fa-angle-down" aria-hidden="true"></i>'}},glyphicons:{icons:{expandRow:'<span class="glyphicon glyphicon-chevron-right" />',collapseRow:'<span class="glyphicon glyphicon-chevron-down" />'}}},private:{expandDetail:function(a,b,c){var d=b.closest("tr"),e=$('<tr data-role="details" />'),f=$('<td colspan="'+gj.grid.methods.countVisibleColumns(a)+'" />'),g=$('<div data-role="display" />'),h=a.data(),i=d.data("position"),j=a.get(i),k=gj.grid.plugins.expandCollapseRows;void 0===typeof c&&(c=gj.grid.methods.getId(j,h.primaryKey,j)),e.append(f.append(g.append(d.data("details")))),e.insertAfter(d),b.children('div[data-role="display"]').empty().append(h.icons.collapseRow),a.updateDetails(d),k.private.keepSelection(a,c),k.events.detailExpand(a,e.find("td>div"),c)},collapseDetail:function(a,b,c){var d=b.closest("tr"),e=d.next('tr[data-role="details"]'),f=a.data(),g=gj.grid.plugins.expandCollapseRows;void 0===typeof c&&(c=gj.grid.methods.getId(record,f.primaryKey,record)),e.remove(),b.children('div[data-role="display"]').empty().append(f.icons.expandRow),g.private.removeSelection(a,c),g.events.detailCollapse(a,e.find("td>div"),c)},keepSelection:function(a,b){var c=a.data();c.keepExpandedRows&&($.isArray(c.expandedRows)?-1==c.expandedRows.indexOf(b)&&c.expandedRows.push(b):c.expandedRows=[b])},removeSelection:function(a,b){var c=a.data();c.keepExpandedRows&&$.isArray(c.expandedRows)&&c.expandedRows.indexOf(b)>-1&&c.expandedRows.splice(c.expandedRows.indexOf(b),1)},updateDetailsColSpan:function(a){var b=a.find('tbody > tr[data-role="details"] > td');b&&b.length&&b.attr("colspan",gj.grid.methods.countVisibleColumns(a))}},public:{collapseAll:function(){var a,b=this,c=b.data();return void 0!==c.detailTemplate&&(a=gj.grid.methods.getColumnPositionByRole(b,"expander"),b.find('tbody tr[data-role="row"]').each(function(){gj.grid.plugins.expandCollapseRows.private.collapseDetail(b,$(this).find("td:eq("+a+")"))})),void 0!==c.grouping&&b.find('tbody tr[role="group"]').each(function(){gj.grid.plugins.grouping.private.collapseGroup(c,$(this).find("td:eq(0)"))}),b},expandAll:function(){var a,b=this,c=b.data();return void 0!==c.detailTemplate&&(a=gj.grid.methods.getColumnPositionByRole(b,"expander"),b.find('tbody tr[data-role="row"]').each(function(){gj.grid.plugins.expandCollapseRows.private.expandDetail(b,$(this).find("td:eq("+a+")"))})),void 0!==c.grouping&&b.find('tbody tr[role="group"]').each(function(){gj.grid.plugins.grouping.private.expandGroup(c,$(this).find("td:eq(0)"))}),b},updateDetails:function(a){var b=this,c=a.data("details"),d=c.html(),e=b.get(a.data("position"));return e&&d&&(c.html().replace(/\{(.+?)\}/g,function(a,c){var f=gj.grid.methods.getColumnInfo(b,c);d=d.replace(a,gj.grid.methods.formatText(e[c],f))}),c.html(d)),b}},events:{detailExpand:function(a,b,c){a.triggerHandler("detailExpand",[b,c])},detailCollapse:function(a,b,c){a.triggerHandler("detailCollapse",[b,c])}},configure:function(a){var b,c=a.data();$.extend(!0,a,gj.grid.plugins.expandCollapseRows.public),void 0!==c.detailTemplate&&(b={title:"",width:c.defaultIconColumnWidth,align:"center",stopPropagation:!0,cssClass:"gj-cursor-pointer gj-unselectable",tmpl:c.icons.expandRow,role:"expander",events:{click:function(b){var c=$(this),d=gj.grid.plugins.expandCollapseRows.private;"details"===c.closest("tr").next().attr("data-role")?d.collapseDetail(a,c,b.data.id):d.expandDetail(a,$(this),b.data.id)}}},c.columns=[b].concat(c.columns),a.on("rowDataBound",function(a,b,d,e){b.data("details",$(c.detailTemplate))}),a.on("columnShow",function(b,c){gj.grid.plugins.expandCollapseRows.private.updateDetailsColSpan(a)}),a.on("columnHide",function(b,c){gj.grid.plugins.expandCollapseRows.private.updateDetailsColSpan(a)}),a.on("rowRemoving",function(b,c,d,e){gj.grid.plugins.expandCollapseRows.private.collapseDetail(a,c.children("td").first(),d)}),a.on("dataBinding",function(){a.collapseAll()}),a.on("pageChanging",function(){a.collapseAll()}),a.on("dataBound",function(){var b,c,d,e,f=a.data();if(f.keepExpandedRows&&$.isArray(f.expandedRows))for(b=0;b<f.expandedRows.length;b++)(d=gj.grid.methods.getRowById(a,f.expandedRows[b]))&&d.length&&(e=gj.grid.methods.getColumnPositionByRole(a,"expander"),(c=d.children("td:eq("+e+")"))&&c.length&&gj.grid.plugins.expandCollapseRows.private.expandDetail(a,c))}))}},gj.grid.plugins.inlineEditing={renderers:{editManager:function(a,b,c,d,e,f){var g=f.data(),h=$(g.inlineEditing.editButton).attr("key",e),i=$(g.inlineEditing.deleteButton).attr("key",e),j=$(g.inlineEditing.updateButton).attr("key",e).hide(),k=$(g.inlineEditing.cancelButton).attr("key",e).hide();h.on("click",function(a){f.edit($(this).attr("key"))}),i.on("click",function(a){f.removeRow($(this).attr("key"))}),j.on("click",function(a){f.update($(this).attr("key"))}),k.on("click",function(a){f.cancel($(this).attr("key"))}),d.empty().append(h).append(i).append(j).append(k)}}},gj.grid.plugins.inlineEditing.config={base:{defaultColumnSettings:{editor:void 0,editField:void 0,mode:"readEdit"},inlineEditing:{mode:"click",managementColumn:!0,managementColumnConfig:{width:300,role:"managementColumn",align:"center",renderer:gj.grid.plugins.inlineEditing.renderers.editManager,cssClass:"gj-grid-management-column"}}},bootstrap:{inlineEditing:{managementColumnConfig:{width:200,role:"managementColumn",align:"center",renderer:gj.grid.plugins.inlineEditing.renderers.editManager,cssClass:"gj-grid-management-column"}}},bootstrap4:{inlineEditing:{managementColumnConfig:{width:280,role:"managementColumn",align:"center",renderer:gj.grid.plugins.inlineEditing.renderers.editManager,cssClass:"gj-grid-management-column"}}}},gj.grid.plugins.inlineEditing.private={localization:function(a){"bootstrap"===a.uiLibrary?(a.inlineEditing.editButton='<button role="edit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> '+gj.grid.messages[a.locale].Edit+"</button>",a.inlineEditing.deleteButton='<button role="delete" class="btn btn-default btn-sm gj-margin-left-10"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> '+gj.grid.messages[a.locale].Delete+"</button>",a.inlineEditing.updateButton='<button role="update" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+gj.grid.messages[a.locale].Update+"</button>",a.inlineEditing.cancelButton='<button role="cancel" class="btn btn-default btn-sm gj-margin-left-10"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> '+gj.grid.messages[a.locale].Cancel+"</button>"):(a.inlineEditing.editButton='<button role="edit" class="gj-button-md"><i class="gj-icon pencil" /> '+gj.grid.messages[a.locale].Edit.toUpperCase()+"</button>",a.inlineEditing.deleteButton='<button role="delete" class="gj-button-md"><i class="gj-icon delete" /> '+gj.grid.messages[a.locale].Delete.toUpperCase()+"</button>",a.inlineEditing.updateButton='<button role="update" class="gj-button-md"><i class="gj-icon check-circle" /> '+gj.grid.messages[a.locale].Update.toUpperCase()+"</button>",a.inlineEditing.cancelButton='<button role="cancel" class="gj-button-md"><i class="gj-icon cancel" /> '+gj.grid.messages[a.locale].Cancel.toUpperCase()+"</button>")},editMode:function(a,b,c,d){var e,f,g,h,i,j=a.data();if("edit"!==b.attr("data-mode"))if(c.editor){if(gj.grid.plugins.inlineEditing.private.updateOtherCells(a,c.mode),e=b.find('div[data-role="display"]').hide(),f=b.find('div[data-role="edit"]').show(),0===f.length&&(f=$('<div data-role="edit" />'),b.append(f)),h=d[c.editField||c.field],g=f.find("input, select, textarea").first(),g.length)switch(c.type){case"checkbox":g.prop("checked",h);break;case"dropdown":g=g.dropdown("value",h);break;default:g.val(h)}else{if("function"==typeof c.editor)c.editor(f,h,d),g=f.find("input, select, textarea").first();else if(i="object"==typeof c.editor?c.editor:{},i.uiLibrary=j.uiLibrary,i.iconsLibrary=j.iconsLibrary,i.fontSize=a.css("font-size"),i.showOnFocus=!1,"checkbox"===c.type&&gj.checkbox)g=$('<input type="checkbox" />').prop("checked",h),f.append(g),g.checkbox(i);else if("date"===c.type&&gj.datepicker||"time"===c.type&&gj.timepicker||"datetime"===c.type&&gj.datetimepicker){switch(g=$('<input type="text" width="100%"/>'),f.append(g),c.format&&(i.format=c.format),c.type){case"date":g=g.datepicker(i);break;case"time":g=g.timepicker(i);break;case"datetime":g=g.datetimepicker(i)}g.value&&g.value(e.html())}else"dropdown"===c.type&&gj.dropdown?(g=$('<select type="text" width="100%"/>'),f.append(g),i.dataBound=function(a){var b=$(this).dropdown();c.editField?b.value(d[c.editField]):b.value(d[c.field])},g=g.dropdown(i)):(g=$('<input type="text" value="'+h+'" class="gj-width-full"/>'),"materialdesign"===j.uiLibrary&&g.addClass("gj-textbox-md").css("font-size",a.css("font-size")),f.append(g));"command"!==j.inlineEditing.mode&&"editOnly"!==c.mode&&(g=f.find("input, select, textarea").first(),g.on("keyup",function(d){13!==d.keyCode&&27!==d.keyCode||gj.grid.plugins.inlineEditing.private.displayMode(a,b,c)}))}"INPUT"===g.prop("tagName").toUpperCase()&&"TEXT"===g.prop("type").toUpperCase()?gj.core.setCaretAtEnd(g[0]):g.focus(),b.attr("data-mode","edit")}else"managementColumn"===c.role&&(b.find('[role="edit"]').hide(),b.find('[role="delete"]').hide(),b.find('[role="update"]').show(),b.find('[role="cancel"]').show())},displayMode:function(a,b,c,d){var e,f,g,h,i,j,k;"editOnly"!==c.mode&&("edit"===b.attr("data-mode")&&(e=b.find('div[data-role="edit"]'),f=b.find('div[data-role="display"]'),g=e.find("input, select, textarea").first(),"SELECT"===g[0].tagName.toUpperCase()&&g[0].selectedIndex>-1?(h=g[0].options[g[0].selectedIndex].innerHTML,i=g[0].value):h="INPUT"===g[0].tagName.toUpperCase()&&"CHECKBOX"===g[0].type.toUpperCase()?g[0].checked:g.val(),k=b.parent().data("position"),j=a.get(k),!0!==d&&h!==j[c.field]&&(j[c.field]="date"===c.type?gj.core.parseDate(h,c.format):h,c.editField&&(j[c.editField]=i||h),"editOnly"!==c.mode&&(gj.grid.methods.renderDisplayElement(a,f,c,j,gj.grid.methods.getId(j,a.data("primaryKey"),k),"update"),0===b.find("span.gj-dirty").length&&b.prepend($('<span class="gj-dirty" />'))),gj.grid.plugins.inlineEditing.events.cellDataChanged(a,b,c,j,h),gj.grid.plugins.inlineEditing.private.updateChanges(a,c,j,h)),e.hide(),f.show(),b.attr("data-mode","display")),"managementColumn"===c.role&&(b.find('[role="update"]').hide(),b.find('[role="cancel"]').hide(),b.find('[role="edit"]').show(),b.find('[role="delete"]').show()))},updateOtherCells:function(a,b){var c=a.data();"command"!==c.inlineEditing.mode&&"editOnly"!==b&&a.find('div[data-role="edit"]:visible').parent("td").each(function(){var b=$(this),d=c.columns[b.index()];gj.grid.plugins.inlineEditing.private.displayMode(a,b,d)})},updateChanges:function(a,b,c,d){var e,f,g,h=a.data();h.guid||(h.guid=gj.grid.plugins.inlineEditing.private.generateGUID()),h.primaryKey&&(e=JSON.parse(sessionStorage.getItem("gj.grid."+h.guid)),e?f=e.filter(function(a){return a[h.primaryKey]===c[h.primaryKey]}):e=[],f&&1===f.length?f[0][b.field]=d:(g={},g[h.primaryKey]=c[h.primaryKey],h.primaryKey!==b.field&&(g[b.field]=d),e.push(g)),sessionStorage.setItem("gj.grid."+h.guid,JSON.stringify(e)))},generateGUID:function(){function a(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return a()+a()+"-"+a()+"-"+a()+"-"+a()+"-"+a()+a()+a()}},gj.grid.plugins.inlineEditing.public={getChanges:function(){return JSON.parse(sessionStorage.getItem("gj.grid."+this.data().guid))},edit:function(a){var b,c=this.getById(a),d=gj.grid.methods.getRowById(this,a).children("td"),e=this.data("columns");for(b=0;b<d.length;b++)gj.grid.plugins.inlineEditing.private.editMode(this,$(d[b]),e[b],c);return this},update:function(a){var b,c=this.getById(a),d=gj.grid.methods.getRowById(this,a).children("td"),e=this.data("columns");for(b=0;b<d.length;b++)gj.grid.plugins.inlineEditing.private.displayMode(this,$(d[b]),e[b],!1);return gj.grid.plugins.inlineEditing.events.rowDataChanged(this,a,c),this},cancel:function(a){var b,c=(this.getById(a),gj.grid.methods.getRowById(this,a).children("td")),d=this.data("columns");for(b=0;b<c.length;b++)gj.grid.plugins.inlineEditing.private.displayMode(this,$(c[b]),d[b],!0);return this}},gj.grid.plugins.inlineEditing.events={cellDataChanged:function(a,b,c,d,e,f){a.triggerHandler("cellDataChanged",[b,c,d,e,f])},rowDataChanged:function(a,b,c){a.triggerHandler("rowDataChanged",[b,c])}},gj.grid.plugins.inlineEditing.configure=function(a,b,c){var d=a.data();$.extend(!0,a,gj.grid.plugins.inlineEditing.public),c.inlineEditing&&(a.on("dataBound",function(){a.find("span.gj-dirty").remove()}),a.on("rowDataBound",function(b,c,d,e){a.cancel(d)})),"command"===d.inlineEditing.mode?(gj.grid.plugins.inlineEditing.private.localization(d),b.inlineEditing.managementColumn&&d.columns.push(b.inlineEditing.managementColumnConfig)):a.on("cellDataBound",function(b,c,e,f,g){f.editor&&("editOnly"===f.mode?gj.grid.plugins.inlineEditing.private.editMode(a,c.parent(),f,g):c.parent("td").on("dblclick"===d.inlineEditing.mode?"dblclick":"click",function(){gj.grid.plugins.inlineEditing.private.editMode(a,c.parent(),f,g)}))})},gj.grid.plugins.optimisticPersistence={config:{base:{optimisticPersistence:{localStorage:void 0,sessionStorage:void 0}}},private:{applyParams:function(a){var b,c=a.data(),d={};b=JSON.parse(sessionStorage.getItem("gj.grid."+c.guid)),b&&b.optimisticPersistence&&$.extend(d,b.optimisticPersistence),b=JSON.parse(localStorage.getItem("gj.grid."+c.guid)),b&&b.optimisticPersistence&&$.extend(d,b.optimisticPersistence),$.extend(c.params,d)},saveParams:function(a){var b,c,d=a.data(),e={optimisticPersistence:{}};if(d.optimisticPersistence.sessionStorage){for(b=0;b<d.optimisticPersistence.sessionStorage.length;b++)c=d.optimisticPersistence.sessionStorage[b],e.optimisticPersistence[c]=d.params[c];e=$.extend(!0,JSON.parse(sessionStorage.getItem("gj.grid."+d.guid)),e),sessionStorage.setItem("gj.grid."+d.guid,JSON.stringify(e))}if(d.optimisticPersistence.localStorage){for(e={optimisticPersistence:{}},b=0;b<d.optimisticPersistence.localStorage.length;b++)c=d.optimisticPersistence.localStorage[b],e.optimisticPersistence[c]=d.params[c];e=$.extend(!0,JSON.parse(localStorage.getItem("gj.grid."+d.guid)),e),localStorage.setItem("gj.grid."+d.guid,JSON.stringify(e))}}},configure:function(a,b,c){b.guid&&(b.optimisticPersistence.localStorage||b.optimisticPersistence.sessionStorage)&&(gj.grid.plugins.optimisticPersistence.private.applyParams(a),a.on("dataBound",function(b){gj.grid.plugins.optimisticPersistence.private.saveParams(a)}))}},gj.grid.plugins.pagination={config:{base:{style:{pager:{panel:"",stateDisabled:"",activeButton:""}},paramNames:{page:"page",limit:"limit"},pager:{limit:10,sizes:[5,10,20,100],leftControls:void 0,rightControls:void 0}},bootstrap:{style:{pager:{panel:"",stateDisabled:""}}},bootstrap4:{style:{pager:{panel:"btn-toolbar",stateDisabled:""}}},glyphicons:{icons:{first:'<span class="glyphicon glyphicon-step-backward"></span>',previous:'<span class="glyphicon glyphicon-backward"></span>',next:'<span class="glyphicon glyphicon-forward"></span>',last:'<span class="glyphicon glyphicon-step-forward"></span>',refresh:'<span class="glyphicon glyphicon-refresh"></span>'}},materialicons:{icons:{first:'<i class="gj-icon first-page" />',previous:'<i class="gj-icon chevron-left" />',next:'<i class="gj-icon chevron-right" />',last:'<i class="gj-icon last-page" />',refresh:'<i class="gj-icon refresh" />'}},fontawesome:{icons:{first:'<i class="fa fa-fast-backward" aria-hidden="true"></i>',previous:'<i class="fa fa-backward" aria-hidden="true"></i>',next:'<i class="fa fa-forward" aria-hidden="true"></i>',last:'<i class="fa fa-fast-forward" aria-hidden="true"></i>',refresh:'<i class="fa fa-refresh" aria-hidden="true"></i>'}}},private:{init:function(a){var b,c,d,e,f,g,h,i,j,k;if(d=a.data(),d.pager)for(d.params[d.paramNames.page]||(d.params[d.paramNames.page]=1),d.params[d.paramNames.limit]||(d.params[d.paramNames.limit]=d.pager.limit),gj.grid.plugins.pagination.private.localization(d),b=$('<tr data-role="pager"/>'),c=$("<th/>"),b.append(c),f=$('<div data-role="display" />').addClass(d.style.pager.panel).css({float:"left"}),g=$('<div data-role="display" />').addClass(d.style.pager.panel).css({float:"right"}),c.append(f).append(g),h=$("<tfoot />").append(b),a.append(h),gj.grid.plugins.pagination.private.updatePagerColSpan(a),i=gj.grid.methods.clone(d.pager.leftControls),$.each(i,function(){f.append(this)}),j=gj.grid.methods.clone(d.pager.rightControls),$.each(j,function(){g.append(this)}),e=a.find("tfoot [data-role]"),k=0;k<e.length;k++)gj.grid.plugins.pagination.private.initPagerControl($(e[k]),a)},localization:function(a){"bootstrap"===a.uiLibrary?gj.grid.plugins.pagination.private.localizationBootstrap(a):"bootstrap4"===a.uiLibrary?gj.grid.plugins.pagination.private.localizationBootstrap4(a):gj.grid.plugins.pagination.private.localizationMaterialDesign(a)},localizationBootstrap:function(a){var b=gj.grid.messages[a.locale];void 0===a.pager.leftControls&&(a.pager.leftControls=[$('<button type="button" class="btn btn-default btn-sm">'+(a.icons.first||b.First)+"</button>").attr("title",b.FirstPageTooltip).attr("data-role","page-first"),$('<button type="button" class="btn btn-default btn-sm">'+(a.icons.previous||b.Previous)+"</button>").attr("title",b.PreviousPageTooltip).attr("data-role","page-previous"),$("<div>"+b.Page+"</div>"),$('<input data-role="page-number" class="form-control input-sm" type="text" value="0">'),$("<div>"+b.Of+"</div>"),$('<div data-role="page-label-last">0</div>'),$('<button type="button" class="btn btn-default btn-sm">'+(a.icons.next||b.Next)+"</button>").attr("title",b.NextPageTooltip).attr("data-role","page-next"),$('<button type="button" class="btn btn-default btn-sm">'+(a.icons.last||b.Last)+"</button>").attr("title",b.LastPageTooltip).attr("data-role","page-last"),$('<button type="button" class="btn btn-default btn-sm">'+(a.icons.refresh||b.Refresh)+"</button>").attr("title",b.Refresh).attr("data-role","page-refresh"),$('<select data-role="page-size" class="form-control input-sm" width="60"></select>')]),void 0===a.pager.rightControls&&(a.pager.rightControls=[$("<div>"+b.DisplayingRecords+"</div>"),$('<div data-role="record-first">0</div>'),$("<div>-</div>"),$('<div data-role="record-last">0</div>'),$("<div>"+b.Of+"</div>"),$('<div data-role="record-total">0</div>')])},localizationBootstrap4:function(a){var b=gj.grid.messages[a.locale];void 0===a.pager.leftControls&&(a.pager.leftControls=[$('<button class="btn btn-default btn-sm gj-cursor-pointer">'+(a.icons.first||b.First)+"</button>").attr("title",b.FirstPageTooltip).attr("data-role","page-first"),$('<button class="btn btn-default btn-sm gj-cursor-pointer">'+(a.icons.previous||b.Previous)+"</button>").attr("title",b.PreviousPageTooltip).attr("data-role","page-previous"),$("<div>"+b.Page+"</div>"),$('<div class="input-group"><input data-role="page-number" class="form-control form-control-sm" type="text" value="0"></div>'),$("<div>"+b.Of+"</div>"),$('<div data-role="page-label-last">0</div>'),$('<button class="btn btn-default btn-sm gj-cursor-pointer">'+(a.icons.next||b.Next)+"</button>").attr("title",b.NextPageTooltip).attr("data-role","page-next"),$('<button class="btn btn-default btn-sm gj-cursor-pointer">'+(a.icons.last||b.Last)+"</button>").attr("title",b.LastPageTooltip).attr("data-role","page-last"),$('<button class="btn btn-default btn-sm gj-cursor-pointer">'+(a.icons.refresh||b.Refresh)+"</button>").attr("title",b.Refresh).attr("data-role","page-refresh"),$('<select data-role="page-size" class="form-control input-sm" width="60"></select>')]),void 0===a.pager.rightControls&&(a.pager.rightControls=[$("<div>"+b.DisplayingRecords+"&nbsp;</div>"),$('<div data-role="record-first">0</div>'),$("<div>-</div>"),$('<div data-role="record-last">0</div>'),$("<div>"+b.Of+"</div>"),$('<div data-role="record-total">0</div>')])},localizationMaterialDesign:function(a){var b=gj.grid.messages[a.locale];void 0===a.pager.leftControls&&(a.pager.leftControls=[]),void 0===a.pager.rightControls&&(a.pager.rightControls=[$('<span class="">'+b.RowsPerPage+"</span>"),$('<select data-role="page-size" class="gj-grid-md-limit-select" width="52"></select></div>'),$('<span class="gj-md-spacer-32">&nbsp;</span>'),$('<span data-role="record-first" class="">0</span>'),$('<span class="">-</span>'),$('<span data-role="record-last" class="">0</span>'),$('<span class="gj-grid-mdl-pager-label">'+b.Of+"</span>"),$('<span data-role="record-total" class="">0</span>'),$('<span class="gj-md-spacer-32">&nbsp;</span>'),$('<button class="gj-button-md">'+(a.icons.previous||b.Previous)+"</button>").attr("title",b.PreviousPageTooltip).attr("data-role","page-previous").addClass(a.icons.first?"gj-button-md-icon":""),$('<span class="gj-md-spacer-24">&nbsp;</span>'),$('<button class="gj-button-md">'+(a.icons.next||b.Next)+"</button>").attr("title",b.NextPageTooltip).attr("data-role","page-next").addClass(a.icons.first?"gj-button-md-icon":"")])},initPagerControl:function(a,b){var c=b.data();switch(a.data("role")){case"page-size":c.pager.sizes&&0<c.pager.sizes.length?(a.show(),$.each(c.pager.sizes,function(){a.append($("<option/>").attr("value",this.toString()).text(this.toString()))}),a.change(function(){var a=parseInt(this.value,10);c.params[c.paramNames.limit]=a,gj.grid.plugins.pagination.private.changePage(b,1),gj.grid.plugins.pagination.events.pageSizeChange(b,a)}),a.val(c.params[c.paramNames.limit]),gj.dropdown&&a.dropdown({uiLibrary:c.uiLibrary,iconsLibrary:c.iconsLibrary,fontSize:a.css("font-size"),style:{presenter:"btn btn-default btn-sm"}})):a.hide();break;case"page-refresh":a.on("click",function(){b.reload()})}},reloadPager:function(a,b){var c,d,e,f,g,h,i,j;if(h=a.data(),h.pager){for(c=0===b?0:parseInt(h.params[h.paramNames.page],10),d=parseInt(h.params[h.paramNames.limit],10),e=Math.ceil(b/d),f=0===c?0:d*(c-1)+1,g=f+d>b?b:f+d-1,i=a.find("TFOOT [data-role]"),j=0;j<i.length;j++)gj.grid.plugins.pagination.private.reloadPagerControl($(i[j]),a,c,e,f,g,b);gj.grid.plugins.pagination.private.updatePagerColSpan(a)}},reloadPagerControl:function(a,b,c,d,e,f,g){var h;switch(a.data("role")){case"page-first":gj.grid.plugins.pagination.private.assignPageHandler(b,a,1,c<2);break;case"page-previous":gj.grid.plugins.pagination.private.assignPageHandler(b,a,c-1,c<2);break;case"page-number":a.val(c).off("change").on("change",gj.grid.plugins.pagination.private.createChangePageHandler(b,c));break;case"page-label-last":a.text(d);break;case"page-next":gj.grid.plugins.pagination.private.assignPageHandler(b,a,c+1,d===c);break;case"page-last":gj.grid.plugins.pagination.private.assignPageHandler(b,a,d,d===c);break;case"page-button-one":h=1===c?1:c==d?c-2:c-1,gj.grid.plugins.pagination.private.assignButtonHandler(b,a,c,h,d);break;case"page-button-two":h=1===c?2:c==d?d-1:c,gj.grid.plugins.pagination.private.assignButtonHandler(b,a,c,h,d);break;case"page-button-three":h=1===c?c+2:c==d?c:c+1,gj.grid.plugins.pagination.private.assignButtonHandler(b,a,c,h,d);break;case"record-first":a.text(e);break;case"record-last":a.text(f);break;case"record-total":a.text(g)}},assignPageHandler:function(a,b,c,d){var e=a.data().style.pager;d?b.addClass(e.stateDisabled).prop("disabled",!0).off("click"):b.removeClass(e.stateDisabled).prop("disabled",!1).off("click").on("click",function(){gj.grid.plugins.pagination.private.changePage(a,c)})},assignButtonHandler:function(a,b,c,d,e){var f=a.data().style.pager;d<1||d>e?b.hide():(b.show().off("click").text(d),d===c?b.addClass(f.activeButton):b.removeClass(f.activeButton).on("click",function(){gj.grid.plugins.pagination.private.changePage(a,d)}))},createChangePageHandler:function(a,b){return function(){var b=(a.data(),parseInt(this.value,10));gj.grid.plugins.pagination.private.changePage(a,b)}},changePage:function(a,b){var c=a.data();!1===gj.grid.plugins.pagination.events.pageChanging(a,b)||isNaN(b)||(a.find('TFOOT [data-role="page-number"]').val(b),c.params[c.paramNames.page]=b),a.reload()},updatePagerColSpan:function(a){var b=a.find('tfoot > tr[data-role="pager"] > th');b&&b.length&&b.attr("colspan",gj.grid.methods.countVisibleColumns(a))},isLastRecordVisible:function(a){var b=!0,c=a.data(),d=parseInt(c.params[c.paramNames.limit],10),e=parseInt(c.params[c.paramNames.page],10),f=a.count();return d&&e&&(b=(e-1)*d+f===c.totalRecords),b}},public:{getAll:function(a){var b,c,d,e=this.data();return $.isArray(e.dataSource)?a?e.dataSource:e.params[e.paramNames.limit]&&e.params[e.paramNames.page]?(b=parseInt(e.params[e.paramNames.limit],10),c=parseInt(e.params[e.paramNames.page],10),d=(c-1)*b,e.records.slice(d,d+b)):e.records:e.records}},events:{pageSizeChange:function(a,b){a.triggerHandler("pageSizeChange",[b])},pageChanging:function(a,b){a.triggerHandler("pageChanging",[b])}},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.pagination.public);a.data();c.pager&&(gj.grid.methods.isLastRecordVisible=gj.grid.plugins.pagination.private.isLastRecordVisible,a.on("initialized",function(){gj.grid.plugins.pagination.private.init(a)}),a.on("dataBound",function(b,c,d){gj.grid.plugins.pagination.private.reloadPager(a,d)}),a.on("columnShow",function(){gj.grid.plugins.pagination.private.updatePagerColSpan(a)}),a.on("columnHide",function(){gj.grid.plugins.pagination.private.updatePagerColSpan(a)}))}},gj.grid.plugins.responsiveDesign={config:{base:{resizeCheckInterval:500,responsive:!1,showHiddenColumnsAsDetails:!1,defaultColumn:{priority:void 0,minWidth:250},style:{rowDetailItem:""}},bootstrap:{style:{rowDetailItem:"col-lg-4"}}},private:{orderColumns:function(a){var b=[];if(a.columns&&a.columns.length){for(i=0;i<a.columns.length;i++)b.push({position:i,field:a.columns[i].field,minWidth:a.columns[i].width||a.columns[i].minWidth||a.defaultColumn.minWidth,priority:a.columns[i].priority||0});b.sort(function(a,b){var c=0;return a.priority<b.priority?c=-1:a.priority>b.priority&&(c=1),c})}return b},updateDetails:function(a){var b,c,d,e,f,g,h,i,j;for(b=a.find('tbody > tr[data-role="row"]'),c=a.data(),d=0;d<b.length;d++){for(f=$(b[d]),g=f.data("details"),e=0;e<c.columns.length;e++)i=c.columns[e],h=g&&g.find('div[data-id="'+i.field+'"]'),c.columns[e].hidden?(j="<b>"+(i.title||i.field)+"</b>: {"+i.field+"}",h&&h.length?h.empty().html(j):(h=$('<div data-id="'+i.field+'"/>').html(j),h.addClass(c.style.rowDetailItem),g&&g.length||(g=$('<div class="row"/>')),g.append(h))):h&&h.length&&h.remove();a.updateDetails(f)}}},public:{oldWidth:void 0,resizeCheckIntervalId:void 0,makeResponsive:function(){var a,b,c=0,d=this.data(),e=gj.grid.plugins.responsiveDesign.private.orderColumns(d);for(a=0;a<e.length;a++)b=this.find("thead>tr>th:eq("+e[a].position+")"),b.is(":visible")&&e[a].minWidth<b.width()&&(c+=b.width()-e[a].minWidth);if(c)for(a=0;a<e.length;a++)b=this.find("thead>tr>th:eq("+e[a].position+")"),!b.is(":visible")&&e[a].minWidth<=c&&(this.showColumn(e[a].field),c-=b.width());for(a=e.length-1;a>=0;a--)b=this.find("thead>tr>th:eq("+e[a].position+")"),b.is(":visible")&&e[a].priority&&e[a].minWidth>b.outerWidth()&&this.hideColumn(e[a].field);return this}},events:{resize:function(a,b,c){a.triggerHandler("resize",[b,c])}},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.responsiveDesign.public),b.responsive&&(a.on("initialized",function(){a.makeResponsive(),a.oldWidth=a.width(),a.resizeCheckIntervalId=setInterval(function(){var b=a.width();b!==a.oldWidth&&gj.grid.plugins.responsiveDesign.events.resize(a,b,a.oldWidth),a.oldWidth=b},b.resizeCheckInterval)}),a.on("destroy",function(){a.resizeCheckIntervalId&&clearInterval(a.resizeCheckIntervalId)}),a.on("resize",function(){a.makeResponsive()})),b.showHiddenColumnsAsDetails&&gj.grid.plugins.expandCollapseRows&&(a.on("dataBound",function(){gj.grid.plugins.responsiveDesign.private.updateDetails(a)}),a.on("columnHide",function(){gj.grid.plugins.responsiveDesign.private.updateDetails(a)}),a.on("columnShow",function(){gj.grid.plugins.responsiveDesign.private.updateDetails(a)}),a.on("rowDataBound",function(){gj.grid.plugins.responsiveDesign.private.updateDetails(a)}))}},gj.grid.plugins.toolbar={config:{base:{toolbarTemplate:void 0,title:void 0,style:{toolbar:"gj-grid-md-toolbar"}},bootstrap:{style:{toolbar:"gj-grid-bootstrap-toolbar"}},bootstrap4:{style:{toolbar:"gj-grid-bootstrap-4-toolbar"}}},private:{init:function(a){var b,c,d;b=a.data(),c=a.prev('div[data-role="toolbar"]'),(void 0!==b.toolbarTemplate||void 0!==b.title||c.length>0)&&(0===c.length&&(c=$('<div data-role="toolbar"></div>'),a.before(c)),c.addClass(b.style.toolbar),0===c.children().length&&b.toolbarTemplate&&c.append(b.toolbarTemplate),d=c.find('[data-role="title"]'),0===d.length&&(d=$('<div data-role="title"/>'),c.prepend(d)),b.title&&d.text(b.title),b.minWidth&&c.css("min-width",b.minWidth))}},public:{title:function(a){var b=this.parent().find('div[data-role="toolbar"] [data-role="title"]');return void 0!==a?(b.text(a),this):b.text()}},configure:function(a){$.extend(!0,a,gj.grid.plugins.toolbar.public),a.on("initialized",function(){gj.grid.plugins.toolbar.private.init(a)}),a.on("destroying",function(){a.prev('[data-role="toolbar"]').remove()})}},gj.grid.plugins.resizableColumns={config:{base:{resizableColumns:!1}},private:{init:function(a,b){var c,d,e,f,g,h;if(c=a.find('thead tr[data-role="caption"] th'),c.length){for(e=0;e<c.length-1;e++)d=$(c[e]),f=$('<div class="gj-grid-column-resizer-wrapper" />'),h=parseInt(d.css("padding-right"),10)+3,g=$('<span class="gj-grid-column-resizer" />').css("margin-right","-"+h+"px"),g.draggable({start:function(){a.addClass("gj-unselectable"),a.addClass("gj-grid-resize-cursor")},stop:function(){a.removeClass("gj-unselectable"),a.removeClass("gj-grid-resize-cursor"),this.style.removeProperty("top"),this.style.removeProperty("left"),this.style.removeProperty("position")},drag:gj.grid.plugins.resizableColumns.private.createResizeHandle(a,d,b.columns[e])}),d.append(f.append(g));for(e=0;e<c.length;e++)d=$(c[e]),d.attr("width")||d.attr("width",d.outerWidth())}},createResizeHandle:function(a,b,c){var d=a.data();return function(e,f){var g,h,i,j,k,l,m=parseInt(b.attr("width"),10),n=gj.core.position(this),o={top:f.top-n.top,left:f.left-n.left};if(m||(m=b.outerWidth()),o.left&&(k=m+o.left,c.width=k,b.attr("width",k),h=b[0].cellIndex,j=b[0].parentElement.children[h+1],l=parseInt($(j).attr("width"),10)-o.left,j.setAttribute("width",l),d.resizableColumns))for(i=a[0].tBodies[0].children,g=0;g<i.length;g++)i[g].cells[h].setAttribute("width",k),j=i[g].cells[h+1],j.setAttribute("width",l)}}},public:{},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.resizableColumns.public),b.resizableColumns&&gj.draggable&&a.on("initialized",function(){gj.grid.plugins.resizableColumns.private.init(a,b)})}},gj.grid.plugins.rowReorder={config:{base:{rowReorder:!1,rowReorderColumn:void 0,orderNumberField:void 0,style:{targetRowIndicatorTop:"gj-grid-row-reorder-indicator-top",targetRowIndicatorBottom:"gj-grid-row-reorder-indicator-bottom"}}},private:{init:function(a){var b,c,d,e=a.find('tbody tr[data-role="row"]');for(a.data("rowReorderColumn")&&(c=gj.grid.methods.getColumnPosition(a.data("columns"),a.data("rowReorderColumn"))),b=0;b<e.length;b++)d=$(e[b]),void 0!==c?d.find("td:eq("+c+")").on("mousedown",gj.grid.plugins.rowReorder.private.createRowMouseDownHandler(a,d)):d.on("mousedown",gj.grid.plugins.rowReorder.private.createRowMouseDownHandler(a,d))},createRowMouseDownHandler:function(a,b){return function(c){var d,e,f=a.clone(),g=a.data("columns");for(a.addClass("gj-unselectable"),$("body").append(f),f.attr("data-role","draggable-clone").css("cursor","move"),f.children("thead").remove().children("tfoot").remove(),f.find('tbody tr:not([data-position="'+b.data("position")+'"])').remove(),e=f.find("tbody tr td"),d=0;d<e.length;d++)g[d].width&&e[d].setAttribute("width",g[d].width);f.draggable({stop:gj.grid.plugins.rowReorder.private.createDragStopHandler(a,b)}),f.css({position:"absolute",top:b.offset().top,left:b.offset().left,width:b.width(),zIndex:1}),"true"===b.attr("data-droppable")&&b.droppable("destroy"),b.siblings('tr[data-role="row"]').each(function(){var a=$(this);"true"===a.attr("data-droppable")&&a.droppable("destroy"),a.droppable({over:gj.grid.plugins.rowReorder.private.createDroppableOverHandler(b),out:gj.grid.plugins.rowReorder.private.droppableOut})}),f.trigger("mousedown")}},createDragStopHandler:function(a,b){return function(c,d){$('table[data-role="draggable-clone"]').draggable("destroy").remove(),a.removeClass("gj-unselectable"),b.siblings('tr[data-role="row"]').each(function(){var c,e,f,g,h,i=$(this),j=i.data("position"),k=b.data("position"),l=a.data();if(i.droppable("isOver",d)){for(j<k?i.before(b):i.after(b),l.records.splice(j-1,0,l.records.splice(k-1,1)[0]),c=i.parent().find('tr[data-role="row"]'),f=0;f<c.length;f++)$(c[f]).attr("data-position",f+1);if(l.orderNumberField){for(f=0;f<l.records.length;f++)l.records[f][l.orderNumberField]=f+1;for(f=0;f<c.length;f++)e=$(c[f]),h=gj.grid.methods.getId(e,l.primaryKey,e.attr("data-position")),g=gj.grid.methods.getByPosition(a,e.attr("data-position")),a.setCellContent(h,l.orderNumberField,g[l.orderNumberField])}}i.removeClass("gj-grid-top-border"),i.removeClass("gj-grid-bottom-border"),i.droppable("destroy")})}},createDroppableOverHandler:function(a){return function(b){var c=$(this);c.data("position")<a.data("position")?c.addClass("gj-grid-top-border"):c.addClass("gj-grid-bottom-border")}},droppableOut:function(){$(this).removeClass("gj-grid-top-border"),$(this).removeClass("gj-grid-bottom-border")}},public:{},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.rowReorder.public),b.rowReorder&&gj.draggable&&gj.droppable&&a.on("dataBound",function(){gj.grid.plugins.rowReorder.private.init(a)})}},gj.grid.plugins.export={config:{base:{}},public:{getCSV:function(a){var b,c,d="",e="",f=this.data().columns,g=this.getAll(a);if(g.length){for(b=0;b<f.length;b++)gj.grid.plugins.export.public.isColumnApplicable(f[b])&&(d+='"'+(f[b].title||f[b].field).replace(/<[^>]+>/g," ")+'",');for(e+=d.slice(0,d.length-1)+"\r\n",b=0;b<g.length;b++){for(d="",c=0;c<f.length;c++)gj.grid.plugins.export.public.isColumnApplicable(f[c])&&(d+='"'+g[b][f[c].field]+'",');e+=d.slice(0,d.length-1)+"\r\n"}}return e},downloadCSV:function(a,b){var c=document.createElement("a");return document.body.appendChild(c),c.download=a||"griddata.csv",window.navigator.userAgent.indexOf("Edge")>-1?c.href=URL.createObjectURL(new Blob([this.getCSV(b)],{type:"text/csv;charset=utf-8;"})):c.href="data:text/csv;charset=utf-8,"+escape(this.getCSV(b)),c.click(),document.body.removeChild(c),this},isColumnApplicable:function(a){return!0!==a.hidden&&!a.role}},configure:function(a){$.extend(!0,a,gj.grid.plugins.export.public)}},gj.grid.plugins.columnReorder={config:{base:{columnReorder:!1,dragReady:!1,style:{targetRowIndicatorTop:"gj-grid-row-reorder-indicator-top",targetRowIndicatorBottom:"gj-grid-row-reorder-indicator-bottom"}}},private:{init:function(a){var b,c,d=a.find("thead tr th");for(b=0;b<d.length;b++)c=$(d[b]),c.on("mousedown",gj.grid.plugins.columnReorder.private.createMouseDownHandler(a,c)),c.on("mousemove",gj.grid.plugins.columnReorder.private.createMouseMoveHandler(a,c)),c.on("mouseup",gj.grid.plugins.columnReorder.private.createMouseUpHandler(a,c))},createMouseDownHandler:function(a){return function(b){a.timeout=setTimeout(function(){a.data("dragReady",!0)},100)}},createMouseUpHandler:function(a){return function(b){clearTimeout(a.timeout),a.data("dragReady",!1)}},createMouseMoveHandler:function(a,b){return function(c){var d,e;a.data("dragReady")&&(a.data("dragReady",!1),d=a.clone(),e=b.index(),a.addClass("gj-unselectable"),$("body").append(d),d.attr("data-role","draggable-clone").css("cursor","move"),d.find("thead tr th:eq("+e+")").siblings().remove(),d.find('tbody tr[data-role != "row"]').remove(),d.find("tbody tr td:nth-child("+(e+1)+")").siblings().remove(),d.find("tfoot").remove(),d.draggable({stop:gj.grid.plugins.columnReorder.private.createDragStopHandler(a,b)}),d.css({position:"absolute",top:b.offset().top,left:b.offset().left,width:b.width(),zIndex:1}),"true"===b.attr("data-droppable")&&b.droppable("destroy"),b.siblings("th").each(function(){var c=$(this);"true"===c.attr("data-droppable")&&c.droppable("destroy"),c.droppable({over:gj.grid.plugins.columnReorder.private.createDroppableOverHandler(a,b),out:gj.grid.plugins.columnReorder.private.droppableOut})}),d.trigger("mousedown"))}},createDragStopHandler:function(a,b){return function(c,d){$('table[data-role="draggable-clone"]').draggable("destroy").remove(),a.removeClass("gj-unselectable"),b.siblings("th").each(function(){var c=$(this),e=a.data(),f=gj.grid.methods.getColumnPosition(e.columns,c.data("field")),g=gj.grid.methods.getColumnPosition(e.columns,b.data("field"));c.removeClass("gj-grid-left-border").removeClass("gj-grid-right-border"),c.closest("table").find('tbody tr[data-role="row"] td:nth-child('+(c.index()+1)+")").removeClass("gj-grid-left-border").removeClass("gj-grid-right-border"),c.droppable("isOver",d)&&(f<g?c.before(b):c.after(b),gj.grid.plugins.columnReorder.private.moveRowCells(a,g,f),e.columns.splice(f,0,e.columns.splice(g,1)[0])),c.droppable("destroy")})}},moveRowCells:function(a,b,c){var d,e,f=a.find('tbody tr[data-role="row"]');for(d=0;d<f.length;d++)e=$(f[d]),c<b?e.find("td:eq("+c+")").before(e.find("td:eq("+b+")")):e.find("td:eq("+c+")").after(e.find("td:eq("+b+")"))},createDroppableOverHandler:function(a,b){return function(c){var d=$(this),e=a.data();gj.grid.methods.getColumnPosition(e.columns,d.data("field"))<gj.grid.methods.getColumnPosition(e.columns,b.data("field"))?(d.addClass("gj-grid-left-border"),a.find('tbody tr[data-role="row"] td:nth-child('+(d.index()+1)+")").addClass("gj-grid-left-border")):(d.addClass("gj-grid-right-border"),a.find('tbody tr[data-role="row"] td:nth-child('+(d.index()+1)+")").addClass("gj-grid-right-border"))}},droppableOut:function(){var a=$(this);a.removeClass("gj-grid-left-border").removeClass("gj-grid-right-border"),a.closest("table").find('tbody tr[data-role="row"] td:nth-child('+(a.index()+1)+")").removeClass("gj-grid-left-border").removeClass("gj-grid-right-border")}},public:{},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.columnReorder.public),b.columnReorder&&a.on("initialized",function(){gj.grid.plugins.columnReorder.private.init(a)})}},gj.grid.plugins.headerFilter={config:{base:{defaultColumnSettings:{filterable:!0},headerFilter:{type:"onenterkeypress"}}},private:{init:function(a){var b,c,d,e=a.data(),f=$('<tr data-role="filter"/>');for(b=0;b<e.columns.length;b++)c=$("<th/>"),e.columns[b].filterable&&(d=$('<input data-field="'+e.columns[b].field+'" class="gj-width-full" />'),"onchange"===e.headerFilter.type?d.on("input propertychange",function(b){gj.grid.plugins.headerFilter.private.reload(a,$(this))}):(d.on("keypress",function(b){13==b.which&&gj.grid.plugins.headerFilter.private.reload(a,$(this))}),d.on("blur",function(b){gj.grid.plugins.headerFilter.private.reload(a,$(this))})),c.append(d)),e.columns[b].hidden&&c.hide(),f.append(c);a.children("thead").append(f)},reload:function(a,b){var c={};c[b.data("field")]=b.val(),a.reload(c)}},public:{},events:{},configure:function(a,b,c){$.extend(!0,a,gj.grid.plugins.headerFilter.public);a.data();c.headerFilter&&a.on("initialized",function(){gj.grid.plugins.headerFilter.private.init(a)})}},gj.grid.plugins.grouping={config:{base:{paramNames:{groupBy:"groupBy",groupByDirection:"groupByDirection"},grouping:{groupBy:void 0,direction:"asc"},icons:{expandGroup:'<i class="gj-icon plus" />',collapseGroup:'<i class="gj-icon minus" />'}},fontawesome:{icons:{expandGroup:'<i class="fa fa-plus" aria-hidden="true"></i>',collapseGroup:'<i class="fa fa-minus" aria-hidden="true"></i>'}},glyphicons:{icons:{expandGroup:'<span class="glyphicon glyphicon-plus" />',collapseGroup:'<span class="glyphicon glyphicon-minus" />'}}},private:{init:function(a){var b,c=a.data();b=void 0,a.on("rowDataBound",function(d,e,f,g){if(b!==g[c.grouping.groupBy]||1===e[0].rowIndex){var h=gj.grid.methods.countVisibleColumns(a)-1,i=$('<tr role="group" />'),j=$('<td class="gj-text-align-center gj-unselectable gj-cursor-pointer" />');j.append('<div data-role="display">'+c.icons.collapseGroup+"</div>"),j.on("click",gj.grid.plugins.grouping.private.createExpandCollapseHandler(c)),i.append(j),i.append('<td colspan="'+h+'"><div data-role="display">'+c.grouping.groupBy+": "+g[c.grouping.groupBy]+"</div></td>"),i.insertBefore(e),b=g[c.grouping.groupBy]}e.show()}),c.params[c.paramNames.groupBy]=c.grouping.groupBy,c.params[c.paramNames.groupByDirection]=c.grouping.direction},grouping:function(a,b){var c=a.data();b.sort(gj.grid.methods.createDefaultSorter(c.grouping.direction,c.grouping.groupBy))},createExpandCollapseHandler:function(a){return function(b){var c=$(this),d=gj.grid.plugins.grouping.private;"row"===c.closest("tr").next(":visible").data("role")?d.collapseGroup(a,c):d.expandGroup(a,c)}},collapseGroup:function(a,b){var c=b.children('div[data-role="display"]');b.closest("tr").nextUntil('[role="group"]').hide(),c.empty().append(a.icons.expandGroup)},expandGroup:function(a,b){var c=b.children('div[data-role="display"]');b.closest("tr").nextUntil('[role="group"]').show(),c.empty().append(a.icons.collapseGroup)}},public:{},configure:function(a){var b,c=a.data();$.extend(!0,a,gj.grid.plugins.grouping.public),c.grouping&&c.grouping.groupBy&&(b={title:"",width:c.defaultIconColumnWidth,align:"center",stopPropagation:!0,cssClass:"gj-cursor-pointer gj-unselectable"},c.columns=[b].concat(c.columns),a.on("initialized",function(){gj.grid.plugins.grouping.private.init(a)}),a.on("dataFiltered",function(b,c){gj.grid.plugins.grouping.private.grouping(a,c)}))}},gj.grid.messages["en-us"]={First:"First",Previous:"Previous",Next:"Next",Last:"Last",Page:"Page",FirstPageTooltip:"First Page",PreviousPageTooltip:"Previous Page",NextPageTooltip:"Next Page",LastPageTooltip:"Last Page",Refresh:"Refresh",Of:"of",DisplayingRecords:"Displaying records",RowsPerPage:"Rows per page:",Edit:"Edit",Delete:"Delete",Update:"Update",Cancel:"Cancel",NoRecordsFound:"No records found.",Loading:"Loading..."},gj.tree={plugins:{}},gj.tree.config={base:{params:{},autoLoad:!0,selectionType:"single",cascadeSelection:!1,dataSource:void 0,primaryKey:void 0,textField:"text",childrenField:"children",hasChildrenField:"hasChildren",imageCssClassField:"imageCssClass",imageUrlField:"imageUrl",imageHtmlField:"imageHtml",disabledField:"disabled",width:void 0,border:!1,uiLibrary:"materialdesign",iconsLibrary:"materialicons",autoGenId:1,autoGenFieldName:"autoId_b5497cc5-7ef3-49f5-a7dc-4a932e1aee4a",indentation:24,style:{wrapper:"gj-unselectable",list:"gj-list gj-list-md",item:void 0,active:"gj-list-md-active",leafIcon:void 0,border:"gj-tree-md-border"},icons:{expand:'<i class="gj-icon chevron-right" />',collapse:'<i class="gj-icon chevron-down" />'}},bootstrap:{style:{wrapper:"gj-unselectable gj-tree-bootstrap-3",list:"gj-list gj-list-bootstrap list-group",item:"list-group-item",active:"active",border:"gj-tree-bootstrap-border"},iconsLibrary:"glyphicons"},bootstrap4:{style:{wrapper:"gj-unselectable gj-tree-bootstrap-4",list:"gj-list gj-list-bootstrap",item:"list-group-item",active:"active",border:"gj-tree-bootstrap-border"},icons:{expand:'<i class="gj-icon plus" />',collapse:'<i class="gj-icon minus" />'}},materialicons:{style:{expander:"gj-tree-material-icons-expander"}},fontawesome:{style:{expander:"gj-tree-font-awesome-expander"},icons:{expand:'<i class="fa fa-plus" aria-hidden="true"></i>',collapse:'<i class="fa fa-minus" aria-hidden="true"></i>'}},glyphicons:{style:{expander:"gj-tree-glyphicons-expander"},icons:{expand:'<span class="glyphicon glyphicon-plus" />',collapse:'<span class="glyphicon glyphicon-minus" />'}}},gj.tree.events={initialized:function(a){a.triggerHandler("initialized")},dataBinding:function(a){a.triggerHandler("dataBinding")},dataBound:function(a){a.triggerHandler("dataBound")},select:function(a,b,c){return a.triggerHandler("select",[b,c])},unselect:function(a,b,c){return a.triggerHandler("unselect",[b,c])},expand:function(a,b,c){return a.triggerHandler("expand",[b,c])},collapse:function(a,b,c){return a.triggerHandler("collapse",[b,c])},enable:function(a,b){return a.triggerHandler("enable",[b])},disable:function(a,b){return a.triggerHandler("disable",[b])},destroying:function(a){return a.triggerHandler("destroying")},nodeDataBound:function(a,b,c,d){return a.triggerHandler("nodeDataBound",[b,c,d])}},gj.tree.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"tree"),gj.tree.methods.initialize.call(this),this.data("autoLoad")&&this.reload(),this},initialize:function(){var a=this.data(),b=$('<ul class="'+a.style.list+'"/>');this.empty().addClass(a.style.wrapper).append(b),a.width&&this.width(a.width),a.border&&this.addClass(a.style.border),gj.tree.events.initialized(this)},useHtmlDataSource:function(a,b){b.dataSource=[]},render:function(a,b){var c;return b&&("string"==typeof b&&JSON&&(b=JSON.parse(b)),c=a.data(),c.records=b,c.primaryKey||gj.tree.methods.genAutoId(c,c.records),gj.tree.methods.loadData(a)),a},filter:function(a){return a.data().dataSource},genAutoId:function(a,b){var c;for(c=0;c<b.length;c++)b[c][a.autoGenFieldName]=a.autoGenId++,b[c][a.childrenField]&&b[c][a.childrenField].length&&gj.tree.methods.genAutoId(a,b[c][a.childrenField])},loadData:function(a){var b,c=a.data("records"),d=a.children("ul");for(gj.tree.events.dataBinding(a),d.off().empty(),b=0;b<c.length;b++)gj.tree.methods.appendNode(a,d,c[b],1);gj.tree.events.dataBound(a)},appendNode:function(a,b,c,d,e){var f,g,h,i,j,k=a.data(),l=k.primaryKey?c[k.primaryKey]:c[k.autoGenFieldName];if(g=$('<li data-id="'+l+'" data-role="node" />').addClass(k.style.item),$wrapper=$('<div data-role="wrapper" />'),$expander=$('<span data-role="expander" data-mode="close"></span>').addClass(k.style.expander),$display=$('<span data-role="display">'+c[k.textField]+"</span>"),hasChildren=void 0!==c[k.hasChildrenField]&&"true"===c[k.hasChildrenField].toString().toLowerCase(),disabled=void 0!==c[k.disabledField]&&"true"===c[k.disabledField].toString().toLowerCase(),k.indentation&&$wrapper.append('<span data-role="spacer" style="width: '+k.indentation*(d-1)+'px;"></span>'),disabled?gj.tree.methods.disableNode(a,g):($expander.on("click",gj.tree.methods.expanderClickHandler(a)),$display.on("click",gj.tree.methods.displayClickHandler(a))),$wrapper.append($expander),$wrapper.append($display),g.append($wrapper),e?b.find("li:eq("+(e-1)+")").before(g):b.append(g),k.imageCssClassField&&c[k.imageCssClassField]?(i=$('<span data-role="image"><span class="'+c[k.imageCssClassField]+'"></span></span>'),i.insertBefore($display)):k.imageUrlField&&c[k.imageUrlField]?(i=$('<span data-role="image"></span>'),i.insertBefore($display),j=$('<img src="'+c[k.imageUrlField]+'"></img>'),j.attr("width",i.width()).attr("height",i.height()),i.append(j)):k.imageHtmlField&&c[k.imageHtmlField]&&(i=$('<span data-role="image">'+c[k.imageHtmlField]+"</span>"),i.insertBefore($display)),c[k.childrenField]&&c[k.childrenField].length||hasChildren){if($expander.empty().append(k.icons.expand),h=$("<ul />").addClass(k.style.list).addClass("gj-hidden"),g.append(h),c[k.childrenField]&&c[k.childrenField].length)for(f=0;f<c[k.childrenField].length;f++)gj.tree.methods.appendNode(a,h,c[k.childrenField][f],d+1)}else k.style.leafIcon?$expander.addClass(k.style.leafIcon):$expander.html("&nbsp;");gj.tree.events.nodeDataBound(a,g,c.id,c)},expanderClickHandler:function(a){return function(b){var c=$(this),d=c.closest("li");"close"===c.attr("data-mode")?a.expand(d):a.collapse(d)}},expand:function(a,b,c){var d,e,f=b.find('>[data-role="wrapper"]>[data-role="expander"]'),g=a.data(),h=b.attr("data-id"),i=b.children("ul");if(!1!==gj.tree.events.expand(a,b,h)&&i&&i.length&&(i.show(),f.attr("data-mode","open"),f.empty().append(g.icons.collapse),c))for(d=b.find("ul>li"),e=0;e<d.length;e++)gj.tree.methods.expand(a,$(d[e]),c);return a},collapse:function(a,b,c){var d,e,f=b.find('>[data-role="wrapper"]>[data-role="expander"]'),g=a.data(),h=b.attr("data-id"),i=b.children("ul");if(!1!==gj.tree.events.collapse(a,b,h)&&i&&i.length&&(i.hide(),f.attr("data-mode","close"),f.empty().append(g.icons.expand),c))for(d=b.find("ul>li"),e=0;e<d.length;e++)gj.tree.methods.collapse(a,$(d[e]),c);return a},expandAll:function(a){var b,c=a.find("ul>li");for(b=0;b<c.length;b++)gj.tree.methods.expand(a,$(c[b]),!0);return a},collapseAll:function(a){var b,c=a.find("ul>li");for(b=0;b<c.length;b++)gj.tree.methods.collapse(a,$(c[b]),!0);return a},displayClickHandler:function(a){return function(b){var c=$(this),d=c.closest("li"),e=a.data().cascadeSelection;"true"===d.attr("data-selected")?gj.tree.methods.unselect(a,d,e):("single"===a.data("selectionType")&&gj.tree.methods.unselectAll(a),gj.tree.methods.select(a,d,e))}},selectAll:function(a){var b,c=a.find("ul>li");for(b=0;b<c.length;b++)gj.tree.methods.select(a,$(c[b]),!0);return a},select:function(a,b,c){var d,e,f=a.data();if("true"!==b.attr("data-selected")&&!1!==gj.tree.events.select(a,b,b.attr("data-id"))&&(b.addClass(f.style.active).attr("data-selected","true"),c))for(e=b.find("ul>li"),d=0;d<e.length;d++)gj.tree.methods.select(a,$(e[d]),c)},unselectAll:function(a){var b,c=a.find("ul>li");for(b=0;b<c.length;b++)gj.tree.methods.unselect(a,$(c[b]),!0);return a},unselect:function(a,b,c){var d,e;a.data();if("true"===b.attr("data-selected")&&!1!==gj.tree.events.unselect(a,b,b.attr("data-id"))&&(b.removeClass(a.data().style.active).removeAttr("data-selected"),c))for(e=b.find("ul>li"),d=0;d<e.length;d++)gj.tree.methods.unselect(a,$(e[d]),c)},getSelections:function(a){var b,c,d,e=[],f=a.children("li");if(f&&f.length)for(b=0;b<f.length;b++)c=$(f[b]),"true"===c.attr("data-selected")?e.push(c.attr("data-id")):c.has("ul")&&(d=gj.tree.methods.getSelections(c.children("ul")),d.length&&(e=e.concat(d)));return e},getDataById:function(a,b,c){var d,e=a.data(),f=void 0;for(d=0;d<c.length;d++){if(e.primaryKey&&c[d][e.primaryKey]==b){f=c[d];break}if(c[d][e.autoGenFieldName]==b){f=c[d];break}if(c[d][e.childrenField]&&c[d][e.childrenField].length&&(f=gj.tree.methods.getDataById(a,b,c[d][e.childrenField])))break}return f},getDataByText:function(a,b,c){var d,e=void 0,f=a.data();for(d=0;d<c.length;d++){if(b===c[d][f.textField]){e=c[d];break}if(c[d][f.childrenField]&&c[d][f.childrenField].length&&(e=gj.tree.methods.getDataByText(a,b,c[d][f.childrenField])))break}return e},getNodeById:function(a,b){var c,d,e=void 0,f=a.children("li");if(f&&f.length)for(c=0;c<f.length;c++){if(d=$(f[c]),b==d.attr("data-id")){e=d;break}if(d.has("ul")&&(e=gj.tree.methods.getNodeById(d.children("ul"),b)))break}return e},getNodeByText:function(a,b){var c,d,e=void 0,f=a.children("li");if(f&&f.length)for(c=0;c<f.length;c++){if(d=$(f[c]),b===d.find('>[data-role="wrapper"]>[data-role="display"]').text()){e=d;break}if(d.has("ul")&&(e=gj.tree.methods.getNodeByText(d.children("ul"),b)))break}return e},addNode:function(a,b,c,d){var e,f,g=a.data();return c&&c.length?("li"===c[0].tagName.toLowerCase()&&(0===c.children("ul").length&&(c.find('[data-role="expander"]').empty().append(g.icons.collapse),c.append($("<ul />").addClass(g.style.list))),c=c.children("ul")),f=a.getDataById(c.parent().data("id")),f[g.childrenField]||(f[g.childrenField]=[]),f[g.childrenField].push(b)):(c=a.children("ul"),a.data("records").push(b)),e=c.parentsUntil('[data-type="tree"]',"ul").length+1,g.primaryKey||gj.tree.methods.genAutoId(g,[b]),gj.tree.methods.appendNode(a,c,b,e,d),a},remove:function(a,b){return gj.tree.methods.removeDataById(a,b.attr("data-id"),a.data("records")),b.remove(),a},removeDataById:function(a,b,c){var d,e=a.data();for(d=0;d<c.length;d++){if(e.primaryKey&&c[d][e.primaryKey]==b){c.splice(d,1);break}if(c[d][e.autoGenFieldName]==b){c.splice(d,1);break}c[d][e.childrenField]&&c[d][e.childrenField].length&&gj.tree.methods.removeDataById(a,b,c[d][e.childrenField])}},update:function(a,b,c){var d=a.data(),e=a.getNodeById(b);a.getDataById(b);return c,e.find('>[data-role="wrapper"]>[data-role="display"]').html(c[d.textField]),gj.tree.events.nodeDataBound(a,e,b,c),a},getChildren:function(a,b,c){var d,e,f=[],c=void 0===c||c;for(e=c?b.find("ul li"):b.find(">ul>li"),d=0;d<e.length;d++)f.push($(e[d]).data("id"));return f},enableAll:function(a){var b,c=a.find("ul>li");for(b=0;b<c.length;b++)gj.tree.methods.enableNode(a,$(c[b]),!0);return a},enableNode:function(a,b,c){var d,e,f=b.find('>[data-role="wrapper"]>[data-role="expander"]'),g=b.find('>[data-role="wrapper"]>[data-role="display"]'),c=void 0===c||c;if(b.removeClass("disabled"),f.on("click",gj.tree.methods.expanderClickHandler(a)),g.on("click",gj.tree.methods.displayClickHandler(a)),gj.tree.events.enable(a,b),c)for(e=b.find("ul>li"),d=0;d<e.length;d++)gj.tree.methods.enableNode(a,$(e[d]),c)},disableAll:function(a){var b,c=a.find("ul>li");for(b=0;b<c.length;b++)gj.tree.methods.disableNode(a,$(c[b]),!0);return a},disableNode:function(a,b,c){var d,e,f=b.find('>[data-role="wrapper"]>[data-role="expander"]'),g=b.find('>[data-role="wrapper"]>[data-role="display"]'),c=void 0===c||c;if(b.addClass("disabled"),f.off("click"),g.off("click"),gj.tree.events.disable(a,b),c)for(e=b.find("ul>li"),d=0;d<e.length;d++)gj.tree.methods.disableNode(a,$(e[d]),c)},destroy:function(a){return a.data()&&(gj.tree.events.destroying(a),a.xhr&&a.xhr.abort(),a.off(),a.removeData(),a.removeAttr("data-type"),a.removeClass().empty()),a},pathFinder:function(a,b,c,d){var e,f=!1;for(e=0;e<b.length;e++){if(b[e].id==c){f=!0;break}if(gj.tree.methods.pathFinder(a,b[e][a.childrenField],c,d)){d.push(b[e].data[a.textField]),f=!0;break}}return f}},gj.tree.widget=function(a,b){var c=this,d=gj.tree.methods;return c.reload=function(a){return gj.widget.prototype.reload.call(this,a)},c.render=function(a){return d.render(this,a)},c.addNode=function(a,b,c){return d.addNode(this,a,b,c)},c.removeNode=function(a){return d.remove(this,a)},c.updateNode=function(a,b){return d.update(this,a,b)},c.destroy=function(){return d.destroy(this)},c.expand=function(a,b){return d.expand(this,a,b)},c.collapse=function(a,b){return d.collapse(this,a,b)},c.expandAll=function(){return d.expandAll(this)},c.collapseAll=function(){return d.collapseAll(this)},c.getDataById=function(a){return d.getDataById(this,a,this.data("records"))},c.getDataByText=function(a){return d.getDataByText(this,a,this.data("records"))},c.getNodeById=function(a){return d.getNodeById(this.children("ul"),a)},c.getNodeByText=function(a){return d.getNodeByText(this.children("ul"),a)},c.getAll=function(){return this.data("records")},c.select=function(a){return d.select(this,a)},c.unselect=function(a){return d.unselect(this,a)},c.selectAll=function(){return d.selectAll(this)},c.unselectAll=function(){return d.unselectAll(this)},c.getSelections=function(){return d.getSelections(this.children("ul"))},c.getChildren=function(a,b){return d.getChildren(this,a,b)},c.parents=function(a){var b=[],c=this.data();return d.pathFinder(c,c.records,a,b),b.reverse()},c.enable=function(a,b){return d.enableNode(this,a,b)},c.enableAll=function(){return d.enableAll(this)},c.disable=function(a,b){return d.disableNode(this,a,b)},c.disableAll=function(){return d.disableAll(this)},$.extend(a,c),"tree"!==a.attr("data-type")&&d.init.call(a,b),a},gj.tree.widget.prototype=new gj.widget,gj.tree.widget.constructor=gj.tree.widget,function(a){a.fn.tree=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.tree.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.tree.widget(this,a)}}}(jQuery),gj.tree.plugins.checkboxes={config:{base:{checkboxes:void 0,checkedField:"checked",cascadeCheck:!0}},private:{dataBound:function(a){var b;a.data("cascadeCheck")&&(b=a.find('li[data-role="node"]'),$.each(b,function(){var a=$(this),b=a.find('[data-role="checkbox"] input[type="checkbox"]').checkbox("state");"checked"===b&&(gj.tree.plugins.checkboxes.private.updateChildrenState(a,b),gj.tree.plugins.checkboxes.private.updateParentState(a,b))}))},nodeDataBound:function(a,b,c,d){var e,f,g,h,i;0===b.find('> [data-role="wrapper"] > [data-role="checkbox"]').length&&(e=a.data(),f=b.find('> [data-role="wrapper"] > [data-role="expander"]'),g=$('<input type="checkbox"/>'),h=$('<span data-role="checkbox"></span>').append(g),i=void 0!==d[e.disabledField]&&"true"===d[e.disabledField].toString().toLowerCase(),g=g.checkbox({uiLibrary:e.uiLibrary,iconsLibrary:e.iconsLibrary,change:function(c,e){gj.tree.plugins.checkboxes.events.checkboxChange(a,b,d,g.state())}}),i&&g.prop("disabled",!0),d[e.checkedField]&&g.state("checked"),g.on("click",function(a){var b=g.closest("li"),c=g.state();e.cascadeCheck&&(gj.tree.plugins.checkboxes.private.updateChildrenState(b,c),gj.tree.plugins.checkboxes.private.updateParentState(b,c))}),f.after(h))},updateParentState:function(a,b){var c,d,e,f,g,h;c=a.parent("ul").parent("li"),1===c.length&&(d=a.parent("ul").parent("li").find('> [data-role="wrapper"] > [data-role="checkbox"] input[type="checkbox"]'),e=a.siblings().find('> [data-role="wrapper"] > span[data-role="checkbox"] input[type="checkbox"]'),f="checked"===b,g="unchecked"===b,h="indeterminate",$.each(e,function(){var a=$(this).checkbox("state");f&&"checked"!==a&&(f=!1),g&&"unchecked"!==a&&(g=!1)}),f&&!g&&(h="checked"),!f&&g&&(h="unchecked"),d.checkbox("state",h),gj.tree.plugins.checkboxes.private.updateParentState(c,d.checkbox("state")))},updateChildrenState:function(a,b){var c=a.find('ul li [data-role="wrapper"] [data-role="checkbox"] input[type="checkbox"]');c.length>0&&$.each(c,function(){$(this).checkbox("state",b)})},update:function(a,b,c){var d=b.find('[data-role="checkbox"] input[type="checkbox"]').first();$(d).checkbox("state",c),a.data().cascadeCheck&&(gj.tree.plugins.checkboxes.private.updateChildrenState(b,c),gj.tree.plugins.checkboxes.private.updateParentState(b,c))}},public:{getCheckedNodes:function(){var a=[],b=this.find('li [data-role="checkbox"] input[type="checkbox"]');return $.each(b,function(){var b=$(this);"checked"===b.checkbox("state")&&a.push(b.closest("li").data("id"))}),a},checkAll:function(){var a=this.find('li [data-role="checkbox"] input[type="checkbox"]');return $.each(a,function(){$(this).checkbox("state","checked")}),this},uncheckAll:function(){var a=this.find('li [data-role="checkbox"] input[type="checkbox"]');return $.each(a,function(){$(this).checkbox("state","unchecked")}),this},check:function(a){return gj.tree.plugins.checkboxes.private.update(this,a,"checked"),this},uncheck:function(a){return gj.tree.plugins.checkboxes.private.update(this,a,"unchecked"),this}},events:{checkboxChange:function(a,b,c,d){return a.triggerHandler("checkboxChange",[b,c,d])}},configure:function(a){a.data("checkboxes")&&gj.checkbox&&($.extend(!0,a,gj.tree.plugins.checkboxes.public),a.on("nodeDataBound",function(b,c,d,e){gj.tree.plugins.checkboxes.private.nodeDataBound(a,c,d,e)}),a.on("dataBound",function(){gj.tree.plugins.checkboxes.private.dataBound(a)}),a.on("enable",function(a,b){b.find('>[data-role="wrapper"]>[data-role="checkbox"] input[type="checkbox"]').prop("disabled",!1)}),a.on("disable",function(a,b){b.find('>[data-role="wrapper"]>[data-role="checkbox"] input[type="checkbox"]').prop("disabled",!0)}))}},gj.tree.plugins.dragAndDrop={config:{base:{dragAndDrop:void 0,style:{dragEl:"gj-tree-drag-el gj-tree-md-drag-el",dropAsChildIcon:"gj-cursor-pointer gj-icon plus",dropAbove:"gj-tree-drop-above",dropBelow:"gj-tree-drop-below"}},bootstrap:{style:{dragEl:"gj-tree-drag-el gj-tree-bootstrap-drag-el",dropAsChildIcon:"glyphicon glyphicon-plus",dropAbove:"drop-above",dropBelow:"drop-below"}},bootstrap4:{style:{dragEl:"gj-tree-drag-el gj-tree-bootstrap-drag-el",dropAsChildIcon:"gj-cursor-pointer gj-icon plus",dropAbove:"drop-above",dropBelow:"drop-below"}}},private:{nodeDataBound:function(a,b){var c=b.children('[data-role="wrapper"]'),d=b.find('>[data-role="wrapper"]>[data-role="display"]');c.length&&d.length&&(d.on("mousedown",gj.tree.plugins.dragAndDrop.private.createNodeMouseDownHandler(a)),d.on("mousemove",gj.tree.plugins.dragAndDrop.private.createNodeMouseMoveHandler(a,b,d)),d.on("mouseup",gj.tree.plugins.dragAndDrop.private.createNodeMouseUpHandler(a)))},createNodeMouseDownHandler:function(a){return function(b){a.data("dragReady",!0)}},createNodeMouseUpHandler:function(a){return function(b){a.data("dragReady",!1)}},createNodeMouseMoveHandler:function(a,b,c){return function(d){if(a.data("dragReady")){var e,f,g,h,i=a.data();a.data("dragReady",!1),e=c.clone().wrap('<div data-role="wrapper"/>').closest("div").wrap('<li class="'+i.style.item+'" />').closest("li").wrap('<ul class="'+i.style.list+'" />').closest("ul"),$("body").append(e),e.attr("data-role","draggable-clone").addClass("gj-unselectable").addClass(i.style.dragEl),e.find('[data-role="wrapper"]').prepend('<span data-role="indicator" />'),e.draggable({drag:gj.tree.plugins.dragAndDrop.private.createDragHandler(a,b,c),stop:gj.tree.plugins.dragAndDrop.private.createDragStopHandler(a,b,c)}),f=c.parent(),g=c.offset().top,g-=parseInt(f.css("border-top-width"))+parseInt(f.css("margin-top"))+parseInt(f.css("padding-top")),h=c.offset().left,h-=parseInt(f.css("border-left-width"))+parseInt(f.css("margin-left"))+parseInt(f.css("padding-left")),h-=e.find('[data-role="indicator"]').outerWidth(!0),e.css({position:"absolute",top:g,left:h,width:c.outerWidth(!0)}),"true"===c.attr("data-droppable")&&c.droppable("destroy"),gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a,b,c).each(function(){var a=$(this);"true"===a.attr("data-droppable")&&a.droppable("destroy"),a.droppable()}),gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a,b).each(function(){var a=$(this);"true"===a.attr("data-droppable")&&a.droppable("destroy"),a.droppable()}),e.trigger("mousedown")}}},getTargetDisplays:function(a,b,c){return a.find('[data-role="display"]').not(c).not(b.find('[data-role="display"]'))},getTargetWrappers:function(a,b){return a.find('[data-role="wrapper"]').not(b.find('[data-role="wrapper"]'))},createDragHandler:function(a,b,c){var d=gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a,b,c),e=gj.tree.plugins.dragAndDrop.private.getTargetWrappers(a,b),f=a.data();return function(a,b,c){var g=$(this),h=!1;d.each(function(){var a,b=$(this);if(b.droppable("isOver",c))return a=g.find('[data-role="indicator"]'),f.style.dropAsChildIcon?a.addClass(f.style.dropAsChildIcon):a.text("+"),h=!0,!1;g.find('[data-role="indicator"]').removeClass(f.style.dropAsChildIcon).empty()}),e.each(function(){var a,b=$(this);!h&&b.droppable("isOver",c)?(a=b.position().top+b.outerHeight()/2,c.y<a?b.addClass(f.style.dropAbove).removeClass(f.style.dropBelow):b.addClass(f.style.dropBelow).removeClass(f.style.dropAbove)):b.removeClass(f.style.dropAbove).removeClass(f.style.dropBelow)})}},createDragStopHandler:function(a,b,c){var d=gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a,b,c),e=gj.tree.plugins.dragAndDrop.private.getTargetWrappers(a,b),f=a.data();return function(c,g){var h,i,j,k,l=!1;$(this).draggable("destroy").remove(),d.each(function(){var c,d=$(this);if(d.droppable("isOver",g))return i=d.closest("li"),j=b.parent("ul").parent("li"),c=i.children("ul"),0===c.length&&(c=$("<ul />").addClass(f.style.list),i.append(c)),!1!==gj.tree.plugins.dragAndDrop.events.nodeDrop(a,b.data("id"),i.data("id"),c.children("li").length+1)&&(c.append(b),h=a.getDataById(b.data("id")),gj.tree.methods.removeDataById(a,b.data("id"),f.records),k=a.getDataById(c.parent().data("id")),void 0===k[f.childrenField]&&(k[f.childrenField]=[]),k[f.childrenField].push(h),gj.tree.plugins.dragAndDrop.private.refresh(a,b,i,j)),l=!0,!1;d.droppable("destroy")}),l||e.each(function(){var c,d,e,k=$(this);if(k.droppable("isOver",g))return i=k.closest("li"),j=b.parent("ul").parent("li"),c=g.y<k.position().top+k.outerHeight()/2,e=b.data("id"),d=i.prevAll('li:not([data-id="'+e+'"])').length+(c?1:2),!1!==gj.tree.plugins.dragAndDrop.events.nodeDrop(a,e,i.parent("ul").parent("li").data("id"),d)&&(h=a.getDataById(b.data("id")),gj.tree.methods.removeDataById(a,b.data("id"),f.records),a.getDataById(i.parent().data("id"))[f.childrenField].splice(i.index()+(c?0:1),0,h),c?b.insertBefore(i):b.insertAfter(i),gj.tree.plugins.dragAndDrop.private.refresh(a,b,i,j)),!1;k.droppable("destroy")})}},refresh:function(a,b,c,d){var e=a.data();gj.tree.plugins.dragAndDrop.private.refreshNode(a,c),gj.tree.plugins.dragAndDrop.private.refreshNode(a,d),gj.tree.plugins.dragAndDrop.private.refreshNode(a,b),b.find('li[data-role="node"]').each(function(){gj.tree.plugins.dragAndDrop.private.refreshNode(a,$(this))}),c.children('[data-role="wrapper"]').removeClass(e.style.dropAbove).removeClass(e.style.dropBelow)},refreshNode:function(a,b){var c=b.children('[data-role="wrapper"]'),d=c.children('[data-role="expander"]'),e=c.children('[data-role="spacer"]'),f=b.children("ul"),g=a.data(),h=b.parentsUntil('[data-type="tree"]',"ul").length;f.length&&f.children().length?f.is(":visible")?d.empty().append(g.icons.collapse):d.empty().append(g.icons.expand):d.empty(),c.removeClass(g.style.dropAbove).removeClass(g.style.dropBelow),e.css("width",g.indentation*(h-1))}},public:{},events:{nodeDrop:function(a,b,c,d){return a.triggerHandler("nodeDrop",[b,c,d])}},configure:function(a){$.extend(!0,a,gj.tree.plugins.dragAndDrop.public),a.data("dragAndDrop")&&gj.draggable&&gj.droppable&&a.on("nodeDataBound",function(b,c){gj.tree.plugins.dragAndDrop.private.nodeDataBound(a,c)})}},gj.tree.plugins.lazyLoading={config:{base:{paramNames:{parentId:"parentId"},lazyLoading:!1}},private:{nodeDataBound:function(a,b,c,d){var e=a.data(),f=b.find('> [data-role="wrapper"] > [data-role="expander"]');d.hasChildren&&f.empty().append(e.icons.expand)},createDoneHandler:function(a,b){return function(c){var d,e,f,g=a.data();if("string"==typeof c&&JSON&&(c=JSON.parse(c)),c&&c.length){for(f=b.children("ul"),0===f.length&&(f=$("<ul />").addClass(g.style.list),b.append(f)),d=0;d<c.length;d++)a.addNode(c[d],f);e=b.find('>[data-role="wrapper"]>[data-role="expander"]'),e.attr("data-mode","open"),e.empty().append(g.icons.collapse),gj.tree.events.dataBound(a)}}},expand:function(a,b,c){var d,e=a.data(),f={},g=b.find(">ul>li");g&&g.length||"string"==typeof e.dataSource&&(f[e.paramNames.parentId]=c,d={url:e.dataSource,data:f},a.xhr&&a.xhr.abort(),a.xhr=$.ajax(d).done(gj.tree.plugins.lazyLoading.private.createDoneHandler(a,b)).fail(a.createErrorHandler()))}},public:{},events:{},configure:function(a,b,c){c.lazyLoading&&(a.on("nodeDataBound",function(b,c,d,e){gj.tree.plugins.lazyLoading.private.nodeDataBound(a,c,d,e)}),a.on("expand",function(b,c,d){gj.tree.plugins.lazyLoading.private.expand(a,c,d)}))}},gj.checkbox={plugins:{}},gj.checkbox.config={base:{uiLibrary:"materialdesign",iconsLibrary:"materialicons",style:{wrapperCssClass:"gj-checkbox-md",spanCssClass:void 0}},bootstrap:{style:{wrapperCssClass:"gj-checkbox-bootstrap"},iconsLibrary:"glyphicons"},bootstrap4:{style:{wrapperCssClass:"gj-checkbox-bootstrap gj-checkbox-bootstrap-4"},iconsLibrary:"materialicons"},materialicons:{style:{iconsCssClass:"gj-checkbox-material-icons",spanCssClass:"gj-icon"}},glyphicons:{style:{iconsCssClass:"gj-checkbox-glyphicons",spanCssClass:""}},fontawesome:{style:{iconsCssClass:"gj-checkbox-fontawesome",spanCssClass:"fa"}}},gj.checkbox.methods={init:function(a){var b=this;return gj.widget.prototype.init.call(this,a,"checkbox"),b.attr("data-checkbox","true"),gj.checkbox.methods.initialize(b),b},initialize:function(a){var b,c,d=a.data();d.style.wrapperCssClass&&(b=$('<label class="'+d.style.wrapperCssClass+" "+d.style.iconsCssClass+'"></label>'),a.attr("id")&&b.attr("for",a.attr("id")),a.wrap(b),c=$("<span />"),d.style.spanCssClass&&c.addClass(d.style.spanCssClass),a.parent().append(c))},state:function(a,b){return b?("checked"===b?(a.prop("indeterminate",!1),a.prop("checked",!0)):"unchecked"===b?(a.prop("indeterminate",!1),a.prop("checked",!1)):"indeterminate"===b&&(a.prop("checked",!0),a.prop("indeterminate",!0)),gj.checkbox.events.change(a,b),a):b=a.prop("indeterminate")?"indeterminate":a.prop("checked")?"checked":"unchecked"},toggle:function(a){return"checked"==a.state()?a.state("unchecked"):a.state("checked"),a},destroy:function(a){return"true"===a.attr("data-checkbox")&&(a.removeData(),a.removeAttr("data-guid"),a.removeAttr("data-checkbox"),a.off(),a.next("span").remove(),a.unwrap()),a}},gj.checkbox.events={change:function(a,b){return a.triggerHandler("change",[b])}},gj.checkbox.widget=function(a,b){var c=this,d=gj.checkbox.methods;return c.toggle=function(){return d.toggle(this)},c.state=function(a){return d.state(this,a)},c.destroy=function(){return d.destroy(this)},$.extend(a,c),"true"!==a.attr("data-checkbox")&&d.init.call(a,b),a},gj.checkbox.widget.prototype=new gj.widget,gj.checkbox.widget.constructor=gj.checkbox.widget,function(a){a.fn.checkbox=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.checkbox.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.checkbox.widget(this,a)}}}(jQuery),gj.editor={plugins:{},messages:{}},gj.editor.config={base:{height:300,width:void 0,uiLibrary:"materialdesign",iconsLibrary:"materialicons",locale:"en-us",buttons:void 0,style:{wrapper:"gj-editor gj-editor-md",buttonsGroup:"gj-button-md-group",button:"gj-button-md",buttonActive:"active"}},bootstrap:{style:{wrapper:"gj-editor gj-editor-bootstrap",buttonsGroup:"btn-group",button:"btn btn-default gj-cursor-pointer",buttonActive:"active"}},bootstrap4:{style:{wrapper:"gj-editor gj-editor-bootstrap",buttonsGroup:"btn-group",button:"btn btn-outline-secondary gj-cursor-pointer",buttonActive:"active"}},materialicons:{icons:{bold:'<i class="gj-icon bold" />',italic:'<i class="gj-icon italic" />',strikethrough:'<i class="gj-icon strikethrough" />',underline:'<i class="gj-icon underlined" />',listBulleted:'<i class="gj-icon list-bulleted" />',listNumbered:'<i class="gj-icon list-numbered" />',indentDecrease:'<i class="gj-icon indent-decrease" />',indentIncrease:'<i class="gj-icon indent-increase" />',alignLeft:'<i class="gj-icon align-left" />',alignCenter:'<i class="gj-icon align-center" />',alignRight:'<i class="gj-icon align-right" />',alignJustify:'<i class="gj-icon align-justify" />',undo:'<i class="gj-icon undo" />',redo:'<i class="gj-icon redo" />'}},fontawesome:{icons:{bold:'<i class="fa fa-bold" aria-hidden="true"></i>',italic:'<i class="fa fa-italic" aria-hidden="true"></i>',strikethrough:'<i class="fa fa-strikethrough" aria-hidden="true"></i>',underline:'<i class="fa fa-underline" aria-hidden="true"></i>',listBulleted:'<i class="fa fa-list-ul" aria-hidden="true"></i>',listNumbered:'<i class="fa fa-list-ol" aria-hidden="true"></i>',indentDecrease:'<i class="fa fa-indent" aria-hidden="true"></i>',indentIncrease:'<i class="fa fa-outdent" aria-hidden="true"></i>',alignLeft:'<i class="fa fa-align-left" aria-hidden="true"></i>',alignCenter:'<i class="fa fa-align-center" aria-hidden="true"></i>',alignRight:'<i class="fa fa-align-right" aria-hidden="true"></i>',alignJustify:'<i class="fa fa-align-justify" aria-hidden="true"></i>',undo:'<i class="fa fa-undo" aria-hidden="true"></i>',redo:'<i class="fa fa-repeat" aria-hidden="true"></i>'}}},gj.editor.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"editor"),this.attr("data-editor","true"),gj.editor.methods.initialize(this),this},initialize:function(a){var b,c,d,e,f,g=this,h=a.data();if(a.hide(),"wrapper"!==a[0].parentElement.attributes.role&&(d=document.createElement("div"),d.setAttribute("role","wrapper"),a[0].parentNode.insertBefore(d,a[0]),d.appendChild(a[0])),gj.editor.methods.localization(h),$(d).addClass(h.style.wrapper),h.width&&$(d).width(h.width),e=$(d).children('div[role="body"]'),0===e.length&&(e=$('<div role="body"></div>'),$(d).append(e),a[0].innerText&&(e[0].innerHTML=a[0].innerText)),e.attr("contenteditable",!0),e.on("keydown",function(b){var c=event.keyCode||event.charCode;!1===gj.editor.events.changing(a)&&8!==c&&46!==c&&b.preventDefault()}),e.on("mouseup keyup mouseout cut paste",function(b){g.updateToolbar(a,f),gj.editor.events.changed(a),a.html(e.html())}),f=$(d).children('div[role="toolbar"]'),0===f.length){f=$('<div role="toolbar"></div>'),e.before(f);for(var i in h.buttons){b=$("<div />").addClass(h.style.buttonsGroup);for(var j in h.buttons[i])c=$(h.buttons[i][j]),c.on("click",function(){gj.editor.methods.executeCmd(a,e,f,$(this))}),b.append(c);f.append(b)}}e.height(h.height-gj.core.height(f[0],!0))},localization:function(a){var b=gj.editor.messages[a.locale];void 0===a.buttons&&(a.buttons=[['<button type="button" class="'+a.style.button+'" title="'+b.bold+'" role="bold">'+a.icons.bold+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.italic+'" role="italic">'+a.icons.italic+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.strikethrough+'" role="strikethrough">'+a.icons.strikethrough+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.underline+'" role="underline">'+a.icons.underline+"</button>"],['<button type="button" class="'+a.style.button+'" title="'+b.listBulleted+'" role="insertunorderedlist">'+a.icons.listBulleted+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.listNumbered+'" role="insertorderedlist">'+a.icons.listNumbered+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.indentDecrease+'" role="outdent">'+a.icons.indentDecrease+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.indentIncrease+'" role="indent">'+a.icons.indentIncrease+"</button>"],['<button type="button" class="'+a.style.button+'" title="'+b.alignLeft+'" role="justifyleft">'+a.icons.alignLeft+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.alignCenter+'" role="justifycenter">'+a.icons.alignCenter+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.alignRight+'" role="justifyright">'+a.icons.alignRight+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.alignJustify+'" role="justifyfull">'+a.icons.alignJustify+"</button>"],['<button type="button" class="'+a.style.button+'" title="'+b.undo+'" role="undo">'+a.icons.undo+"</button>",'<button type="button" class="'+a.style.button+'" title="'+b.redo+'" role="redo">'+a.icons.redo+"</button>"]])},updateToolbar:function(a,b){var c=a.data();$buttons=b.find("[role]").each(function(){var a=$(this),b=a.attr("role");b&&document.queryCommandEnabled(b)&&"true"===document.queryCommandValue(b)?a.addClass(c.style.buttonActive):a.removeClass(c.style.buttonActive)})},executeCmd:function(a,b,c,d){b.focus(),document.execCommand(d.attr("role"),!1),gj.editor.methods.updateToolbar(a,c)},content:function(a,b){var c=a.parent().children('div[role="body"]');return void 0===b?c.html():c.html(b)},destroy:function(a){var b;return"true"===a.attr("data-editor")&&(b=a.parent(),b.children('div[role="body"]').remove(),b.children('div[role="toolbar"]').remove(),a.unwrap(),a.removeData(),a.removeAttr("data-guid"),a.removeAttr("data-editor"),a.off(),a.show()),a}},gj.editor.events={changing:function(a){return a.triggerHandler("changing")},changed:function(a){return a.triggerHandler("changed")}},gj.editor.widget=function(a,b){var c=this,d=gj.editor.methods;return c.content=function(a){return d.content(this,a)},c.destroy=function(){return d.destroy(this)},$.extend(a,c),"true"!==a.attr("data-editor")&&d.init.call(a,b),a},gj.editor.widget.prototype=new gj.widget,gj.editor.widget.constructor=gj.editor.widget,function(a){a.fn.editor=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.editor.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.editor.widget(this,a)}}}(jQuery),gj.editor.messages["en-us"]={bold:"Bold",italic:"Italic",strikethrough:"Strikethrough",underline:"Underline",listBulleted:"List Bulleted",listNumbered:"List Numbered",indentDecrease:"Indent Decrease",indentIncrease:"Indent Increase",alignLeft:"Align Left",alignCenter:"Align Center",alignRight:"Align Right",alignJustify:"Align Justify",undo:"Undo",redo:"Redo"},gj.dropdown={plugins:{}},gj.dropdown.config={base:{dataSource:void 0,textField:"text",valueField:"value",selectedField:"selected",width:void 0,maxHeight:"auto",placeholder:void 0,fontSize:void 0,uiLibrary:"materialdesign",iconsLibrary:"materialicons",icons:{dropdown:'<i class="gj-icon arrow-dropdown" />',dropup:'<i class="gj-icon arrow-dropup" />'},style:{wrapper:"gj-dropdown gj-dropdown-md gj-unselectable",list:"gj-list gj-list-md gj-dropdown-list-md",active:"gj-list-md-active"}},bootstrap:{style:{wrapper:"gj-dropdown gj-dropdown-bootstrap gj-dropdown-bootstrap-3 gj-unselectable",presenter:"btn btn-default",list:"gj-list gj-list-bootstrap gj-dropdown-list-bootstrap list-group",item:"list-group-item",active:"active"},iconsLibrary:"glyphicons"},bootstrap4:{style:{wrapper:"gj-dropdown gj-dropdown-bootstrap gj-dropdown-bootstrap-4 gj-unselectable",presenter:"btn btn-outline-secondary",list:"gj-list gj-list-bootstrap gj-dropdown-list-bootstrap list-group",item:"list-group-item",active:"active"}},materialicons:{style:{expander:"gj-dropdown-expander-mi"}},fontawesome:{icons:{dropdown:'<i class="fa fa-caret-down" aria-hidden="true"></i>',dropup:'<i class="fa fa-caret-up" aria-hidden="true"></i>'},style:{expander:"gj-dropdown-expander-fa"}},glyphicons:{icons:{dropdown:'<span class="caret"></span>',dropup:'<span class="dropup"><span class="caret" ></span></span>'},style:{expander:"gj-dropdown-expander-glyphicons"}}},gj.dropdown.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"dropdown"),this.attr("data-dropdown","true"),gj.dropdown.methods.initialize(this),this},getHTMLConfig:function(){var a=gj.widget.prototype.getHTMLConfig.call(this),b=this[0].attributes;return b.placeholder&&(a.placeholder=b.placeholder.value),a},initialize:function(a){var b=a.data(),c=a.parent('div[role="wrapper"]'),d=$('<span role="display"></span>'),e=$('<span role="expander">'+b.icons.dropdown+"</span>").addClass(b.style.expander),f=$('<button role="presenter" type="button"></button>').addClass(b.style.presenter),g=$('<ul role="list" class="'+b.style.list+'"></ul>').attr("guid",a.attr("data-guid"));0===c.length?(c=$('<div role="wrapper" />').addClass(b.style.wrapper),a.wrap(c)):c.addClass(b.style.wrapper),b.fontSize&&f.css("font-size",b.fontSize),f.on("click",function(b){g.is(":visible")?gj.dropdown.methods.close(a,g):gj.dropdown.methods.open(a,g)}),f.on("blur",function(b){setTimeout(function(){gj.dropdown.methods.close(a,g)},500)}),f.append(d).append(e),a.hide(),a.after(f),$("body").append(g),g.hide(),a.reload()},setListPosition:function(a,b,c){var d,e,f,g,h=a.getBoundingClientRect(),i=window.scrollY||window.pageYOffset||0;window.scrollX||window.pageXOffset;b.style.overflow="",b.style.overflowX="",b.style.height="",gj.core.setChildPosition(a,b),d=gj.core.height(b,!0),g=b.getBoundingClientRect(),e=gj.core.height(a,!0),"auto"===c.maxHeight?h.top<g.top?h.top+d+e>window.innerHeight&&(f=window.innerHeight-h.top-e-3):h.top-d-3>0?b.style.top=Math.round(h.top+i-d-3)+"px":(b.style.top=i+"px",f=h.top-3):!isNaN(c.maxHeight)&&c.maxHeight<d&&(f=c.maxHeight),f&&(b.style.overflow="scroll",b.style.overflowX="hidden",b.style.height=f+"px")},useHtmlDataSource:function(a,b){var c,d,e=[],f=a.find("option");for(c=0;c<f.length;c++)d={},d[b.valueField]=f[c].value,d[b.textField]=f[c].innerHTML,d[b.selectedField]=a[0].value===f[c].value,e.push(d);b.dataSource=e},filter:function(a){var b,c,d=a.data();if(d.dataSource){if("string"==typeof d.dataSource[0])for(b=0;b<d.dataSource.length;b++)c={},c[d.valueField]=d.dataSource[b],c[d.textField]=d.dataSource[b],d.dataSource[b]=c}else d.dataSource=[];return d.dataSource},render:function(a,b){var c=[],d=a.data(),e=a.parent(),f=$("body").children('[role="list"][guid="'+a.attr("data-guid")+'"]'),g=e.children('[role="presenter"]'),h=(g.children('[role="expander"]'),g.children('[role="display"]'));if(a.data("records",b),a.empty(),f.empty(),b&&b.length)if($.each(b,function(){var b,e=this[d.valueField],g=this[d.textField],h=this[d.selectedField]&&"true"===this[d.selectedField].toString().toLowerCase();b=$('<li value="'+e+'"><div data-role="wrapper"><span data-role="display">'+g+"</span></div></li>"),b.addClass(d.style.item),b.on("click",function(b){gj.dropdown.methods.select(a,e)}),f.append(b),a.append('<option value="'+e+'">'+g+"</option>"),h&&c.push(e)}),0===c.length)a.prepend('<option value=""></option>'),a[0].selectedIndex=0,d.placeholder&&(h[0].innerHTML='<span class="placeholder">'+d.placeholder+"</span>");else for(i=0;i<c.length;i++)gj.dropdown.methods.select(a,c[i]);return d.width&&(e.css("width",d.width),g.css("width",d.width)),d.fontSize&&f.children("li").css("font-size",d.fontSize),gj.dropdown.events.dataBound(a),a},open:function(a,b){var c=a.data(),d=a.parent().find('[role="expander"]'),e=a.parent().find('[role="presenter"]'),f=gj.core.getScrollParent(a[0]);b.css("width",gj.core.width(e[0])),b.show(),gj.dropdown.methods.setListPosition(e[0],b[0],c),d.html(c.icons.dropup),f&&(c.parentScrollHandler=function(){gj.dropdown.methods.setListPosition(e[0],b[0],c)},gj.dropdown.methods.addParentsScrollListener(f,c.parentScrollHandler))},close:function(a,b){var c=a.data(),d=a.parent().find('[role="expander"]'),e=gj.core.getScrollParent(a[0]);d.html(c.icons.dropdown),e&&c.parentScrollHandler&&gj.dropdown.methods.removeParentsScrollListener(e,c.parentScrollHandler),b.hide()},addParentsScrollListener:function(a,b){var c=gj.core.getScrollParent(a.parentNode);a.addEventListener("scroll",b),c&&gj.dropdown.methods.addParentsScrollListener(c,b)},removeParentsScrollListener:function(a,b){var c=gj.core.getScrollParent(a.parentNode);a.removeEventListener("scroll",b),c&&gj.dropdown.methods.removeParentsScrollListener(c,b)},select:function(a,b){var c=a.data(),d=$("body").children('[role="list"][guid="'+a.attr("data-guid")+'"]'),e=d.children('li[value="'+b+'"]'),f=a.next('[role="presenter"]').find('[role="display"]'),g=gj.dropdown.methods.getRecordByValue(a,b);return d.children("li").removeClass(c.style.active),g?(e.addClass(c.style.active),a[0].value=b,f[0].innerHTML=g[c.textField]):(c.placeholder&&(f[0].innerHTML='<span class="placeholder">'+c.placeholder+"</span>"),a[0].value=""),gj.dropdown.events.change(a),gj.dropdown.methods.close(a,d),a},getRecordByValue:function(a,b){var c,d=a.data(),e=void 0;for(c=0;c<d.records.length;c++)if(d.records[c][d.valueField]===b){e=d.records[c];break}return e},value:function(a,b){return void 0===b?a.val():(gj.dropdown.methods.select(a,b),a)},destroy:function(a){var b=a.data(),c=a.parent('div[role="wrapper"]');return b&&(a.xhr&&a.xhr.abort(),a.off(),a.removeData(),a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-dropdown"),a.removeClass(),c.length>0&&(c.children('[role="presenter"]').remove(),c.children('[role="list"]').remove(),a.unwrap()),a.show()),a}},gj.dropdown.events={change:function(a){return a.triggerHandler("change")},dataBound:function(a){return a.triggerHandler("dataBound")}},gj.dropdown.widget=function(a,b){var c=this,d=gj.dropdown.methods;return c.value=function(a){return d.value(this,a)},c.enable=function(){return d.enable(this)},c.disable=function(){return d.disable(this)},c.destroy=function(){return d.destroy(this)},$.extend(a,c),"true"!==a.attr("data-dropdown")&&d.init.call(a,b),a},gj.dropdown.widget.prototype=new gj.widget,gj.dropdown.widget.constructor=gj.dropdown.widget,gj.dropdown.widget.prototype.getHTMLConfig=gj.dropdown.methods.getHTMLConfig,function(a){a.fn.dropdown=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.dropdown.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.dropdown.widget(this,a)}}}(jQuery),gj.datepicker={plugins:{}},gj.datepicker.config={base:{showOtherMonths:!1,selectOtherMonths:!0,width:void 0,minDate:void 0,maxDate:void 0,format:"mm/dd/yyyy",uiLibrary:"materialdesign",iconsLibrary:"materialicons",value:void 0,weekStartDay:0,disableDates:void 0,disableDaysOfWeek:void 0,calendarWeeks:!1,keyboardNavigation:!0,locale:"en-us",icons:{rightIcon:'<i class="gj-icon">event</i>',previousMonth:'<i class="gj-icon chevron-left"></i>',nextMonth:'<i class="gj-icon chevron-right"></i>'},fontSize:void 0,size:"default",modal:!1,header:!1,footer:!1,showOnFocus:!0,showRightIcon:!0,style:{modal:"gj-modal",wrapper:"gj-datepicker gj-datepicker-md gj-unselectable",input:"gj-textbox-md",calendar:"gj-picker gj-picker-md datepicker gj-unselectable",footer:"",button:"gj-button-md"}},bootstrap:{style:{wrapper:"gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group",input:"form-control",calendar:"gj-picker gj-picker-bootstrap datepicker gj-unselectable",footer:"modal-footer",button:"btn btn-default"},iconsLibrary:"glyphicons",showOtherMonths:!0},bootstrap4:{style:{wrapper:"gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group",input:"form-control",calendar:"gj-picker gj-picker-bootstrap datepicker gj-unselectable",footer:"modal-footer",button:"btn btn-default"},showOtherMonths:!0},fontawesome:{icons:{rightIcon:'<i class="fa fa-calendar" aria-hidden="true"></i>',previousMonth:'<i class="fa fa-chevron-left" aria-hidden="true"></i>',nextMonth:'<i class="fa fa-chevron-right" aria-hidden="true"></i>'}},glyphicons:{icons:{rightIcon:'<span class="glyphicon glyphicon-calendar"></span>',previousMonth:'<span class="glyphicon glyphicon-chevron-left"></span>',nextMonth:'<span class="glyphicon glyphicon-chevron-right"></span>'}}},gj.datepicker.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"datepicker"),this.attr("data-datepicker","true"),gj.datepicker.methods.initialize(this,this.data()),this},initialize:function(a,b){var c,d,e=a.parent('div[role="wrapper"]');0===e.length?(e=$('<div role="wrapper" />').addClass(b.style.wrapper),a.wrap(e)):e.addClass(b.style.wrapper),e=a.parent('div[role="wrapper"]'),b.width&&e.css("width",b.width),a.val(b.value).addClass(b.style.input).attr("role","input"),b.fontSize&&a.css("font-size",b.fontSize),"bootstrap"===b.uiLibrary||"bootstrap4"===b.uiLibrary?"small"===b.size?(e.addClass("input-group-sm"),a.addClass("form-control-sm")):"large"===b.size&&(e.addClass("input-group-lg"),a.addClass("form-control-lg")):"small"===b.size?e.addClass("small"):"large"===b.size&&e.addClass("large"),b.showRightIcon&&(d="bootstrap"===b.uiLibrary?$('<span class="input-group-addon">'+b.icons.rightIcon+"</span>"):"bootstrap4"===b.uiLibrary?$('<span class="input-group-append"><button class="btn btn-outline-secondary border-left-0" type="button">'+b.icons.rightIcon+"</button></span>"):$(b.icons.rightIcon),d.attr("role","right-icon"),d.on("click",function(c){$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]').is(":visible")?gj.datepicker.methods.close(a):gj.datepicker.methods.open(a,b)}),e.append(d)),b.showOnFocus&&a.on("focus",function(){gj.datepicker.methods.open(a,b)}),c=gj.datepicker.methods.createCalendar(a,b),!0!==b.footer&&(a.on("blur",function(){a.timeout=setTimeout(function(){gj.datepicker.methods.close(a)},500)}),c.mousedown(function(){return clearTimeout(a.timeout),document.activeElement!==a[0]&&a.focus(),!1}),c.on("click",function(){clearTimeout(a.timeout),document.activeElement!==a[0]&&a.focus()})),b.keyboardNavigation&&$(document).on("keydown",gj.datepicker.methods.createKeyDownHandler(a,c,b))},createCalendar:function(a,b){var c,d,e,f,g,h=$('<div role="calendar" type="month"/>').addClass(b.style.calendar).attr("guid",a.attr("data-guid"));return b.fontSize&&h.css("font-size",b.fontSize),c=gj.core.parseDate(b.value,b.format,b.locale),!c||isNaN(c.getTime())?c=new Date:a.attr("day",c.getFullYear()+"-"+c.getMonth()+"-"+c.getDate()),h.attr("month",c.getMonth()),h.attr("year",c.getFullYear()),gj.datepicker.methods.renderHeader(a,h,b,c),d=$('<div role="body" />'),h.append(d),b.footer&&(e=$('<div role="footer" class="'+b.style.footer+'" />'),f=$('<button class="'+b.style.button+'">'+gj.core.messages[b.locale].cancel+"</button>"),f.on("click",function(){a.close()}),e.append(f),g=$('<button class="'+b.style.button+'">'+gj.core.messages[b.locale].ok+"</button>"),g.on("click",function(){var c,d,e=h.attr("selectedDay");e?(d=e.split("-"),c=new Date(d[0],d[1],d[2],h.attr("hour")||0,h.attr("minute")||0),gj.datepicker.methods.change(a,h,b,c)):a.close()}),e.append(g),h.append(e)),h.hide(),$("body").append(h),b.modal&&(h.wrapAll('<div role="modal" class="'+b.style.modal+'"/>'),gj.core.center(h)),h},renderHeader:function(a,b,c,d){var e,f,g;c.header&&(e=$('<div role="header" />'),g=$('<div role="year" />').on("click",function(){gj.datepicker.methods.renderDecade(a,b,c),g.addClass("selected"),f.removeClass("selected")}),g.html(gj.core.formatDate(d,"yyyy",c.locale)),e.append(g),f=$('<div role="date" class="selected" />').on("click",function(){gj.datepicker.methods.renderMonth(a,b,c),f.addClass("selected"),g.removeClass("selected")}),f.html(gj.core.formatDate(d,"ddd, mmm dd",c.locale)),e.append(f),b.append(e))},updateHeader:function(a,b,c){a.find('[role="header"] [role="year"]').removeClass("selected").html(gj.core.formatDate(c,"yyyy",b.locale)),a.find('[role="header"] [role="date"]').addClass("selected").html(gj.core.formatDate(c,"ddd, mmm dd",b.locale)),a.find('[role="header"] [role="hour"]').removeClass("selected").html(gj.core.formatDate(c,"HH",b.locale)),a.find('[role="header"] [role="minute"]').removeClass("selected").html(gj.core.formatDate(c,"MM",b.locale))},createNavigation:function(a,b,c,d){var e,f,g=$("<thead/>");for(f=$('<div role="navigator" />'),f.append($("<div>"+d.icons.previousMonth+"</div>").on("click",gj.datepicker.methods.prev(a,d))),f.append($('<div role="period"></div>').on("click",gj.datepicker.methods.changePeriod(a,d))),f.append($("<div>"+d.icons.nextMonth+"</div>").on("click",gj.datepicker.methods.next(a,d))),b.append(f),e=$('<tr role="week-days" />'),d.calendarWeeks&&e.append("<th><div>&nbsp;</div></th>"),i=d.weekStartDay;i<gj.core.messages[d.locale].weekDaysMin.length;i++)e.append("<th><div>"+gj.core.messages[d.locale].weekDaysMin[i]+"</div></th>");for(i=0;i<d.weekStartDay;i++)e.append("<th><div>"+gj.core.messages[d.locale].weekDaysMin[i]+"</div></th>");g.append(e),c.append(g)},renderMonth:function(a,b,c){var d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s=b.children('[role="body"]'),t=$("<table/>"),u=$("<tbody/>"),v=gj.core.messages[c.locale].titleFormat;for(s.off().empty(),gj.datepicker.methods.createNavigation(a,s,t,c),g=parseInt(b.attr("month"),10),h=parseInt(b.attr("year"),10),b.attr("type","month"),v=v.replace("mmmm",gj.core.messages[c.locale].monthNames[g]).replace("yyyy",h),b.find('div[role="period"]').text(v),i=new Array(31,28,31,30,31,30,31,31,30,31,30,31),h%4==0&&1900!=h&&(i[1]=29),j=i[g],k=(new Date(h,g,1).getDay()+7-c.weekStartDay)%7,d=0,$row=$("<tr />"),n=gj.datepicker.methods.getPrevMonth(g,h),l=1;l<=k;l++)f=i[n.month]-k+l,r=new Date(n.year,n.month,f),c.calendarWeeks&&1===l&&$row.append('<td class="calendar-week"><div>'+gj.datepicker.methods.getWeekNumber(r)+"</div></td>"),p=$('<td class="other-month" />'),c.showOtherMonths&&(q=$("<div>"+f+"</div>"),p.append(q),c.selectOtherMonths&&gj.datepicker.methods.isSelectable(c,r)?(p.addClass("gj-cursor-pointer").attr("day",f).attr("month",n.month).attr("year",n.year),q.on("click",gj.datepicker.methods.dayClickHandler(a,b,c,r)),q.on("mousedown",function(a){a.stopPropagation()})):p.addClass("disabled")),$row.append(p),d++;for(l>1&&u.append($row),m=new Date,l=1;l<=j;l++)r=new Date(h,g,l),0==d&&($row=$("<tr>"),c.calendarWeeks&&$row.append('<td class="calendar-week"><div>'+gj.datepicker.methods.getWeekNumber(r)+"</div></td>")),p=$('<td day="'+l+'" month="'+g+'" year="'+h+'" />'),h===m.getFullYear()&&g===m.getMonth()&&l===m.getDate()?p.addClass("today"):p.addClass("current-month"),q=$("<div>"+l+"</div>"),gj.datepicker.methods.isSelectable(c,r)?(p.addClass("gj-cursor-pointer"),q.on("click",gj.datepicker.methods.dayClickHandler(a,b,c,r)),q.on("mousedown",function(a){a.stopPropagation()})):p.addClass("disabled"),p.append(q),$row.append(p),7==++d&&(u.append($row),d=0);for(o=gj.datepicker.methods.getNextMonth(g,h),l=1;0!=d;l++)r=new Date(o.year,o.month,l),p=$('<td class="other-month" />'),c.showOtherMonths&&(q=$("<div>"+l+"</div>"),c.selectOtherMonths&&gj.datepicker.methods.isSelectable(c,r)?(p.addClass("gj-cursor-pointer").attr("day",l).attr("month",o.month).attr("year",o.year),q.on("click",gj.datepicker.methods.dayClickHandler(a,b,c,r)),q.on("mousedown",function(a){a.stopPropagation()})):p.addClass("disabled"),p.append(q)),$row.append(p),7==++d&&(u.append($row),d=0);t.append(u),s.append(t),b.attr("selectedDay")&&(e=b.attr("selectedDay").split("-"),r=new Date(e[0],e[1],e[2],b.attr("hour")||0,b.attr("minute")||0),b.find('tbody td[day="'+e[2]+'"][month="'+e[1]+'"]').addClass("selected"),gj.datepicker.methods.updateHeader(b,c,r))},renderYear:function(a,b,c){var d,e,f,g,h=b.find('>[role="body"]>table'),i=h.children("tbody");for(h.children("thead").hide(),d=parseInt(b.attr("year"),10),b.attr("type","year"),b.find('div[role="period"]').text(d),i.empty(),e=0;e<3;e++){for($row=$("<tr />"),f=4*e;f<=4*e+3;f++)g=$("<div>"+gj.core.messages[c.locale].monthShortNames[f]+"</div>"),g.on("click",gj.datepicker.methods.selectMonth(a,b,c,f)),$cell=$("<td></td>").append(g),$row.append($cell);i.append($row)}},renderDecade:function(a,b,c){var d,e,f,g,h,i=b.find('>[role="body"]>table'),j=i.children("tbody");for(i.children("thead").hide(),d=parseInt(b.attr("year"),10),e=d-d%10,b.attr("type","decade"),b.find('div[role="period"]').text(e+" - "+(e+9)),j.empty(),f=e-1;f<=e+10;f+=4){for($row=$("<tr />"),g=f;g<=f+3;g++)h=$("<div>"+g+"</div>"),h.on("click",gj.datepicker.methods.selectYear(a,b,c,g)),$cell=$("<td></td>").append(h),$row.append($cell);j.append($row)}},renderCentury:function(a,b,c){var d,e,f,g,h,i=b.find('>[role="body"]>table'),j=i.children("tbody");for(i.children("thead").hide(),d=parseInt(b.attr("year"),10),e=d-d%100,b.attr("type","century"),b.find('div[role="period"]').text(e+" - "+(e+99)),j.empty(),f=e-10;f<e+100;f+=40){for($row=$("<tr />"),g=f;g<=f+30;g+=10)h=$("<div>"+g+"</div>"),h.on("click",gj.datepicker.methods.selectDecade(a,b,c,g)),$cell=$("<td></td>").append(h),$row.append($cell);j.append($row)}},getWeekNumber:function(a){var b=new Date(a.valueOf());b.setDate(b.getDate()+6),b=new Date(Date.UTC(b.getFullYear(),b.getMonth(),b.getDate())),b.setUTCDate(b.getUTCDate()+4-(b.getUTCDay()||7));var c=new Date(Date.UTC(b.getUTCFullYear(),0,1));return Math.ceil(((b-c)/864e5+1)/7)},getMinDate:function(a){var b;return a.minDate&&("string"==typeof a.minDate?b=gj.core.parseDate(a.minDate,a.format,a.locale):"function"==typeof a.minDate?"string"==typeof(b=a.minDate())&&(b=gj.core.parseDate(b,a.format,a.locale)):"function"==typeof a.minDate.getMonth&&(b=a.minDate)),b},getMaxDate:function(a){var b;return a.maxDate&&("string"==typeof a.maxDate?b=gj.core.parseDate(a.maxDate,a.format,a.locale):"function"==typeof a.maxDate?"string"==typeof(b=a.maxDate())&&(b=gj.core.parseDate(b,a.format,a.locale)):"function"==typeof a.maxDate.getMonth&&(b=a.maxDate)),b},isSelectable:function(a,b){var c,d=!0,e=gj.datepicker.methods.getMinDate(a),f=gj.datepicker.methods.getMaxDate(a);if(e&&b<e?d=!1:f&&b>f&&(d=!1),d){if(a.disableDates)if($.isArray(a.disableDates))for(c=0;c<a.disableDates.length;c++)a.disableDates[c]instanceof Date&&a.disableDates[c].getTime()===b.getTime()?d=!1:"string"==typeof a.disableDates[c]&&gj.core.parseDate(a.disableDates[c],a.format,a.locale).getTime()===b.getTime()&&(d=!1);else a.disableDates instanceof Function&&(d=a.disableDates(b));$.isArray(a.disableDaysOfWeek)&&a.disableDaysOfWeek.indexOf(b.getDay())>-1&&(d=!1)}return d},getPrevMonth:function(a,b){return date=new Date(b,a,1),date.setMonth(date.getMonth()-1),{month:date.getMonth(),year:date.getFullYear()}},getNextMonth:function(a,b){return date=new Date(b,a,1),date.setMonth(date.getMonth()+1),{month:date.getMonth(),year:date.getFullYear()}},prev:function(a,b){return function(){var c,d,e,f,g,h=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');switch(e=parseInt(h.attr("year"),10),h.attr("type")){case"month":d=parseInt(h.attr("month"),10),c=gj.datepicker.methods.getPrevMonth(d,e),h.attr("month",c.month),h.attr("year",c.year),gj.datepicker.methods.renderMonth(a,h,b);break;case"year":h.attr("year",e-1),gj.datepicker.methods.renderYear(a,h,b);break;case"decade":f=e-e%10,h.attr("year",f-10),gj.datepicker.methods.renderDecade(a,h,b);break;case"century":g=e-e%100,h.attr("year",g-100),gj.datepicker.methods.renderCentury(a,h,b)}}},next:function(a,b){return function(){var c,d,e,f,g,h=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');switch(e=parseInt(h.attr("year"),10),h.attr("type")){case"month":d=parseInt(h.attr("month"),10),c=gj.datepicker.methods.getNextMonth(d,e),h.attr("month",c.month),h.attr("year",c.year),gj.datepicker.methods.renderMonth(a,h,b);break;case"year":h.attr("year",e+1),gj.datepicker.methods.renderYear(a,h,b);break;case"decade":f=e-e%10,h.attr("year",f+10),gj.datepicker.methods.renderDecade(a,h,b);break;case"century":g=e-e%100,h.attr("year",g+100),gj.datepicker.methods.renderCentury(a,h,b)}}},changePeriod:function(a,b){return function(c){var d=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');switch(d.attr("type")){case"month":gj.datepicker.methods.renderYear(a,d,b);break;case"year":gj.datepicker.methods.renderDecade(a,d,b);break;case"decade":gj.datepicker.methods.renderCentury(a,d,b)}}},dayClickHandler:function(a,b,c,d){return function(e){return e&&e.stopPropagation(),gj.datepicker.methods.selectDay(a,b,c,d),!0!==c.footer&&!1!==c.autoClose&&gj.datepicker.methods.change(a,b,c,d),a}},change:function(a,b,c,d){var e=(d.getDate(),d.getMonth()),f=d.getFullYear(),g=gj.core.formatDate(d,c.format,c.locale);b.attr("month",e),b.attr("year",f),a.val(g),gj.datepicker.events.change(a),"none"!==window.getComputedStyle(b[0]).display&&gj.datepicker.methods.close(a)},selectDay:function(a,b,c,d){var e=d.getDate(),f=d.getMonth(),g=d.getFullYear();b.attr("selectedDay",g+"-"+f+"-"+e),b.find("tbody td").removeClass("selected"),b.find('tbody td[day="'+e+'"][month="'+f+'"]').addClass("selected"),gj.datepicker.methods.updateHeader(b,c,d),gj.datepicker.events.select(a,"day")},selectMonth:function(a,b,c,d){return function(e){b.attr("month",d),gj.datepicker.methods.renderMonth(a,b,c),gj.datepicker.events.select(a,"month")}},selectYear:function(a,b,c,d){return function(e){b.attr("year",d),gj.datepicker.methods.renderYear(a,b,c),gj.datepicker.events.select(a,"year")}},selectDecade:function(a,b,c,d){return function(e){b.attr("year",d),gj.datepicker.methods.renderDecade(a,b,c),gj.datepicker.events.select(a,"decade")}},open:function(a,b){var c,d=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');switch(a.val()?a.value(a.val()):(c=new Date,d.attr("month",c.getMonth()),d.attr("year",c.getFullYear())),d.attr("type")){case"month":gj.datepicker.methods.renderMonth(a,d,b);break;case"year":gj.datepicker.methods.renderYear(a,d,b);break;case"decade":gj.datepicker.methods.renderDecade(a,d,b);break;case"century":gj.datepicker.methods.renderCentury(a,d,b)}d.show(),d.closest('div[role="modal"]').show(),b.modal?gj.core.center(d):(gj.core.setChildPosition(a[0],d[0]),document.activeElement!==a[0]&&a.focus()),clearTimeout(a.timeout),gj.datepicker.events.open(a)},close:function(a){var b=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');b.hide(),b.closest('div[role="modal"]').hide(),gj.datepicker.events.close(a)},createKeyDownHandler:function(a,b,c){return function(d){var e,f,g,h,i,j,d=d||window.event;"none"!==window.getComputedStyle(b[0]).display&&(j=gj.datepicker.methods.getActiveCell(b),"38"==d.keyCode?(h=j.index(),i=j.closest("tr").prev("tr").find("td:eq("+h+")"),i.is("[day]")||(gj.datepicker.methods.prev(a,c)(),i=b.find("tbody tr").last().find("td:eq("+h+")"),i.is(":empty")&&(i=b.find("tbody tr").last().prev().find("td:eq("+h+")"))),i.is("[day]")&&(i.addClass("focused"),j.removeClass("focused"))):"40"==d.keyCode?(h=j.index(),i=j.closest("tr").next("tr").find("td:eq("+h+")"),i.is("[day]")||(gj.datepicker.methods.next(a,c)(),i=b.find("tbody tr").first().find("td:eq("+h+")"),i.is("[day]")||(i=b.find("tbody tr:eq(1)").find("td:eq("+h+")"))),i.is("[day]")&&(i.addClass("focused"),j.removeClass("focused"))):"37"==d.keyCode?(i=j.prev("td[day]:not(.disabled)"),0===i.length&&(i=j.closest("tr").prev("tr").find("td[day]").last()),0===i.length&&(gj.datepicker.methods.prev(a,c)(),i=b.find("tbody tr").last().find("td[day]").last()),i.length>0&&(i.addClass("focused"),j.removeClass("focused"))):"39"==d.keyCode?(i=j.next("[day]:not(.disabled)"),0===i.length&&(i=j.closest("tr").next("tr").find("td[day]").first()),0===i.length&&(gj.datepicker.methods.next(a,c)(),i=b.find("tbody tr").first().find("td[day]").first()),i.length>0&&(i.addClass("focused"),j.removeClass("focused"))):"13"==d.keyCode?(g=parseInt(j.attr("day"),10),e=parseInt(j.attr("month"),10),f=parseInt(j.attr("year"),10),gj.datepicker.methods.dayClickHandler(a,b,c,new Date(f,e,g))()):"27"==d.keyCode&&a.close())}},getActiveCell:function(a){var b=a.find("td[day].focused");return 0===b.length&&(b=a.find("td[day].selected"),0===b.length&&(b=a.find("td[day].today"),0===b.length&&(b=a.find("td[day]:not(.disabled)").first()))),b},value:function(a,b){var c,d,e=a.data();return void 0===b?a.val():(d=gj.core.parseDate(b,e.format,e.locale),d&&d.getTime()?(c=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]'),gj.datepicker.methods.dayClickHandler(a,c,e,d)()):a.val(""),a)},destroy:function(a){var b=a.data(),c=a.parent(),d=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');return b&&(a.off(),d.parent('[role="modal"]').length>0&&d.unwrap(),d.remove(),a.removeData(),a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-datepicker"),a.removeClass(),c.children('[role="right-icon"]').remove(),a.unwrap()),a}},gj.datepicker.events={change:function(a){return a.triggerHandler("change")},select:function(a,b){return a.triggerHandler("select",[b])},open:function(a){return a.triggerHandler("open")},close:function(a){return a.triggerHandler("close")}},gj.datepicker.widget=function(a,b){var c=this,d=gj.datepicker.methods;return c.value=function(a){return d.value(this,a)},c.destroy=function(){return d.destroy(this)},c.open=function(){return d.open(this,this.data())},c.close=function(){return d.close(this)},$.extend(a,c),"true"!==a.attr("data-datepicker")&&d.init.call(a,b),a},gj.datepicker.widget.prototype=new gj.widget,gj.datepicker.widget.constructor=gj.datepicker.widget,function(a){a.fn.datepicker=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.datepicker.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.datepicker.widget(this,a)}}}(jQuery),gj.timepicker={plugins:{}},gj.timepicker.config={base:{width:void 0,modal:!0,header:!0,footer:!0,format:"HH:MM",uiLibrary:"materialdesign",value:void 0,mode:"ampm",locale:"en-us",size:"default",icons:{rightIcon:'<i class="gj-icon clock" />'},style:{modal:"gj-modal",wrapper:"gj-timepicker gj-timepicker-md gj-unselectable",input:"gj-textbox-md",clock:"gj-picker gj-picker-md timepicker",footer:"",button:"gj-button-md"}},bootstrap:{style:{wrapper:"gj-timepicker gj-timepicker-bootstrap gj-unselectable input-group",input:"form-control",clock:"gj-picker gj-picker-bootstrap timepicker",footer:"modal-footer",button:"btn btn-default"},iconsLibrary:"glyphicons"},bootstrap4:{style:{wrapper:"gj-timepicker gj-timepicker-bootstrap gj-unselectable input-group",input:"form-control border",clock:"gj-picker gj-picker-bootstrap timepicker",footer:"modal-footer",button:"btn btn-default"}}},gj.timepicker.methods={init:function(a){return gj.picker.widget.prototype.init.call(this,a,"timepicker"),this},initialize:function(){},initMouse:function(a,b,c,d){a.off(),a.on("mousedown",gj.timepicker.methods.mouseDownHandler(b,c)),a.on("mousemove",gj.timepicker.methods.mouseMoveHandler(b,c,d)),a.on("mouseup",gj.timepicker.methods.mouseUpHandler(b,c,d))},createPicker:function(a){var b,c=a.data(),d=$('<div role="picker" />').addClass(c.style.clock).attr("guid",a.attr("data-guid")),e=$('<div role="hour" />'),f=$('<div role="minute" />'),g=$('<div role="header" />'),h=$('<div role="mode" />'),i=$('<div role="body" />'),j=$('<button class="'+c.style.button+'">'+gj.core.messages[c.locale].ok+"</button>"),k=$('<button class="'+c.style.button+'">'+gj.core.messages[c.locale].cancel+"</button>"),l=$('<div role="footer" class="'+c.style.footer+'" />');return b=gj.core.parseDate(c.value,c.format,c.locale),!b||isNaN(b.getTime())?b=new Date:a.attr("hours",b.getHours()),gj.timepicker.methods.initMouse(i,a,d,c),c.header&&(e.on("click",function(){gj.timepicker.methods.renderHours(a,d,c)}),f.on("click",function(){gj.timepicker.methods.renderMinutes(a,d,c)}),g.append(e).append(":").append(f),"ampm"===c.mode&&(h.append($('<span role="am">'+gj.core.messages[c.locale].am+"</span>").on("click",function(){var b=gj.timepicker.methods.getHour(d);d.attr("mode","am"),$(this).addClass("selected"),$(this).parent().children('[role="pm"]').removeClass("selected"),b>=12&&d.attr("hour",b-12),c.modal||(clearTimeout(a.timeout),a.focus())})),h.append("<br />"),h.append($('<span role="pm">'+gj.core.messages[c.locale].pm+"</span>").on("click",function(){var b=gj.timepicker.methods.getHour(d);d.attr("mode","pm"),$(this).addClass("selected"),$(this).parent().children('[role="am"]').removeClass("selected"),b<12&&d.attr("hour",b+12),c.modal||(clearTimeout(a.timeout),a.focus())})),g.append(h)),d.append(g)),d.append(i),c.footer&&(k.on("click",function(){a.close()}),l.append(k),j.on("click",gj.timepicker.methods.setTime(a,d)),l.append(j),d.append(l)),d.hide(),$("body").append(d),c.modal&&(d.wrapAll('<div role="modal" class="'+c.style.modal+'"/>'),gj.core.center(d)),d},getHour:function(a){return parseInt(a.attr("hour"),10)||0},getMinute:function(a){return parseInt(a.attr("minute"),10)||0},setTime:function(a,b){return function(){var c=gj.timepicker.methods.getHour(b),d=gj.timepicker.methods.getMinute(b),e=b.attr("mode"),f=new Date(0,0,0,12===c&&"am"===e?0:c,d),g=a.data(),h=gj.core.formatDate(f,g.format,g.locale);a.value(h),a.close()}},getPointerValue:function(a,b,c){var d,e,f=256,g=Math.atan2(f/2-a,f/2-b)/Math.PI*180;switch(g<0&&(g=360+g),c){case"ampm":return d=12-Math.round(12*g/360),0===d?12:d;case"24hr":return e=Math.sqrt(Math.pow(f/2-a,2)+Math.pow(f/2-b,2)),d=12-Math.round(12*g/360),0===d&&(d=12),e<f/2-32&&(d=12===d?0:d+12),d;case"minutes":return d=Math.round(60-60*g/360),60===d?0:d}},updateArrow:function(a,b,c,d){var e,f,g=b.mouseX(a),h=b.mouseY(a),i=window.scrollY||window.pageYOffset||0,j=window.scrollX||window.pageXOffset||0;e=a.target.getBoundingClientRect(),"hours"==d.dialMode?(f=gj.timepicker.methods.getPointerValue(g-j-e.left,h-i-e.top,d.mode),c.attr("hour","ampm"===d.mode&&"pm"===c.attr("mode")&&f<12?f+12:f)):"minutes"==d.dialMode&&(f=gj.timepicker.methods.getPointerValue(g-j-e.left,h-i-e.top,"minutes"),c.attr("minute",f)),gj.timepicker.methods.update(b,c,d)},update:function(a,b,c){var d,e,f,g,h,i;d=gj.timepicker.methods.getHour(b),e=gj.timepicker.methods.getMinute(b),f=b.find('[role="arrow"]'),"hours"==c.dialMode&&(0==d||d>12)&&"24hr"===c.mode?f.css("width","calc(50% - 52px)"):f.css("width","calc(50% - 20px)"),"hours"==c.dialMode?f.css("transform","rotate("+(30*d-90).toString()+"deg)"):f.css("transform","rotate("+(6*e-90).toString()+"deg)"),f.show(),g="ampm"===c.mode&&d>12?d-12:0==d?12:d,i=b.find('[role="body"] span'),i.removeClass("selected"),i.filter(function(a){return"hours"==c.dialMode?parseInt($(this).text(),10)==g:parseInt($(this).text(),10)==e}).addClass("selected"),c.header&&(h=b.find('[role="header"]'),h.find('[role="hour"]').text(g),h.find('[role="minute"]').text(gj.core.pad(e)),"ampm"===c.mode&&(d>=12?(h.find('[role="pm"]').addClass("selected"),h.find('[role="am"]').removeClass("selected")):(h.find('[role="am"]').addClass("selected"),h.find('[role="pm"]').removeClass("selected"))))},mouseDownHandler:function(a,b){return function(b){a.mouseMove=!0}},mouseMoveHandler:function(a,b,c){return function(d){a.mouseMove&&gj.timepicker.methods.updateArrow(d,a,b,c)}},mouseUpHandler:function(a,b,c){return function(d){gj.timepicker.methods.updateArrow(d,a,b,c),a.mouseMove=!1,c.modal||(clearTimeout(a.timeout),a.focus()),"hours"==c.dialMode?setTimeout(function(){gj.timepicker.events.select(a,"hour"),gj.timepicker.methods.renderMinutes(a,b,c)},1e3):"minutes"==c.dialMode&&(!0!==c.footer&&!1!==c.autoClose&&gj.timepicker.methods.setTime(a,b)(),gj.timepicker.events.select(a,"minute"))}},renderHours:function(a,b,c){var d,e=b.find('[role="body"]');clearTimeout(a.timeout),e.empty(),d=$('<div role="dial"></div>'),d.append('<div role="arrow" style="transform: rotate(-90deg); display: none;"><div class="arrow-begin"></div><div class="arrow-end"></div></div>'),d.append('<span role="hour" style="transform: translate(54px, -93.5307px);">1</span>'),d.append('<span role="hour" style="transform: translate(93.5307px, -54px);">2</span>'),d.append('<span role="hour" style="transform: translate(108px, 0px);">3</span>'),d.append('<span role="hour" style="transform: translate(93.5307px, 54px);">4</span>'),d.append('<span role="hour" style="transform: translate(54px, 93.5307px);">5</span>'),d.append('<span role="hour" style="transform: translate(6.61309e-15px, 108px);">6</span>'),d.append('<span role="hour" style="transform: translate(-54px, 93.5307px);">7</span>'),d.append('<span role="hour" style="transform: translate(-93.5307px, 54px);">8</span>'),d.append('<span role="hour" style="transform: translate(-108px, 1.32262e-14px);">9</span>'),d.append('<span role="hour" style="transform: translate(-93.5307px, -54px);">10</span>'),d.append('<span role="hour" style="transform: translate(-54px, -93.5307px);">11</span>'),d.append('<span role="hour" style="transform: translate(-1.98393e-14px, -108px);">12</span>'),"24hr"===c.mode&&(d.append('<span role="hour" style="transform: translate(38px, -65.8179px);">13</span>'),d.append('<span role="hour" style="transform: translate(65.8179px, -38px);">14</span>'),d.append('<span role="hour" style="transform: translate(76px, 0px);">15</span>'),d.append('<span role="hour" style="transform: translate(65.8179px, 38px);">16</span>'),d.append('<span role="hour" style="transform: translate(38px, 65.8179px);">17</span>'),d.append('<span role="hour" style="transform: translate(4.65366e-15px, 76px);">18</span>'),d.append('<span role="hour" style="transform: translate(-38px, 65.8179px);">19</span>'),d.append('<span role="hour" style="transform: translate(-65.8179px, 38px);">20</span>'),d.append('<span role="hour" style="transform: translate(-76px, 9.30732e-15px);">21</span>'),d.append('<span role="hour" style="transform: translate(-65.8179px, -38px);">22</span>'),d.append('<span role="hour" style="transform: translate(-38px, -65.8179px);">23</span>'),d.append('<span role="hour" style="transform: translate(-1.3961e-14px, -76px);">00</span>')),e.append(d),b.find('[role="header"] [role="hour"]').addClass("selected"),b.find('[role="header"] [role="minute"]').removeClass("selected"),c.dialMode="hours",gj.timepicker.methods.update(a,b,c)},renderMinutes:function(a,b,c){var d=b.find('[role="body"]');clearTimeout(a.timeout),d.empty(),$dial=$('<div role="dial"></div>'),$dial.append('<div role="arrow" style="transform: rotate(-90deg); display: none;"><div class="arrow-begin"></div><div class="arrow-end"></div></div>'),$dial.append('<span role="hour" style="transform: translate(54px, -93.5307px);">5</span>'),$dial.append('<span role="hour" style="transform: translate(93.5307px, -54px);">10</span>'),$dial.append('<span role="hour" style="transform: translate(108px, 0px);">15</span>'),$dial.append('<span role="hour" style="transform: translate(93.5307px, 54px);">20</span>'),$dial.append('<span role="hour" style="transform: translate(54px, 93.5307px);">25</span>'),$dial.append('<span role="hour" style="transform: translate(6.61309e-15px, 108px);">30</span>'),$dial.append('<span role="hour" style="transform: translate(-54px, 93.5307px);">35</span>'),$dial.append('<span role="hour" style="transform: translate(-93.5307px, 54px);">40</span>'),$dial.append('<span role="hour" style="transform: translate(-108px, 1.32262e-14px);">45</span>'),$dial.append('<span role="hour" style="transform: translate(-93.5307px, -54px);">50</span>'),$dial.append('<span role="hour" style="transform: translate(-54px, -93.5307px);">55</span>'),$dial.append('<span role="hour" style="transform: translate(-1.98393e-14px, -108px);">00</span>'),d.append($dial),b.find('[role="header"] [role="hour"]').removeClass("selected"),b.find('[role="header"] [role="minute"]').addClass("selected"),c.dialMode="minutes",gj.timepicker.methods.update(a,b,c)},open:function(a){var b,c,d=a.data(),e=$("body").find('[role="picker"][guid="'+a.attr("data-guid")+'"]');return b=a.value()?gj.core.parseDate(a.value(),d.format,d.locale):new Date,c=b.getHours(),"ampm"===d.mode&&e.attr("mode",c>12?"pm":"am"),e.attr("hour",c),e.attr("minute",b.getMinutes()),gj.timepicker.methods.renderHours(a,e,d),gj.picker.widget.prototype.open.call(a,"timepicker"),a},value:function(a,b){a.data();return void 0===b?a.val():(a.val(b),gj.timepicker.events.change(a),a)}},gj.timepicker.events={change:function(a){return a.triggerHandler("change")},select:function(a,b){return a.triggerHandler("select",[b])},open:function(a){return a.triggerHandler("open")},close:function(a){return a.triggerHandler("close")}},gj.timepicker.widget=function(a,b){var c=this,d=gj.timepicker.methods;return c.mouseMove=!1,c.value=function(a){return d.value(this,a)},c.destroy=function(){return gj.picker.widget.prototype.destroy.call(this,"timepicker")},c.open=function(){return gj.timepicker.methods.open(this)},c.close=function(){return gj.picker.widget.prototype.close.call(this,"timepicker")},$.extend(a,c),"true"!==a.attr("data-timepicker")&&d.init.call(a,b),a},gj.timepicker.widget.prototype=new gj.picker.widget,gj.timepicker.widget.constructor=gj.timepicker.widget,function(a){a.fn.timepicker=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.timepicker.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.timepicker.widget(this,a)}}}(jQuery),gj.datetimepicker={plugins:{},messages:{"en-us":{}}},gj.datetimepicker.config={base:{datepicker:gj.datepicker.config.base,timepicker:gj.timepicker.config.base,uiLibrary:"materialdesign",value:void 0,format:"HH:MM mm/dd/yyyy",width:void 0,modal:!1,footer:!1,size:"default",locale:"en-us",icons:{},style:{calendar:"gj-picker gj-picker-md datetimepicker gj-unselectable"}},bootstrap:{style:{calendar:"gj-picker gj-picker-bootstrap datetimepicker gj-unselectable"},iconsLibrary:"glyphicons"},bootstrap4:{style:{calendar:"gj-picker gj-picker-bootstrap datetimepicker gj-unselectable"}}},gj.datetimepicker.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"datetimepicker"),this.attr("data-datetimepicker","true"),gj.datetimepicker.methods.initialize(this),this},getConfig:function(a,b){var c=gj.widget.prototype.getConfig.call(this,a,b);return uiLibrary=a.hasOwnProperty("uiLibrary")?a.uiLibrary:c.uiLibrary,gj.datepicker.config[uiLibrary]&&$.extend(!0,c.datepicker,gj.datepicker.config[uiLibrary]),gj.timepicker.config[uiLibrary]&&$.extend(!0,c.timepicker,gj.timepicker.config[uiLibrary]),iconsLibrary=a.hasOwnProperty("iconsLibrary")?a.iconsLibrary:c.iconsLibrary,gj.datepicker.config[iconsLibrary]&&$.extend(!0,c.datepicker,gj.datepicker.config[iconsLibrary]),gj.timepicker.config[iconsLibrary]&&$.extend(!0,c.timepicker,gj.timepicker.config[iconsLibrary]),c},initialize:function(a){var b,c,d,e,f,g,h,i,j=a.data();j.datepicker.uiLibrary=j.uiLibrary,j.datepicker.iconsLibrary=j.iconsLibrary,j.datepicker.width=j.width,j.datepicker.format=j.format,j.datepicker.locale=j.locale,j.datepicker.modal=j.modal,j.datepicker.footer=j.footer,j.datepicker.style.calendar=j.style.calendar,j.datepicker.value=j.value,j.datepicker.size=j.size,j.datepicker.autoClose=!1,gj.datepicker.methods.initialize(a,j.datepicker),a.on("select",function(c,d){var e,f;"day"===d?gj.datetimepicker.methods.createShowHourHandler(a,b,j)():"minute"===d&&b.attr("selectedDay")&&!0!==j.footer&&(selectedDay=b.attr("selectedDay").split("-"),e=new Date(selectedDay[0],selectedDay[1],selectedDay[2],b.attr("hour")||0,b.attr("minute")||0),f=gj.core.formatDate(e,j.format,j.locale),a.val(f),gj.datetimepicker.events.change(a),gj.datetimepicker.methods.close(a))}),a.on("open",function(){var a=b.children('[role="header"]');a.find('[role="calendarMode"]').addClass("selected"),a.find('[role="clockMode"]').removeClass("selected")}),b=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]'),f=j.value?gj.core.parseDate(j.value,j.format,j.locale):new Date,b.attr("hour",f.getHours()),b.attr("minute",f.getMinutes()),j.timepicker.uiLibrary=j.uiLibrary,j.timepicker.iconsLibrary=j.iconsLibrary,j.timepicker.format=j.format,j.timepicker.locale=j.locale,j.timepicker.header=!0,j.timepicker.footer=j.footer,j.timepicker.size=j.size,j.timepicker.mode="24hr",j.timepicker.autoClose=!1,c=$('<div role="header" />'),d=$('<div role="date" class="selected" />'),d.on("click",gj.datetimepicker.methods.createShowDateHandler(a,b,j)),d.html(gj.core.formatDate(new Date,"ddd, mmm dd",j.locale)),c.append(d),g=$('<div role="switch"></div>'),h=$('<i class="gj-icon selected" role="calendarMode">event</i>'),h.on("click",gj.datetimepicker.methods.createShowDateHandler(a,b,j)),g.append(h),e=$('<div role="time" />'),e.append($('<div role="hour" />').on("click",gj.datetimepicker.methods.createShowHourHandler(a,b,j)).html(gj.core.formatDate(new Date,"HH",j.locale))),e.append(":"),e.append($('<div role="minute" />').on("click",gj.datetimepicker.methods.createShowMinuteHandler(a,b,j)).html(gj.core.formatDate(new Date,"MM",j.locale))),g.append(e),i=$('<i class="gj-icon" role="clockMode">clock</i>'),i.on("click",gj.datetimepicker.methods.createShowHourHandler(a,b,j)),g.append(i),c.append(g),b.prepend(c)},createShowDateHandler:function(a,b,c){return function(d){var e=b.children('[role="header"]');e.find('[role="calendarMode"]').addClass("selected"),e.find('[role="date"]').addClass("selected"),e.find('[role="clockMode"]').removeClass("selected"),e.find('[role="hour"]').removeClass("selected"),e.find('[role="minute"]').removeClass("selected"),gj.datepicker.methods.renderMonth(a,b,c.datepicker)}},createShowHourHandler:function(a,b,c){return function(){var d=b.children('[role="header"]');d.find('[role="calendarMode"]').removeClass("selected"),d.find('[role="date"]').removeClass("selected"),d.find('[role="clockMode"]').addClass("selected"),d.find('[role="hour"]').addClass("selected"),d.find('[role="minute"]').removeClass("selected"),gj.timepicker.methods.initMouse(b.children('[role="body"]'),a,b,c.timepicker),gj.timepicker.methods.renderHours(a,b,c.timepicker)}},createShowMinuteHandler:function(a,b,c){return function(){var d=b.children('[role="header"]');d.find('[role="calendarMode"]').removeClass("selected"),d.find('[role="date"]').removeClass("selected"),d.find('[role="clockMode"]').addClass("selected"),d.find('[role="hour"]').removeClass("selected"),d.find('[role="minute"]').addClass("selected"),gj.timepicker.methods.initMouse(b.children('[role="body"]'),a,b,c.timepicker),gj.timepicker.methods.renderMinutes(a,b,c.timepicker)}},close:function(a){var b=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');b.hide(),b.closest('div[role="modal"]').hide()},value:function(a,b){var c,d,e,f=a.data();return void 0===b?a.val():(d=gj.core.parseDate(b,f.format,f.locale),d?(c=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]'),gj.datepicker.methods.dayClickHandler(a,c,f,d)(),e=d.getHours(),"ampm"===f.mode&&c.attr("mode",e>12?"pm":"am"),c.attr("hour",e),c.attr("minute",d.getMinutes()),a.val(b)):a.val(""),a)},destroy:function(a){var b=a.data(),c=a.parent(),d=$("body").find('[role="calendar"][guid="'+a.attr("data-guid")+'"]');return b&&(a.off(),d.parent('[role="modal"]').length>0&&d.unwrap(),d.remove(),a.removeData(),a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-datetimepicker"),a.removeClass(),c.children('[role="right-icon"]').remove(),a.unwrap()),a}},gj.datetimepicker.events={change:function(a){return a.triggerHandler("change")}},gj.datetimepicker.widget=function(a,b){var c=this,d=gj.datetimepicker.methods;return c.mouseMove=!1,c.value=function(a){return d.value(this,a)},c.open=function(){gj.datepicker.methods.open(this,this.data().datepicker)},c.close=function(){gj.datepicker.methods.close(this)},c.destroy=function(){return d.destroy(this)},$.extend(a,c),"true"!==a.attr("data-datetimepicker")&&d.init.call(a,b),a},gj.datetimepicker.widget.prototype=new gj.widget,gj.datetimepicker.widget.constructor=gj.datetimepicker.widget,gj.datetimepicker.widget.prototype.getConfig=gj.datetimepicker.methods.getConfig,function(a){a.fn.datetimepicker=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.datetimepicker.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.datetimepicker.widget(this,a)}}}(jQuery),gj.slider={plugins:{},messages:{"en-us":{}}},gj.slider.config={base:{min:0,max:100,width:void 0,uiLibrary:"materialdesign",value:void 0,icons:{},style:{wrapper:"gj-slider gj-slider-md",progress:void 0,track:void 0}},bootstrap:{style:{wrapper:"gj-slider gj-slider-bootstrap gj-slider-bootstrap-3",progress:"progress-bar",track:"progress"}},bootstrap4:{style:{wrapper:"gj-slider gj-slider-bootstrap gj-slider-bootstrap-4",progress:"progress-bar",track:"progress"}}},gj.slider.methods={init:function(a){return gj.widget.prototype.init.call(this,a,"slider"),this.attr("data-slider","true"),gj.slider.methods.initialize(this,this.data()),this},initialize:function(a,b){var c,d,e,f;a[0].style.display="none","wrapper"!==a[0].parentElement.attributes.role?(c=document.createElement("div"),c.setAttribute("role","wrapper"),a[0].parentNode.insertBefore(c,a[0]),c.appendChild(a[0])):c=a[0].parentElement,b.width&&(c.style.width=b.width+"px"),gj.core.addClasses(c,b.style.wrapper),d=a[0].querySelector('[role="track"]'),null==d&&(d=document.createElement("div"),d.setAttribute("role","track"),c.appendChild(d)),gj.core.addClasses(d,b.style.track),e=a[0].querySelector('[role="handle"]'),null==e&&(e=document.createElement("div"),e.setAttribute("role","handle"),c.appendChild(e)),f=a[0].querySelector('[role="progress"]'),null==f&&(f=document.createElement("div"),f.setAttribute("role","progress"),c.appendChild(f)),gj.core.addClasses(f,b.style.progress),b.value||(b.value=b.min),gj.slider.methods.value(a,b,b.value),gj.documentManager.subscribeForEvent("mouseup",a.data("guid"),gj.slider.methods.createMouseUpHandler(a,e,b)),e.addEventListener("mousedown",gj.slider.methods.createMouseDownHandler(e,b)),gj.documentManager.subscribeForEvent("mousemove",a.data("guid"),gj.slider.methods.createMouseMoveHandler(a,d,e,f,b)),e.addEventListener("click",function(a){a.stopPropagation()}),c.addEventListener("click",gj.slider.methods.createClickHandler(a,d,e,b))},createClickHandler:function(a,b,c,d){return function(e){var f,g,h,i,j;"true"!==c.getAttribute("drag")&&(f=gj.core.position(a[0].parentElement),g=(new gj.widget).mouseX(e)-f.left,h=gj.core.width(c)/2,i=gj.core.width(b)/(d.max-d.min),j=Math.round((g-h)/i)+d.min,gj.slider.methods.value(a,d,j))}},createMouseUpHandler:function(a,b,c){return function(c){"true"===b.getAttribute("drag")&&(b.setAttribute("drag","false"),gj.slider.events.change(a))}},createMouseDownHandler:function(a,b){return function(b){a.setAttribute("drag","true")}},createMouseMoveHandler:function(a,b,c,d,e){return function(d){var f,g,h,i,j,k,l;"true"===c.getAttribute("drag")&&(f=gj.core.position(a[0].parentElement),g=(new gj.widget).mouseX(d)-f.left,h=gj.core.width(b),i=gj.core.width(c)/2,j=h/(e.max-e.min),k=(e.value-e.min)*j,g>=i&&g<=h+i&&(g>k+j/2||g<k-j/2)&&(l=Math.round((g-i)/j)+e.min,gj.slider.methods.value(a,e,l)))}},value:function(a,b,c){var d,e,f,g;return void 0===c?a[0].value:(a[0].setAttribute("value",c),b.value=c,e=a.parent().children('[role="track"]')[0],d=gj.core.width(e)/(b.max-b.min),f=a.parent().children('[role="handle"]')[0],f.style.left=(c-b.min)*d+"px",g=a.parent().children('[role="progress"]')[0],g.style.width=(c-b.min)*d+"px",gj.slider.events.slide(a,c),a)},destroy:function(a){var b=a.data(),c=a.parent();return b&&(c.children('[role="track"]').remove(),c.children('[role="handle"]').remove(),c.children('[role="progress"]').remove(),a.unwrap(),a.off(),a.removeData(),a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-slider"),a.removeClass(),a.show()),a}},gj.slider.events={change:function(a){return a.triggerHandler("change")},slide:function(a,b){return a.triggerHandler("slide",[b])}},gj.slider.widget=function(a,b){var c=this,d=gj.slider.methods;return c.value=function(a){return d.value(this,this.data(),a)},c.destroy=function(){return d.destroy(this)},$.extend(a,c),"true"!==a.attr("data-slider")&&d.init.call(a,b),a},gj.slider.widget.prototype=new gj.widget,gj.slider.widget.constructor=gj.slider.widget,function(a){a.fn.slider=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.slider.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.slider.widget(this,a)}}}(jQuery),gj.colorpicker={plugins:{},messages:{"en-us":{}}},gj.colorpicker.config={base:{uiLibrary:"materialdesign",value:void 0,icons:{rightIcon:'<i class="gj-icon">event</i>'},style:{modal:"gj-modal",wrapper:"gj-colorpicker gj-colorpicker-md gj-unselectable",input:"gj-textbox-md",picker:"gj-picker gj-picker-md colorpicker gj-unselectable",footer:"",button:"gj-button-md"}},bootstrap:{style:{}},bootstrap4:{style:{}}},gj.colorpicker.methods={init:function(a){return gj.picker.widget.prototype.init.call(this,a,"colorpicker"),gj.colorpicker.methods.initialize(this),this},initialize:function(a){},createPicker:function(a,b){var c=$('<div role="picker" />').addClass(b.style.picker).attr("guid",a.attr("data-guid"));return c.html("test"),c.hide(),$("body").append(c),c},open:function(a){return a.val()&&a.value(a.val()),gj.picker.widget.prototype.open.call(a,"colorpicker")}},gj.colorpicker.events={change:function(a){return a.triggerHandler("change")},select:function(a){return a.triggerHandler("select")},open:function(a){return a.triggerHandler("open")},close:function(a){return a.triggerHandler("close")}},gj.colorpicker.widget=function(a,b){var c=this,d=gj.colorpicker.methods;return c.value=function(a){return d.value(this,a)},c.destroy=function(){return gj.picker.widget.prototype.destroy.call(this,"colorpicker")},c.open=function(){return d.open(this)},c.close=function(){return gj.picker.widget.prototype.close.call(this,"colorpicker")},$.extend(a,c),"true"!==a.attr("data-colorpicker")&&d.init.call(a,b),a},gj.colorpicker.widget.prototype=new gj.picker.widget,gj.colorpicker.widget.constructor=gj.colorpicker.widget,function(a){a.fn.colorpicker=function(a){var b;if(this&&this.length){if("object"!=typeof a&&a){if(b=new gj.colorpicker.widget(this,null),b[a])return b[a].apply(this,Array.prototype.slice.call(arguments,1));throw"Method "+a+" does not exist."}return new gj.colorpicker.widget(this,a)}}}(jQuery);
gj.dialog.messages['pt-br'] = {
    Close: 'Fechar',
    DefaultTitle: 'Caixa de diálogo'
};
gj.grid.messages['pt-br'] = {
    First: 'Primeiro',
    Previous: 'Anterior',
    Next: 'Próximo',
    Last: 'Último',
    Page: 'Página',
    FirstPageTooltip: 'Primeira página',
    PreviousPageTooltip: 'Página anterior',
    NextPageTooltip: 'Próxima página',
    LastPageTooltip: 'Última Página',
    Refresh: 'Atualizar',
    Of: 'de',
    DisplayingRecords: 'Mostrando registros',
    RowsPerPage: 'Linhas por página:',
    Edit: 'Editar',
    Delete: 'Excluir',
    Update: 'Alterar',
    Cancel: 'Cancelar',
    NoRecordsFound: 'Nenhum registro encontrado.',
    Loading: 'Carregando...'
};
gj.editor.messages['pt-br'] = {
    bold: 'Negrito',
    italic: 'It\u00e1lico',
    strikethrough: 'Riscar',
    underline: 'Sublinhar',
    listBulleted: 'Lista n\u00e3o ordenada',
    listNumbered: 'Lista ordenada',
    indentDecrease: 'Diminuir recuo',
    indentIncrease: 'Aumentar recuo',
    alignLeft: 'Alinhar \u00e0 esquerda',
    alignCenter: 'Centralizar',
    alignRight: 'Alinhar \u00e0 direita',
    alignJustify: 'Justificar',
    undo: 'Desfazer',
    redo: 'Refazer'
};
gj.core.messages['pt-br'] = {
    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthShortNames: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    weekDaysMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
    weekDaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
    weekDays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
    am: 'AM',
    pm: 'PM',
    ok: 'OK',
    cancel: 'Cancelar',
    titleFormat: 'mmmm yyyy'
};
/* == jquery mousewheel plugin == Version: 3.1.13, License: MIT License (MIT) */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b),d=c["offsetParent"in a.fn?"offsetParent":"parent"]();return d.length||(d=a("body")),parseInt(d.css("fontSize"),10)||parseInt(c.css("fontSize"),10)||16},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b),d=c["offsetParent"in a.fn?"offsetParent":"parent"]();return d.length||(d=a("body")),parseInt(d.css("fontSize"),10)||parseInt(c.css("fontSize"),10)||16},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});
/* == malihu jquery custom scrollbar plugin == Version: 3.1.5, License: MIT License (MIT) */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"undefined"!=typeof module&&module.exports?module.exports=e:e(jQuery,window,document)}(function(e){!function(t){var o="function"==typeof define&&define.amd,a="undefined"!=typeof module&&module.exports,n="https:"==document.location.protocol?"https:":"http:",i="cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js";o||(a?require("jquery-mousewheel")(e):e.event.special.mousewheel||e("head").append(decodeURI("%3Cscript src="+n+"//"+i+"%3E%3C/script%3E"))),t()}(function(){var t,o="mCustomScrollbar",a="mCS",n=".mCustomScrollbar",i={setTop:0,setLeft:0,axis:"y",scrollbarPosition:"inside",scrollInertia:950,autoDraggerLength:!0,alwaysShowScrollbar:0,snapOffset:0,mouseWheel:{enable:!0,scrollAmount:"auto",axis:"y",deltaFactor:"auto",disableOver:["select","option","keygen","datalist","textarea"]},scrollButtons:{scrollType:"stepless",scrollAmount:"auto"},keyboard:{enable:!0,scrollType:"stepless",scrollAmount:"auto"},contentTouchScroll:25,documentTouchScroll:!0,advanced:{autoScrollOnFocus:"input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",updateOnContentResize:!0,updateOnImageLoad:"auto",autoUpdateTimeout:60},theme:"light",callbacks:{onTotalScrollOffset:0,onTotalScrollBackOffset:0,alwaysTriggerOffsets:!0}},r=0,l={},s=window.attachEvent&&!window.addEventListener?1:0,c=!1,d=["mCSB_dragger_onDrag","mCSB_scrollTools_onDrag","mCS_img_loaded","mCS_disabled","mCS_destroyed","mCS_no_scrollbar","mCS-autoHide","mCS-dir-rtl","mCS_no_scrollbar_y","mCS_no_scrollbar_x","mCS_y_hidden","mCS_x_hidden","mCSB_draggerContainer","mCSB_buttonUp","mCSB_buttonDown","mCSB_buttonLeft","mCSB_buttonRight"],u={init:function(t){var t=e.extend(!0,{},i,t),o=f.call(this);if(t.live){var s=t.liveSelector||this.selector||n,c=e(s);if("off"===t.live)return void m(s);l[s]=setTimeout(function(){c.mCustomScrollbar(t),"once"===t.live&&c.length&&m(s)},500)}else m(s);return t.setWidth=t.set_width?t.set_width:t.setWidth,t.setHeight=t.set_height?t.set_height:t.setHeight,t.axis=t.horizontalScroll?"x":p(t.axis),t.scrollInertia=t.scrollInertia>0&&t.scrollInertia<17?17:t.scrollInertia,"object"!=typeof t.mouseWheel&&1==t.mouseWheel&&(t.mouseWheel={enable:!0,scrollAmount:"auto",axis:"y",preventDefault:!1,deltaFactor:"auto",normalizeDelta:!1,invert:!1}),t.mouseWheel.scrollAmount=t.mouseWheelPixels?t.mouseWheelPixels:t.mouseWheel.scrollAmount,t.mouseWheel.normalizeDelta=t.advanced.normalizeMouseWheelDelta?t.advanced.normalizeMouseWheelDelta:t.mouseWheel.normalizeDelta,t.scrollButtons.scrollType=g(t.scrollButtons.scrollType),h(t),e(o).each(function(){var o=e(this);if(!o.data(a)){o.data(a,{idx:++r,opt:t,scrollRatio:{y:null,x:null},overflowed:null,contentReset:{y:null,x:null},bindEvents:!1,tweenRunning:!1,sequential:{},langDir:o.css("direction"),cbOffsets:null,trigger:null,poll:{size:{o:0,n:0},img:{o:0,n:0},change:{o:0,n:0}}});var n=o.data(a),i=n.opt,l=o.data("mcs-axis"),s=o.data("mcs-scrollbar-position"),c=o.data("mcs-theme");l&&(i.axis=l),s&&(i.scrollbarPosition=s),c&&(i.theme=c,h(i)),v.call(this),n&&i.callbacks.onCreate&&"function"==typeof i.callbacks.onCreate&&i.callbacks.onCreate.call(this),e("#mCSB_"+n.idx+"_container img:not(."+d[2]+")").addClass(d[2]),u.update.call(null,o)}})},update:function(t,o){var n=t||f.call(this);return e(n).each(function(){var t=e(this);if(t.data(a)){var n=t.data(a),i=n.opt,r=e("#mCSB_"+n.idx+"_container"),l=e("#mCSB_"+n.idx),s=[e("#mCSB_"+n.idx+"_dragger_vertical"),e("#mCSB_"+n.idx+"_dragger_horizontal")];if(!r.length)return;n.tweenRunning&&Q(t),o&&n&&i.callbacks.onBeforeUpdate&&"function"==typeof i.callbacks.onBeforeUpdate&&i.callbacks.onBeforeUpdate.call(this),t.hasClass(d[3])&&t.removeClass(d[3]),t.hasClass(d[4])&&t.removeClass(d[4]),l.css("max-height","none"),l.height()!==t.height()&&l.css("max-height",t.height()),_.call(this),"y"===i.axis||i.advanced.autoExpandHorizontalScroll||r.css("width",x(r)),n.overflowed=y.call(this),M.call(this),i.autoDraggerLength&&S.call(this),b.call(this),T.call(this);var c=[Math.abs(r[0].offsetTop),Math.abs(r[0].offsetLeft)];"x"!==i.axis&&(n.overflowed[0]?s[0].height()>s[0].parent().height()?B.call(this):(G(t,c[0].toString(),{dir:"y",dur:0,overwrite:"none"}),n.contentReset.y=null):(B.call(this),"y"===i.axis?k.call(this):"yx"===i.axis&&n.overflowed[1]&&G(t,c[1].toString(),{dir:"x",dur:0,overwrite:"none"}))),"y"!==i.axis&&(n.overflowed[1]?s[1].width()>s[1].parent().width()?B.call(this):(G(t,c[1].toString(),{dir:"x",dur:0,overwrite:"none"}),n.contentReset.x=null):(B.call(this),"x"===i.axis?k.call(this):"yx"===i.axis&&n.overflowed[0]&&G(t,c[0].toString(),{dir:"y",dur:0,overwrite:"none"}))),o&&n&&(2===o&&i.callbacks.onImageLoad&&"function"==typeof i.callbacks.onImageLoad?i.callbacks.onImageLoad.call(this):3===o&&i.callbacks.onSelectorChange&&"function"==typeof i.callbacks.onSelectorChange?i.callbacks.onSelectorChange.call(this):i.callbacks.onUpdate&&"function"==typeof i.callbacks.onUpdate&&i.callbacks.onUpdate.call(this)),N.call(this)}})},scrollTo:function(t,o){if("undefined"!=typeof t&&null!=t){var n=f.call(this);return e(n).each(function(){var n=e(this);if(n.data(a)){var i=n.data(a),r=i.opt,l={trigger:"external",scrollInertia:r.scrollInertia,scrollEasing:"mcsEaseInOut",moveDragger:!1,timeout:60,callbacks:!0,onStart:!0,onUpdate:!0,onComplete:!0},s=e.extend(!0,{},l,o),c=Y.call(this,t),d=s.scrollInertia>0&&s.scrollInertia<17?17:s.scrollInertia;c[0]=X.call(this,c[0],"y"),c[1]=X.call(this,c[1],"x"),s.moveDragger&&(c[0]*=i.scrollRatio.y,c[1]*=i.scrollRatio.x),s.dur=ne()?0:d,setTimeout(function(){null!==c[0]&&"undefined"!=typeof c[0]&&"x"!==r.axis&&i.overflowed[0]&&(s.dir="y",s.overwrite="all",G(n,c[0].toString(),s)),null!==c[1]&&"undefined"!=typeof c[1]&&"y"!==r.axis&&i.overflowed[1]&&(s.dir="x",s.overwrite="none",G(n,c[1].toString(),s))},s.timeout)}})}},stop:function(){var t=f.call(this);return e(t).each(function(){var t=e(this);t.data(a)&&Q(t)})},disable:function(t){var o=f.call(this);return e(o).each(function(){var o=e(this);if(o.data(a)){o.data(a);N.call(this,"remove"),k.call(this),t&&B.call(this),M.call(this,!0),o.addClass(d[3])}})},destroy:function(){var t=f.call(this);return e(t).each(function(){var n=e(this);if(n.data(a)){var i=n.data(a),r=i.opt,l=e("#mCSB_"+i.idx),s=e("#mCSB_"+i.idx+"_container"),c=e(".mCSB_"+i.idx+"_scrollbar");r.live&&m(r.liveSelector||e(t).selector),N.call(this,"remove"),k.call(this),B.call(this),n.removeData(a),$(this,"mcs"),c.remove(),s.find("img."+d[2]).removeClass(d[2]),l.replaceWith(s.contents()),n.removeClass(o+" _"+a+"_"+i.idx+" "+d[6]+" "+d[7]+" "+d[5]+" "+d[3]).addClass(d[4])}})}},f=function(){return"object"!=typeof e(this)||e(this).length<1?n:this},h=function(t){var o=["rounded","rounded-dark","rounded-dots","rounded-dots-dark"],a=["rounded-dots","rounded-dots-dark","3d","3d-dark","3d-thick","3d-thick-dark","inset","inset-dark","inset-2","inset-2-dark","inset-3","inset-3-dark"],n=["minimal","minimal-dark"],i=["minimal","minimal-dark"],r=["minimal","minimal-dark"];t.autoDraggerLength=e.inArray(t.theme,o)>-1?!1:t.autoDraggerLength,t.autoExpandScrollbar=e.inArray(t.theme,a)>-1?!1:t.autoExpandScrollbar,t.scrollButtons.enable=e.inArray(t.theme,n)>-1?!1:t.scrollButtons.enable,t.autoHideScrollbar=e.inArray(t.theme,i)>-1?!0:t.autoHideScrollbar,t.scrollbarPosition=e.inArray(t.theme,r)>-1?"outside":t.scrollbarPosition},m=function(e){l[e]&&(clearTimeout(l[e]),$(l,e))},p=function(e){return"yx"===e||"xy"===e||"auto"===e?"yx":"x"===e||"horizontal"===e?"x":"y"},g=function(e){return"stepped"===e||"pixels"===e||"step"===e||"click"===e?"stepped":"stepless"},v=function(){var t=e(this),n=t.data(a),i=n.opt,r=i.autoExpandScrollbar?" "+d[1]+"_expand":"",l=["<div id='mCSB_"+n.idx+"_scrollbar_vertical' class='mCSB_scrollTools mCSB_"+n.idx+"_scrollbar mCS-"+i.theme+" mCSB_scrollTools_vertical"+r+"'><div class='"+d[12]+"'><div id='mCSB_"+n.idx+"_dragger_vertical' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>","<div id='mCSB_"+n.idx+"_scrollbar_horizontal' class='mCSB_scrollTools mCSB_"+n.idx+"_scrollbar mCS-"+i.theme+" mCSB_scrollTools_horizontal"+r+"'><div class='"+d[12]+"'><div id='mCSB_"+n.idx+"_dragger_horizontal' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],s="yx"===i.axis?"mCSB_vertical_horizontal":"x"===i.axis?"mCSB_horizontal":"mCSB_vertical",c="yx"===i.axis?l[0]+l[1]:"x"===i.axis?l[1]:l[0],u="yx"===i.axis?"<div id='mCSB_"+n.idx+"_container_wrapper' class='mCSB_container_wrapper' />":"",f=i.autoHideScrollbar?" "+d[6]:"",h="x"!==i.axis&&"rtl"===n.langDir?" "+d[7]:"";i.setWidth&&t.css("width",i.setWidth),i.setHeight&&t.css("height",i.setHeight),i.setLeft="y"!==i.axis&&"rtl"===n.langDir?"989999px":i.setLeft,t.addClass(o+" _"+a+"_"+n.idx+f+h).wrapInner("<div id='mCSB_"+n.idx+"' class='mCustomScrollBox mCS-"+i.theme+" "+s+"'><div id='mCSB_"+n.idx+"_container' class='mCSB_container' style='position:relative; top:"+i.setTop+"; left:"+i.setLeft+";' dir='"+n.langDir+"' /></div>");var m=e("#mCSB_"+n.idx),p=e("#mCSB_"+n.idx+"_container");"y"===i.axis||i.advanced.autoExpandHorizontalScroll||p.css("width",x(p)),"outside"===i.scrollbarPosition?("static"===t.css("position")&&t.css("position","relative"),t.css("overflow","visible"),m.addClass("mCSB_outside").after(c)):(m.addClass("mCSB_inside").append(c),p.wrap(u)),w.call(this);var g=[e("#mCSB_"+n.idx+"_dragger_vertical"),e("#mCSB_"+n.idx+"_dragger_horizontal")];g[0].css("min-height",g[0].height()),g[1].css("min-width",g[1].width())},x=function(t){var o=[t[0].scrollWidth,Math.max.apply(Math,t.children().map(function(){return e(this).outerWidth(!0)}).get())],a=t.parent().width();return o[0]>a?o[0]:o[1]>a?o[1]:"100%"},_=function(){var t=e(this),o=t.data(a),n=o.opt,i=e("#mCSB_"+o.idx+"_container");if(n.advanced.autoExpandHorizontalScroll&&"y"!==n.axis){i.css({width:"auto","min-width":0,"overflow-x":"scroll"});var r=Math.ceil(i[0].scrollWidth);3===n.advanced.autoExpandHorizontalScroll||2!==n.advanced.autoExpandHorizontalScroll&&r>i.parent().width()?i.css({width:r,"min-width":"100%","overflow-x":"inherit"}):i.css({"overflow-x":"inherit",position:"absolute"}).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({width:Math.ceil(i[0].getBoundingClientRect().right+.4)-Math.floor(i[0].getBoundingClientRect().left),"min-width":"100%",position:"relative"}).unwrap()}},w=function(){var t=e(this),o=t.data(a),n=o.opt,i=e(".mCSB_"+o.idx+"_scrollbar:first"),r=oe(n.scrollButtons.tabindex)?"tabindex='"+n.scrollButtons.tabindex+"'":"",l=["<a href='#' class='"+d[13]+"' "+r+" />","<a href='#' class='"+d[14]+"' "+r+" />","<a href='#' class='"+d[15]+"' "+r+" />","<a href='#' class='"+d[16]+"' "+r+" />"],s=["x"===n.axis?l[2]:l[0],"x"===n.axis?l[3]:l[1],l[2],l[3]];n.scrollButtons.enable&&i.prepend(s[0]).append(s[1]).next(".mCSB_scrollTools").prepend(s[2]).append(s[3])},S=function(){var t=e(this),o=t.data(a),n=e("#mCSB_"+o.idx),i=e("#mCSB_"+o.idx+"_container"),r=[e("#mCSB_"+o.idx+"_dragger_vertical"),e("#mCSB_"+o.idx+"_dragger_horizontal")],l=[n.height()/i.outerHeight(!1),n.width()/i.outerWidth(!1)],c=[parseInt(r[0].css("min-height")),Math.round(l[0]*r[0].parent().height()),parseInt(r[1].css("min-width")),Math.round(l[1]*r[1].parent().width())],d=s&&c[1]<c[0]?c[0]:c[1],u=s&&c[3]<c[2]?c[2]:c[3];r[0].css({height:d,"max-height":r[0].parent().height()-10}).find(".mCSB_dragger_bar").css({"line-height":c[0]+"px"}),r[1].css({width:u,"max-width":r[1].parent().width()-10})},b=function(){var t=e(this),o=t.data(a),n=e("#mCSB_"+o.idx),i=e("#mCSB_"+o.idx+"_container"),r=[e("#mCSB_"+o.idx+"_dragger_vertical"),e("#mCSB_"+o.idx+"_dragger_horizontal")],l=[i.outerHeight(!1)-n.height(),i.outerWidth(!1)-n.width()],s=[l[0]/(r[0].parent().height()-r[0].height()),l[1]/(r[1].parent().width()-r[1].width())];o.scrollRatio={y:s[0],x:s[1]}},C=function(e,t,o){var a=o?d[0]+"_expanded":"",n=e.closest(".mCSB_scrollTools");"active"===t?(e.toggleClass(d[0]+" "+a),n.toggleClass(d[1]),e[0]._draggable=e[0]._draggable?0:1):e[0]._draggable||("hide"===t?(e.removeClass(d[0]),n.removeClass(d[1])):(e.addClass(d[0]),n.addClass(d[1])))},y=function(){var t=e(this),o=t.data(a),n=e("#mCSB_"+o.idx),i=e("#mCSB_"+o.idx+"_container"),r=null==o.overflowed?i.height():i.outerHeight(!1),l=null==o.overflowed?i.width():i.outerWidth(!1),s=i[0].scrollHeight,c=i[0].scrollWidth;return s>r&&(r=s),c>l&&(l=c),[r>n.height(),l>n.width()]},B=function(){var t=e(this),o=t.data(a),n=o.opt,i=e("#mCSB_"+o.idx),r=e("#mCSB_"+o.idx+"_container"),l=[e("#mCSB_"+o.idx+"_dragger_vertical"),e("#mCSB_"+o.idx+"_dragger_horizontal")];if(Q(t),("x"!==n.axis&&!o.overflowed[0]||"y"===n.axis&&o.overflowed[0])&&(l[0].add(r).css("top",0),G(t,"_resetY")),"y"!==n.axis&&!o.overflowed[1]||"x"===n.axis&&o.overflowed[1]){var s=dx=0;"rtl"===o.langDir&&(s=i.width()-r.outerWidth(!1),dx=Math.abs(s/o.scrollRatio.x)),r.css("left",s),l[1].css("left",dx),G(t,"_resetX")}},T=function(){function t(){r=setTimeout(function(){e.event.special.mousewheel?(clearTimeout(r),W.call(o[0])):t()},100)}var o=e(this),n=o.data(a),i=n.opt;if(!n.bindEvents){if(I.call(this),i.contentTouchScroll&&D.call(this),E.call(this),i.mouseWheel.enable){var r;t()}P.call(this),U.call(this),i.advanced.autoScrollOnFocus&&H.call(this),i.scrollButtons.enable&&F.call(this),i.keyboard.enable&&q.call(this),n.bindEvents=!0}},k=function(){var t=e(this),o=t.data(a),n=o.opt,i=a+"_"+o.idx,r=".mCSB_"+o.idx+"_scrollbar",l=e("#mCSB_"+o.idx+",#mCSB_"+o.idx+"_container,#mCSB_"+o.idx+"_container_wrapper,"+r+" ."+d[12]+",#mCSB_"+o.idx+"_dragger_vertical,#mCSB_"+o.idx+"_dragger_horizontal,"+r+">a"),s=e("#mCSB_"+o.idx+"_container");n.advanced.releaseDraggableSelectors&&l.add(e(n.advanced.releaseDraggableSelectors)),n.advanced.extraDraggableSelectors&&l.add(e(n.advanced.extraDraggableSelectors)),o.bindEvents&&(e(document).add(e(!A()||top.document)).unbind("."+i),l.each(function(){e(this).unbind("."+i)}),clearTimeout(t[0]._focusTimeout),$(t[0],"_focusTimeout"),clearTimeout(o.sequential.step),$(o.sequential,"step"),clearTimeout(s[0].onCompleteTimeout),$(s[0],"onCompleteTimeout"),o.bindEvents=!1)},M=function(t){var o=e(this),n=o.data(a),i=n.opt,r=e("#mCSB_"+n.idx+"_container_wrapper"),l=r.length?r:e("#mCSB_"+n.idx+"_container"),s=[e("#mCSB_"+n.idx+"_scrollbar_vertical"),e("#mCSB_"+n.idx+"_scrollbar_horizontal")],c=[s[0].find(".mCSB_dragger"),s[1].find(".mCSB_dragger")];"x"!==i.axis&&(n.overflowed[0]&&!t?(s[0].add(c[0]).add(s[0].children("a")).css("display","block"),l.removeClass(d[8]+" "+d[10])):(i.alwaysShowScrollbar?(2!==i.alwaysShowScrollbar&&c[0].css("display","none"),l.removeClass(d[10])):(s[0].css("display","none"),l.addClass(d[10])),l.addClass(d[8]))),"y"!==i.axis&&(n.overflowed[1]&&!t?(s[1].add(c[1]).add(s[1].children("a")).css("display","block"),l.removeClass(d[9]+" "+d[11])):(i.alwaysShowScrollbar?(2!==i.alwaysShowScrollbar&&c[1].css("display","none"),l.removeClass(d[11])):(s[1].css("display","none"),l.addClass(d[11])),l.addClass(d[9]))),n.overflowed[0]||n.overflowed[1]?o.removeClass(d[5]):o.addClass(d[5])},O=function(t){var o=t.type,a=t.target.ownerDocument!==document&&null!==frameElement?[e(frameElement).offset().top,e(frameElement).offset().left]:null,n=A()&&t.target.ownerDocument!==top.document&&null!==frameElement?[e(t.view.frameElement).offset().top,e(t.view.frameElement).offset().left]:[0,0];switch(o){case"pointerdown":case"MSPointerDown":case"pointermove":case"MSPointerMove":case"pointerup":case"MSPointerUp":return a?[t.originalEvent.pageY-a[0]+n[0],t.originalEvent.pageX-a[1]+n[1],!1]:[t.originalEvent.pageY,t.originalEvent.pageX,!1];case"touchstart":case"touchmove":case"touchend":var i=t.originalEvent.touches[0]||t.originalEvent.changedTouches[0],r=t.originalEvent.touches.length||t.originalEvent.changedTouches.length;return t.target.ownerDocument!==document?[i.screenY,i.screenX,r>1]:[i.pageY,i.pageX,r>1];default:return a?[t.pageY-a[0]+n[0],t.pageX-a[1]+n[1],!1]:[t.pageY,t.pageX,!1]}},I=function(){function t(e,t,a,n){if(h[0].idleTimer=d.scrollInertia<233?250:0,o.attr("id")===f[1])var i="x",s=(o[0].offsetLeft-t+n)*l.scrollRatio.x;else var i="y",s=(o[0].offsetTop-e+a)*l.scrollRatio.y;G(r,s.toString(),{dir:i,drag:!0})}var o,n,i,r=e(this),l=r.data(a),d=l.opt,u=a+"_"+l.idx,f=["mCSB_"+l.idx+"_dragger_vertical","mCSB_"+l.idx+"_dragger_horizontal"],h=e("#mCSB_"+l.idx+"_container"),m=e("#"+f[0]+",#"+f[1]),p=d.advanced.releaseDraggableSelectors?m.add(e(d.advanced.releaseDraggableSelectors)):m,g=d.advanced.extraDraggableSelectors?e(!A()||top.document).add(e(d.advanced.extraDraggableSelectors)):e(!A()||top.document);m.bind("contextmenu."+u,function(e){e.preventDefault()}).bind("mousedown."+u+" touchstart."+u+" pointerdown."+u+" MSPointerDown."+u,function(t){if(t.stopImmediatePropagation(),t.preventDefault(),ee(t)){c=!0,s&&(document.onselectstart=function(){return!1}),L.call(h,!1),Q(r),o=e(this);var a=o.offset(),l=O(t)[0]-a.top,u=O(t)[1]-a.left,f=o.height()+a.top,m=o.width()+a.left;f>l&&l>0&&m>u&&u>0&&(n=l,i=u),C(o,"active",d.autoExpandScrollbar)}}).bind("touchmove."+u,function(e){e.stopImmediatePropagation(),e.preventDefault();var a=o.offset(),r=O(e)[0]-a.top,l=O(e)[1]-a.left;t(n,i,r,l)}),e(document).add(g).bind("mousemove."+u+" pointermove."+u+" MSPointerMove."+u,function(e){if(o){var a=o.offset(),r=O(e)[0]-a.top,l=O(e)[1]-a.left;if(n===r&&i===l)return;t(n,i,r,l)}}).add(p).bind("mouseup."+u+" touchend."+u+" pointerup."+u+" MSPointerUp."+u,function(){o&&(C(o,"active",d.autoExpandScrollbar),o=null),c=!1,s&&(document.onselectstart=null),L.call(h,!0)})},D=function(){function o(e){if(!te(e)||c||O(e)[2])return void(t=0);t=1,b=0,C=0,d=1,y.removeClass("mCS_touch_action");var o=I.offset();u=O(e)[0]-o.top,f=O(e)[1]-o.left,z=[O(e)[0],O(e)[1]]}function n(e){if(te(e)&&!c&&!O(e)[2]&&(T.documentTouchScroll||e.preventDefault(),e.stopImmediatePropagation(),(!C||b)&&d)){g=K();var t=M.offset(),o=O(e)[0]-t.top,a=O(e)[1]-t.left,n="mcsLinearOut";if(E.push(o),W.push(a),z[2]=Math.abs(O(e)[0]-z[0]),z[3]=Math.abs(O(e)[1]-z[1]),B.overflowed[0])var i=D[0].parent().height()-D[0].height(),r=u-o>0&&o-u>-(i*B.scrollRatio.y)&&(2*z[3]<z[2]||"yx"===T.axis);if(B.overflowed[1])var l=D[1].parent().width()-D[1].width(),h=f-a>0&&a-f>-(l*B.scrollRatio.x)&&(2*z[2]<z[3]||"yx"===T.axis);r||h?(U||e.preventDefault(),b=1):(C=1,y.addClass("mCS_touch_action")),U&&e.preventDefault(),w="yx"===T.axis?[u-o,f-a]:"x"===T.axis?[null,f-a]:[u-o,null],I[0].idleTimer=250,B.overflowed[0]&&s(w[0],R,n,"y","all",!0),B.overflowed[1]&&s(w[1],R,n,"x",L,!0)}}function i(e){if(!te(e)||c||O(e)[2])return void(t=0);t=1,e.stopImmediatePropagation(),Q(y),p=K();var o=M.offset();h=O(e)[0]-o.top,m=O(e)[1]-o.left,E=[],W=[]}function r(e){if(te(e)&&!c&&!O(e)[2]){d=0,e.stopImmediatePropagation(),b=0,C=0,v=K();var t=M.offset(),o=O(e)[0]-t.top,a=O(e)[1]-t.left;if(!(v-g>30)){_=1e3/(v-p);var n="mcsEaseOut",i=2.5>_,r=i?[E[E.length-2],W[W.length-2]]:[0,0];x=i?[o-r[0],a-r[1]]:[o-h,a-m];var u=[Math.abs(x[0]),Math.abs(x[1])];_=i?[Math.abs(x[0]/4),Math.abs(x[1]/4)]:[_,_];var f=[Math.abs(I[0].offsetTop)-x[0]*l(u[0]/_[0],_[0]),Math.abs(I[0].offsetLeft)-x[1]*l(u[1]/_[1],_[1])];w="yx"===T.axis?[f[0],f[1]]:"x"===T.axis?[null,f[1]]:[f[0],null],S=[4*u[0]+T.scrollInertia,4*u[1]+T.scrollInertia];var y=parseInt(T.contentTouchScroll)||0;w[0]=u[0]>y?w[0]:0,w[1]=u[1]>y?w[1]:0,B.overflowed[0]&&s(w[0],S[0],n,"y",L,!1),B.overflowed[1]&&s(w[1],S[1],n,"x",L,!1)}}}function l(e,t){var o=[1.5*t,2*t,t/1.5,t/2];return e>90?t>4?o[0]:o[3]:e>60?t>3?o[3]:o[2]:e>30?t>8?o[1]:t>6?o[0]:t>4?t:o[2]:t>8?t:o[3]}function s(e,t,o,a,n,i){e&&G(y,e.toString(),{dur:t,scrollEasing:o,dir:a,overwrite:n,drag:i})}var d,u,f,h,m,p,g,v,x,_,w,S,b,C,y=e(this),B=y.data(a),T=B.opt,k=a+"_"+B.idx,M=e("#mCSB_"+B.idx),I=e("#mCSB_"+B.idx+"_container"),D=[e("#mCSB_"+B.idx+"_dragger_vertical"),e("#mCSB_"+B.idx+"_dragger_horizontal")],E=[],W=[],R=0,L="yx"===T.axis?"none":"all",z=[],P=I.find("iframe"),H=["touchstart."+k+" pointerdown."+k+" MSPointerDown."+k,"touchmove."+k+" pointermove."+k+" MSPointerMove."+k,"touchend."+k+" pointerup."+k+" MSPointerUp."+k],U=void 0!==document.body.style.touchAction&&""!==document.body.style.touchAction;I.bind(H[0],function(e){o(e)}).bind(H[1],function(e){n(e)}),M.bind(H[0],function(e){i(e)}).bind(H[2],function(e){r(e)}),P.length&&P.each(function(){e(this).bind("load",function(){A(this)&&e(this.contentDocument||this.contentWindow.document).bind(H[0],function(e){o(e),i(e)}).bind(H[1],function(e){n(e)}).bind(H[2],function(e){r(e)})})})},E=function(){function o(){return window.getSelection?window.getSelection().toString():document.selection&&"Control"!=document.selection.type?document.selection.createRange().text:0}function n(e,t,o){d.type=o&&i?"stepped":"stepless",d.scrollAmount=10,j(r,e,t,"mcsLinearOut",o?60:null)}var i,r=e(this),l=r.data(a),s=l.opt,d=l.sequential,u=a+"_"+l.idx,f=e("#mCSB_"+l.idx+"_container"),h=f.parent();f.bind("mousedown."+u,function(){t||i||(i=1,c=!0)}).add(document).bind("mousemove."+u,function(e){if(!t&&i&&o()){var a=f.offset(),r=O(e)[0]-a.top+f[0].offsetTop,c=O(e)[1]-a.left+f[0].offsetLeft;r>0&&r<h.height()&&c>0&&c<h.width()?d.step&&n("off",null,"stepped"):("x"!==s.axis&&l.overflowed[0]&&(0>r?n("on",38):r>h.height()&&n("on",40)),"y"!==s.axis&&l.overflowed[1]&&(0>c?n("on",37):c>h.width()&&n("on",39)))}}).bind("mouseup."+u+" dragend."+u,function(){t||(i&&(i=0,n("off",null)),c=!1)})},W=function(){function t(t,a){if(Q(o),!z(o,t.target)){var r="auto"!==i.mouseWheel.deltaFactor?parseInt(i.mouseWheel.deltaFactor):s&&t.deltaFactor<100?100:t.deltaFactor||100,d=i.scrollInertia;if("x"===i.axis||"x"===i.mouseWheel.axis)var u="x",f=[Math.round(r*n.scrollRatio.x),parseInt(i.mouseWheel.scrollAmount)],h="auto"!==i.mouseWheel.scrollAmount?f[1]:f[0]>=l.width()?.9*l.width():f[0],m=Math.abs(e("#mCSB_"+n.idx+"_container")[0].offsetLeft),p=c[1][0].offsetLeft,g=c[1].parent().width()-c[1].width(),v="y"===i.mouseWheel.axis?t.deltaY||a:t.deltaX;else var u="y",f=[Math.round(r*n.scrollRatio.y),parseInt(i.mouseWheel.scrollAmount)],h="auto"!==i.mouseWheel.scrollAmount?f[1]:f[0]>=l.height()?.9*l.height():f[0],m=Math.abs(e("#mCSB_"+n.idx+"_container")[0].offsetTop),p=c[0][0].offsetTop,g=c[0].parent().height()-c[0].height(),v=t.deltaY||a;"y"===u&&!n.overflowed[0]||"x"===u&&!n.overflowed[1]||((i.mouseWheel.invert||t.webkitDirectionInvertedFromDevice)&&(v=-v),i.mouseWheel.normalizeDelta&&(v=0>v?-1:1),(v>0&&0!==p||0>v&&p!==g||i.mouseWheel.preventDefault)&&(t.stopImmediatePropagation(),t.preventDefault()),t.deltaFactor<5&&!i.mouseWheel.normalizeDelta&&(h=t.deltaFactor,d=17),G(o,(m-v*h).toString(),{dir:u,dur:d}))}}if(e(this).data(a)){var o=e(this),n=o.data(a),i=n.opt,r=a+"_"+n.idx,l=e("#mCSB_"+n.idx),c=[e("#mCSB_"+n.idx+"_dragger_vertical"),e("#mCSB_"+n.idx+"_dragger_horizontal")],d=e("#mCSB_"+n.idx+"_container").find("iframe");d.length&&d.each(function(){e(this).bind("load",function(){A(this)&&e(this.contentDocument||this.contentWindow.document).bind("mousewheel."+r,function(e,o){t(e,o)})})}),l.bind("mousewheel."+r,function(e,o){t(e,o)})}},R=new Object,A=function(t){var o=!1,a=!1,n=null;if(void 0===t?a="#empty":void 0!==e(t).attr("id")&&(a=e(t).attr("id")),a!==!1&&void 0!==R[a])return R[a];if(t){try{var i=t.contentDocument||t.contentWindow.document;n=i.body.innerHTML}catch(r){}o=null!==n}else{try{var i=top.document;n=i.body.innerHTML}catch(r){}o=null!==n}return a!==!1&&(R[a]=o),o},L=function(e){var t=this.find("iframe");if(t.length){var o=e?"auto":"none";t.css("pointer-events",o)}},z=function(t,o){var n=o.nodeName.toLowerCase(),i=t.data(a).opt.mouseWheel.disableOver,r=["select","textarea"];return e.inArray(n,i)>-1&&!(e.inArray(n,r)>-1&&!e(o).is(":focus"))},P=function(){var t,o=e(this),n=o.data(a),i=a+"_"+n.idx,r=e("#mCSB_"+n.idx+"_container"),l=r.parent(),s=e(".mCSB_"+n.idx+"_scrollbar ."+d[12]);s.bind("mousedown."+i+" touchstart."+i+" pointerdown."+i+" MSPointerDown."+i,function(o){c=!0,e(o.target).hasClass("mCSB_dragger")||(t=1)}).bind("touchend."+i+" pointerup."+i+" MSPointerUp."+i,function(){c=!1}).bind("click."+i,function(a){if(t&&(t=0,e(a.target).hasClass(d[12])||e(a.target).hasClass("mCSB_draggerRail"))){Q(o);var i=e(this),s=i.find(".mCSB_dragger");if(i.parent(".mCSB_scrollTools_horizontal").length>0){if(!n.overflowed[1])return;var c="x",u=a.pageX>s.offset().left?-1:1,f=Math.abs(r[0].offsetLeft)-u*(.9*l.width())}else{if(!n.overflowed[0])return;var c="y",u=a.pageY>s.offset().top?-1:1,f=Math.abs(r[0].offsetTop)-u*(.9*l.height())}G(o,f.toString(),{dir:c,scrollEasing:"mcsEaseInOut"})}})},H=function(){var t=e(this),o=t.data(a),n=o.opt,i=a+"_"+o.idx,r=e("#mCSB_"+o.idx+"_container"),l=r.parent();r.bind("focusin."+i,function(){var o=e(document.activeElement),a=r.find(".mCustomScrollBox").length,i=0;o.is(n.advanced.autoScrollOnFocus)&&(Q(t),clearTimeout(t[0]._focusTimeout),t[0]._focusTimer=a?(i+17)*a:0,t[0]._focusTimeout=setTimeout(function(){var e=[ae(o)[0],ae(o)[1]],a=[r[0].offsetTop,r[0].offsetLeft],s=[a[0]+e[0]>=0&&a[0]+e[0]<l.height()-o.outerHeight(!1),a[1]+e[1]>=0&&a[0]+e[1]<l.width()-o.outerWidth(!1)],c="yx"!==n.axis||s[0]||s[1]?"all":"none";"x"===n.axis||s[0]||G(t,e[0].toString(),{dir:"y",scrollEasing:"mcsEaseInOut",overwrite:c,dur:i}),"y"===n.axis||s[1]||G(t,e[1].toString(),{dir:"x",scrollEasing:"mcsEaseInOut",overwrite:c,dur:i})},t[0]._focusTimer))})},U=function(){var t=e(this),o=t.data(a),n=a+"_"+o.idx,i=e("#mCSB_"+o.idx+"_container").parent();i.bind("scroll."+n,function(){0===i.scrollTop()&&0===i.scrollLeft()||e(".mCSB_"+o.idx+"_scrollbar").css("visibility","hidden")})},F=function(){var t=e(this),o=t.data(a),n=o.opt,i=o.sequential,r=a+"_"+o.idx,l=".mCSB_"+o.idx+"_scrollbar",s=e(l+">a");s.bind("contextmenu."+r,function(e){e.preventDefault()}).bind("mousedown."+r+" touchstart."+r+" pointerdown."+r+" MSPointerDown."+r+" mouseup."+r+" touchend."+r+" pointerup."+r+" MSPointerUp."+r+" mouseout."+r+" pointerout."+r+" MSPointerOut."+r+" click."+r,function(a){function r(e,o){i.scrollAmount=n.scrollButtons.scrollAmount,j(t,e,o)}if(a.preventDefault(),ee(a)){var l=e(this).attr("class");switch(i.type=n.scrollButtons.scrollType,a.type){case"mousedown":case"touchstart":case"pointerdown":case"MSPointerDown":if("stepped"===i.type)return;c=!0,o.tweenRunning=!1,r("on",l);break;case"mouseup":case"touchend":case"pointerup":case"MSPointerUp":case"mouseout":case"pointerout":case"MSPointerOut":if("stepped"===i.type)return;c=!1,i.dir&&r("off",l);break;case"click":if("stepped"!==i.type||o.tweenRunning)return;r("on",l)}}})},q=function(){function t(t){function a(e,t){r.type=i.keyboard.scrollType,r.scrollAmount=i.keyboard.scrollAmount,"stepped"===r.type&&n.tweenRunning||j(o,e,t)}switch(t.type){case"blur":n.tweenRunning&&r.dir&&a("off",null);break;case"keydown":case"keyup":var l=t.keyCode?t.keyCode:t.which,s="on";if("x"!==i.axis&&(38===l||40===l)||"y"!==i.axis&&(37===l||39===l)){if((38===l||40===l)&&!n.overflowed[0]||(37===l||39===l)&&!n.overflowed[1])return;"keyup"===t.type&&(s="off"),e(document.activeElement).is(u)||(t.preventDefault(),t.stopImmediatePropagation(),a(s,l))}else if(33===l||34===l){if((n.overflowed[0]||n.overflowed[1])&&(t.preventDefault(),t.stopImmediatePropagation()),"keyup"===t.type){Q(o);var f=34===l?-1:1;if("x"===i.axis||"yx"===i.axis&&n.overflowed[1]&&!n.overflowed[0])var h="x",m=Math.abs(c[0].offsetLeft)-f*(.9*d.width());else var h="y",m=Math.abs(c[0].offsetTop)-f*(.9*d.height());G(o,m.toString(),{dir:h,scrollEasing:"mcsEaseInOut"})}}else if((35===l||36===l)&&!e(document.activeElement).is(u)&&((n.overflowed[0]||n.overflowed[1])&&(t.preventDefault(),t.stopImmediatePropagation()),"keyup"===t.type)){if("x"===i.axis||"yx"===i.axis&&n.overflowed[1]&&!n.overflowed[0])var h="x",m=35===l?Math.abs(d.width()-c.outerWidth(!1)):0;else var h="y",m=35===l?Math.abs(d.height()-c.outerHeight(!1)):0;G(o,m.toString(),{dir:h,scrollEasing:"mcsEaseInOut"})}}}var o=e(this),n=o.data(a),i=n.opt,r=n.sequential,l=a+"_"+n.idx,s=e("#mCSB_"+n.idx),c=e("#mCSB_"+n.idx+"_container"),d=c.parent(),u="input,textarea,select,datalist,keygen,[contenteditable='true']",f=c.find("iframe"),h=["blur."+l+" keydown."+l+" keyup."+l];f.length&&f.each(function(){e(this).bind("load",function(){A(this)&&e(this.contentDocument||this.contentWindow.document).bind(h[0],function(e){t(e)})})}),s.attr("tabindex","0").bind(h[0],function(e){t(e)})},j=function(t,o,n,i,r){function l(e){u.snapAmount&&(f.scrollAmount=u.snapAmount instanceof Array?"x"===f.dir[0]?u.snapAmount[1]:u.snapAmount[0]:u.snapAmount);var o="stepped"!==f.type,a=r?r:e?o?p/1.5:g:1e3/60,n=e?o?7.5:40:2.5,s=[Math.abs(h[0].offsetTop),Math.abs(h[0].offsetLeft)],d=[c.scrollRatio.y>10?10:c.scrollRatio.y,c.scrollRatio.x>10?10:c.scrollRatio.x],m="x"===f.dir[0]?s[1]+f.dir[1]*(d[1]*n):s[0]+f.dir[1]*(d[0]*n),v="x"===f.dir[0]?s[1]+f.dir[1]*parseInt(f.scrollAmount):s[0]+f.dir[1]*parseInt(f.scrollAmount),x="auto"!==f.scrollAmount?v:m,_=i?i:e?o?"mcsLinearOut":"mcsEaseInOut":"mcsLinear",w=!!e;return e&&17>a&&(x="x"===f.dir[0]?s[1]:s[0]),G(t,x.toString(),{dir:f.dir[0],scrollEasing:_,dur:a,onComplete:w}),e?void(f.dir=!1):(clearTimeout(f.step),void(f.step=setTimeout(function(){l()},a)))}function s(){clearTimeout(f.step),$(f,"step"),Q(t)}var c=t.data(a),u=c.opt,f=c.sequential,h=e("#mCSB_"+c.idx+"_container"),m="stepped"===f.type,p=u.scrollInertia<26?26:u.scrollInertia,g=u.scrollInertia<1?17:u.scrollInertia;switch(o){case"on":if(f.dir=[n===d[16]||n===d[15]||39===n||37===n?"x":"y",n===d[13]||n===d[15]||38===n||37===n?-1:1],Q(t),oe(n)&&"stepped"===f.type)return;l(m);break;case"off":s(),(m||c.tweenRunning&&f.dir)&&l(!0)}},Y=function(t){var o=e(this).data(a).opt,n=[];return"function"==typeof t&&(t=t()),t instanceof Array?n=t.length>1?[t[0],t[1]]:"x"===o.axis?[null,t[0]]:[t[0],null]:(n[0]=t.y?t.y:t.x||"x"===o.axis?null:t,n[1]=t.x?t.x:t.y||"y"===o.axis?null:t),"function"==typeof n[0]&&(n[0]=n[0]()),"function"==typeof n[1]&&(n[1]=n[1]()),n},X=function(t,o){if(null!=t&&"undefined"!=typeof t){var n=e(this),i=n.data(a),r=i.opt,l=e("#mCSB_"+i.idx+"_container"),s=l.parent(),c=typeof t;o||(o="x"===r.axis?"x":"y");var d="x"===o?l.outerWidth(!1)-s.width():l.outerHeight(!1)-s.height(),f="x"===o?l[0].offsetLeft:l[0].offsetTop,h="x"===o?"left":"top";switch(c){case"function":return t();case"object":var m=t.jquery?t:e(t);if(!m.length)return;return"x"===o?ae(m)[1]:ae(m)[0];case"string":case"number":if(oe(t))return Math.abs(t);if(-1!==t.indexOf("%"))return Math.abs(d*parseInt(t)/100);if(-1!==t.indexOf("-="))return Math.abs(f-parseInt(t.split("-=")[1]));if(-1!==t.indexOf("+=")){var p=f+parseInt(t.split("+=")[1]);return p>=0?0:Math.abs(p)}if(-1!==t.indexOf("px")&&oe(t.split("px")[0]))return Math.abs(t.split("px")[0]);if("top"===t||"left"===t)return 0;if("bottom"===t)return Math.abs(s.height()-l.outerHeight(!1));if("right"===t)return Math.abs(s.width()-l.outerWidth(!1));if("first"===t||"last"===t){var m=l.find(":"+t);return"x"===o?ae(m)[1]:ae(m)[0]}return e(t).length?"x"===o?ae(e(t))[1]:ae(e(t))[0]:(l.css(h,t),void u.update.call(null,n[0]))}}},N=function(t){function o(){return clearTimeout(f[0].autoUpdate),0===l.parents("html").length?void(l=null):void(f[0].autoUpdate=setTimeout(function(){return c.advanced.updateOnSelectorChange&&(s.poll.change.n=i(),s.poll.change.n!==s.poll.change.o)?(s.poll.change.o=s.poll.change.n,void r(3)):c.advanced.updateOnContentResize&&(s.poll.size.n=l[0].scrollHeight+l[0].scrollWidth+f[0].offsetHeight+l[0].offsetHeight+l[0].offsetWidth,s.poll.size.n!==s.poll.size.o)?(s.poll.size.o=s.poll.size.n,void r(1)):!c.advanced.updateOnImageLoad||"auto"===c.advanced.updateOnImageLoad&&"y"===c.axis||(s.poll.img.n=f.find("img").length,s.poll.img.n===s.poll.img.o)?void((c.advanced.updateOnSelectorChange||c.advanced.updateOnContentResize||c.advanced.updateOnImageLoad)&&o()):(s.poll.img.o=s.poll.img.n,void f.find("img").each(function(){n(this)}))},c.advanced.autoUpdateTimeout))}function n(t){function o(e,t){return function(){
return t.apply(e,arguments)}}function a(){this.onload=null,e(t).addClass(d[2]),r(2)}if(e(t).hasClass(d[2]))return void r();var n=new Image;n.onload=o(n,a),n.src=t.src}function i(){c.advanced.updateOnSelectorChange===!0&&(c.advanced.updateOnSelectorChange="*");var e=0,t=f.find(c.advanced.updateOnSelectorChange);return c.advanced.updateOnSelectorChange&&t.length>0&&t.each(function(){e+=this.offsetHeight+this.offsetWidth}),e}function r(e){clearTimeout(f[0].autoUpdate),u.update.call(null,l[0],e)}var l=e(this),s=l.data(a),c=s.opt,f=e("#mCSB_"+s.idx+"_container");return t?(clearTimeout(f[0].autoUpdate),void $(f[0],"autoUpdate")):void o()},V=function(e,t,o){return Math.round(e/t)*t-o},Q=function(t){var o=t.data(a),n=e("#mCSB_"+o.idx+"_container,#mCSB_"+o.idx+"_container_wrapper,#mCSB_"+o.idx+"_dragger_vertical,#mCSB_"+o.idx+"_dragger_horizontal");n.each(function(){Z.call(this)})},G=function(t,o,n){function i(e){return s&&c.callbacks[e]&&"function"==typeof c.callbacks[e]}function r(){return[c.callbacks.alwaysTriggerOffsets||w>=S[0]+y,c.callbacks.alwaysTriggerOffsets||-B>=w]}function l(){var e=[h[0].offsetTop,h[0].offsetLeft],o=[x[0].offsetTop,x[0].offsetLeft],a=[h.outerHeight(!1),h.outerWidth(!1)],i=[f.height(),f.width()];t[0].mcs={content:h,top:e[0],left:e[1],draggerTop:o[0],draggerLeft:o[1],topPct:Math.round(100*Math.abs(e[0])/(Math.abs(a[0])-i[0])),leftPct:Math.round(100*Math.abs(e[1])/(Math.abs(a[1])-i[1])),direction:n.dir}}var s=t.data(a),c=s.opt,d={trigger:"internal",dir:"y",scrollEasing:"mcsEaseOut",drag:!1,dur:c.scrollInertia,overwrite:"all",callbacks:!0,onStart:!0,onUpdate:!0,onComplete:!0},n=e.extend(d,n),u=[n.dur,n.drag?0:n.dur],f=e("#mCSB_"+s.idx),h=e("#mCSB_"+s.idx+"_container"),m=h.parent(),p=c.callbacks.onTotalScrollOffset?Y.call(t,c.callbacks.onTotalScrollOffset):[0,0],g=c.callbacks.onTotalScrollBackOffset?Y.call(t,c.callbacks.onTotalScrollBackOffset):[0,0];if(s.trigger=n.trigger,0===m.scrollTop()&&0===m.scrollLeft()||(e(".mCSB_"+s.idx+"_scrollbar").css("visibility","visible"),m.scrollTop(0).scrollLeft(0)),"_resetY"!==o||s.contentReset.y||(i("onOverflowYNone")&&c.callbacks.onOverflowYNone.call(t[0]),s.contentReset.y=1),"_resetX"!==o||s.contentReset.x||(i("onOverflowXNone")&&c.callbacks.onOverflowXNone.call(t[0]),s.contentReset.x=1),"_resetY"!==o&&"_resetX"!==o){if(!s.contentReset.y&&t[0].mcs||!s.overflowed[0]||(i("onOverflowY")&&c.callbacks.onOverflowY.call(t[0]),s.contentReset.x=null),!s.contentReset.x&&t[0].mcs||!s.overflowed[1]||(i("onOverflowX")&&c.callbacks.onOverflowX.call(t[0]),s.contentReset.x=null),c.snapAmount){var v=c.snapAmount instanceof Array?"x"===n.dir?c.snapAmount[1]:c.snapAmount[0]:c.snapAmount;o=V(o,v,c.snapOffset)}switch(n.dir){case"x":var x=e("#mCSB_"+s.idx+"_dragger_horizontal"),_="left",w=h[0].offsetLeft,S=[f.width()-h.outerWidth(!1),x.parent().width()-x.width()],b=[o,0===o?0:o/s.scrollRatio.x],y=p[1],B=g[1],T=y>0?y/s.scrollRatio.x:0,k=B>0?B/s.scrollRatio.x:0;break;case"y":var x=e("#mCSB_"+s.idx+"_dragger_vertical"),_="top",w=h[0].offsetTop,S=[f.height()-h.outerHeight(!1),x.parent().height()-x.height()],b=[o,0===o?0:o/s.scrollRatio.y],y=p[0],B=g[0],T=y>0?y/s.scrollRatio.y:0,k=B>0?B/s.scrollRatio.y:0}b[1]<0||0===b[0]&&0===b[1]?b=[0,0]:b[1]>=S[1]?b=[S[0],S[1]]:b[0]=-b[0],t[0].mcs||(l(),i("onInit")&&c.callbacks.onInit.call(t[0])),clearTimeout(h[0].onCompleteTimeout),J(x[0],_,Math.round(b[1]),u[1],n.scrollEasing),!s.tweenRunning&&(0===w&&b[0]>=0||w===S[0]&&b[0]<=S[0])||J(h[0],_,Math.round(b[0]),u[0],n.scrollEasing,n.overwrite,{onStart:function(){n.callbacks&&n.onStart&&!s.tweenRunning&&(i("onScrollStart")&&(l(),c.callbacks.onScrollStart.call(t[0])),s.tweenRunning=!0,C(x),s.cbOffsets=r())},onUpdate:function(){n.callbacks&&n.onUpdate&&i("whileScrolling")&&(l(),c.callbacks.whileScrolling.call(t[0]))},onComplete:function(){if(n.callbacks&&n.onComplete){"yx"===c.axis&&clearTimeout(h[0].onCompleteTimeout);var e=h[0].idleTimer||0;h[0].onCompleteTimeout=setTimeout(function(){i("onScroll")&&(l(),c.callbacks.onScroll.call(t[0])),i("onTotalScroll")&&b[1]>=S[1]-T&&s.cbOffsets[0]&&(l(),c.callbacks.onTotalScroll.call(t[0])),i("onTotalScrollBack")&&b[1]<=k&&s.cbOffsets[1]&&(l(),c.callbacks.onTotalScrollBack.call(t[0])),s.tweenRunning=!1,h[0].idleTimer=0,C(x,"hide")},e)}}})}},J=function(e,t,o,a,n,i,r){function l(){S.stop||(x||m.call(),x=K()-v,s(),x>=S.time&&(S.time=x>S.time?x+f-(x-S.time):x+f-1,S.time<x+1&&(S.time=x+1)),S.time<a?S.id=h(l):g.call())}function s(){a>0?(S.currVal=u(S.time,_,b,a,n),w[t]=Math.round(S.currVal)+"px"):w[t]=o+"px",p.call()}function c(){f=1e3/60,S.time=x+f,h=window.requestAnimationFrame?window.requestAnimationFrame:function(e){return s(),setTimeout(e,.01)},S.id=h(l)}function d(){null!=S.id&&(window.requestAnimationFrame?window.cancelAnimationFrame(S.id):clearTimeout(S.id),S.id=null)}function u(e,t,o,a,n){switch(n){case"linear":case"mcsLinear":return o*e/a+t;case"mcsLinearOut":return e/=a,e--,o*Math.sqrt(1-e*e)+t;case"easeInOutSmooth":return e/=a/2,1>e?o/2*e*e+t:(e--,-o/2*(e*(e-2)-1)+t);case"easeInOutStrong":return e/=a/2,1>e?o/2*Math.pow(2,10*(e-1))+t:(e--,o/2*(-Math.pow(2,-10*e)+2)+t);case"easeInOut":case"mcsEaseInOut":return e/=a/2,1>e?o/2*e*e*e+t:(e-=2,o/2*(e*e*e+2)+t);case"easeOutSmooth":return e/=a,e--,-o*(e*e*e*e-1)+t;case"easeOutStrong":return o*(-Math.pow(2,-10*e/a)+1)+t;case"easeOut":case"mcsEaseOut":default:var i=(e/=a)*e,r=i*e;return t+o*(.499999999999997*r*i+-2.5*i*i+5.5*r+-6.5*i+4*e)}}e._mTween||(e._mTween={top:{},left:{}});var f,h,r=r||{},m=r.onStart||function(){},p=r.onUpdate||function(){},g=r.onComplete||function(){},v=K(),x=0,_=e.offsetTop,w=e.style,S=e._mTween[t];"left"===t&&(_=e.offsetLeft);var b=o-_;S.stop=0,"none"!==i&&d(),c()},K=function(){return window.performance&&window.performance.now?window.performance.now():window.performance&&window.performance.webkitNow?window.performance.webkitNow():Date.now?Date.now():(new Date).getTime()},Z=function(){var e=this;e._mTween||(e._mTween={top:{},left:{}});for(var t=["top","left"],o=0;o<t.length;o++){var a=t[o];e._mTween[a].id&&(window.requestAnimationFrame?window.cancelAnimationFrame(e._mTween[a].id):clearTimeout(e._mTween[a].id),e._mTween[a].id=null,e._mTween[a].stop=1)}},$=function(e,t){try{delete e[t]}catch(o){e[t]=null}},ee=function(e){return!(e.which&&1!==e.which)},te=function(e){var t=e.originalEvent.pointerType;return!(t&&"touch"!==t&&2!==t)},oe=function(e){return!isNaN(parseFloat(e))&&isFinite(e)},ae=function(e){var t=e.parents(".mCSB_container");return[e.offset().top-t.offset().top,e.offset().left-t.offset().left]},ne=function(){function e(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}var t=e();return t?document[t]:!1};e.fn[o]=function(t){return u[t]?u[t].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof t&&t?void e.error("Method "+t+" does not exist"):u.init.apply(this,arguments)},e[o]=function(t){return u[t]?u[t].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof t&&t?void e.error("Method "+t+" does not exist"):u.init.apply(this,arguments)},e[o].defaults=i,window[o]=!0,e(window).bind("load",function(){e(n)[o](),e.extend(e.expr[":"],{mcsInView:e.expr[":"].mcsInView||function(t){var o,a,n=e(t),i=n.parents(".mCSB_container");if(i.length)return o=i.parent(),a=[i[0].offsetTop,i[0].offsetLeft],a[0]+ae(n)[0]>=0&&a[0]+ae(n)[0]<o.height()-n.outerHeight(!1)&&a[1]+ae(n)[1]>=0&&a[1]+ae(n)[1]<o.width()-n.outerWidth(!1)},mcsInSight:e.expr[":"].mcsInSight||function(t,o,a){var n,i,r,l,s=e(t),c=s.parents(".mCSB_container"),d="exact"===a[3]?[[1,0],[1,0]]:[[.9,.1],[.6,.4]];if(c.length)return n=[s.outerHeight(!1),s.outerWidth(!1)],r=[c[0].offsetTop+ae(s)[0],c[0].offsetLeft+ae(s)[1]],i=[c.parent()[0].offsetHeight,c.parent()[0].offsetWidth],l=[n[0]<i[0]?d[0]:d[1],n[1]<i[1]?d[0]:d[1]],r[0]-i[0]*l[0][0]<0&&r[0]+n[0]-i[0]*l[0][1]>=0&&r[1]-i[1]*l[1][0]<0&&r[1]+n[1]-i[1]*l[1][1]>=0},mcsOverflow:e.expr[":"].mcsOverflow||function(t){var o=e(t).data(a);if(o)return o.overflowed[0]||o.overflowed[1]}})})})});