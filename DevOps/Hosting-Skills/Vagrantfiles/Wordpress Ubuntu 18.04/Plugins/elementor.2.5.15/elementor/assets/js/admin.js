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
/******/ 	return __webpack_require__(__webpack_require__.s = 164);
/******/ })
/************************************************************************/
/******/ ({

/***/ 164:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($) {
	var ElementorAdmin = elementorModules.ViewModule.extend({

		maintenanceMode: null,

		config: elementorAdminConfig,

		getDefaultElements: function getDefaultElements() {
			var elements = {
				$switchMode: $('#elementor-switch-mode'),
				$goToEditLink: $('#elementor-go-to-edit-page-link'),
				$switchModeInput: $('#elementor-switch-mode-input'),
				$switchModeButton: $('#elementor-switch-mode-button'),
				$elementorLoader: $('.elementor-loader'),
				$builderEditor: $('#elementor-editor'),
				$importButton: $('#elementor-import-template-trigger'),
				$importArea: $('#elementor-import-template-area'),
				$settingsForm: $('#elementor-settings-form'),
				$settingsTabsWrapper: $('#elementor-settings-tabs-wrapper')
			};

			elements.$settingsFormPages = elements.$settingsForm.find('.elementor-settings-form-page');

			elements.$activeSettingsPage = elements.$settingsFormPages.filter('.elementor-active');

			elements.$settingsTabs = elements.$settingsTabsWrapper.children();

			elements.$activeSettingsTab = elements.$settingsTabs.filter('.nav-tab-active');

			return elements;
		},

		toggleStatus: function toggleStatus() {
			var isElementorMode = this.isElementorMode();

			elementorCommon.elements.$body.toggleClass('elementor-editor-active', isElementorMode).toggleClass('elementor-editor-inactive', !isElementorMode);
		},

		bindEvents: function bindEvents() {
			var self = this;

			self.elements.$switchModeButton.on('click', function (event) {
				event.preventDefault();

				if (self.isElementorMode()) {
					elementorCommon.dialogsManager.createWidget('confirm', {
						message: self.translate('back_to_wordpress_editor_message'),
						headerMessage: self.translate('back_to_wordpress_editor_header'),
						strings: {
							confirm: self.translate('yes'),
							cancel: self.translate('cancel')
						},
						defaultOption: 'confirm',
						onConfirm: function onConfirm() {
							self.elements.$switchModeInput.val('');
							self.toggleStatus();
						}
					}).show();
				} else {
					self.elements.$switchModeInput.val(true);

					var $wpTitle = $('#title');

					if (!$wpTitle.val()) {
						$wpTitle.val('Elementor #' + $('#post_ID').val());
					}

					if (wp.autosave) {
						wp.autosave.server.triggerSave();
					}

					self.animateLoader();

					$(document).on('heartbeat-tick.autosave', function () {
						elementorCommon.elements.$window.off('beforeunload.edit-post');

						location.href = self.elements.$goToEditLink.attr('href');
					});
					self.toggleStatus();
				}
			});

			self.elements.$goToEditLink.on('click', function () {
				self.animateLoader();
			});

			$('div.notice.elementor-message-dismissed').on('click', 'button.notice-dismiss, .elementor-button-notice-dismiss', function (event) {
				event.preventDefault();

				$.post(ajaxurl, {
					action: 'elementor_set_admin_notice_viewed',
					notice_id: $(this).closest('.elementor-message-dismissed').data('notice_id')
				});

				var $wrapperElm = $(this).closest('.elementor-message-dismissed');
				$wrapperElm.fadeTo(100, 0, function () {
					$wrapperElm.slideUp(100, function () {
						$wrapperElm.remove();
					});
				});
			});

			$('#elementor-clear-cache-button').on('click', function (event) {
				event.preventDefault();
				var $thisButton = $(this);

				$thisButton.removeClass('success').addClass('loading');

				$.post(ajaxurl, {
					action: 'elementor_clear_cache',
					_nonce: $thisButton.data('nonce')
				}).done(function () {
					$thisButton.removeClass('loading').addClass('success');
				});
			});

			$('#elementor-library-sync-button').on('click', function (event) {
				event.preventDefault();
				var $thisButton = $(this);

				$thisButton.removeClass('success').addClass('loading');

				$.post(ajaxurl, {
					action: 'elementor_reset_library',
					_nonce: $thisButton.data('nonce')
				}).done(function () {
					$thisButton.removeClass('loading').addClass('success');
				});
			});

			$('#elementor-replace-url-button').on('click', function (event) {
				event.preventDefault();
				var $this = $(this),
				    $tr = $this.parents('tr'),
				    $from = $tr.find('[name="from"]'),
				    $to = $tr.find('[name="to"]');

				$this.removeClass('success').addClass('loading');

				$.post(ajaxurl, {
					action: 'elementor_replace_url',
					from: $from.val(),
					to: $to.val(),
					_nonce: $this.data('nonce')
				}).done(function (response) {
					$this.removeClass('loading');

					if (response.success) {
						$this.addClass('success');
					}

					elementorCommon.dialogsManager.createWidget('alert', {
						message: response.data
					}).show();
				});
			});

			self.elements.$settingsTabs.on({
				click: function click(event) {
					event.preventDefault();

					event.currentTarget.focus(); // Safari does not focus the tab automatically
				},
				focus: function focus() {
					// Using focus event to enable navigation by tab key
					var hrefWithoutHash = location.href.replace(/#.*/, '');

					history.pushState({}, '', hrefWithoutHash + this.hash);

					self.goToSettingsTabFromHash();
				}
			});

			$('.elementor-rollback-button').on('click', function (event) {
				event.preventDefault();

				var $this = $(this);

				elementorCommon.dialogsManager.createWidget('confirm', {
					headerMessage: self.translate('rollback_to_previous_version'),
					message: self.translate('rollback_confirm'),
					strings: {
						confirm: self.translate('yes'),
						cancel: self.translate('cancel')
					},
					onConfirm: function onConfirm() {
						$this.addClass('loading');

						location.href = $this.attr('href');
					}
				}).show();
			});

			$('.elementor_css_print_method select').on('change', function () {
				var $descriptions = $('.elementor-css-print-method-description');

				$descriptions.hide();
				$descriptions.filter('[data-value="' + $(this).val() + '"]').show();
			}).trigger('change');
		},

		onInit: function onInit() {
			elementorModules.ViewModule.prototype.onInit.apply(this, arguments);

			this.initTemplatesImport();

			this.initMaintenanceMode();

			this.goToSettingsTabFromHash();

			this.roleManager.init();
		},

		initTemplatesImport: function initTemplatesImport() {
			if (!elementorCommon.elements.$body.hasClass('post-type-elementor_library')) {
				return;
			}

			var self = this,
			    $importButton = self.elements.$importButton,
			    $importArea = self.elements.$importArea;

			self.elements.$formAnchor = $('h1');

			$('#wpbody-content').find('.page-title-action:last').after($importButton);

			self.elements.$formAnchor.after($importArea);

			$importButton.on('click', function () {
				$('#elementor-import-template-area').toggle();
			});
		},

		initMaintenanceMode: function initMaintenanceMode() {
			var MaintenanceMode = __webpack_require__(165);

			this.maintenanceMode = new MaintenanceMode();
		},

		isElementorMode: function isElementorMode() {
			return !!this.elements.$switchModeInput.val();
		},

		animateLoader: function animateLoader() {
			this.elements.$goToEditLink.addClass('elementor-animate');
		},

		goToSettingsTabFromHash: function goToSettingsTabFromHash() {
			var hash = location.hash.slice(1);

			if (hash) {
				this.goToSettingsTab(hash);
			}
		},

		goToSettingsTab: function goToSettingsTab(tabName) {
			var $pages = this.elements.$settingsFormPages;

			if (!$pages.length) {
				return;
			}

			var $activePage = $pages.filter('#' + tabName);

			this.elements.$activeSettingsPage.removeClass('elementor-active');

			this.elements.$activeSettingsTab.removeClass('nav-tab-active');

			var $activeTab = this.elements.$settingsTabs.filter('#elementor-settings-' + tabName);

			$activePage.addClass('elementor-active');

			$activeTab.addClass('nav-tab-active');

			this.elements.$settingsForm.attr('action', 'options.php#' + tabName);

			this.elements.$activeSettingsPage = $activePage;

			this.elements.$activeSettingsTab = $activeTab;
		},

		translate: function translate(stringKey, templateArgs) {
			return elementorCommon.translate(stringKey, null, templateArgs, this.config.i18n);
		},

		roleManager: {
			selectors: {
				body: 'elementor-role-manager',
				row: '.elementor-role-row',
				label: '.elementor-role-label',
				excludedIndicator: '.elementor-role-excluded-indicator',
				excludedField: 'input[name="elementor_exclude_user_roles[]"]',
				controlsContainer: '.elementor-role-controls',
				toggleHandle: '.elementor-role-toggle',
				arrowUp: 'dashicons-arrow-up',
				arrowDown: 'dashicons-arrow-down'
			},
			toggle: function toggle($trigger) {
				var self = this,
				    $row = $trigger.closest(self.selectors.row),
				    $toggleHandleIcon = $row.find(self.selectors.toggleHandle).find('.dashicons'),
				    $controls = $row.find(self.selectors.controlsContainer);

				$controls.toggleClass('hidden');
				if ($controls.hasClass('hidden')) {
					$toggleHandleIcon.removeClass(self.selectors.arrowUp).addClass(self.selectors.arrowDown);
				} else {
					$toggleHandleIcon.removeClass(self.selectors.arrowDown).addClass(self.selectors.arrowUp);
				}
				self.updateLabel($row);
			},
			updateLabel: function updateLabel($row) {
				var self = this,
				    $indicator = $row.find(self.selectors.excludedIndicator),
				    excluded = $row.find(self.selectors.excludedField).is(':checked');
				if (excluded) {
					$indicator.html($indicator.data('excluded-label'));
				} else {
					$indicator.html('');
				}
				self.setAdvancedState($row, excluded);
			},
			setAdvancedState: function setAdvancedState($row, state) {
				var self = this,
				    $controls = $row.find('input[type="checkbox"]').not(self.selectors.excludedField);

				$controls.each(function (index, input) {
					$(input).prop('disabled', state);
				});
			},
			bind: function bind() {
				var self = this;
				$(document).on('click', self.selectors.label + ',' + self.selectors.toggleHandle, function (event) {
					event.stopPropagation();
					event.preventDefault();
					self.toggle($(this));
				}).on('change', self.selectors.excludedField, function () {
					self.updateLabel($(this).closest(self.selectors.row));
				});
			},
			init: function init() {
				var self = this;
				if (!$('body[class*="' + self.selectors.body + '"]').length) {
					return;
				}
				self.bind();
				$(self.selectors.row).each(function (index, row) {
					self.updateLabel($(row));
				});
			}
		}
	});

	$(function () {
		window.elementorAdmin = new ElementorAdmin();

		elementorCommon.elements.$window.trigger('elementor/admin/init');
	});
})(jQuery);

/***/ }),

/***/ 165:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				modeSelect: '.elementor_maintenance_mode_mode select',
				maintenanceModeTable: '#tab-maintenance_mode table',
				maintenanceModeDescriptions: '.elementor-maintenance-mode-description',
				excludeModeSelect: '.elementor_maintenance_mode_exclude_mode select',
				excludeRolesArea: '.elementor_maintenance_mode_exclude_roles',
				templateSelect: '.elementor_maintenance_mode_template_id select',
				editTemplateButton: '.elementor-edit-template',
				maintenanceModeError: '.elementor-maintenance-mode-error'
			},
			classes: {
				isEnabled: 'elementor-maintenance-mode-is-enabled'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var elements = {},
		    selectors = this.getSettings('selectors');

		elements.$modeSelect = jQuery(selectors.modeSelect);
		elements.$maintenanceModeTable = elements.$modeSelect.parents(selectors.maintenanceModeTable);
		elements.$excludeModeSelect = elements.$maintenanceModeTable.find(selectors.excludeModeSelect);
		elements.$excludeRolesArea = elements.$maintenanceModeTable.find(selectors.excludeRolesArea);
		elements.$templateSelect = elements.$maintenanceModeTable.find(selectors.templateSelect);
		elements.$editTemplateButton = elements.$maintenanceModeTable.find(selectors.editTemplateButton);
		elements.$maintenanceModeDescriptions = elements.$maintenanceModeTable.find(selectors.maintenanceModeDescriptions);
		elements.$maintenanceModeError = elements.$maintenanceModeTable.find(selectors.maintenanceModeError);

		return elements;
	},

	handleModeSelectChange: function handleModeSelectChange() {
		var settings = this.getSettings(),
		    elements = this.elements;

		elements.$maintenanceModeTable.toggleClass(settings.classes.isEnabled, !!elements.$modeSelect.val());
		elements.$maintenanceModeDescriptions.hide();
		elements.$maintenanceModeDescriptions.filter('[data-value="' + elements.$modeSelect.val() + '"]').show();
	},

	handleExcludeModeSelectChange: function handleExcludeModeSelectChange() {
		var elements = this.elements;

		elements.$excludeRolesArea.toggle('custom' === elements.$excludeModeSelect.val());
	},

	handleTemplateSelectChange: function handleTemplateSelectChange() {
		var elements = this.elements;

		var templateID = elements.$templateSelect.val();

		if (!templateID) {
			elements.$editTemplateButton.hide();
			elements.$maintenanceModeError.show();
			return;
		}

		var editUrl = elementorAdmin.config.home_url + '?p=' + templateID + '&elementor';

		elements.$editTemplateButton.prop('href', editUrl).show();
		elements.$maintenanceModeError.hide();
	},

	bindEvents: function bindEvents() {
		var elements = this.elements;

		elements.$modeSelect.on('change', this.handleModeSelectChange.bind(this));

		elements.$excludeModeSelect.on('change', this.handleExcludeModeSelectChange.bind(this));

		elements.$templateSelect.on('change', this.handleTemplateSelectChange.bind(this));
	},

	onAdminInit: function onAdminInit() {
		this.handleModeSelectChange();
		this.handleExcludeModeSelectChange();
		this.handleTemplateSelectChange();
	},

	onInit: function onInit() {
		elementorModules.ViewModule.prototype.onInit.apply(this, arguments);

		elementorCommon.elements.$window.on('elementor/admin/init', this.onAdminInit);
	}
});

/***/ })

/******/ });
//# sourceMappingURL=admin.js.map