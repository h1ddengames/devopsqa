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
/******/ 	return __webpack_require__(__webpack_require__.s = 209);
/******/ })
/************************************************************************/
/******/ ({

/***/ 17:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					elements: '.elementor-element',
					nestedDocumentElements: '.elementor .elementor-element'
				},
				classes: {
					editMode: 'elementor-edit-mode'
				}
			};
		}
	}, {
		key: 'getDefaultElements',
		value: function getDefaultElements() {
			var selectors = this.getSettings('selectors');

			return {
				$elements: this.$element.find(selectors.elements).not(this.$element.find(selectors.nestedDocumentElements))
			};
		}
	}, {
		key: 'getDocumentSettings',
		value: function getDocumentSettings(setting) {
			var elementSettings = void 0;

			if (this.isEdit) {
				elementSettings = {};

				var settings = elementor.settings.page.model;

				jQuery.each(settings.getActiveControls(), function (controlKey) {
					elementSettings[controlKey] = settings.attributes[controlKey];
				});
			} else {
				elementSettings = this.$element.data('elementor-settings') || {};
			}

			return this.getItems(elementSettings, setting);
		}
	}, {
		key: 'runElementsHandlers',
		value: function runElementsHandlers() {
			this.elements.$elements.each(function (index, element) {
				return elementorFrontend.elementsHandler.runReadyTrigger(element);
			});
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			this.$element = this.getSettings('$element');

			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onInit', this).call(this);

			this.isEdit = this.$element.hasClass(this.getSettings('classes.editMode'));

			if (this.isEdit) {
				elementor.settings.page.model.on('change', this.onSettingsChange.bind(this));
			} else {
				this.runElementsHandlers();
			}
		}
	}, {
		key: 'onSettingsChange',
		value: function onSettingsChange() {}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

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

/***/ 209:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _modules = __webpack_require__(19);

var _modules2 = _interopRequireDefault(_modules);

var _document = __webpack_require__(17);

var _document2 = _interopRequireDefault(_document);

var _stretchElement = __webpack_require__(210);

var _stretchElement2 = _interopRequireDefault(_stretchElement);

var _base = __webpack_require__(211);

var _base2 = _interopRequireDefault(_base);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_modules2.default.frontend = {
	Document: _document2.default,
	tools: {
		StretchElement: _stretchElement2.default
	},
	handlers: {
		Base: _base2.default
	}
};

/***/ }),

/***/ 210:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			element: null,
			direction: elementorFrontend.config.is_rtl ? 'right' : 'left',
			selectors: {
				container: window
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		return {
			$element: jQuery(this.getSettings('element'))
		};
	},

	stretch: function stretch() {
		var containerSelector = this.getSettings('selectors.container'),
		    $container;

		try {
			$container = jQuery(containerSelector);
		} catch (e) {}

		if (!$container || !$container.length) {
			$container = jQuery(this.getDefaultSettings().selectors.container);
		}

		this.reset();

		var $element = this.elements.$element,
		    containerWidth = $container.outerWidth(),
		    elementOffset = $element.offset().left,
		    isFixed = 'fixed' === $element.css('position'),
		    correctOffset = isFixed ? 0 : elementOffset;

		if (window !== $container[0]) {
			var containerOffset = $container.offset().left;

			if (isFixed) {
				correctOffset = containerOffset;
			}
			if (elementOffset > containerOffset) {
				correctOffset = elementOffset - containerOffset;
			}
		}

		if (!isFixed) {
			if (elementorFrontend.config.is_rtl) {
				correctOffset = containerWidth - ($element.outerWidth() + correctOffset);
			}

			correctOffset = -correctOffset;
		}

		var css = {};

		css.width = containerWidth + 'px';

		css[this.getSettings('direction')] = correctOffset + 'px';

		$element.css(css);
	},

	reset: function reset() {
		var css = {};

		css.width = '';

		css[this.getSettings('direction')] = '';

		this.elements.$element.css(css);
	}
});

/***/ }),

/***/ 211:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	$element: null,

	editorListeners: null,

	onElementChange: null,

	onEditSettingsChange: null,

	onGeneralSettingsChange: null,

	onPageSettingsChange: null,

	isEdit: null,

	__construct: function __construct(settings) {
		this.$element = settings.$element;

		this.isEdit = this.$element.hasClass('elementor-element-edit-mode');

		if (this.isEdit) {
			this.addEditorListeners();
		}
	},

	findElement: function findElement(selector) {
		var $mainElement = this.$element;

		return $mainElement.find(selector).filter(function () {
			return jQuery(this).closest('.elementor-element').is($mainElement);
		});
	},

	getUniqueHandlerID: function getUniqueHandlerID(cid, $element) {
		if (!cid) {
			cid = this.getModelCID();
		}

		if (!$element) {
			$element = this.$element;
		}

		return cid + $element.attr('data-element_type') + this.getConstructorID();
	},

	initEditorListeners: function initEditorListeners() {
		var self = this;

		self.editorListeners = [{
			event: 'element:destroy',
			to: elementor.channels.data,
			callback: function callback(removedModel) {
				if (removedModel.cid !== self.getModelCID()) {
					return;
				}

				self.onDestroy();
			}
		}];

		if (self.onElementChange) {
			var elementType = self.getWidgetType() || self.getElementType();

			var eventName = 'change';

			if ('global' !== elementType) {
				eventName += ':' + elementType;
			}

			self.editorListeners.push({
				event: eventName,
				to: elementor.channels.editor,
				callback: function callback(controlView, elementView) {
					var elementViewHandlerID = self.getUniqueHandlerID(elementView.model.cid, elementView.$el);

					if (elementViewHandlerID !== self.getUniqueHandlerID()) {
						return;
					}

					self.onElementChange(controlView.model.get('name'), controlView, elementView);
				}
			});
		}

		if (self.onEditSettingsChange) {
			self.editorListeners.push({
				event: 'change:editSettings',
				to: elementor.channels.editor,
				callback: function callback(changedModel, view) {
					if (view.model.cid !== self.getModelCID()) {
						return;
					}

					self.onEditSettingsChange(Object.keys(changedModel.changed)[0]);
				}
			});
		}

		['page', 'general'].forEach(function (settingsType) {
			var listenerMethodName = 'on' + settingsType[0].toUpperCase() + settingsType.slice(1) + 'SettingsChange';

			if (self[listenerMethodName]) {
				self.editorListeners.push({
					event: 'change',
					to: elementor.settings[settingsType].model,
					callback: function callback(model) {
						self[listenerMethodName](model.changed);
					}
				});
			}
		});
	},

	getEditorListeners: function getEditorListeners() {
		if (!this.editorListeners) {
			this.initEditorListeners();
		}

		return this.editorListeners;
	},

	addEditorListeners: function addEditorListeners() {
		var uniqueHandlerID = this.getUniqueHandlerID();

		this.getEditorListeners().forEach(function (listener) {
			elementorFrontend.addListenerOnce(uniqueHandlerID, listener.event, listener.callback, listener.to);
		});
	},

	removeEditorListeners: function removeEditorListeners() {
		var uniqueHandlerID = this.getUniqueHandlerID();

		this.getEditorListeners().forEach(function (listener) {
			elementorFrontend.removeListeners(uniqueHandlerID, listener.event, null, listener.to);
		});
	},

	getElementType: function getElementType() {
		return this.$element.data('element_type');
	},

	getWidgetType: function getWidgetType() {
		var widgetType = this.$element.data('widget_type');

		if (!widgetType) {
			return;
		}

		return widgetType.split('.')[0];
	},

	getID: function getID() {
		return this.$element.data('id');
	},

	getModelCID: function getModelCID() {
		return this.$element.data('model-cid');
	},

	getElementSettings: function getElementSettings(setting) {
		var elementSettings = {};

		var modelCID = this.getModelCID();

		if (this.isEdit && modelCID) {
			var settings = elementorFrontend.config.elements.data[modelCID],
			    attributes = settings.attributes;

			var type = attributes.widgetType || attributes.elType;

			if (attributes.isInner) {
				type = 'inner-' + type;
			}

			var settingsKeys = elementorFrontend.config.elements.keys[type];

			if (!settingsKeys) {
				settingsKeys = elementorFrontend.config.elements.keys[type] = [];

				jQuery.each(settings.controls, function (name, control) {
					if (control.frontend_available) {
						settingsKeys.push(name);
					}
				});
			}

			jQuery.each(settings.getActiveControls(), function (controlKey) {
				if (-1 !== settingsKeys.indexOf(controlKey)) {
					elementSettings[controlKey] = attributes[controlKey];
				}
			});
		} else {
			elementSettings = this.$element.data('settings') || {};
		}

		return this.getItems(elementSettings, setting);
	},

	getEditSettings: function getEditSettings(setting) {
		var attributes = {};

		if (this.isEdit) {
			attributes = elementorFrontend.config.elements.editSettings[this.getModelCID()].attributes;
		}

		return this.getItems(attributes, setting);
	},

	getCurrentDeviceSetting: function getCurrentDeviceSetting(settingKey) {
		return elementorFrontend.getCurrentDeviceSetting(this.getElementSettings(), settingKey);
	},

	onDestroy: function onDestroy() {
		this.removeEditorListeners();

		if (this.unbindEvents) {
			this.unbindEvents();
		}
	}
});

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
//# sourceMappingURL=frontend-modules.js.map