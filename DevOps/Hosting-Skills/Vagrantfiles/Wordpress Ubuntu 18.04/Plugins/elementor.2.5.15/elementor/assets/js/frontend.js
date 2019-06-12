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
/******/ 	return __webpack_require__(__webpack_require__.s = 182);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});
var userAgent = navigator.userAgent;

exports.default = {
	webkit: -1 !== userAgent.indexOf('AppleWebKit'),
	firefox: -1 !== userAgent.indexOf('Firefox'),
	ie: /Trident|MSIE/.test(userAgent),
	edge: -1 !== userAgent.indexOf('Edge'),
	mac: -1 !== userAgent.indexOf('Macintosh')
};

/***/ }),

/***/ 13:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Handles managing all events for whatever you plug it into. Priorities for hooks are based on lowest to highest in
 * that, lowest priority hooks are fired first.
 */

var EventManager = function EventManager() {
	var slice = Array.prototype.slice,
	    MethodsAvailable;

	/**
  * Contains the hooks that get registered with this EventManager. The array for storage utilizes a "flat"
  * object literal such that looking up the hook utilizes the native object literal hash.
  */
	var STORAGE = {
		actions: {},
		filters: {}
	};

	/**
  * Removes the specified hook by resetting the value of it.
  *
  * @param type Type of hook, either 'actions' or 'filters'
  * @param hook The hook (namespace.identifier) to remove
  *
  * @private
  */
	function _removeHook(type, hook, callback, context) {
		var handlers, handler, i;

		if (!STORAGE[type][hook]) {
			return;
		}
		if (!callback) {
			STORAGE[type][hook] = [];
		} else {
			handlers = STORAGE[type][hook];
			if (!context) {
				for (i = handlers.length; i--;) {
					if (handlers[i].callback === callback) {
						handlers.splice(i, 1);
					}
				}
			} else {
				for (i = handlers.length; i--;) {
					handler = handlers[i];
					if (handler.callback === callback && handler.context === context) {
						handlers.splice(i, 1);
					}
				}
			}
		}
	}

	/**
  * Use an insert sort for keeping our hooks organized based on priority. This function is ridiculously faster
  * than bubble sort, etc: http://jsperf.com/javascript-sort
  *
  * @param hooks The custom array containing all of the appropriate hooks to perform an insert sort on.
  * @private
  */
	function _hookInsertSort(hooks) {
		var tmpHook, j, prevHook;
		for (var i = 1, len = hooks.length; i < len; i++) {
			tmpHook = hooks[i];
			j = i;
			while ((prevHook = hooks[j - 1]) && prevHook.priority > tmpHook.priority) {
				hooks[j] = hooks[j - 1];
				--j;
			}
			hooks[j] = tmpHook;
		}

		return hooks;
	}

	/**
  * Adds the hook to the appropriate storage container
  *
  * @param type 'actions' or 'filters'
  * @param hook The hook (namespace.identifier) to add to our event manager
  * @param callback The function that will be called when the hook is executed.
  * @param priority The priority of this hook. Must be an integer.
  * @param [context] A value to be used for this
  * @private
  */
	function _addHook(type, hook, callback, priority, context) {
		var hookObject = {
			callback: callback,
			priority: priority,
			context: context
		};

		// Utilize 'prop itself' : http://jsperf.com/hasownproperty-vs-in-vs-undefined/19
		var hooks = STORAGE[type][hook];
		if (hooks) {
			// TEMP FIX BUG
			var hasSameCallback = false;
			jQuery.each(hooks, function () {
				if (this.callback === callback) {
					hasSameCallback = true;
					return false;
				}
			});

			if (hasSameCallback) {
				return;
			}
			// END TEMP FIX BUG

			hooks.push(hookObject);
			hooks = _hookInsertSort(hooks);
		} else {
			hooks = [hookObject];
		}

		STORAGE[type][hook] = hooks;
	}

	/**
  * Runs the specified hook. If it is an action, the value is not modified but if it is a filter, it is.
  *
  * @param type 'actions' or 'filters'
  * @param hook The hook ( namespace.identifier ) to be ran.
  * @param args Arguments to pass to the action/filter. If it's a filter, args is actually a single parameter.
  * @private
  */
	function _runHook(type, hook, args) {
		var handlers = STORAGE[type][hook],
		    i,
		    len;

		if (!handlers) {
			return 'filters' === type ? args[0] : false;
		}

		len = handlers.length;
		if ('filters' === type) {
			for (i = 0; i < len; i++) {
				args[0] = handlers[i].callback.apply(handlers[i].context, args);
			}
		} else {
			for (i = 0; i < len; i++) {
				handlers[i].callback.apply(handlers[i].context, args);
			}
		}

		return 'filters' === type ? args[0] : true;
	}

	/**
  * Adds an action to the event manager.
  *
  * @param action Must contain namespace.identifier
  * @param callback Must be a valid callback function before this action is added
  * @param [priority=10] Used to control when the function is executed in relation to other callbacks bound to the same hook
  * @param [context] Supply a value to be used for this
  */
	function addAction(action, callback, priority, context) {
		if ('string' === typeof action && 'function' === typeof callback) {
			priority = parseInt(priority || 10, 10);
			_addHook('actions', action, callback, priority, context);
		}

		return MethodsAvailable;
	}

	/**
  * Performs an action if it exists. You can pass as many arguments as you want to this function; the only rule is
  * that the first argument must always be the action.
  */
	function doAction() /* action, arg1, arg2, ... */{
		var args = slice.call(arguments);
		var action = args.shift();

		if ('string' === typeof action) {
			_runHook('actions', action, args);
		}

		return MethodsAvailable;
	}

	/**
  * Removes the specified action if it contains a namespace.identifier & exists.
  *
  * @param action The action to remove
  * @param [callback] Callback function to remove
  */
	function removeAction(action, callback) {
		if ('string' === typeof action) {
			_removeHook('actions', action, callback);
		}

		return MethodsAvailable;
	}

	/**
  * Adds a filter to the event manager.
  *
  * @param filter Must contain namespace.identifier
  * @param callback Must be a valid callback function before this action is added
  * @param [priority=10] Used to control when the function is executed in relation to other callbacks bound to the same hook
  * @param [context] Supply a value to be used for this
  */
	function addFilter(filter, callback, priority, context) {
		if ('string' === typeof filter && 'function' === typeof callback) {
			priority = parseInt(priority || 10, 10);
			_addHook('filters', filter, callback, priority, context);
		}

		return MethodsAvailable;
	}

	/**
  * Performs a filter if it exists. You should only ever pass 1 argument to be filtered. The only rule is that
  * the first argument must always be the filter.
  */
	function applyFilters() /* filter, filtered arg, arg2, ... */{
		var args = slice.call(arguments);
		var filter = args.shift();

		if ('string' === typeof filter) {
			return _runHook('filters', filter, args);
		}

		return MethodsAvailable;
	}

	/**
  * Removes the specified filter if it contains a namespace.identifier & exists.
  *
  * @param filter The action to remove
  * @param [callback] Callback function to remove
  */
	function removeFilter(filter, callback) {
		if ('string' === typeof filter) {
			_removeHook('filters', filter, callback);
		}

		return MethodsAvailable;
	}

	/**
  * Maintain a reference to the object scope so our public methods never get confusing.
  */
	MethodsAvailable = {
		removeFilter: removeFilter,
		applyFilters: applyFilters,
		addFilter: addFilter,
		removeAction: removeAction,
		doAction: doAction,
		addAction: addAction
	};

	// return all of the publicly available methods
	return MethodsAvailable;
};

module.exports = EventManager;

/***/ }),

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Mod) {
	_inherits(_class, _elementorModules$Mod);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'get',
		value: function get(key, options) {
			options = options || {};

			var storage = void 0;

			try {
				storage = options.session ? sessionStorage : localStorage;
			} catch (e) {
				return key ? undefined : {};
			}

			var elementorStorage = storage.getItem('elementor');

			if (elementorStorage) {
				elementorStorage = JSON.parse(elementorStorage);
			} else {
				elementorStorage = {};
			}

			if (!elementorStorage.__expiration) {
				elementorStorage.__expiration = {};
			}

			var expiration = elementorStorage.__expiration;

			var expirationToCheck = [];

			if (key) {
				if (expiration[key]) {
					expirationToCheck = [key];
				}
			} else {
				expirationToCheck = Object.keys(expiration);
			}

			var entryExpired = false;

			expirationToCheck.forEach(function (expirationKey) {
				if (new Date(expiration[expirationKey]) < new Date()) {
					delete elementorStorage[expirationKey];

					delete expiration[expirationKey];

					entryExpired = true;
				}
			});

			if (entryExpired) {
				this.save(elementorStorage, options.session);
			}

			if (key) {
				return elementorStorage[key];
			}

			return elementorStorage;
		}
	}, {
		key: 'set',
		value: function set(key, value, options) {
			options = options || {};

			var elementorStorage = this.get(null, options);

			elementorStorage[key] = value;

			if (options.lifetimeInSeconds) {
				var date = new Date();

				date.setTime(date.getTime() + options.lifetimeInSeconds * 1000);

				elementorStorage.__expiration[key] = date.getTime();
			}

			this.save(elementorStorage, options.session);
		}
	}, {
		key: 'save',
		value: function save(object, session) {
			var storage = void 0;

			try {
				storage = session ? sessionStorage : localStorage;
			} catch (e) {
				return;
			}

			storage.setItem('elementor', JSON.stringify(object));
		}
	}]);

	return _class;
}(elementorModules.Module);

exports.default = _class;

/***/ }),

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _environment = __webpack_require__(1);

var _environment2 = _interopRequireDefault(_environment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var HotKeys = function () {
	function HotKeys() {
		_classCallCheck(this, HotKeys);

		this.hotKeysHandlers = {};
	}

	_createClass(HotKeys, [{
		key: 'applyHotKey',
		value: function applyHotKey(event) {
			var handlers = this.hotKeysHandlers[event.which];

			if (!handlers) {
				return;
			}

			jQuery.each(handlers, function (key, handler) {
				if (handler.isWorthHandling && !handler.isWorthHandling(event)) {
					return;
				}

				// Fix for some keyboard sources that consider alt key as ctrl key
				if (!handler.allowAltKey && event.altKey) {
					return;
				}

				event.preventDefault();

				handler.handle(event);
			});
		}
	}, {
		key: 'isControlEvent',
		value: function isControlEvent(event) {
			return event[_environment2.default.mac ? 'metaKey' : 'ctrlKey'];
		}
	}, {
		key: 'addHotKeyHandler',
		value: function addHotKeyHandler(keyCode, handlerName, handler) {
			if (!this.hotKeysHandlers[keyCode]) {
				this.hotKeysHandlers[keyCode] = {};
			}

			this.hotKeysHandlers[keyCode][handlerName] = handler;
		}
	}, {
		key: 'bindListener',
		value: function bindListener($listener) {
			$listener.on('keydown', this.applyHotKey.bind(this));
		}
	}]);

	return HotKeys;
}();

exports.default = HotKeys;

/***/ }),

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

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.frontend.handlers.Base.extend({
	$activeContent: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				tabTitle: '.elementor-tab-title',
				tabContent: '.elementor-tab-content'
			},
			classes: {
				active: 'elementor-active'
			},
			showTabFn: 'show',
			hideTabFn: 'hide',
			toggleSelf: true,
			hidePrevious: true,
			autoExpand: true
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$tabTitles: this.findElement(selectors.tabTitle),
			$tabContents: this.findElement(selectors.tabContent)
		};
	},

	activateDefaultTab: function activateDefaultTab() {
		var settings = this.getSettings();

		if (!settings.autoExpand || 'editor' === settings.autoExpand && !this.isEdit) {
			return;
		}

		var defaultActiveTab = this.getEditSettings('activeItemIndex') || 1,
		    originalToggleMethods = {
			showTabFn: settings.showTabFn,
			hideTabFn: settings.hideTabFn
		};

		// Toggle tabs without animation to avoid jumping
		this.setSettings({
			showTabFn: 'show',
			hideTabFn: 'hide'
		});

		this.changeActiveTab(defaultActiveTab);

		// Return back original toggle effects
		this.setSettings(originalToggleMethods);
	},

	deactivateActiveTab: function deactivateActiveTab(tabIndex) {
		var settings = this.getSettings(),
		    activeClass = settings.classes.active,
		    activeFilter = tabIndex ? '[data-tab="' + tabIndex + '"]' : '.' + activeClass,
		    $activeTitle = this.elements.$tabTitles.filter(activeFilter),
		    $activeContent = this.elements.$tabContents.filter(activeFilter);

		$activeTitle.add($activeContent).removeClass(activeClass);

		$activeContent[settings.hideTabFn]();
	},

	activateTab: function activateTab(tabIndex) {
		var settings = this.getSettings(),
		    activeClass = settings.classes.active,
		    $requestedTitle = this.elements.$tabTitles.filter('[data-tab="' + tabIndex + '"]'),
		    $requestedContent = this.elements.$tabContents.filter('[data-tab="' + tabIndex + '"]');

		$requestedTitle.add($requestedContent).addClass(activeClass);

		$requestedContent[settings.showTabFn]();
	},

	isActiveTab: function isActiveTab(tabIndex) {
		return this.elements.$tabTitles.filter('[data-tab="' + tabIndex + '"]').hasClass(this.getSettings('classes.active'));
	},

	bindEvents: function bindEvents() {
		var _this = this;

		this.elements.$tabTitles.on({
			keydown: function keydown(event) {
				if ('Enter' === event.key) {
					event.preventDefault();

					_this.changeActiveTab(event.currentTarget.dataset.tab);
				}
			},
			click: function click(event) {
				event.preventDefault();

				_this.changeActiveTab(event.currentTarget.dataset.tab);
			}
		});
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.activateDefaultTab();
	},

	onEditSettingsChange: function onEditSettingsChange(propertyName) {
		if ('activeItemIndex' === propertyName) {
			this.activateDefaultTab();
		}
	},

	changeActiveTab: function changeActiveTab(tabIndex) {
		var isActiveTab = this.isActiveTab(tabIndex),
		    settings = this.getSettings();

		if ((settings.toggleSelf || !isActiveTab) && settings.hidePrevious) {
			this.deactivateActiveTab();
		}

		if (!settings.hidePrevious && isActiveTab) {
			this.deactivateActiveTab(tabIndex);
		}

		if (!isActiveTab) {
			this.activateTab(tabIndex);
		}
	}
});

/***/ }),

/***/ 182:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _documentsManager = __webpack_require__(183);

var _documentsManager2 = _interopRequireDefault(_documentsManager);

var _hotKeys = __webpack_require__(16);

var _hotKeys2 = _interopRequireDefault(_hotKeys);

var _storage = __webpack_require__(15);

var _storage2 = _interopRequireDefault(_storage);

var _environment = __webpack_require__(1);

var _environment2 = _interopRequireDefault(_environment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; } /* global elementorFrontendConfig */


var EventManager = __webpack_require__(13),
    ElementsHandler = __webpack_require__(184),
    YouTubeModule = __webpack_require__(196),
    AnchorsModule = __webpack_require__(197),
    LightboxModule = __webpack_require__(198);

var Frontend = function (_elementorModules$Vie) {
	_inherits(Frontend, _elementorModules$Vie);

	function Frontend() {
		var _ref;

		_classCallCheck(this, Frontend);

		for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
			args[_key] = arguments[_key];
		}

		var _this = _possibleConstructorReturn(this, (_ref = Frontend.__proto__ || Object.getPrototypeOf(Frontend)).call.apply(_ref, [this].concat(args)));

		_this.config = elementorFrontendConfig;
		return _this;
	}

	// TODO: BC since 2.5.0


	_createClass(Frontend, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					elementor: '.elementor',
					adminBar: '#wpadminbar'
				},
				classes: {
					ie: 'elementor-msie'
				}
			};
		}
	}, {
		key: 'getDefaultElements',
		value: function getDefaultElements() {
			var defaultElements = {
				window: window,
				$window: jQuery(window),
				$document: jQuery(document),
				$head: jQuery(document.head),
				$body: jQuery(document.body),
				$deviceMode: jQuery('<span>', { id: 'elementor-device-mode', class: 'elementor-screen-only' })
			};
			defaultElements.$body.append(defaultElements.$deviceMode);

			return defaultElements;
		}
	}, {
		key: 'bindEvents',
		value: function bindEvents() {
			var _this2 = this;

			this.elements.$window.on('resize', function () {
				return _this2.setDeviceModeData();
			});
		}

		/**
   * @deprecated 2.4.0 Use just `this.elements` instead
   */

	}, {
		key: 'getElements',
		value: function getElements(elementName) {
			return this.getItems(this.elements, elementName);
		}

		/**
   * @deprecated 2.4.0 This method was never in use
   */

	}, {
		key: 'getPageSettings',
		value: function getPageSettings(settingName) {
			var settingsObject = this.isEditMode() ? elementor.settings.page.model.attributes : this.config.settings.page;

			return this.getItems(settingsObject, settingName);
		}
	}, {
		key: 'getGeneralSettings',
		value: function getGeneralSettings(settingName) {
			var settingsObject = this.isEditMode() ? elementor.settings.general.model.attributes : this.config.settings.general;

			return this.getItems(settingsObject, settingName);
		}
	}, {
		key: 'getCurrentDeviceMode',
		value: function getCurrentDeviceMode() {
			return getComputedStyle(this.elements.$deviceMode[0], ':after').content.replace(/"/g, '');
		}
	}, {
		key: 'getCurrentDeviceSetting',
		value: function getCurrentDeviceSetting(settings, settingKey) {
			var devices = ['desktop', 'tablet', 'mobile'],
			    currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

			var currentDeviceIndex = devices.indexOf(currentDeviceMode);

			while (currentDeviceIndex > 0) {
				var currentDevice = devices[currentDeviceIndex],
				    fullSettingKey = settingKey + '_' + currentDevice,
				    deviceValue = settings[fullSettingKey];

				if (deviceValue) {
					return deviceValue;
				}

				currentDeviceIndex--;
			}

			return settings[settingKey];
		}
	}, {
		key: 'isEditMode',
		value: function isEditMode() {
			return this.config.environmentMode.edit;
		}
	}, {
		key: 'isWPPreviewMode',
		value: function isWPPreviewMode() {
			return this.config.environmentMode.wpPreview;
		}
	}, {
		key: 'initDialogsManager',
		value: function initDialogsManager() {
			var dialogsManager = void 0;

			this.getDialogsManager = function () {
				if (!dialogsManager) {
					dialogsManager = new DialogsManager.Instance();
				}

				return dialogsManager;
			};
		}
	}, {
		key: 'initHotKeys',
		value: function initHotKeys() {
			this.hotKeys = new _hotKeys2.default();

			this.hotKeys.bindListener(this.elements.$window);
		}
	}, {
		key: 'initOnReadyComponents',
		value: function initOnReadyComponents() {
			this.utils = {
				youtube: new YouTubeModule(),
				anchors: new AnchorsModule(),
				lightbox: new LightboxModule()
			};

			// TODO: BC since 2.4.0
			this.modules = {
				StretchElement: elementorModules.frontend.tools.StretchElement,
				Masonry: elementorModules.utils.Masonry
			};

			this.elementsHandler = new ElementsHandler(jQuery);

			this.documentsManager = new _documentsManager2.default();

			this.trigger('components:init');
		}
	}, {
		key: 'initOnReadyElements',
		value: function initOnReadyElements() {
			this.elements.$wpAdminBar = this.elements.$document.find(this.getSettings('selectors.adminBar'));
		}
	}, {
		key: 'addIeCompatibility',
		value: function addIeCompatibility() {
			var el = document.createElement('div'),
			    supportsGrid = 'string' === typeof el.style.grid;

			if (!_environment2.default.ie && supportsGrid) {
				return;
			}

			this.elements.$body.addClass(this.getSettings('classes.ie'));

			var msieCss = '<link rel="stylesheet" id="elementor-frontend-css-msie" href="' + this.config.urls.assets + 'css/frontend-msie.min.css?' + this.config.version + '" type="text/css" />';

			this.elements.$body.append(msieCss);
		}
	}, {
		key: 'setDeviceModeData',
		value: function setDeviceModeData() {
			this.elements.$body.attr('data-elementor-device-mode', this.getCurrentDeviceMode());
		}
	}, {
		key: 'addListenerOnce',
		value: function addListenerOnce(listenerID, event, callback, to) {
			if (!to) {
				to = this.elements.$window;
			}

			if (!this.isEditMode()) {
				to.on(event, callback);

				return;
			}

			this.removeListeners(listenerID, event, to);

			if (to instanceof jQuery) {
				var eventNS = event + '.' + listenerID;

				to.on(eventNS, callback);
			} else {
				to.on(event, callback, listenerID);
			}
		}
	}, {
		key: 'removeListeners',
		value: function removeListeners(listenerID, event, callback, from) {
			if (!from) {
				from = this.elements.$window;
			}

			if (from instanceof jQuery) {
				var eventNS = event + '.' + listenerID;

				from.off(eventNS, callback);
			} else {
				from.off(event, callback, listenerID);
			}
		}

		// Based on underscore function

	}, {
		key: 'debounce',
		value: function debounce(func, wait) {
			var timeout = void 0;

			return function () {
				var context = this,
				    args = arguments;

				var later = function later() {
					timeout = null;

					func.apply(context, args);
				};

				var callNow = !timeout;

				clearTimeout(timeout);

				timeout = setTimeout(later, wait);

				if (callNow) {
					func.apply(context, args);
				}
			};
		}
	}, {
		key: 'waypoint',
		value: function waypoint($element, callback, options) {
			var defaultOptions = {
				offset: '100%',
				triggerOnce: true
			};

			options = jQuery.extend(defaultOptions, options);

			var correctCallback = function correctCallback() {
				var element = this.element || this,
				    result = callback.apply(element, arguments);

				// If is Waypoint new API and is frontend
				if (options.triggerOnce && this.destroy) {
					this.destroy();
				}

				return result;
			};

			return $element.elementorWaypoint(correctCallback, options);
		}
	}, {
		key: 'muteMigrationTraces',
		value: function muteMigrationTraces() {
			jQuery.migrateMute = true;

			jQuery.migrateTrace = false;
		}
	}, {
		key: 'init',
		value: function init() {
			this.hooks = new EventManager();

			this.storage = new _storage2.default();

			this.addIeCompatibility();

			this.setDeviceModeData();

			this.initDialogsManager();

			if (this.isEditMode()) {
				this.muteMigrationTraces();
			}

			// Keep this line before `initOnReadyComponents` call
			this.elements.$window.trigger('elementor/frontend/init');

			if (!this.isEditMode()) {
				this.initHotKeys();
			}

			this.initOnReadyElements();

			this.initOnReadyComponents();
		}
	}, {
		key: 'Module',
		get: function get() {
			/*if ( this.isEditMode() ) {
   	parent.elementorCommon.helpers.deprecatedMethod( 'elementorFrontend.Module', '2.5.0', 'elementorModules.frontend.handlers.Base' );
   }*/

			return elementorModules.frontend.handlers.Base;
		}
	}]);

	return Frontend;
}(elementorModules.ViewModule);

window.elementorFrontend = new Frontend();

if (!elementorFrontend.isEditMode()) {
	jQuery(function () {
		return elementorFrontend.init();
	});
}

/***/ }),

/***/ 183:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _document = __webpack_require__(17);

var _document2 = _interopRequireDefault(_document);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		var _ref;

		_classCallCheck(this, _class);

		for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
			args[_key] = arguments[_key];
		}

		var _this = _possibleConstructorReturn(this, (_ref = _class.__proto__ || Object.getPrototypeOf(_class)).call.apply(_ref, [this].concat(args)));

		_this.documents = {};

		_this.initDocumentClasses();

		_this.attachDocumentsClasses();
		return _this;
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					document: '.elementor'
				}
			};
		}
	}, {
		key: 'getDefaultElements',
		value: function getDefaultElements() {
			var selectors = this.getSettings('selectors');

			return {
				$documents: jQuery(selectors.document)
			};
		}
	}, {
		key: 'initDocumentClasses',
		value: function initDocumentClasses() {
			this.documentClasses = {
				base: _document2.default
			};

			elementorFrontend.hooks.doAction('elementor/frontend/documents-manager/init-classes', this);
		}
	}, {
		key: 'addDocumentClass',
		value: function addDocumentClass(documentType, documentClass) {
			this.documentClasses[documentType] = documentClass;
		}
	}, {
		key: 'attachDocumentsClasses',
		value: function attachDocumentsClasses() {
			var _this2 = this;

			this.elements.$documents.each(function (index, document) {
				return _this2.attachDocumentClass(jQuery(document));
			});
		}
	}, {
		key: 'attachDocumentClass',
		value: function attachDocumentClass($document) {
			var documentData = $document.data(),
			    documentID = documentData.elementorId,
			    documentType = documentData.elementorType,
			    DocumentClass = this.documentClasses[documentType] || this.documentClasses.base;

			this.documents[documentID] = new DocumentClass({
				$element: $document,
				id: documentID
			});
		}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

/***/ 184:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($) {
	var self = this;

	// element-type.skin-type
	var handlers = {
		// Elements
		section: __webpack_require__(185),

		// Widgets
		'accordion.default': __webpack_require__(186),
		'alert.default': __webpack_require__(187),
		'counter.default': __webpack_require__(188),
		'progress.default': __webpack_require__(189),
		'tabs.default': __webpack_require__(190),
		'toggle.default': __webpack_require__(191),
		'video.default': __webpack_require__(192),
		'image-carousel.default': __webpack_require__(193),
		'text-editor.default': __webpack_require__(194)
	};

	var handlersInstances = {};

	var addGlobalHandlers = function addGlobalHandlers() {
		elementorFrontend.hooks.addAction('frontend/element_ready/global', __webpack_require__(195));
	};

	var addElementsHandlers = function addElementsHandlers() {
		$.each(handlers, function (elementName, funcCallback) {
			elementorFrontend.hooks.addAction('frontend/element_ready/' + elementName, funcCallback);
		});
	};

	var init = function init() {
		self.initHandlers();
	};

	this.initHandlers = function () {
		addGlobalHandlers();

		addElementsHandlers();
	};

	this.addHandler = function (HandlerClass, options) {
		var elementID = options.$element.data('model-cid');

		var handlerID = void 0;

		// If element is in edit mode
		if (elementID) {
			handlerID = HandlerClass.prototype.getConstructorID();

			if (!handlersInstances[elementID]) {
				handlersInstances[elementID] = {};
			}

			var oldHandler = handlersInstances[elementID][handlerID];

			if (oldHandler) {
				oldHandler.onDestroy();
			}
		}

		var newHandler = new HandlerClass(options);

		if (elementID) {
			handlersInstances[elementID][handlerID] = newHandler;
		}
	};

	this.getHandlers = function (handlerName) {
		if (handlerName) {
			return handlers[handlerName];
		}

		return handlers;
	};

	this.runReadyTrigger = function (scope) {
		// Initializing the `$scope` as frontend jQuery instance
		var $scope = jQuery(scope),
		    elementType = $scope.attr('data-element_type');

		if (!elementType) {
			return;
		}

		elementorFrontend.hooks.doAction('frontend/element_ready/global', $scope, $);

		elementorFrontend.hooks.doAction('frontend/element_ready/' + elementType, $scope, $);

		if ('widget' === elementType) {
			elementorFrontend.hooks.doAction('frontend/element_ready/' + $scope.attr('data-widget_type'), $scope, $);
		}
	};

	init();
};

/***/ }),

/***/ 185:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var BackgroundVideo = elementorModules.frontend.handlers.Base.extend({
	player: null,

	isYTVideo: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				backgroundVideoContainer: '.elementor-background-video-container',
				backgroundVideoEmbed: '.elementor-background-video-embed',
				backgroundVideoHosted: '.elementor-background-video-hosted'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
		    elements = {
			$backgroundVideoContainer: this.$element.find(selectors.backgroundVideoContainer)
		};

		elements.$backgroundVideoEmbed = elements.$backgroundVideoContainer.children(selectors.backgroundVideoEmbed);

		elements.$backgroundVideoHosted = elements.$backgroundVideoContainer.children(selectors.backgroundVideoHosted);

		return elements;
	},

	calcVideosSize: function calcVideosSize() {
		var containerWidth = this.elements.$backgroundVideoContainer.outerWidth(),
		    containerHeight = this.elements.$backgroundVideoContainer.outerHeight(),
		    aspectRatioSetting = '16:9',
		    //TEMP
		aspectRatioArray = aspectRatioSetting.split(':'),
		    aspectRatio = aspectRatioArray[0] / aspectRatioArray[1],
		    ratioWidth = containerWidth / aspectRatio,
		    ratioHeight = containerHeight * aspectRatio,
		    isWidthFixed = containerWidth / containerHeight > aspectRatio;

		return {
			width: isWidthFixed ? containerWidth : ratioHeight,
			height: isWidthFixed ? ratioWidth : containerHeight
		};
	},

	changeVideoSize: function changeVideoSize() {
		var $video = this.isYTVideo ? jQuery(this.player.getIframe()) : this.elements.$backgroundVideoHosted,
		    size = this.calcVideosSize();

		$video.width(size.width).height(size.height);
	},

	startVideoLoop: function startVideoLoop() {
		var self = this;

		// If the section has been removed
		if (!self.player.getIframe().contentWindow) {
			return;
		}

		var elementSettings = self.getElementSettings(),
		    startPoint = elementSettings.background_video_start || 0,
		    endPoint = elementSettings.background_video_end;

		self.player.seekTo(startPoint);

		if (endPoint) {
			var durationToEnd = endPoint - startPoint + 1;

			setTimeout(function () {
				self.startVideoLoop();
			}, durationToEnd * 1000);
		}
	},

	prepareYTVideo: function prepareYTVideo(YT, videoID) {
		var self = this,
		    $backgroundVideoContainer = self.elements.$backgroundVideoContainer,
		    elementSettings = self.getElementSettings(),
		    startStateCode = YT.PlayerState.PLAYING;

		// Since version 67, Chrome doesn't fire the `PLAYING` state at start time
		if (window.chrome) {
			startStateCode = YT.PlayerState.UNSTARTED;
		}

		$backgroundVideoContainer.addClass('elementor-loading elementor-invisible');

		self.player = new YT.Player(self.elements.$backgroundVideoEmbed[0], {
			videoId: videoID,
			events: {
				onReady: function onReady() {
					self.player.mute();

					self.changeVideoSize();

					self.startVideoLoop();

					self.player.playVideo();
				},
				onStateChange: function onStateChange(event) {
					switch (event.data) {
						case startStateCode:
							$backgroundVideoContainer.removeClass('elementor-invisible elementor-loading');

							break;
						case YT.PlayerState.ENDED:
							self.player.seekTo(elementSettings.background_video_start || 0);
					}
				}
			},
			playerVars: {
				controls: 0,
				rel: 0
			}
		});
	},

	activate: function activate() {
		var self = this,
		    videoLink = self.getElementSettings('background_video_link'),
		    videoID = elementorFrontend.utils.youtube.getYoutubeIDFromURL(videoLink);

		self.isYTVideo = !!videoID;

		if (videoID) {
			elementorFrontend.utils.youtube.onYoutubeApiReady(function (YT) {
				setTimeout(function () {
					self.prepareYTVideo(YT, videoID);
				}, 1);
			});
		} else {
			self.elements.$backgroundVideoHosted.attr('src', videoLink).one('canplay', self.changeVideoSize);
		}

		elementorFrontend.elements.$window.on('resize', self.changeVideoSize);
	},

	deactivate: function deactivate() {
		if (this.isYTVideo && this.player.getIframe()) {
			this.player.destroy();
		} else {
			this.elements.$backgroundVideoHosted.removeAttr('src');
		}

		elementorFrontend.elements.$window.off('resize', this.changeVideoSize);
	},

	run: function run() {
		var elementSettings = this.getElementSettings();

		if ('video' === elementSettings.background_background && elementSettings.background_video_link) {
			this.activate();
		} else {
			this.deactivate();
		}
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.run();
	},

	onElementChange: function onElementChange(propertyName) {
		if ('background_background' === propertyName) {
			this.run();
		}
	}
});

var StretchedSection = elementorModules.frontend.handlers.Base.extend({

	stretchElement: null,

	bindEvents: function bindEvents() {
		var handlerID = this.getUniqueHandlerID();

		elementorFrontend.addListenerOnce(handlerID, 'resize', this.stretch);

		elementorFrontend.addListenerOnce(handlerID, 'sticky:stick', this.stretch, this.$element);

		elementorFrontend.addListenerOnce(handlerID, 'sticky:unstick', this.stretch, this.$element);
	},

	unbindEvents: function unbindEvents() {
		elementorFrontend.removeListeners(this.getUniqueHandlerID(), 'resize', this.stretch);
	},

	initStretch: function initStretch() {
		this.stretchElement = new elementorModules.frontend.tools.StretchElement({
			element: this.$element,
			selectors: {
				container: this.getStretchContainer()
			}
		});
	},

	getStretchContainer: function getStretchContainer() {
		return elementorFrontend.getGeneralSettings('elementor_stretched_section_container') || window;
	},

	stretch: function stretch() {
		if (!this.getElementSettings('stretch_section')) {
			return;
		}

		this.stretchElement.stretch();
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.initStretch();

		this.stretch();
	},

	onElementChange: function onElementChange(propertyName) {
		if ('stretch_section' === propertyName) {
			if (this.getElementSettings('stretch_section')) {
				this.stretch();
			} else {
				this.stretchElement.reset();
			}
		}
	},

	onGeneralSettingsChange: function onGeneralSettingsChange(changed) {
		if ('elementor_stretched_section_container' in changed) {
			this.stretchElement.setSettings('selectors.container', this.getStretchContainer());

			this.stretch();
		}
	}
});

var Shapes = elementorModules.frontend.handlers.Base.extend({

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				container: '> .elementor-shape-%s'
			},
			svgURL: elementorFrontend.config.urls.assets + 'shapes/'
		};
	},

	getDefaultElements: function getDefaultElements() {
		var elements = {},
		    selectors = this.getSettings('selectors');

		elements.$topContainer = this.$element.find(selectors.container.replace('%s', 'top'));

		elements.$bottomContainer = this.$element.find(selectors.container.replace('%s', 'bottom'));

		return elements;
	},

	getSvgURL: function getSvgURL(shapeType, fileName) {
		var svgURL = this.getSettings('svgURL') + fileName + '.svg';
		if (elementor.config.additional_shapes && shapeType in elementor.config.additional_shapes) {
			svgURL = elementor.config.additional_shapes[shapeType];
		}
		return svgURL;
	},


	buildSVG: function buildSVG(side) {
		var self = this,
		    baseSettingKey = 'shape_divider_' + side,
		    shapeType = self.getElementSettings(baseSettingKey),
		    $svgContainer = this.elements['$' + side + 'Container'];

		$svgContainer.attr('data-shape', shapeType);

		if (!shapeType) {
			$svgContainer.empty(); // Shape-divider set to 'none'
			return;
		}

		var fileName = shapeType;

		if (self.getElementSettings(baseSettingKey + '_negative')) {
			fileName += '-negative';
		}

		var svgURL = self.getSvgURL(shapeType, fileName);

		jQuery.get(svgURL, function (data) {
			$svgContainer.empty().append(data.childNodes[0]);
		});

		this.setNegative(side);
	},

	setNegative: function setNegative(side) {
		this.elements['$' + side + 'Container'].attr('data-negative', !!this.getElementSettings('shape_divider_' + side + '_negative'));
	},

	onInit: function onInit() {
		var self = this;

		elementorModules.frontend.handlers.Base.prototype.onInit.apply(self, arguments);

		['top', 'bottom'].forEach(function (side) {
			if (self.getElementSettings('shape_divider_' + side)) {
				self.buildSVG(side);
			}
		});
	},

	onElementChange: function onElementChange(propertyName) {
		var shapeChange = propertyName.match(/^shape_divider_(top|bottom)$/);

		if (shapeChange) {
			this.buildSVG(shapeChange[1]);

			return;
		}

		var negativeChange = propertyName.match(/^shape_divider_(top|bottom)_negative$/);

		if (negativeChange) {
			this.buildSVG(negativeChange[1]);

			this.setNegative(negativeChange[1]);
		}
	}
});

var HandlesPosition = elementorModules.frontend.handlers.Base.extend({

	isFirstSection: function isFirstSection() {
		return this.$element.is('.elementor-edit-mode .elementor-top-section:first');
	},

	isOverflowHidden: function isOverflowHidden() {
		return 'hidden' === this.$element.css('overflow');
	},

	getOffset: function getOffset() {
		if ('body' === elementor.config.document.container) {
			return this.$element.offset().top;
		}

		var $container = jQuery(elementor.config.document.container);
		return this.$element.offset().top - $container.offset().top;
	},

	setHandlesPosition: function setHandlesPosition() {
		var isOverflowHidden = this.isOverflowHidden();

		if (!isOverflowHidden && !this.isFirstSection()) {
			return;
		}

		var offset = isOverflowHidden ? 0 : this.getOffset(),
		    $handlesElement = this.$element.find('> .elementor-element-overlay > .elementor-editor-section-settings'),
		    insideHandleClass = 'elementor-section--handles-inside';

		if (offset < 25) {
			this.$element.addClass(insideHandleClass);

			if (offset < -5) {
				$handlesElement.css('top', -offset);
			} else {
				$handlesElement.css('top', '');
			}
		} else {
			this.$element.removeClass(insideHandleClass);
		}
	},

	onInit: function onInit() {
		this.setHandlesPosition();

		this.$element.on('mouseenter', this.setHandlesPosition);
	}
});

module.exports = function ($scope) {
	if (elementorFrontend.isEditMode() || $scope.hasClass('elementor-section-stretched')) {
		elementorFrontend.elementsHandler.addHandler(StretchedSection, { $element: $scope });
	}

	if (elementorFrontend.isEditMode()) {
		elementorFrontend.elementsHandler.addHandler(Shapes, { $element: $scope });
		elementorFrontend.elementsHandler.addHandler(HandlesPosition, { $element: $scope });
	}

	elementorFrontend.elementsHandler.addHandler(BackgroundVideo, { $element: $scope });
};

/***/ }),

/***/ 186:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TabsModule = __webpack_require__(18);

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(TabsModule, {
		$element: $scope,
		showTabFn: 'slideDown',
		hideTabFn: 'slideUp'
	});
};

/***/ }),

/***/ 187:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($scope, $) {
	$scope.find('.elementor-alert-dismiss').on('click', function () {
		$(this).parent().fadeOut();
	});
};

/***/ }),

/***/ 188:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($scope, $) {
	elementorFrontend.waypoint($scope.find('.elementor-counter-number'), function () {
		var $number = $(this),
		    data = $number.data();

		var decimalDigits = data.toValue.toString().match(/\.(.*)/);

		if (decimalDigits) {
			data.rounding = decimalDigits[1].length;
		}

		$number.numerator(data);
	});
};

/***/ }),

/***/ 189:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($scope, $) {
	elementorFrontend.waypoint($scope.find('.elementor-progress-bar'), function () {
		var $progressbar = $(this);

		$progressbar.css('width', $progressbar.data('max') + '%');
	});
};

/***/ }),

/***/ 190:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TabsModule = __webpack_require__(18);

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(TabsModule, {
		$element: $scope,
		toggleSelf: false
	});
};

/***/ }),

/***/ 191:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TabsModule = __webpack_require__(18);

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(TabsModule, {
		$element: $scope,
		showTabFn: 'slideDown',
		hideTabFn: 'slideUp',
		hidePrevious: false,
		autoExpand: 'editor'
	});
};

/***/ }),

/***/ 192:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var VideoModule = elementorModules.frontend.handlers.Base.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				imageOverlay: '.elementor-custom-embed-image-overlay',
				video: '.elementor-video',
				videoIframe: '.elementor-video-iframe'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$imageOverlay: this.$element.find(selectors.imageOverlay),
			$video: this.$element.find(selectors.video),
			$videoIframe: this.$element.find(selectors.videoIframe)
		};
	},

	getLightBox: function getLightBox() {
		return elementorFrontend.utils.lightbox;
	},

	handleVideo: function handleVideo() {
		if (!this.getElementSettings('lightbox')) {
			this.elements.$imageOverlay.remove();

			this.playVideo();
		}
	},

	playVideo: function playVideo() {
		if (this.elements.$video.length) {
			this.elements.$video[0].play();

			return;
		}

		var $videoIframe = this.elements.$videoIframe,
		    lazyLoad = $videoIframe.data('lazy-load');

		if (lazyLoad) {
			$videoIframe.attr('src', lazyLoad);
		}

		var newSourceUrl = $videoIframe[0].src.replace('&autoplay=0', '');

		$videoIframe[0].src = newSourceUrl + '&autoplay=1';
	},

	animateVideo: function animateVideo() {
		this.getLightBox().setEntranceAnimation(this.getCurrentDeviceSetting('lightbox_content_animation'));
	},

	handleAspectRatio: function handleAspectRatio() {
		this.getLightBox().setVideoAspectRatio(this.getElementSettings('aspect_ratio'));
	},

	bindEvents: function bindEvents() {
		this.elements.$imageOverlay.on('click', this.handleVideo);
	},

	onElementChange: function onElementChange(propertyName) {
		if (0 === propertyName.indexOf('lightbox_content_animation')) {
			this.animateVideo();

			return;
		}

		var isLightBoxEnabled = this.getElementSettings('lightbox');

		if ('lightbox' === propertyName && !isLightBoxEnabled) {
			this.getLightBox().getModal().hide();

			return;
		}

		if ('aspect_ratio' === propertyName && isLightBoxEnabled) {
			this.handleAspectRatio();
		}
	}
});

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(VideoModule, { $element: $scope });
};

/***/ }),

/***/ 193:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var ImageCarouselHandler = elementorModules.frontend.handlers.Base.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				carousel: '.elementor-image-carousel'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$carousel: this.$element.find(selectors.carousel)
		};
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		var elementSettings = this.getElementSettings(),
		    slidesToShow = +elementSettings.slides_to_show || 3,
		    isSingleSlide = 1 === slidesToShow,
		    defaultLGDevicesSlidesCount = isSingleSlide ? 1 : 2,
		    breakpoints = elementorFrontend.config.breakpoints;

		var slickOptions = {
			slidesToShow: slidesToShow,
			autoplay: 'yes' === elementSettings.autoplay,
			autoplaySpeed: elementSettings.autoplay_speed,
			infinite: 'yes' === elementSettings.infinite,
			pauseOnHover: 'yes' === elementSettings.pause_on_hover,
			speed: elementSettings.speed,
			arrows: -1 !== ['arrows', 'both'].indexOf(elementSettings.navigation),
			dots: -1 !== ['dots', 'both'].indexOf(elementSettings.navigation),
			rtl: 'rtl' === elementSettings.direction,
			responsive: [{
				breakpoint: breakpoints.lg,
				settings: {
					slidesToShow: +elementSettings.slides_to_show_tablet || defaultLGDevicesSlidesCount,
					slidesToScroll: +elementSettings.slides_to_scroll_tablet || defaultLGDevicesSlidesCount
				}
			}, {
				breakpoint: breakpoints.md,
				settings: {
					slidesToShow: +elementSettings.slides_to_show_mobile || 1,
					slidesToScroll: +elementSettings.slides_to_scroll_mobile || 1
				}
			}]
		};

		if (isSingleSlide) {
			slickOptions.fade = 'fade' === elementSettings.effect;
		} else {
			slickOptions.slidesToScroll = +elementSettings.slides_to_scroll || defaultLGDevicesSlidesCount;
		}

		this.elements.$carousel.slick(slickOptions);
	}
});

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(ImageCarouselHandler, { $element: $scope });
};

/***/ }),

/***/ 194:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TextEditor = elementorModules.frontend.handlers.Base.extend({
	dropCapLetter: '',

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				paragraph: 'p:first'
			},
			classes: {
				dropCap: 'elementor-drop-cap',
				dropCapLetter: 'elementor-drop-cap-letter'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
		    classes = this.getSettings('classes'),
		    $dropCap = jQuery('<span>', { class: classes.dropCap }),
		    $dropCapLetter = jQuery('<span>', { class: classes.dropCapLetter });

		$dropCap.append($dropCapLetter);

		return {
			$paragraph: this.$element.find(selectors.paragraph),
			$dropCap: $dropCap,
			$dropCapLetter: $dropCapLetter
		};
	},

	wrapDropCap: function wrapDropCap() {
		var isDropCapEnabled = this.getElementSettings('drop_cap');

		if (!isDropCapEnabled) {
			// If there is an old drop cap inside the paragraph
			if (this.dropCapLetter) {
				this.elements.$dropCap.remove();

				this.elements.$paragraph.prepend(this.dropCapLetter);

				this.dropCapLetter = '';
			}

			return;
		}

		var $paragraph = this.elements.$paragraph;

		if (!$paragraph.length) {
			return;
		}

		var paragraphContent = $paragraph.html().replace(/&nbsp;/g, ' '),
		    firstLetterMatch = paragraphContent.match(/^ *([^ ] ?)/);

		if (!firstLetterMatch) {
			return;
		}

		var firstLetter = firstLetterMatch[1],
		    trimmedFirstLetter = firstLetter.trim();

		// Don't apply drop cap when the content starting with an HTML tag
		if ('<' === trimmedFirstLetter) {
			return;
		}

		this.dropCapLetter = firstLetter;

		this.elements.$dropCapLetter.text(trimmedFirstLetter);

		var restoredParagraphContent = paragraphContent.slice(firstLetter.length).replace(/^ */, function (match) {
			return new Array(match.length + 1).join('&nbsp;');
		});

		$paragraph.html(restoredParagraphContent).prepend(this.elements.$dropCap);
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.wrapDropCap();
	},

	onElementChange: function onElementChange(propertyName) {
		if ('drop_cap' === propertyName) {
			this.wrapDropCap();
		}
	}
});

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(TextEditor, { $element: $scope });
};

/***/ }),

/***/ 195:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var GlobalHandler = elementorModules.frontend.handlers.Base.extend({
	getWidgetType: function getWidgetType() {
		return 'global';
	},
	animate: function animate() {
		var $element = this.$element,
		    animation = this.getAnimation();

		if ('none' === animation) {
			$element.removeClass('elementor-invisible');
			return;
		}

		var elementSettings = this.getElementSettings(),
		    animationDelay = elementSettings._animation_delay || elementSettings.animation_delay || 0;

		$element.removeClass(animation);

		if (this.currentAnimation) {
			$element.removeClass(this.currentAnimation);
		}

		this.currentAnimation = animation;

		setTimeout(function () {
			$element.removeClass('elementor-invisible').addClass('animated ' + animation);
		}, animationDelay);
	},
	getAnimation: function getAnimation() {
		return this.getCurrentDeviceSetting('animation') || this.getCurrentDeviceSetting('_animation');
	},
	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		if (this.getAnimation()) {
			elementorFrontend.waypoint(this.$element, this.animate.bind(this));
		}
	},
	onElementChange: function onElementChange(propertyName) {
		if (/^_?animation/.test(propertyName)) {
			this.animate();
		}
	}
});

module.exports = function ($scope) {
	elementorFrontend.elementsHandler.addHandler(GlobalHandler, { $element: $scope });
};

/***/ }),

/***/ 196:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			isInserted: false,
			APISrc: 'https://www.youtube.com/iframe_api',
			selectors: {
				firstScript: 'script:first'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		return {
			$firstScript: jQuery(this.getSettings('selectors.firstScript'))
		};
	},

	insertYTAPI: function insertYTAPI() {
		this.setSettings('isInserted', true);

		this.elements.$firstScript.before(jQuery('<script>', { src: this.getSettings('APISrc') }));
	},

	onYoutubeApiReady: function onYoutubeApiReady(callback) {
		var self = this;

		if (!self.getSettings('IsInserted')) {
			self.insertYTAPI();
		}

		if (window.YT && YT.loaded) {
			callback(YT);
		} else {
			// If not ready check again by timeout..
			setTimeout(function () {
				self.onYoutubeApiReady(callback);
			}, 350);
		}
	},

	getYoutubeIDFromURL: function getYoutubeIDFromURL(url) {
		var videoIDParts = url.match(/^(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^?&"'>]+)/);

		return videoIDParts && videoIDParts[1];
	}
});

/***/ }),

/***/ 197:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			scrollDuration: 500,
			selectors: {
				links: 'a[href*="#"]',
				targets: '.elementor-element, .elementor-menu-anchor',
				scrollable: 'html, body'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var $ = jQuery,
		    selectors = this.getSettings('selectors');

		return {
			$scrollable: $(selectors.scrollable)
		};
	},

	bindEvents: function bindEvents() {
		elementorFrontend.elements.$document.on('click', this.getSettings('selectors.links'), this.handleAnchorLinks);
	},

	handleAnchorLinks: function handleAnchorLinks(event) {
		var clickedLink = event.currentTarget,
		    isSamePathname = location.pathname === clickedLink.pathname,
		    isSameHostname = location.hostname === clickedLink.hostname,
		    $anchor;

		if (!isSameHostname || !isSamePathname || clickedLink.hash.length < 2) {
			return;
		}

		try {
			$anchor = jQuery(clickedLink.hash).filter(this.getSettings('selectors.targets'));
		} catch (e) {
			return;
		}

		if (!$anchor.length) {
			return;
		}

		var scrollTop = $anchor.offset().top,
		    $wpAdminBar = elementorFrontend.elements.$wpAdminBar,
		    $activeStickies = jQuery('.elementor-section.elementor-sticky--active'),
		    maxStickyHeight = 0;

		if ($wpAdminBar.length > 0) {
			scrollTop -= $wpAdminBar.height();
		}

		// Offset height of tallest sticky
		if ($activeStickies.length > 0) {
			maxStickyHeight = Math.max.apply(null, $activeStickies.map(function () {
				return jQuery(this).outerHeight();
			}).get());

			scrollTop -= maxStickyHeight;
		}

		event.preventDefault();

		scrollTop = elementorFrontend.hooks.applyFilters('frontend/handlers/menu_anchor/scroll_top_distance', scrollTop);

		this.elements.$scrollable.animate({
			scrollTop: scrollTop
		}, this.getSettings('scrollDuration'), 'linear');
	},

	onInit: function onInit() {
		elementorModules.ViewModule.prototype.onInit.apply(this, arguments);

		this.bindEvents();
	}
});

/***/ }),

/***/ 198:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	oldAspectRatio: null,

	oldAnimation: null,

	swiper: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			classes: {
				aspectRatio: 'elementor-aspect-ratio-%s',
				item: 'elementor-lightbox-item',
				image: 'elementor-lightbox-image',
				videoContainer: 'elementor-video-container',
				videoWrapper: 'elementor-fit-aspect-ratio',
				playButton: 'elementor-custom-embed-play',
				playButtonIcon: 'fa',
				playing: 'elementor-playing',
				hidden: 'elementor-hidden',
				invisible: 'elementor-invisible',
				preventClose: 'elementor-lightbox-prevent-close',
				slideshow: {
					container: 'swiper-container',
					slidesWrapper: 'swiper-wrapper',
					prevButton: 'elementor-swiper-button elementor-swiper-button-prev',
					nextButton: 'elementor-swiper-button elementor-swiper-button-next',
					prevButtonIcon: 'eicon-chevron-left',
					nextButtonIcon: 'eicon-chevron-right',
					slide: 'swiper-slide'
				}
			},
			selectors: {
				links: 'a, [data-elementor-lightbox]',
				slideshow: {
					activeSlide: '.swiper-slide-active',
					prevSlide: '.swiper-slide-prev',
					nextSlide: '.swiper-slide-next'
				}
			},
			modalOptions: {
				id: 'elementor-lightbox',
				entranceAnimation: 'zoomIn',
				videoAspectRatio: 169,
				position: {
					enable: false
				}
			}
		};
	},

	getModal: function getModal() {
		if (!module.exports.modal) {
			this.initModal();
		}

		return module.exports.modal;
	},

	initModal: function initModal() {
		var modal = module.exports.modal = elementorFrontend.getDialogsManager().createWidget('lightbox', {
			className: 'elementor-lightbox',
			closeButton: true,
			closeButtonClass: 'eicon-close',
			selectors: {
				preventClose: '.' + this.getSettings('classes.preventClose')
			},
			hide: {
				onClick: true
			}
		});

		modal.on('hide', function () {
			modal.setMessage('');
		});
	},

	showModal: function showModal(options) {
		var self = this,
		    defaultOptions = self.getDefaultSettings().modalOptions;

		self.setSettings('modalOptions', jQuery.extend(defaultOptions, options.modalOptions));

		var modal = self.getModal();

		modal.setID(self.getSettings('modalOptions.id'));

		modal.onShow = function () {
			DialogsManager.getWidgetType('lightbox').prototype.onShow.apply(modal, arguments);

			self.setEntranceAnimation();
		};

		modal.onHide = function () {
			DialogsManager.getWidgetType('lightbox').prototype.onHide.apply(modal, arguments);

			modal.getElements('message').removeClass('animated');
		};

		switch (options.type) {
			case 'image':
				self.setImageContent(options.url);

				break;
			case 'video':
				self.setVideoContent(options);

				break;
			case 'slideshow':
				self.setSlideshowContent(options.slideshow);

				break;
			default:
				self.setHTMLContent(options.html);
		}

		modal.show();
	},

	setHTMLContent: function setHTMLContent(html) {
		this.getModal().setMessage(html);
	},

	setImageContent: function setImageContent(imageURL) {
		var self = this,
		    classes = self.getSettings('classes'),
		    $item = jQuery('<div>', { class: classes.item }),
		    $image = jQuery('<img>', { src: imageURL, class: classes.image + ' ' + classes.preventClose });

		$item.append($image);

		self.getModal().setMessage($item);
	},

	setVideoContent: function setVideoContent(options) {
		var classes = this.getSettings('classes'),
		    $videoContainer = jQuery('<div>', { class: classes.videoContainer }),
		    $videoWrapper = jQuery('<div>', { class: classes.videoWrapper }),
		    $videoElement,
		    modal = this.getModal();

		if ('hosted' === options.videoType) {
			var videoParams = jQuery.extend({ src: options.url, autoplay: '' }, options.videoParams);

			$videoElement = jQuery('<video>', videoParams);
		} else {
			var videoURL = options.url.replace('&autoplay=0', '') + '&autoplay=1';

			$videoElement = jQuery('<iframe>', { src: videoURL, allowfullscreen: 1 });
		}

		$videoContainer.append($videoWrapper);

		$videoWrapper.append($videoElement);

		modal.setMessage($videoContainer);

		this.setVideoAspectRatio();

		var onHideMethod = modal.onHide;

		modal.onHide = function () {
			onHideMethod();

			modal.getElements('message').removeClass('elementor-fit-aspect-ratio');
		};
	},

	setSlideshowContent: function setSlideshowContent(options) {
		var $ = jQuery,
		    self = this,
		    classes = self.getSettings('classes'),
		    slideshowClasses = classes.slideshow,
		    $container = $('<div>', { class: slideshowClasses.container }),
		    $slidesWrapper = $('<div>', { class: slideshowClasses.slidesWrapper }),
		    $prevButton = $('<div>', { class: slideshowClasses.prevButton + ' ' + classes.preventClose }).html($('<i>', { class: slideshowClasses.prevButtonIcon })),
		    $nextButton = $('<div>', { class: slideshowClasses.nextButton + ' ' + classes.preventClose }).html($('<i>', { class: slideshowClasses.nextButtonIcon }));

		options.slides.forEach(function (slide) {
			var slideClass = slideshowClasses.slide + ' ' + classes.item;

			if (slide.video) {
				slideClass += ' ' + classes.video;
			}

			var $slide = $('<div>', { class: slideClass });

			if (slide.video) {
				$slide.attr('data-elementor-slideshow-video', slide.video);

				var $playIcon = $('<div>', { class: classes.playButton }).html($('<i>', { class: classes.playButtonIcon }));

				$slide.append($playIcon);
			} else {
				var $zoomContainer = $('<div>', { class: 'swiper-zoom-container' }),
				    $slideImage = $('<img>', { class: classes.image + ' ' + classes.preventClose, src: slide.image });

				$zoomContainer.append($slideImage);

				$slide.append($zoomContainer);
			}

			$slidesWrapper.append($slide);
		});

		$container.append($slidesWrapper, $prevButton, $nextButton);

		var modal = self.getModal();

		modal.setMessage($container);

		var onShowMethod = modal.onShow;

		modal.onShow = function () {
			onShowMethod();

			var swiperOptions = {
				navigation: {
					prevEl: $prevButton,
					nextEl: $nextButton
				},
				pagination: {
					clickable: true
				},
				on: {
					slideChangeTransitionEnd: self.onSlideChange
				},
				grabCursor: true,
				runCallbacksOnInit: false,
				loop: true,
				keyboard: true
			};

			if (options.swiper) {
				$.extend(swiperOptions, options.swiper);
			}

			self.swiper = new Swiper($container, swiperOptions);

			self.setVideoAspectRatio();

			self.playSlideVideo();
		};
	},

	setVideoAspectRatio: function setVideoAspectRatio(aspectRatio) {
		aspectRatio = aspectRatio || this.getSettings('modalOptions.videoAspectRatio');

		var $widgetContent = this.getModal().getElements('widgetContent'),
		    oldAspectRatio = this.oldAspectRatio,
		    aspectRatioClass = this.getSettings('classes.aspectRatio');

		this.oldAspectRatio = aspectRatio;

		if (oldAspectRatio) {
			$widgetContent.removeClass(aspectRatioClass.replace('%s', oldAspectRatio));
		}

		if (aspectRatio) {
			$widgetContent.addClass(aspectRatioClass.replace('%s', aspectRatio));
		}
	},

	getSlide: function getSlide(slideState) {
		return jQuery(this.swiper.slides).filter(this.getSettings('selectors.slideshow.' + slideState + 'Slide'));
	},

	playSlideVideo: function playSlideVideo() {
		var $activeSlide = this.getSlide('active'),
		    videoURL = $activeSlide.data('elementor-slideshow-video');

		if (!videoURL) {
			return;
		}

		var classes = this.getSettings('classes'),
		    $videoContainer = jQuery('<div>', { class: classes.videoContainer + ' ' + classes.invisible }),
		    $videoWrapper = jQuery('<div>', { class: classes.videoWrapper }),
		    $videoFrame = jQuery('<iframe>', { src: videoURL }),
		    $playIcon = $activeSlide.children('.' + classes.playButton);

		$videoContainer.append($videoWrapper);

		$videoWrapper.append($videoFrame);

		$activeSlide.append($videoContainer);

		$playIcon.addClass(classes.playing).removeClass(classes.hidden);

		$videoFrame.on('load', function () {
			$playIcon.addClass(classes.hidden);

			$videoContainer.removeClass(classes.invisible);
		});
	},

	setEntranceAnimation: function setEntranceAnimation(animation) {
		animation = animation || elementorFrontend.getCurrentDeviceSetting(this.getSettings('modalOptions'), 'entranceAnimation');

		var $widgetMessage = this.getModal().getElements('message');

		if (this.oldAnimation) {
			$widgetMessage.removeClass(this.oldAnimation);
		}

		this.oldAnimation = animation;

		if (animation) {
			$widgetMessage.addClass('animated ' + animation);
		}
	},

	isLightboxLink: function isLightboxLink(element) {
		if ('A' === element.tagName && (element.hasAttribute('download') || !/\.(png|jpe?g|gif|svg)(\?.*)?$/i.test(element.href))) {
			return false;
		}

		var generalOpenInLightbox = elementorFrontend.getGeneralSettings('elementor_global_image_lightbox'),
		    currentLinkOpenInLightbox = element.dataset.elementorOpenLightbox;

		return 'yes' === currentLinkOpenInLightbox || generalOpenInLightbox && 'no' !== currentLinkOpenInLightbox;
	},

	openLink: function openLink(event) {
		var element = event.currentTarget,
		    $target = jQuery(event.target),
		    editMode = elementorFrontend.isEditMode(),
		    isClickInsideElementor = !!$target.closest('#elementor').length;

		if (!this.isLightboxLink(element)) {
			if (editMode && isClickInsideElementor) {
				event.preventDefault();
			}

			return;
		}

		event.preventDefault();

		if (editMode && !elementorFrontend.getGeneralSettings('elementor_enable_lightbox_in_editor')) {
			return;
		}

		var lightboxData = {};

		if (element.dataset.elementorLightbox) {
			lightboxData = JSON.parse(element.dataset.elementorLightbox);
		}

		if (lightboxData.type && 'slideshow' !== lightboxData.type) {
			this.showModal(lightboxData);

			return;
		}

		if (!element.dataset.elementorLightboxSlideshow) {
			this.showModal({
				type: 'image',
				url: element.href
			});

			return;
		}

		var slideshowID = element.dataset.elementorLightboxSlideshow;

		var $allSlideshowLinks = jQuery(this.getSettings('selectors.links')).filter(function () {
			return slideshowID === this.dataset.elementorLightboxSlideshow;
		});

		var slides = [],
		    uniqueLinks = {};

		$allSlideshowLinks.each(function () {
			var slideVideo = this.dataset.elementorLightboxVideo,
			    uniqueID = slideVideo || this.href;

			if (uniqueLinks[uniqueID]) {
				return;
			}

			uniqueLinks[uniqueID] = true;

			var slideIndex = this.dataset.elementorLightboxIndex;

			if (undefined === slideIndex) {
				slideIndex = $allSlideshowLinks.index(this);
			}

			var slideData = {
				image: this.href,
				index: slideIndex
			};

			if (slideVideo) {
				slideData.video = slideVideo;
			}

			slides.push(slideData);
		});

		slides.sort(function (a, b) {
			return a.index - b.index;
		});

		var initialSlide = element.dataset.elementorLightboxIndex;

		if (undefined === initialSlide) {
			initialSlide = $allSlideshowLinks.index(element);
		}

		this.showModal({
			type: 'slideshow',
			modalOptions: {
				id: 'elementor-lightbox-slideshow-' + slideshowID
			},
			slideshow: {
				slides: slides,
				swiper: {
					initialSlide: +initialSlide
				}
			}
		});
	},

	bindEvents: function bindEvents() {
		elementorFrontend.elements.$document.on('click', this.getSettings('selectors.links'), this.openLink);
	},

	onSlideChange: function onSlideChange() {
		this.getSlide('prev').add(this.getSlide('next')).add(this.getSlide('active')).find('.' + this.getSettings('classes.videoWrapper')).remove();

		this.playSlideVideo();
	}
});

/***/ })

/******/ });
//# sourceMappingURL=frontend.js.map