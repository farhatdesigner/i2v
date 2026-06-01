/**
 * Custom pill dropdown for Contact Form 7 (Figma: Request a demo modal).
 * Transforms checkbox groups and matching selects into a pill-based dropdown panel.
 */
(function () {
  'use strict';

  var FIELD_NAME_RE = /interested|industry|application|inquir|typeof|partner-type|contact-type/i;
  var EXCLUDE_FIELD_RE = /country|phone|dial-code|dial_code|resume|file|email|tel|language|product[-_]?interest/i;
  var PLACEHOLDER = 'Select';

  function normalizeLabel(text) {
    return (text || '').replace(/\s+/g, ' ').replace(/\*/g, '').trim().toLowerCase();
  }

  /** Resolve visible label (CF7 often uses data-name that differs from the admin label). */
  function getFieldLabel(wrap) {
    if (!wrap) {
      return '';
    }
    var p = wrap.closest('p, .form-group, .col-md-6, .col-sm-6, .col-12, li');
    if (p) {
      var inBlock = p.querySelector('label.form-label, label');
      if (inBlock) {
        return inBlock.textContent;
      }
    }
    var prev = wrap.previousElementSibling;
    if (prev && (prev.matches('label') || prev.matches('label.form-label'))) {
      return prev.textContent;
    }
    if (prev) {
      var nested = prev.querySelector('label.form-label, label');
      if (nested) {
        return nested.textContent;
      }
    }
    return '';
  }

  function labelMatchesField(wrap) {
    var label = normalizeLabel(getFieldLabel(wrap));
    if (!label) {
      return false;
    }
    return (
      /select\s+industry|industry/.test(label) ||
      /select\s+inquir|inquiry\s+type|inquir(y|ery)\s+type/.test(label) ||
      /i'?m\s+interested|interested\s+in|select\s+an?\s+application/.test(label)
    );
  }

  function isProductInterestField(wrap, name) {
    if (/product[-_]?interest/i.test(name || '')) {
      return true;
    }
    return /product\s+interest/.test(normalizeLabel(getFieldLabel(wrap)));
  }

  function fieldNameMatches(name) {
    if (!name || EXCLUDE_FIELD_RE.test(name)) {
      return false;
    }
    return FIELD_NAME_RE.test(name);
  }

  function wrapMatchesField(wrap) {
    if (!wrap) {
      return false;
    }
    if (wrap.classList.contains('i2v-pill-dropdown-wrap')) {
      return true;
    }
    var dataName = wrap.getAttribute('data-name') || '';
    if (fieldNameMatches(dataName)) {
      return true;
    }
    return labelMatchesField(wrap);
  }

  function shouldEnhanceControl(control, wrap) {
    if (!control || control.dataset.i2vPillDropdown === '1') {
      return false;
    }
    if (wrap && wrap.querySelector('.i2v-custom-dropdown')) {
      return false;
    }
    var name = control.getAttribute('name') || getFieldName(control);
    if (EXCLUDE_FIELD_RE.test(name) || isProductInterestField(wrap, name)) {
      return false;
    }
    if (control.classList.contains('i2v-pill-dropdown') || wrapMatchesField(wrap)) {
      /* matched by name, data-name, or visible label */
    } else if (!fieldNameMatches(name)) {
      return false;
    }
    if (control.classList.contains('wpcf7-checkbox')) {
      return control.querySelectorAll('input[type="checkbox"]').length > 1;
    }
    if (control.classList.contains('wpcf7-radio')) {
      return control.querySelectorAll('input[type="radio"]').length > 1;
    }
    if (control.tagName === 'SELECT') {
      return control.options.length > 1;
    }
    return false;
  }

  function getPanelTitle(fieldName, wrap) {
    var custom = wrap && wrap.getAttribute('data-pill-dropdown-title');
    if (custom) {
      return custom;
    }
    var label = normalizeLabel(getFieldLabel(wrap));
    if (/inquir/.test(label)) {
      return 'Select inquiry type';
    }
    if (/industry/.test(label)) {
      return 'Select industry';
    }
    if (/interested|application/.test(label)) {
      return 'Select an application';
    }
    if (/^select\s+/.test(label)) {
      var titled = getFieldLabel(wrap).replace(/\*/g, '').trim();
      return titled.charAt(0).toUpperCase() + titled.slice(1);
    }
    if (/industry/i.test(fieldName)) {
      return 'Select industry';
    }
    if (/inquir/i.test(fieldName)) {
      return 'Select inquiry type';
    }
    if (/interested|application/i.test(fieldName)) {
      return 'Select an application';
    }
    return 'Select option';
  }

  function getFieldName(control) {
    var input = control.querySelector('input[type="checkbox"], input[type="radio"], select option');
    if (control.tagName === 'SELECT') {
      return control.getAttribute('name') || '';
    }
    var first = control.querySelector('input[type="checkbox"], input[type="radio"]');
    return first ? (first.getAttribute('name') || '') : '';
  }

  function getSelectedLabels(control) {
    var labels = [];
    if (control.tagName === 'SELECT') {
      Array.prototype.forEach.call(control.selectedOptions, function (opt) {
        if (opt.value) {
          labels.push(opt.textContent.trim());
        }
      });
      return labels;
    }
    control.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked').forEach(function (input) {
      var label = input.closest('label');
      var textEl = label ? label.querySelector('.wpcf7-list-item-label') : null;
      labels.push(textEl ? textEl.textContent.trim() : input.value);
    });
    return labels;
  }

  function updateTriggerValue(dropdown) {
    var triggerValue = dropdown.querySelector('.i2v-custom-dropdown__value');
    if (!triggerValue) {
      return;
    }
    var labels = getSelectedLabels(dropdown._sourceControl);
    if (!labels.length) {
      triggerValue.textContent = PLACEHOLDER;
      triggerValue.classList.add('is-placeholder');
      dropdown.classList.remove('has-value');
      return;
    }
    triggerValue.textContent = labels.length > 2 ? labels.slice(0, 2).join(', ') + ' +' + (labels.length - 2) : labels.join(', ');
    triggerValue.classList.remove('is-placeholder');
    dropdown.classList.add('has-value');
  }

  function syncPillStates(dropdown) {
    dropdown.querySelectorAll('.i2v-custom-dropdown__pill').forEach(function (pill) {
      var isChecked = false;
      if (pill._input) {
        isChecked = pill._input.checked;
      } else if (pill._option) {
        isChecked = pill._option.selected;
      }
      pill.classList.toggle('is-selected', isChecked);
      pill.setAttribute('aria-pressed', isChecked ? 'true' : 'false');
    });
    updateTriggerValue(dropdown);
  }

  function isListMode(fieldName, wrap, isMulti) {
    if (wrap && wrap.getAttribute('data-dropdown-style') === 'pill') {
      return false;
    }
    if (wrap && wrap.getAttribute('data-dropdown-style') === 'list') {
      return true;
    }
    var label = normalizeLabel(getFieldLabel(wrap));
    if (/industry|inquir/.test(label)) {
      return true;
    }
    if (/interested|application/.test(label) && isMulti) {
      return false;
    }
    if (/industry|inquir/i.test(fieldName)) {
      return true;
    }
    return !isMulti;
  }

  /** Scroll the active option into view when the panel opens (same pattern as hash / locator UI). */
  function scrollSelectedIntoView(dropdown) {
    var optionsEl = dropdown.querySelector('.i2v-custom-dropdown__options');
    if (!optionsEl) {
      return;
    }
    var selected = optionsEl.querySelector('.i2v-custom-dropdown__pill.is-selected');
    if (!selected) {
      return;
    }
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        selected.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      });
    });
  }

  function setDropdownOpen(dropdown, open) {
    var trigger = dropdown.querySelector('.i2v-custom-dropdown__trigger');
    if (open) {
      closeAllExcept(dropdown);
      dropdown.classList.add('is-open');
      if (trigger) {
        trigger.setAttribute('aria-expanded', 'true');
      }
      scrollSelectedIntoView(dropdown);
    } else {
      dropdown.classList.remove('is-open');
      if (trigger) {
        trigger.setAttribute('aria-expanded', 'false');
      }
    }
  }

  function closeAllExcept(exceptDropdown) {
    document.querySelectorAll('.i2v-custom-dropdown.is-open').forEach(function (el) {
      if (el !== exceptDropdown) {
        setDropdownOpen(el, false);
      }
    });
  }

  function buildFromCheckbox(control, wrap) {
    var fieldName = getFieldName(control);
    var isMulti = control.classList.contains('wpcf7-checkbox');
    var listMode = isListMode(fieldName, wrap, isMulti);
    var dropdown = document.createElement('div');
    dropdown.className = 'i2v-custom-dropdown' + (listMode ? ' i2v-custom-dropdown--list' : ' i2v-custom-dropdown--pill');
    dropdown._sourceControl = control;
    dropdown._isMulti = isMulti;

    var trigger = document.createElement('button');
    trigger.type = 'button';
    trigger.className = 'i2v-custom-dropdown__trigger';
    trigger.setAttribute('aria-haspopup', 'listbox');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.innerHTML =
      '<span class="i2v-custom-dropdown__value is-placeholder">' + PLACEHOLDER + '</span>' +
      '<span class="i2v-custom-dropdown__chevron" aria-hidden="true"></span>';

    var panel = document.createElement('div');
    panel.className = 'i2v-custom-dropdown__panel';
    panel.setAttribute('role', 'listbox');
    panel.setAttribute('aria-multiselectable', isMulti ? 'true' : 'false');

    var header = document.createElement('div');
    header.className = 'i2v-custom-dropdown__header';
    header.innerHTML =
      '<span class="i2v-custom-dropdown__title">' + getPanelTitle(fieldName, wrap) + '</span>' +
      (isMulti && !listMode ? '<button type="button" class="i2v-custom-dropdown__select-all">Select all</button>' : '');

    var options = document.createElement('div');
    options.className = 'i2v-custom-dropdown__options';

    control.querySelectorAll('.wpcf7-list-item').forEach(function (item) {
      var input = item.querySelector('input[type="checkbox"], input[type="radio"]');
      if (!input) {
        return;
      }
      var labelEl = item.querySelector('.wpcf7-list-item-label');
      var text = labelEl ? labelEl.textContent.trim() : input.value;

      var pill = document.createElement('button');
      pill.type = 'button';
      pill.className = 'i2v-custom-dropdown__pill';
      pill.textContent = text;
      pill.setAttribute('role', 'option');
      pill._input = input;

      pill.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (isMulti) {
          input.checked = !input.checked;
        } else {
          control.querySelectorAll('input[type="radio"]').forEach(function (r) {
            r.checked = false;
          });
          input.checked = true;
          setDropdownOpen(dropdown, false);
        }
        input.dispatchEvent(new Event('change', { bubbles: true }));
        syncPillStates(dropdown);
      });

      options.appendChild(pill);
    });

    panel.appendChild(header);
    panel.appendChild(options);
    dropdown.appendChild(trigger);
    dropdown.appendChild(panel);

    if (isMulti && !listMode) {
      var selectAllBtn = header.querySelector('.i2v-custom-dropdown__select-all');
      if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var inputs = control.querySelectorAll('input[type="checkbox"]');
          var allChecked = Array.prototype.every.call(inputs, function (inp) {
            return inp.checked;
          });
          inputs.forEach(function (inp) {
            inp.checked = !allChecked;
          });
          control.dispatchEvent(new Event('change', { bubbles: true }));
          syncPillStates(dropdown);
        });
      }
    }

    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      setDropdownOpen(dropdown, !dropdown.classList.contains('is-open'));
    });

    control.classList.add('i2v-custom-dropdown__source--hidden');
    wrap.appendChild(dropdown);
    control.dataset.i2vPillDropdown = '1';
    syncPillStates(dropdown);
    return dropdown;
  }

  function buildFromSelect(select, wrap) {
    var fieldName = select.getAttribute('name') || '';
    var isMulti = select.multiple;
    var listMode = isListMode(fieldName, wrap, isMulti);
    var dropdown = document.createElement('div');
    dropdown.className = 'i2v-custom-dropdown' + (listMode ? ' i2v-custom-dropdown--list' : ' i2v-custom-dropdown--pill');
    dropdown._sourceControl = select;
    dropdown._isMulti = isMulti;

    var trigger = document.createElement('button');
    trigger.type = 'button';
    trigger.className = 'i2v-custom-dropdown__trigger';
    trigger.setAttribute('aria-haspopup', 'listbox');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.innerHTML =
      '<span class="i2v-custom-dropdown__value is-placeholder">' + PLACEHOLDER + '</span>' +
      '<span class="i2v-custom-dropdown__chevron" aria-hidden="true"></span>';

    var panel = document.createElement('div');
    panel.className = 'i2v-custom-dropdown__panel';

    var header = document.createElement('div');
    header.className = 'i2v-custom-dropdown__header';
    header.innerHTML =
      '<span class="i2v-custom-dropdown__title">' + getPanelTitle(fieldName, wrap) + '</span>' +
      (isMulti && !listMode ? '<button type="button" class="i2v-custom-dropdown__select-all">Select all</button>' : '');

    var options = document.createElement('div');
    options.className = 'i2v-custom-dropdown__options';

    Array.prototype.forEach.call(select.options, function (opt) {
      if (!opt.value) {
        return;
      }
      var pill = document.createElement('button');
      pill.type = 'button';
      pill.className = 'i2v-custom-dropdown__pill';
      pill.textContent = opt.textContent.trim();
      pill._option = opt;

      pill.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (select.multiple) {
          opt.selected = !opt.selected;
        } else {
          select.value = opt.value;
          setDropdownOpen(dropdown, false);
        }
        select.dispatchEvent(new Event('change', { bubbles: true }));
        syncPillStates(dropdown);
      });

      options.appendChild(pill);
    });

    panel.appendChild(header);
    panel.appendChild(options);
    dropdown.appendChild(trigger);
    dropdown.appendChild(panel);

    if (select.multiple && !listMode) {
      var selectAllBtn = header.querySelector('.i2v-custom-dropdown__select-all');
      if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var opts = Array.prototype.filter.call(select.options, function (o) {
            return o.value;
          });
          var allSelected = opts.every(function (o) {
            return o.selected;
          });
          opts.forEach(function (o) {
            o.selected = !allSelected;
          });
          select.dispatchEvent(new Event('change', { bubbles: true }));
          syncPillStates(dropdown);
        });
      }
    }

    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      setDropdownOpen(dropdown, !dropdown.classList.contains('is-open'));
    });

    select.classList.add('i2v-custom-dropdown__source--hidden');
    wrap.appendChild(dropdown);
    select.dataset.i2vPillDropdown = '1';
    syncPillStates(dropdown);
    return dropdown;
  }

  /** Undo custom dropdown on Product interest — keep native CF7 checkboxes. */
  function restoreProductInterestCheckboxes(root) {
    var scope = root && root.querySelectorAll ? root : document;
    scope.querySelectorAll('.wpcf7-form-control-wrap').forEach(function (wrap) {
      var control = wrap.querySelector('.wpcf7-form-control.wpcf7-checkbox, .wpcf7-form-control.wpcf7-radio');
      if (!control) {
        return;
      }
      var name = getFieldName(control);
      if (!isProductInterestField(wrap, name)) {
        return;
      }
      var custom = wrap.querySelector('.i2v-custom-dropdown');
      if (custom) {
        custom.remove();
      }
      control.classList.remove('i2v-custom-dropdown__source--hidden');
      delete control.dataset.i2vPillDropdown;
    });
  }

  function initPillDropdowns(root) {
    var scope = root && root.querySelectorAll ? root : document;
    restoreProductInterestCheckboxes(scope);
    scope.querySelectorAll('.wpcf7-form-control-wrap').forEach(function (wrap) {
      if (wrap.querySelector('.i2v-custom-dropdown')) {
        return;
      }

      var checkboxControl = wrap.querySelector('.wpcf7-form-control.wpcf7-checkbox');
      if (checkboxControl && shouldEnhanceControl(checkboxControl, wrap)) {
        buildFromCheckbox(checkboxControl, wrap);
        return;
      }
      var radioControl = wrap.querySelector('.wpcf7-form-control.wpcf7-radio');
      if (radioControl && shouldEnhanceControl(radioControl, wrap)) {
        buildFromCheckbox(radioControl, wrap);
        return;
      }
      var select = wrap.querySelector('select.form-control, select.wpcf7-select, select');
      if (select && !select.classList.contains('country-input') && shouldEnhanceControl(select, wrap)) {
        buildFromSelect(select, wrap);
      }
    });
  }

  function onDocClick(e) {
    if (!e.target.closest('.i2v-custom-dropdown')) {
      closeAllExcept(null);
    }
  }

  function onKeydown(e) {
    if (e.key === 'Escape') {
      closeAllExcept(null);
    }
  }

  document.addEventListener('click', onDocClick);
  document.addEventListener('keydown', onKeydown);

  document.addEventListener('DOMContentLoaded', function () {
    initPillDropdowns(document);
  });

  document.addEventListener('wpcf7mailsent', function () {
    document.querySelectorAll('.i2v-custom-dropdown').forEach(function (dropdown) {
      if (dropdown._sourceControl) {
        if (dropdown._sourceControl.tagName === 'SELECT') {
          Array.prototype.forEach.call(dropdown._sourceControl.options, function (opt) {
            opt.selected = false;
          });
        } else {
          dropdown._sourceControl.querySelectorAll('input').forEach(function (inp) {
            inp.checked = false;
          });
        }
        syncPillStates(dropdown);
      }
      setDropdownOpen(dropdown, false);
    });
  });

  ['wpcf7submit', 'wpcf7invalid', 'wpcf7spam', 'wpcf7mailfailed'].forEach(function (evt) {
    document.addEventListener(evt, function (e) {
      if (e.target && e.target.closest) {
        initPillDropdowns(e.target);
      }
    });
  });

  if (typeof jQuery !== 'undefined') {
    jQuery(document).on('wpcf7init', function (_e, formEl) {
      initPillDropdowns(formEl);
    });
    jQuery(document).on('shown.bs.modal', '.formpopup_modal, .modal', function () {
      initPillDropdowns(this);
    });
  }

  // CF7 / Elementor may inject forms after DOMContentLoaded
  if (typeof MutationObserver !== 'undefined') {
    var initTimer;
    var observer = new MutationObserver(function (mutations) {
      var needsInit = mutations.some(function (mutation) {
        return Array.prototype.some.call(mutation.addedNodes || [], function (node) {
          if (node.nodeType !== 1) {
            return false;
          }
          return (
            (node.classList && node.classList.contains('wpcf7-form-control-wrap')) ||
            (node.querySelector && node.querySelector('.wpcf7-form-control-wrap'))
          );
        });
      });
      if (!needsInit) {
        return;
      }
      clearTimeout(initTimer);
      initTimer = setTimeout(function () {
        initPillDropdowns(document);
      }, 80);
    });
    document.addEventListener('DOMContentLoaded', function () {
      observer.observe(document.body, { childList: true, subtree: true });
    });
  }

  window.repindiaInitPillDropdowns = initPillDropdowns;
})();
