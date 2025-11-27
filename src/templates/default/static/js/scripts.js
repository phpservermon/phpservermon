const modalOrigins = new WeakMap();

function psm_setLayout(layout) {
        const listLayout = document.getElementById('list-layout');
        const flowLayout = document.getElementById('flow-layout');
        const blockLayout = document.getElementById('block-layout');
        const tableLayout = document.getElementById('table-layout');
        const showList = Boolean(layout);

        if (listLayout && flowLayout) {
                listLayout.style.display = showList ? 'block' : 'none';
                flowLayout.style.display = showList ? 'none' : 'block';
        }
        if (blockLayout && tableLayout) {
                blockLayout.classList.toggle('active', !showList);
                tableLayout.classList.toggle('active', showList);
        }
}

function psm_xhr(mod, params = {}, method = 'GET', on_complete, options = {}) {
        const headers = Object.assign({ 'X-Requested-With': 'XMLHttpRequest' }, options.headers || {});
        const upperMethod = method.toUpperCase();
        let url = `index.php?xhr=1&mod=${mod}`;
        const fetchOptions = { method: upperMethod, headers };

        if (upperMethod === 'GET') {
                const query = new URLSearchParams(params).toString();
                if (query) {
                        url += `&${query}`;
                }
        } else {
                fetchOptions.body = new URLSearchParams(params);
        }

        return fetch(url, fetchOptions)
                .then((response) => (options.json ? response.json() : response.text()))
                .then((data) => {
                        if (typeof on_complete === 'function') {
                                on_complete(data);
                        }
                        return data;
                })
                .catch((error) => {
                        if (typeof psm_flash_message === 'function') {
                                psm_flash_message(error);
                        }
                        return null;
                });
}

function psm_saveLayout(layout) {
        psm_setLayout(layout);
        const csrfField = document.querySelector('input[name=csrf]');
        const csrf = csrfField ? csrfField.value : '';

        const params = {
                action: 'saveLayout',
                csrf,
                layout,
        };

        psm_xhr('server_status', params, 'POST');
}

function syncThemeButton(theme) {
        const toggle = document.getElementById('themeToggle');
        if (!toggle) return;
        toggle.setAttribute('aria-pressed', theme === 'dark');
        toggle.querySelectorAll('.theme-icon').forEach((icon) => {
                icon.classList.toggle('d-none', icon.dataset.themePreference !== theme);
        });
}

function applyTheme(theme) {
        const preferredTheme = theme || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.body.setAttribute('data-theme', preferredTheme);
        localStorage.setItem('psm-theme', preferredTheme);
        syncThemeButton(preferredTheme);
}

function initThemeToggle() {
        const savedTheme = localStorage.getItem('psm-theme');
        applyTheme(savedTheme);
        const toggle = document.getElementById('themeToggle');
        if (toggle) {
                toggle.addEventListener('click', () => {
                        const nextTheme = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                        applyTheme(nextTheme);
                });
        }
}

function initModalTriggers() {
        document.querySelectorAll('.show-modal').forEach((trigger) => {
                trigger.addEventListener('click', (event) => {
                        if (trigger.tagName === 'A') {
                                event.preventDefault();
                        }
                        const modalId = trigger.dataset.modalId || 'main';
                        const modalEl = document.getElementById(`${modalId}Modal`);
                        if (modalEl) {
                                const param = trigger.dataset.modalParam;
                                if (param) {
                                        const ary = param.split(',');
                                        ary.forEach((value, index) => {
                                                const span = modalEl.querySelector(`span.modalP${index + 1}`);
                                                if (span) {
                                                        span.textContent = value;
                                                }
                                        });
                                }
                                modalEl.querySelectorAll('.modalOKButton').forEach((btn) => {
                                        modalOrigins.set(btn, trigger);
                                });
                                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                                modalInstance.show();
                        } else {
                                if (confirm('Are you sure?')) {
                                        window.location = trigger.getAttribute('href');
                                }
                        }
                        return false;
                });
        });

        document.querySelectorAll('.modalOKButton').forEach((button) => {
                button.addEventListener('click', (event) => {
                        const origin = modalOrigins.get(button);
                        if (origin && origin.tagName === 'A') {
                                window.location = origin.getAttribute('href');
                        } else if (origin) {
                                const hiddenInput = origin.nextElementSibling;
                                if (hiddenInput && hiddenInput.type === 'hidden') {
                                        hiddenInput.value = 1;
                                }
                                const form = origin.closest('form');
                                if (form) {
                                        form.submit();
                                }
                        }
                        event.preventDefault();
                });
        });
}

function toggleGroup(selector, show) {
        document.querySelectorAll(selector).forEach((element) => {
                element.style.display = show ? '' : 'none';
        });
}

function initTypeControls() {
        const typeSelect = document.getElementById('type');
        const popularMethods = document.getElementById('popular_request_methods');
        const requestMethod = document.getElementById('request_method');
        const popularPorts = document.getElementById('popular_ports');
        const portField = document.getElementById('port');

        if (typeSelect) {
                const handleTypeChange = () => {
                        const value = typeSelect.value;
                        switch (value) {
                        case 'website':
                                toggleGroup('.typeService', false);
                                toggleGroup('.typeWebsite', true);
                                if (popularMethods) popularMethods.dispatchEvent(new Event('change'));
                                break;
                        case 'service':
                                toggleGroup('.typeWebsite', false);
                                toggleGroup('.typeService', true);
                                if (popularPorts) popularPorts.dispatchEvent(new Event('change'));
                                break;
                        default:
                                toggleGroup('.types', false);
                        }
                };
                typeSelect.addEventListener('change', handleTypeChange);
                handleTypeChange();
        }

        if (popularMethods && requestMethod && typeSelect) {
                popularMethods.addEventListener('change', () => {
                        if (typeSelect.value !== 'website') return;
                        const selected = popularMethods.value;
                        if (selected === '') {
                                toggleGroup('.requestMethod', false);
                                requestMethod.value = '';
                        } else if (selected === 'custom') {
                                toggleGroup('.requestMethod', true);
                                requestMethod.focus();
                        } else {
                                requestMethod.value = selected;
                                toggleGroup('.requestMethod', false);
                        }
                });
                popularMethods.dispatchEvent(new Event('change'));
        }

        if (popularPorts && portField && typeSelect) {
                popularPorts.addEventListener('change', () => {
                        if (typeSelect.value !== 'service') return;
                        const selected = popularPorts.value;
                        if (selected === '0' || selected === '') {
                                portField.value = selected;
                                toggleGroup('.port', false);
                        } else if (selected === 'custom') {
                                toggleGroup('.port', true);
                                portField.focus();
                        } else {
                                portField.value = selected;
                                toggleGroup('.port', false);
                        }
                });
                popularPorts.dispatchEvent(new Event('change'));
        }
}

function initUserNameWatcher() {
        const userName = document.getElementById('user_name');
        if (!userName) return;
        const password = document.getElementById('password');
        const passwordRepeat = document.getElementById('password_repeat');
        const level = document.getElementById('level');
        const nameField = document.getElementById('name');

        const togglePasswordVisibility = () => {
                if (userName.value === '__PUBLIC__') {
                        if (password && password.parentElement) password.parentElement.style.display = 'none';
                        if (passwordRepeat && passwordRepeat.parentElement) passwordRepeat.parentElement.style.display = 'none';
                        if (level) level.value = '30';
                        if (nameField) nameField.value = 'Public page';
                } else {
                        if (password && password.parentElement) password.parentElement.style.display = '';
                        if (passwordRepeat && passwordRepeat.parentElement) passwordRepeat.parentElement.style.display = '';
                }
        };

        userName.addEventListener('change', togglePasswordVisibility);
        togglePasswordVisibility();
}

function loadSearchEnhancements() {
        if (!document.querySelector('.search_input')) return;

        const assetBase = document.body.dataset.assetBase || '/';

        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = `${assetBase}src/templates/default/static/css/search.min.css`;
        document.head.appendChild(link);

        const script = document.createElement('script');
        script.src = `${assetBase}src/templates/default/static/js/search.js`;
        script.defer = true;
        document.head.appendChild(script);
}

function initializeLayout() {
        const listLayout = document.getElementById('list-layout');
        const flowLayout = document.getElementById('flow-layout');
        if (listLayout && flowLayout) {
                listLayout.style.display = 'none';
                flowLayout.style.display = 'none';
                if (listLayout.classList.contains('active')) {
                        listLayout.style.display = 'block';
                }
                if (flowLayout.classList.contains('active')) {
                        flowLayout.style.display = 'block';
                }
        }
}

function focusLabel() {
        const labelField = document.getElementById('label');
        if (labelField) {
                labelField.focus();
        }
}

document.addEventListener('DOMContentLoaded', () => {
        initModalTriggers();
        initializeLayout();
        initTypeControls();
        initUserNameWatcher();
        focusLabel();
        loadSearchEnhancements();
        initThemeToggle();

        if ('serviceWorker' in navigator) {
                navigator.serviceWorker
                        .register('./service-worker.js')
                        .then(() => console.log('Service Worker Registered'));
        }
});
