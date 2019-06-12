/*! elementor - v2.5.15 - 07-05-2019 */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 199);
/******/ })
/************************************************************************/
/******/ ({

/***/ 19:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _module = __webpack_require__(5);

var _module2 = _interopRequireDefault(_module);

var _viewModule = __webpack_require__(6);

var _viewModule2 = _interopRequireDefault(_viewModule);

var _masonry = __webpack_require__(20);

var _masonry2 = _interopRequireDefault(_masonry);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = window.elementorModules = {
	Module: _module2.default,
	ViewModule: _viewModule2.default,
	utils: {
		Masonry: _masonry2.default
	}
};

/***/ }),

/***/ 199:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _modules = __webpack_require__(19);

var _modules2 = _interopRequireDefault(_modules);

var _layout = __webpack_require__(200);

var _layout2 = _interopRequireDefault(_layout);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_modules2.default.common = {
	views: {
		modal: {
			Layout: _layout2.default
		}
	}
};

/***/ }),

/***/ 20:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _viewModule = __webpack_require__(6);

var _viewModule2 = _interopRequireDefault(_viewModule);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

module.exports = _viewModule2.default.extend({

	getDefaultSettings: function getDefaultSettings() {
		return {
			container: null,
			items: null,
			columnsCount: 3,
			verticalSpaceBetween: 30
		};
	},

	getDefaultElements: function getDefaultElements() {
		return {
			$container: jQuery(this.getSettings('container')),
			$items: jQuery(this.getSettings('items'))
		};
	},

	run: function run() {
		var heights = [],
		    distanceFromTop = this.elements.$container.position().top,
		    settings = this.getSettings(),
		    columnsCount = settings.columnsCount;

		distanceFromTop += parseInt(this.elements.$container.css('margin-top'), 10);

		this.elements.$items.each(function (index) {
			var row = Math.floor(index / columnsCount),
			    $item = jQuery(this),
			    itemHeight = $item[0].getBoundingClientRect().height + settings.verticalSpaceBetween;

			if (row) {
				var itemPosition = $item.position(),
				    indexAtRow = index % columnsCount,
				    pullHeight = itemPosition.top - distanceFromTop - heights[indexAtRow];

				pullHeight -= parseInt($item.css('margin-top'), 10);

				pullHeight *= -1;

				$item.css('margin-top', pullHeight + 'px');

				heights[indexAtRow] += itemHeight;
			} else {
				heights.push(itemHeight);
			}
		});
	}
});

/***/ }),

/***/ 200:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _header = __webpack_require__(201);

var _header2 = _interopRequireDefault(_header);

var _logo = __webpack_require__(202);

var _logo2 = _interopRequireDefault(_logo);

var _loading = __webpack_require__(203);

var _loading2 = _interopRequireDefault(_loading);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_Marionette$LayoutVie) {
	_inherits(_class, _Marionette$LayoutVie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'el',
		value: function el() {
			return this.getModal().getElements('widget');
		}
	}, {
		key: 'regions',
		value: function regions() {
			return {
				modalHeader: '.dialog-header',
				modalContent: '.dialog-lightbox-content',
				modalLoading: '.dialog-lightbox-loading'
			};
		}
	}, {
		key: 'initialize',
		value: function initialize() {
			this.modalHeader.show(new _header2.default(this.getHeaderOptions()));
		}
	}, {
		key: 'getModal',
		value: function getModal() {
			if (!this.modal) {
				this.initModal();
			}

			return this.modal;
		}
	}, {
		key: 'initModal',
		value: function initModal() {
			var modalOptions = {
				className: 'elementor-templates-modal',
				closeButton: false,
				draggable: false,
				hide: {
					onOutsideClick: false
				}
			};

			jQuery.extend(true, modalOptions, this.getModalOptions());

			this.modal = elementorCommon.dialogsManager.createWidget('lightbox', modalOptions);

			this.modal.getElements('message').append(this.modal.addElement('content'), this.modal.addElement('loading'));

			if (modalOptions.draggable) {
				this.draggableModal();
			}
		}
	}, {
		key: 'showModal',
		value: function showModal() {
			this.getModal().show();
		}
	}, {
		key: 'hideModal',
		value: function hideModal() {
			this.getModal().hide();
		}
	}, {
		key: 'draggableModal',
		value: function draggableModal() {
			var $modalWidgetContent = this.getModal().getElements('widgetContent');

			$modalWidgetContent.draggable({
				containment: 'parent',
				stop: function stop() {
					$modalWidgetContent.height('');
				}
			});

			$modalWidgetContent.css('position', 'absolute');
		}
	}, {
		key: 'getModalOptions',
		value: function getModalOptions() {
			return {};
		}
	}, {
		key: 'getLogoOptions',
		value: function getLogoOptions() {
			return {};
		}
	}, {
		key: 'getHeaderOptions',
		value: function getHeaderOptions() {
			return {
				closeType: 'normal'
			};
		}
	}, {
		key: 'getHeaderView',
		value: function getHeaderView() {
			return this.modalHeader.currentView;
		}
	}, {
		key: 'showLoadingView',
		value: function showLoadingView() {
			this.modalLoading.show(new _loading2.default());

			this.modalLoading.$el.show();

			this.modalContent.$el.hide();
		}
	}, {
		key: 'hideLoadingView',
		value: function hideLoadingView() {
			this.modalContent.$el.show();

			this.modalLoading.$el.hide();
		}
	}, {
		key: 'showLogo',
		value: function showLogo() {
			this.getHeaderView().logoArea.show(new _logo2.default(this.getLogoOptions()));
		}
	}]);

	return _class;
}(Marionette.LayoutView);

exports.default = _class;

/***/ }),

/***/ 201:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_Marionette$LayoutVie) {
	_inherits(_class, _Marionette$LayoutVie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'className',
		value: function className() {
			return 'elementor-templates-modal__header';
		}
	}, {
		key: 'getTemplate',
		value: function getTemplate() {
			return '#tmpl-elementor-templates-modal__header';
		}
	}, {
		key: 'regions',
		value: function regions() {
			return {
				logoArea: '.elementor-templates-modal__header__logo-area',
				tools: '#elementor-template-library-header-tools',
				menuArea: '.elementor-templates-modal__header__menu-area'
			};
		}
	}, {
		key: 'ui',
		value: function ui() {
			return {
				closeModal: '.elementor-templates-modal__header__close'
			};
		}
	}, {
		key: 'events',
		value: function events() {
			return {
				'click @ui.closeModal': 'onCloseModalClick'
			};
		}
	}, {
		key: 'templateHelpers',
		value: function templateHelpers() {
			return {
				closeType: this.getOption('closeType')
			};
		}
	}, {
		key: 'onCloseModalClick',
		value: function onCloseModalClick() {
			this._parent._parent._parent.hideModal();
		}
	}]);

	return _class;
}(Marionette.LayoutView);

exports.default = _class;

/***/ }),

/***/ 202:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_Marionette$ItemView) {
	_inherits(_class, _Marionette$ItemView);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'getTemplate',
		value: function getTemplate() {
			return '#tmpl-elementor-templates-modal__header__logo';
		}
	}, {
		key: 'className',
		value: function className() {
			return 'elementor-templates-modal__header__logo';
		}
	}, {
		key: 'events',
		value: function events() {
			return {
				click: 'onClick'
			};
		}
	}, {
		key: 'templateHelpers',
		value: function templateHelpers() {
			return {
				title: this.getOption('title')
			};
		}
	}, {
		key: 'onClick',
		value: function onClick() {
			var clickCallback = this.getOption('click');

			if (clickCallback) {
				clickCallback();
			}
		}
	}]);

	return _class;
}(Marionette.ItemView);

exports.default = _class;

/***/ }),

/***/ 203:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_Marionette$ItemView) {
	_inherits(_class, _Marionette$ItemView);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'id',
		value: function id() {
			return 'elementor-template-library-loading';
		}
	}, {
		key: 'getTemplate',
		value: function getTemplate() {
			return '#tmpl-elementor-template-library-loading';
		}
	}]);

	return _class;
}(Marionette.ItemView);

exports.default = _class;

/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var Module = function Module() {
	var $ = jQuery,
	    instanceParams = arguments,
	    self = this,
	    events = {};

	var settings = void 0;

	var ensureClosureMethods = function ensureClosureMethods() {
		$.each(self, function (methodName) {
			var oldMethod = self[methodName];

			if ('function' !== typeof oldMethod) {
				return;
			}

			self[methodName] = function () {
				return oldMethod.apply(self, arguments);
			};
		});
	};

	var initSettings = function initSettings() {
		settings = self.getDefaultSettings();

		var instanceSettings = instanceParams[0];

		if (instanceSettings) {
			$.extend(true, settings, instanceSettings);
		}
	};

	var init = function init() {
		self.__construct.apply(self, instanceParams);

		ensureClosureMethods();

		initSettings();

		self.trigger('init');
	};

	this.getItems = function (items, itemKey) {
		if (itemKey) {
			var keyStack = itemKey.split('.'),
			    currentKey = keyStack.splice(0, 1);

			if (!keyStack.length) {
				return items[currentKey];
			}

			if (!items[currentKey]) {
				return;
			}

			return this.getItems(items[currentKey], keyStack.join('.'));
		}

		return items;
	};

	this.getSettings = function (setting) {
		return this.getItems(settings, setting);
	};

	this.setSettings = function (settingKey, value, settingsContainer) {
		if (!settingsContainer) {
			settingsContainer = settings;
		}

		if ('object' === (typeof settingKey === 'undefined' ? 'undefined' : _typeof(settingKey))) {
			$.extend(settingsContainer, settingKey);

			return self;
		}

		var keyStack = settingKey.split('.'),
		    currentKey = keyStack.splice(0, 1);

		if (!keyStack.length) {
			settingsContainer[currentKey] = value;

			return self;
		}

		if (!settingsContainer[currentKey]) {
			settingsContainer[currentKey] = {};
		}

		return self.setSettings(keyStack.join('.'), value, settingsContainer[currentKey]);
	};

	this.forceMethodImplementation = function (methodArguments) {
		var functionName = methodArguments.callee.name;

		throw new ReferenceError('The method ' + functionName + ' must to be implemented in the inheritor child.');
	};

	this.on = function (eventName, callback) {
		if ('object' === (typeof eventName === 'undefined' ? 'undefined' : _typeof(eventName))) {
			$.each(eventName, function (singleEventName) {
				self.on(singleEventName, this);
			});

			return self;
		}

		var eventNames = eventName.split(' ');

		eventNames.forEach(function (singleEventName) {
			if (!events[singleEventName]) {
				events[singleEventName] = [];
			}

			events[singleEventName].push(callback);
		});

		return self;
	};

	this.off = function (eventName, callback) {
		if (!events[eventName]) {
			return self;
		}

		if (!callback) {
			delete events[eventName];

			return self;
		}

		var callbackIndex = events[eventName].indexOf(callback);

		if (-1 !== callbackIndex) {
			delete events[eventName][callbackIndex];
		}

		return self;
	};

	this.trigger = function (eventName) {
		var methodName = 'on' + eventName[0].toUpperCase() + eventName.slice(1),
		    params = Array.prototype.slice.call(arguments, 1);

		if (self[methodName]) {
			self[methodName].apply(self, params);
		}

		var callbacks = events[eventName];

		if (!callbacks) {
			return self;
		}

		$.each(callbacks, function (index, callback) {
			callback.apply(self, params);
		});

		return self;
	};

	init();
};

Module.prototype.__construct = function () {};

Module.prototype.getDefaultSettings = function () {
	return {};
};

Module.extendsCount = 0;

Module.extend = function (properties) {
	var $ = jQuery,
	    parent = this;

	var child = function child() {
		return parent.apply(this, arguments);
	};

	$.extend(child, parent);

	child.prototype = Object.create($.extend({}, parent.prototype, properties));

	child.prototype.constructor = child;

	/*
  * Constructor ID is used to set an unique ID
  * to every extend of the Module.
  *
  * It's useful in some cases such as unique
  * listener for frontend handlers.
  */
	var constructorID = ++Module.extendsCount;

	child.prototype.getConstructorID = function () {
		return constructorID;
	};

	child.__super__ = parent.prototype;

	return child;
};

module.exports = Module;

/***/ }),

/***/ 6:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _module = __webpack_require__(5);

var _module2 = _interopRequireDefault(_module);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

module.exports = _module2.default.extend({
	elements: null,

	getDefaultElements: function getDefaultElements() {
		return {};
	},

	bindEvents: function bindEvents() {},

	onInit: function onInit() {
		this.initElements();

		this.bindEvents();
	},

	initElements: function initElements() {
		this.elements = this.getDefaultElements();
	}
});

/***/ })

/******/ });
//# sourceMappingURL=common-modules.js.map