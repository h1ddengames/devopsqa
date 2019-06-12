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
/******/ 	return __webpack_require__(__webpack_require__.s = 204);
/******/ })
/************************************************************************/
/******/ ({

/***/ 12:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var InnerTabsBehavior;

InnerTabsBehavior = Marionette.Behavior.extend({

	onRenderCollection: function onRenderCollection() {
		this.handleInnerTabs(this.view);
	},

	handleInnerTabs: function handleInnerTabs(parent) {
		var closedClass = 'elementor-tab-close',
		    activeClass = 'elementor-tab-active',
		    tabsWrappers = parent.children.filter(function (view) {
			return 'tabs' === view.model.get('type');
		});

		_.each(tabsWrappers, function (view) {
			view.$el.find('.elementor-control-content').remove();

			var tabsId = view.model.get('name'),
			    tabs = parent.children.filter(function (childView) {
				return 'tab' === childView.model.get('type') && childView.model.get('tabs_wrapper') === tabsId;
			});

			_.each(tabs, function (childView, index) {
				view._addChildView(childView);

				var tabId = childView.model.get('name'),
				    controlsUnderTab = parent.children.filter(function (controlView) {
					return tabId === controlView.model.get('inner_tab');
				});

				if (0 === index) {
					childView.$el.addClass(activeClass);
				} else {
					_.each(controlsUnderTab, function (controlView) {
						controlView.$el.addClass(closedClass);
					});
				}
			});
		});
	},

	onChildviewControlTabClicked: function onChildviewControlTabClicked(childView) {
		var closedClass = 'elementor-tab-close',
		    activeClass = 'elementor-tab-active',
		    tabClicked = childView.model.get('name'),
		    childrenUnderTab = this.view.children.filter(function (view) {
			return 'tab' !== view.model.get('type') && childView.model.get('tabs_wrapper') === view.model.get('tabs_wrapper');
		}),
		    siblingTabs = this.view.children.filter(function (view) {
			return 'tab' === view.model.get('type') && childView.model.get('tabs_wrapper') === view.model.get('tabs_wrapper');
		});

		_.each(siblingTabs, function (view) {
			view.$el.removeClass(activeClass);
		});

		childView.$el.addClass(activeClass);

		_.each(childrenUnderTab, function (view) {
			if (view.model.get('inner_tab') === tabClicked) {
				view.$el.removeClass(closedClass);
			} else {
				view.$el.addClass(closedClass);
			}
		});

		elementor.getPanelView().updateScrollbar();
	}
});

module.exports = InnerTabsBehavior;

/***/ }),

/***/ 204:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _module = __webpack_require__(205);

var _module2 = _interopRequireDefault(_module);

var _introduction = __webpack_require__(206);

var _introduction2 = _interopRequireDefault(_introduction);

var _controlsStack = __webpack_require__(207);

var _controlsStack2 = _interopRequireDefault(_controlsStack);

var _baseSettings = __webpack_require__(208);

var _baseSettings2 = _interopRequireDefault(_baseSettings);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

elementorModules.editor = {
	elements: {
		models: {
			BaseSettings: _baseSettings2.default
		}
	},
	utils: {
		Module: _module2.default,
		Introduction: _introduction2.default
	},
	views: {
		ControlsStack: _controlsStack2.default
	}
};

/***/ }),

/***/ 205:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var EditorModule = elementorModules.Module.extend({

	onInit: function onInit() {
		jQuery(window).on('elementor:init', this.onElementorReady);
	},

	getEditorControlView: function getEditorControlView(name) {
		var editor = elementor.getPanelView().getCurrentPageView();

		return editor.children.findByModelCid(this.getEditorControlModel(name).cid);
	},

	getEditorControlModel: function getEditorControlModel(name) {
		var editor = elementor.getPanelView().getCurrentPageView();

		return editor.collection.findWhere({ name: name });
	},

	onElementorReady: function onElementorReady() {
		this.onElementorInit();

		elementor.on('frontend:init', this.onElementorFrontendInit.bind(this)).on('preview:loaded', this.onElementorPreviewLoaded.bind(this));
	}
});

EditorModule.prototype.onElementorInit = function () {};

EditorModule.prototype.onElementorPreviewLoaded = function () {};

EditorModule.prototype.onElementorFrontendInit = function () {};

module.exports = EditorModule;

/***/ }),

/***/ 206:
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
		var _ref;

		_classCallCheck(this, _class);

		for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
			args[_key] = arguments[_key];
		}

		var _this = _possibleConstructorReturn(this, (_ref = _class.__proto__ || Object.getPrototypeOf(_class)).call.apply(_ref, [this].concat(args)));

		_this.initDialog();
		return _this;
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				dialogType: 'buttons',
				dialogOptions: {
					effects: {
						hide: 'hide',
						show: 'show'
					},
					hide: {
						onBackgroundClick: false
					}
				}
			};
		}
	}, {
		key: 'initDialog',
		value: function initDialog() {
			var _this2 = this;

			var dialog = void 0;

			this.getDialog = function () {
				if (!dialog) {
					var settings = _this2.getSettings();

					dialog = elementorCommon.dialogsManager.createWidget(settings.dialogType, settings.dialogOptions);

					if (settings.onDialogInitCallback) {
						settings.onDialogInitCallback.call(_this2, dialog);
					}
				}

				return dialog;
			};
		}
	}, {
		key: 'show',
		value: function show(target) {
			if (this.introductionViewed) {
				return;
			}

			var dialog = this.getDialog();

			if (target) {
				dialog.setSettings('position', {
					of: target
				});
			}

			dialog.show();
		}
	}, {
		key: 'setViewed',
		value: function setViewed() {
			this.introductionViewed = true;

			elementorCommon.ajax.addRequest('introduction_viewed', {
				data: {
					introductionKey: this.getSettings('introductionKey')
				}
			});
		}
	}]);

	return _class;
}(elementorModules.Module);

exports.default = _class;

/***/ }),

/***/ 207:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var ControlsStack;

ControlsStack = Marionette.CompositeView.extend({
	classes: {
		popover: 'elementor-controls-popover'
	},

	activeTab: null,

	activeSection: null,

	className: function className() {
		return 'elementor-controls-stack';
	},

	templateHelpers: function templateHelpers() {
		return {
			elementData: elementor.getElementData(this.model)
		};
	},

	childViewOptions: function childViewOptions() {
		return {
			elementSettingsModel: this.model
		};
	},

	ui: function ui() {
		return {
			tabs: '.elementor-panel-navigation-tab',
			reloadButton: '.elementor-update-preview-button'
		};
	},

	events: function events() {
		return {
			'click @ui.tabs': 'onClickTabControl',
			'click @ui.reloadButton': 'onReloadButtonClick'
		};
	},

	modelEvents: {
		destroy: 'onModelDestroy'
	},

	behaviors: {
		HandleInnerTabs: {
			behaviorClass: __webpack_require__(12)
		}
	},

	initialize: function initialize() {
		this.initCollection();

		this.listenTo(elementor.channels.deviceMode, 'change', this.onDeviceModeChange);
	},

	initCollection: function initCollection() {
		this.collection = new Backbone.Collection(_.values(elementor.mergeControlsSettings(this.getOption('controls'))));
	},

	filter: function filter(controlModel) {
		if (controlModel.get('tab') !== this.activeTab) {
			return false;
		}

		if ('section' === controlModel.get('type')) {
			return true;
		}

		var section = controlModel.get('section');

		return !section || section === this.activeSection;
	},

	getControlViewByModel: function getControlViewByModel(model) {
		return this.children.findByModelCid(model.cid);
	},

	getControlViewByName: function getControlViewByName(name) {
		return this.getControlViewByModel(this.getControlModel(name));
	},

	getControlModel: function getControlModel(name) {
		return this.collection.findWhere({ name: name });
	},

	isVisibleSectionControl: function isVisibleSectionControl(sectionControlModel) {
		return this.activeTab === sectionControlModel.get('tab');
	},

	activateTab: function activateTab(tabName) {
		this.activeTab = tabName;

		this.ui.tabs.removeClass('elementor-active').filter('[data-tab="' + tabName + '"]').addClass('elementor-active');

		this.activateFirstSection();
	},

	activateSection: function activateSection(sectionName) {
		this.activeSection = sectionName;
	},

	activateFirstSection: function activateFirstSection() {
		var self = this;

		var sectionControls = self.collection.filter(function (controlModel) {
			return 'section' === controlModel.get('type') && self.isVisibleSectionControl(controlModel);
		});

		if (!sectionControls[0]) {
			return;
		}

		var preActivatedSection = sectionControls.filter(function (controlModel) {
			return self.activeSection === controlModel.get('name');
		});

		if (preActivatedSection[0]) {
			return;
		}

		self.activateSection(sectionControls[0].get('name'));
	},

	getChildView: function getChildView(item) {
		var controlType = item.get('type');

		return elementor.getControlView(controlType);
	},

	handlePopovers: function handlePopovers() {
		var self = this,
		    popoverStarted = false,
		    $popover;

		self.removePopovers();

		self.children.each(function (child) {
			if (popoverStarted) {
				$popover.append(child.$el);
			}

			var popover = child.model.get('popover');

			if (!popover) {
				return;
			}

			if (popover.start) {
				popoverStarted = true;

				$popover = jQuery('<div>', { class: self.classes.popover });

				child.$el.before($popover);

				$popover.append(child.$el);
			}

			if (popover.end) {
				popoverStarted = false;
			}
		});
	},

	removePopovers: function removePopovers() {
		this.$el.find('.' + this.classes.popover).remove();
	},

	getNamespaceArray: function getNamespaceArray() {
		return [elementor.getPanelView().getCurrentPageName()];
	},

	openActiveSection: function openActiveSection() {
		var activeSection = this.activeSection,
		    activeSectionView = this.children.filter(function (view) {
			return activeSection === view.model.get('name');
		});

		if (activeSectionView[0]) {
			activeSectionView[0].$el.addClass('elementor-open');

			var eventNamespace = this.getNamespaceArray();

			eventNamespace.push(activeSection, 'activated');

			elementor.channels.editor.trigger(eventNamespace.join(':'), this);
		}
	},

	onRenderCollection: function onRenderCollection() {
		this.openActiveSection();

		this.handlePopovers();
	},

	onRenderTemplate: function onRenderTemplate() {
		this.activateTab(this.activeTab || this.ui.tabs.eq(0).data('tab'));
	},

	onModelDestroy: function onModelDestroy() {
		this.destroy();
	},

	onClickTabControl: function onClickTabControl(event) {
		event.preventDefault();

		var $tab = this.$(event.currentTarget),
		    tabName = $tab.data('tab');

		if (this.activeTab === tabName) {
			return;
		}

		this.activateTab(tabName);

		this._renderChildren();
	},

	onReloadButtonClick: function onReloadButtonClick() {
		elementor.reloadPreview();
	},

	onDeviceModeChange: function onDeviceModeChange() {
		if ('desktop' === elementor.channels.deviceMode.request('currentMode')) {
			this.$el.removeClass('elementor-responsive-switchers-open');
		}
	},

	onChildviewControlSectionClicked: function onChildviewControlSectionClicked(childView) {
		var isSectionOpen = childView.$el.hasClass('elementor-open');

		this.activateSection(isSectionOpen ? null : childView.model.get('name'));

		this._renderChildren();
	},

	onChildviewResponsiveSwitcherClick: function onChildviewResponsiveSwitcherClick(childView, device) {
		if ('desktop' === device) {
			this.$el.toggleClass('elementor-responsive-switchers-open');
		}
	}
});

module.exports = ControlsStack;

/***/ }),

/***/ 208:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var BaseSettingsModel;

BaseSettingsModel = Backbone.Model.extend({
	options: {},

	initialize: function initialize(data, options) {
		var self = this;

		// Keep the options for cloning
		self.options = options;

		self.controls = elementor.mergeControlsSettings(options.controls);

		self.validators = {};

		if (!self.controls) {
			return;
		}

		var attrs = data || {},
		    defaults = {};

		_.each(self.controls, function (control) {
			var isUIControl = -1 !== control.features.indexOf('ui');

			if (isUIControl) {
				return;
			}
			var controlName = control.name;

			if ('object' === _typeof(control.default)) {
				defaults[controlName] = elementorCommon.helpers.cloneObject(control.default);
			} else {
				defaults[controlName] = control.default;
			}

			var isDynamicControl = control.dynamic && control.dynamic.active,
			    hasDynamicSettings = isDynamicControl && attrs.__dynamic__ && attrs.__dynamic__[controlName];

			if (isDynamicControl && !hasDynamicSettings && control.dynamic.default) {
				if (!attrs.__dynamic__) {
					attrs.__dynamic__ = {};
				}

				attrs.__dynamic__[controlName] = control.dynamic.default;

				hasDynamicSettings = true;
			}

			// Check if the value is a plain object ( and not an array )
			var isMultipleControl = jQuery.isPlainObject(control.default);

			if (undefined !== attrs[controlName] && isMultipleControl && !_.isObject(attrs[controlName]) && !hasDynamicSettings) {
				elementor.debug.addCustomError(new TypeError('An invalid argument supplied as multiple control value'), 'InvalidElementData', 'Element `' + (self.get('widgetType') || self.get('elType')) + '` got <' + attrs[controlName] + '> as `' + controlName + '` value. Expected array or object.');

				delete attrs[controlName];
			}

			if (undefined === attrs[controlName]) {
				attrs[controlName] = defaults[controlName];
			}
		});

		self.defaults = defaults;

		self.handleRepeaterData(attrs);

		self.set(attrs);
	},

	handleRepeaterData: function handleRepeaterData(attrs) {
		_.each(this.controls, function (field) {
			if (field.is_repeater) {
				// TODO: Apply defaults on each field in repeater fields
				if (!(attrs[field.name] instanceof Backbone.Collection)) {
					attrs[field.name] = new Backbone.Collection(attrs[field.name], {
						model: function model(attributes, options) {
							options = options || {};

							options.controls = field.fields;

							if (!attributes._id) {
								attributes._id = elementor.helpers.getUniqueID();
							}

							return new BaseSettingsModel(attributes, options);
						}
					});
				}
			}
		});
	},

	getFontControls: function getFontControls() {
		return _.filter(this.getActiveControls(), function (control) {
			return 'font' === control.type;
		});
	},

	getStyleControls: function getStyleControls(controls, attributes) {
		var self = this;

		controls = elementorCommon.helpers.cloneObject(self.getActiveControls(controls, attributes));

		var styleControls = [];

		jQuery.each(controls, function () {
			var control = this,
			    controlDefaultSettings = elementor.config.controls[control.type];

			control = jQuery.extend({}, controlDefaultSettings, control);

			if (control.fields) {
				var styleFields = [];

				self.attributes[control.name].each(function (item) {
					styleFields.push(self.getStyleControls(control.fields, item.attributes));
				});

				control.styleFields = styleFields;
			}

			if (control.fields || control.dynamic && control.dynamic.active || self.isStyleControl(control.name, controls)) {
				styleControls.push(control);
			}
		});

		return styleControls;
	},

	isStyleControl: function isStyleControl(attribute, controls) {
		controls = controls || this.controls;

		var currentControl = _.find(controls, function (control) {
			return attribute === control.name;
		});

		return currentControl && !_.isEmpty(currentControl.selectors);
	},

	getClassControls: function getClassControls(controls) {
		controls = controls || this.controls;

		return _.filter(controls, function (control) {
			return !_.isUndefined(control.prefix_class);
		});
	},

	isClassControl: function isClassControl(attribute) {
		var currentControl = _.find(this.controls, function (control) {
			return attribute === control.name;
		});

		return currentControl && !_.isUndefined(currentControl.prefix_class);
	},

	getControl: function getControl(id) {
		return _.find(this.controls, function (control) {
			return id === control.name;
		});
	},

	getActiveControls: function getActiveControls(controls, attributes) {
		var activeControls = {};

		if (!controls) {
			controls = this.controls;
		}

		if (!attributes) {
			attributes = this.attributes;
		}

		_.each(controls, function (control, controlKey) {
			if (elementor.helpers.isActiveControl(control, attributes)) {
				activeControls[controlKey] = control;
			}
		});

		return activeControls;
	},

	clone: function clone() {
		return new BaseSettingsModel(elementorCommon.helpers.cloneObject(this.attributes), elementorCommon.helpers.cloneObject(this.options));
	},

	setExternalChange: function setExternalChange(key, value) {
		var self = this,
		    settingsToChange;

		if ('object' === (typeof key === 'undefined' ? 'undefined' : _typeof(key))) {
			settingsToChange = key;
		} else {
			settingsToChange = {};

			settingsToChange[key] = value;
		}

		self.set(settingsToChange);

		jQuery.each(settingsToChange, function (changedKey, changedValue) {
			self.trigger('change:external:' + changedKey, changedValue);
		});
	},

	parseDynamicSettings: function parseDynamicSettings(settings, options, controls) {
		var self = this;

		settings = elementorCommon.helpers.cloneObject(settings || self.attributes);

		options = options || {};

		controls = controls || this.controls;

		jQuery.each(controls, function () {
			var control = this,
			    valueToParse;

			if ('repeater' === control.type) {
				valueToParse = settings[control.name];
				valueToParse.forEach(function (value, key) {
					valueToParse[key] = self.parseDynamicSettings(value, options, control.fields);
				});

				return;
			}

			valueToParse = settings.__dynamic__ && settings.__dynamic__[control.name];

			if (!valueToParse) {
				return;
			}

			var dynamicSettings = control.dynamic;

			if (undefined === dynamicSettings) {
				dynamicSettings = elementor.config.controls[control.type].dynamic;
			}

			if (!dynamicSettings || !dynamicSettings.active) {
				return;
			}

			var dynamicValue;

			try {
				dynamicValue = elementor.dynamicTags.parseTagsText(valueToParse, dynamicSettings, elementor.dynamicTags.getTagDataContent);
			} catch (error) {
				if (elementor.dynamicTags.CACHE_KEY_NOT_FOUND_ERROR !== error.message) {
					throw error;
				}

				dynamicValue = '';

				if (options.onServerRequestStart) {
					options.onServerRequestStart();
				}

				elementor.dynamicTags.refreshCacheFromServer(function () {
					if (options.onServerRequestEnd) {
						options.onServerRequestEnd();
					}
				});
			}

			if (dynamicSettings.property) {
				settings[control.name][dynamicSettings.property] = dynamicValue;
			} else {
				settings[control.name] = dynamicValue;
			}
		});

		return settings;
	},

	toJSON: function toJSON(options) {
		var data = Backbone.Model.prototype.toJSON.call(this);

		options = options || {};

		delete data.widgetType;
		delete data.elType;
		delete data.isInner;

		_.each(data, function (attribute, key) {
			if (attribute && attribute.toJSON) {
				data[key] = attribute.toJSON();
			}
		});

		// TODO: `options.removeDefault` is a bc since 2.5.14
		if (options.remove && -1 !== options.remove.indexOf('default') || options.removeDefault) {
			var controls = this.controls;

			_.each(data, function (value, key) {
				var control = controls[key];

				if (!control) {
					return;
				}

				// TODO: use `save_default` in text|textarea controls.
				if (control.save_default || ('text' === control.type || 'textarea' === control.type) && data[key]) {
					return;
				}

				if (_.isEqual(data[key], control.default)) {
					delete data[key];
				}
			});
		}

		return elementorCommon.helpers.cloneObject(data);
	}
});

module.exports = BaseSettingsModel;

/***/ })

/******/ });
//# sourceMappingURL=editor-modules.js.map