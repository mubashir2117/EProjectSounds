/* =========================================================
   auth.js
   Shared behaviour for login.php & signup.php
   ========================================================= */

(function () {

    'use strict';


    /* =========================================================
       BASIC HELPERS
       ========================================================= */

    var reducedMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;


    var $ = function (selector, context) {
        return (context || document).querySelector(selector);
    };


    var $$ = function (selector, context) {
        return Array.prototype.slice.call(
            (context || document).querySelectorAll(selector)
        );
    };


    var EMAIL_RE =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    var NAME_RE =
        /^[a-zA-Z0-9_ .'-]{3,50}$/;


    /* =========================================================
       TOAST ICONS
       ========================================================= */

    var TOAST_ICONS = {

        error:
            '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">' +
            '<circle cx="12" cy="12" r="9"/>' +
            '<path d="M15 9l-6 6M9 9l6-6"/>' +
            '</svg>',

        success:
            '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">' +
            '<path d="M20 6 9 17l-5-5"/>' +
            '</svg>',

        info:
            '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">' +
            '<circle cx="12" cy="12" r="9"/>' +
            '<path d="M12 16v-5M12 8h.01"/>' +
            '</svg>'

    };


    /* =========================================================
       TOAST FUNCTION
       ========================================================= */

    function showToast(message, type) {

        if (!message) {
            return;
        }

        var stack =
            document.getElementById('toastStack');

        if (!stack) {
            return;
        }

        var el =
            document.createElement('div');

        el.className =
            'toast ' + (type || 'info');

        el.setAttribute(
            'role',
            'status'
        );

        el.innerHTML =
            '<span class="t-ic">' +
            (TOAST_ICONS[type] || TOAST_ICONS.info) +
            '</span>' +
            '<span class="t-msg"></span>';

        var messageElement =
            el.querySelector('.t-msg');

        if (messageElement) {
            messageElement.textContent =
                message;
        }

        stack.appendChild(el);


        window.setTimeout(function () {

            el.classList.add('out');

            window.setTimeout(function () {

                if (el.parentNode) {
                    el.parentNode.removeChild(el);
                }

            }, 400);

        }, 4200);

    }


    window.authToast =
        showToast;


    /* =========================================================
       BACKGROUND SCENE
       ========================================================= */

    function buildScene() {

        var waveform =
            $('.waveform');

        if (waveform) {

            var count =
                Math.max(
                    16,
                    Math.min(
                        38,
                        Math.floor(
                            (window.innerWidth || 800) / 28
                        )
                    )
                );


            var html = '';


            for (var i = 0; i < count; i++) {

                html +=
                    '<i class="bar" ' +
                    'style="' +
                    'animation-delay:' +
                    ((i % 9) * 0.13).toFixed(2) +
                    's;' +
                    'animation-duration:' +
                    (2.2 + (i % 5) * 0.25).toFixed(2) +
                    's' +
                    '">' +
                    '</i>';

            }


            waveform.innerHTML =
                html;

        }


        var particles =
            $('.particles');


        if (particles && !reducedMotion) {

            var pCount =
                Math.max(
                    10,
                    Math.min(
                        22,
                        Math.floor(
                            (window.innerWidth || 800) / 70
                        )
                    )
                );


            var p = '';


            for (var j = 0; j < pCount; j++) {

                p +=
                    '<i ' +
                    'style="' +
                    'left:' +
                    (Math.random() * 100).toFixed(2) +
                    '%;' +

                    'width:' +
                    (1 + Math.random() * 1.5).toFixed(2) +
                    'px;' +

                    'height:' +
                    (1 + Math.random() * 1.5).toFixed(2) +
                    'px;' +

                    'animation-duration:' +
                    (12 + Math.random() * 14).toFixed(2) +
                    's;' +

                    'animation-delay:' +
                    (Math.random() * 16).toFixed(2) +
                    's' +

                    '">' +
                    '</i>';

            }


            particles.innerHTML =
                p;

        }

    }


    /* =========================================================
       PASSWORD SHOW / HIDE
       ========================================================= */

    function initToggles() {

        $$('.toggle-pass').forEach(
            function (btn) {

                btn.addEventListener(
                    'click',
                    function () {

                        var target =
                            btn.getAttribute(
                                'data-target'
                            );

                        var input =
                            document.getElementById(
                                target
                            );

                        if (!input) {
                            return;
                        }


                        var show =
                            input.type === 'password';


                        input.type =
                            show ? 'text' : 'password';


                        btn.classList.toggle(
                            'is-visible',
                            show
                        );


                        btn.setAttribute(
                            'aria-pressed',
                            show ? 'true' : 'false'
                        );


                        btn.setAttribute(
                            'aria-label',
                            show
                                ? 'Hide password'
                                : 'Show password'
                        );


                        input.focus();

                    }
                );

            }
        );

    }


    /* =========================================================
       FIELD MESSAGE
       ========================================================= */

    function setMsg(
        input,
        text,
        ok
    ) {

        if (!input) {
            return;
        }


        var wrap =
            input.closest
                ? input.closest('.input-wrap')
                : null;


        if (wrap) {

            wrap.classList.toggle(
                'has-error',
                !!text && !ok
            );

        }


        var msg =
            document.querySelector(
                '[data-for="' +
                input.id +
                '"]'
            );


        if (!msg) {
            return;
        }


        if (text) {

            msg.textContent =
                text;

            msg.classList.add(
                'show'
            );

            msg.classList.toggle(
                'err',
                !ok
            );

            msg.classList.toggle(
                'ok',
                !!ok
            );

        } else {

            msg.textContent =
                '';

            msg.classList.remove(
                'show',
                'err',
                'ok'
            );

        }

    }


    /* =========================================================
       EMAIL VALIDATION
       ========================================================= */

    function validateEmail(input) {

        if (!input) {
            return false;
        }


        var value =
            input.value.trim();


        if (!value) {

            setMsg(
                input,
                'Please enter a valid email address.',
                false
            );

            return false;

        }


        if (!EMAIL_RE.test(value)) {

            setMsg(
                input,
                'Please enter a valid email address.',
                false
            );

            return false;

        }


        setMsg(
            input,
            '',
            true
        );


        return true;

    }


    /* =========================================================
       PASSWORD REQUIRED
       ========================================================= */

    function validatePasswordRequired(input) {

        if (!input) {
            return false;
        }


        var value =
            input.value;


        if (!value) {

            setMsg(
                input,
                'Please enter your password.',
                false
            );

            return false;

        }


        setMsg(
            input,
            '',
            true
        );


        return true;

    }


    /* =========================================================
       USERNAME VALIDATION
       ========================================================= */

    function validateName(input) {

        if (!input) {
            return false;
        }


        var value =
            input.value.trim();


        if (!value) {

            setMsg(
                input,
                'Username is required.',
                false
            );

            return false;

        }


        if (value.length < 3) {

            setMsg(
                input,
                'Username must be at least 3 characters.',
                false
            );

            return false;

        }


        if (!NAME_RE.test(value)) {

            setMsg(
                input,
                'Username can only contain letters, numbers and . _ -',
                false
            );

            return false;

        }


        setMsg(
            input,
            '',
            true
        );


        return true;

    }


    /* =========================================================
       PASSWORD SCORE
       ========================================================= */

    function passwordScore(value) {

        var score = 0;


        if (value.length >= 8) {
            score++;
        }


        if (/[A-Z]/.test(value)) {
            score++;
        }


        if (/[a-z]/.test(value)) {
            score++;
        }


        if (/[0-9]/.test(value)) {
            score++;
        }


        if (/[^A-Za-z0-9]/.test(value)) {
            score++;
        }


        return score;

    }


    /* =========================================================
       PASSWORD STRENGTH
       ========================================================= */

    function updateStrength() {

        var input =
            $('#suPassword');


        if (!input) {
            return;
        }


        var meter =
            $('#strengthMeter');

        var label =
            $('#strengthLabel');

        var bar =
            $('#strengthBar');


        var value =
            input.value;


        var score =
            value
                ? passwordScore(value)
                : 0;


        var levels = [

            'Very Weak',
            'Very Weak',
            'Weak',
            'Medium',
            'Strong',
            'Very Strong'

        ];


        if (meter) {

            meter.className =
                'strength-meter level-' +
                score;

        }


        if (label) {

            label.textContent =
                value
                    ? levels[score]
                    : '';

        }


        if (bar) {

            var segments =
                bar.children;


            for (
                var i = 0;
                i < segments.length;
                i++
            ) {

                segments[i].classList.toggle(
                    'on',
                    i < score
                );

            }

        }


        var checks = {

            len:
                value.length >= 8,

            upper:
                /[A-Z]/.test(value),

            lower:
                /[a-z]/.test(value),

            num:
                /[0-9]/.test(value),

            special:
                /[^A-Za-z0-9]/.test(value)

        };


        Object.keys(checks).forEach(
            function (key) {

                var li =
                    $('.checklist li[data-key="' +
                    key +
                    '"]');


                if (!li) {
                    return;
                }


                var done =
                    checks[key];


                li.classList.toggle(
                    'done',
                    done
                );


                var check =
                    li.querySelector('.ck');


                if (check) {

                    check.textContent =
                        done
                            ? '✓'
                            : '✕';

                }

            }
        );

    }


    /* =========================================================
       CONFIRM PASSWORD
       ========================================================= */

    function validateConfirm() {

        var pw =
            $('#suPassword');

        var cf =
            $('#suConfirm');


        if (!pw || !cf) {
            return true;
        }


        var value =
            cf.value;


        if (!value) {

            setMsg(
                cf,
                'Please confirm your password.',
                false
            );

            return false;

        }


        if (value !== pw.value) {

            setMsg(
                cf,
                '✕ Passwords do not match',
                false
            );

            return false;

        }


        setMsg(
            cf,
            '✓ Passwords match',
            true
        );


        return true;

    }


    /* =========================================================
       LOADING BUTTON
       ========================================================= */

    function setLoading(
        btn,
        text
    ) {

        if (!btn) {
            return;
        }


        /*
         * IMPORTANT:
         * We do NOT disable the submit button here.
         *
         * This avoids any possibility of the browser
         * cancelling the normal form submission.
         */


        var spinner =
            btn.querySelector('.spinner');


        var buttonText =
            btn.querySelector('.btn-text');


        if (spinner) {
            spinner.hidden = false;
        }


        if (buttonText) {
            buttonText.textContent =
                text;
        }

    }


    /* =========================================================
       LOGIN FORM
       ========================================================= */

    function initLoginForm() {

        var form =
            $('#loginForm');


        if (!form) {
            return;
        }


        var email =
            $('#loginEmail');

        var password =
            $('#loginPassword');

        var button =
            $('#loginBtn');


        if (email) {

            email.addEventListener(
                'input',
                function () {

                    validateEmail(email);

                }
            );

        }


        if (password) {

            password.addEventListener(
                'input',
                function () {

                    validatePasswordRequired(
                        password
                    );

                }
            );

        }


        form.addEventListener(
            'submit',
            function (event) {

                var validEmail =
                    validateEmail(email);


                var validPassword =
                    validatePasswordRequired(
                        password
                    );


                /*
                 * Only prevent submission when
                 * the login data is genuinely invalid.
                 */

                if (
                    !validEmail ||
                    !validPassword
                ) {

                    event.preventDefault();


                    showToast(
                        'Please fix the highlighted fields.',
                        'error'
                    );


                    return;

                }


                /*
                 * Valid login:
                 * allow normal PHP POST.
                 */

                setLoading(
                    button,
                    'Logging in...'
                );

            }
        );

    }


    /* =========================================================
       SIGNUP FORM
       ========================================================= */

    function initSignupForm() {

        var form =
            $('#signupForm');


        if (!form) {
            return;
        }


        var name =
            $('#suName');

        var email =
            $('#suEmail');

        var password =
            $('#suPassword');

        var confirmPassword =
            $('#suConfirm');

        var button =
            $('#suBtn');


        /* -----------------------------------------
           Username live validation
           ----------------------------------------- */

        if (name) {

            name.addEventListener(
                'input',
                function () {

                    validateName(name);

                }
            );

        }


        /* -----------------------------------------
           Email live validation
           ----------------------------------------- */

        if (email) {

            email.addEventListener(
                'input',
                function () {

                    validateEmail(email);

                }
            );

        }


        /* -----------------------------------------
           Password strength
           ----------------------------------------- */

        if (password) {

            password.addEventListener(
                'input',
                function () {

                    updateStrength();


                    if (
                        confirmPassword &&
                        confirmPassword.value
                    ) {

                        validateConfirm();

                    }

                }
            );

        }


        /* -----------------------------------------
           Confirm password
           ----------------------------------------- */

        if (confirmPassword) {

            confirmPassword.addEventListener(
                'input',
                function () {

                    validateConfirm();

                }
            );

        }


        /* -----------------------------------------
           Signup Submit
           ----------------------------------------- */

        form.addEventListener(
            'submit',
            function (event) {

                var validName =
                    validateName(name);


                var validEmail =
                    validateEmail(email);


                var validPassword =
                    true;


                var validConfirm =
                    true;


                /*
                 * Password validation
                 */

                if (!password) {

                    validPassword =
                        false;

                } else {

                    var value =
                        password.value;


                    var score =
                        passwordScore(value);


                    if (!value) {

                        setMsg(
                            password,
                            'Password is required.',
                            false
                        );

                        validPassword =
                            false;

                    } else if (
                        value.length < 8
                    ) {

                        setMsg(
                            password,
                            'Password must be at least 8 characters.',
                            false
                        );

                        validPassword =
                            false;

                    } else if (
                        score < 3
                    ) {

                        setMsg(
                            password,
                            'Password does not meet the required strength.',
                            false
                        );

                        validPassword =
                            false;

                    } else {

                        setMsg(
                            password,
                            '',
                            true
                        );

                    }

                }


                updateStrength();


                /*
                 * Confirm password
                 */

                if (confirmPassword) {

                    validConfirm =
                        validateConfirm();

                }


                /*
                 * INVALID FORM
                 */

                if (
                    !validName ||
                    !validEmail ||
                    !validPassword ||
                    !validConfirm
                ) {

                    /*
                     * ONLY INVALID DATA IS BLOCKED.
                     */

                    event.preventDefault();


                    showToast(
                        'Please fix the highlighted fields.',
                        'error'
                    );


                    return;

                }


                /*
                 * VALID FORM
                 *
                 * VERY IMPORTANT:
                 *
                 * There is NO event.preventDefault()
                 * here.
                 *
                 * The browser will submit:
                 *
                 * signup.php
                 *
                 * using POST.
                 */

                setLoading(
                    button,
                    'Creating Account...'
                );


                console.log(
                    'Signup form submitted successfully.'
                );

            }
        );

    }


    /* =========================================================
       FORGOT PASSWORD VIEW
       ========================================================= */

    function initForgotView() {

        var loginView =
            $('#loginView');

        var forgotView =
            $('#forgotView');

        var link =
            $('#forgotLink');

        var back =
            $('#forgotBack');

        var form =
            $('#forgotForm');

        var email =
            $('#forgotEmail');

        var button =
            $('#forgotBtn');


        var toggle =
            function (showForgot) {

                if (
                    !loginView ||
                    !forgotView
                ) {
                    return;
                }


                loginView.classList.toggle(
                    'hidden',
                    showForgot
                );


                loginView.classList.toggle(
                    'auth-view--active',
                    !showForgot
                );


                forgotView.classList.toggle(
                    'hidden',
                    !showForgot
                );


                forgotView.classList.toggle(
                    'auth-view--active',
                    showForgot
                );

            };


        if (link) {

            link.addEventListener(
                'click',
                function () {

                    toggle(true);

                }
            );

        }


        if (back) {

            back.addEventListener(
                'click',
                function () {

                    toggle(false);

                }
            );

        }


        if (form && email) {

            email.addEventListener(
                'input',
                function () {

                    validateEmail(email);

                }
            );


            form.addEventListener(
                'submit',
                function (event) {

                    if (!validateEmail(email)) {

                        event.preventDefault();


                        showToast(
                            'Please enter a valid email address.',
                            'error'
                        );


                        return;

                    }


                    setLoading(
                        button,
                        'Sending...'
                    );

                }
            );

        }

    }


    /* =========================================================
       PAGE TRANSITIONS
       ========================================================= */

    function initTransitions() {

        $$('.auth-alt a').forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function (event) {

                        var href =
                            link.getAttribute(
                                'href'
                            );


                        if (
                            !href ||
                            href.charAt(0) === '#'
                        ) {

                            return;

                        }


                        event.preventDefault();


                        var card =
                            $('.auth-card');


                        if (card) {

                            card.classList.add(
                                'fade-out'
                            );

                        }


                        window.setTimeout(
                            function () {

                                window.location.href =
                                    href;

                            },
                            260
                        );

                    }
                );

            }
        );

    }


    /* =========================================================
       PHP FLASH MESSAGES
       ========================================================= */

    function initFlashed() {

        var flashed =
            window.flashed || {};


        if (flashed.error) {

            showToast(
                flashed.error,
                'error'
            );

        }


        if (flashed.notice) {

            showToast(
                flashed.notice,
                'info'
            );

        }


        if (window.signupSuccess) {

            showToast(
                'Account created successfully. Redirecting to Login...',
                'success'
            );


            window.setTimeout(
                function () {

                    window.location.href =
                        'login.php';

                },
                1800
            );

        }

    }


    /* =========================================================
       INITIALIZE EVERYTHING
       ========================================================= */

    function init() {

        buildScene();

        initToggles();

        initLoginForm();

        initSignupForm();

        initForgotView();

        initTransitions();

        initFlashed();

    }


    /* =========================================================
       DOM READY
       ========================================================= */

    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            init
        );

    } else {

        init();

    }


})();