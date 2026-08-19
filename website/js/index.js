/* ==========================================================================
   YOUR VOICE ON THE MARK — Interaction Engine
   Smooth scroll, GSAP reveals, cursor, preloader, nav, audio, lightbox, forms
   ========================================================================== */
(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var FINE_POINTER = window.matchMedia('(pointer: fine)').matches;
  var lenis = null;
  var isMenuOpen = false;

  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); }

  /* ---------- LENIS SMOOTH SCROLL ---------- */
  function initLenis() {
    if (REDUCED || !window.Lenis) return;
    lenis = new Lenis({ duration: 1.15, easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); }, smoothWheel: true });
    if (window.ScrollTrigger) {
      lenis.on('scroll', ScrollTrigger.update);
      gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
      gsap.ticker.lagSmoothing(0);
    }
  }

  function lockScroll() {
    document.body.classList.add('locked');
    if (lenis) lenis.stop();
  }
  function unlockScroll() {
    document.body.classList.remove('locked');
    if (lenis) lenis.start();
  }

  /* ---------- PRELOADER ---------- */
  function initPreloader(done) {
    var pre = $('#preloader');
    if (!pre) { if (done) done(); return; }
    var bar = pre.querySelector('.loader-bar span');
    var countEl = $('#loaderCount');

    if (REDUCED) {
      gsap.set(pre, { autoAlpha: 0 });
      if (done) done();
      return;
    }

    var start = performance.now();
    var dur = 1500;
    var obj = { v: 0 };

    gsap.to(obj, {
      v: 100, duration: dur / 1000, ease: 'power2.inOut',
      onUpdate: function () {
        var v = Math.round(obj.v);
        if (bar) bar.style.width = v + '%';
        if (countEl) countEl.textContent = v;
      },
      onComplete: function () {
        var tl = gsap.timeline({ onComplete: function () { gsap.set(pre, { display: 'none' }); if (done) done(); } });
        tl.to(pre.querySelector('.loader-mark'), { y: -40, autoAlpha: 0, duration: 0.5, ease: 'power2.in' })
          .to(pre, { yPercent: -100, duration: 0.85, ease: 'power4.inOut' }, 0.15);
      }
    });

    // safety: never leave the overlay stuck
    setTimeout(function () {
      if (pre && gsap.getProperty(pre, 'yPercent') > -90 && !pre.hidden) {
        gsap.set(pre, { display: 'none' });
        if (done) done();
      }
    }, 5200);
  }

  /* ---------- HERO ---------- */
  function initHero() {
    var hero = $('#hero');
    if (!hero) return;

    // starfield
    var field = $('#heroStars');
    if (field) {
      var frag = document.createDocumentFragment();
      for (var i = 0; i < 130; i++) {
        var s = document.createElement('i');
        s.style.left = Math.random() * 100 + '%';
        s.style.top = Math.random() * 100 + '%';
        var sz = 1 + Math.random() * 2;
        s.style.width = sz + 'px';
        s.style.height = sz + 'px';
        s.style.setProperty('--tw', (3 + Math.random() * 5).toFixed(2) + 's');
        s.style.animationDelay = (Math.random() * 4).toFixed(2) + 's';
        frag.appendChild(s);
      }
      field.appendChild(frag);
    }

    var intro = gsap.timeline({ defaults: { ease: 'power4.out' } });
    intro
      .fromTo('.hero-eyebrow', { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7 })
      .fromTo('.hero-title', { y: 80, opacity: 0 }, { y: 0, opacity: 1, duration: 1 }, 0.15)
      .fromTo('.hero-sub', { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 }, 0.35)
      .fromTo('.hero-cta', { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 }, 0.5)
      .fromTo('.hero-equalizer', { opacity: 0 }, { opacity: 0.8, duration: 1 }, 0.7)
      .fromTo('.hero-scroll', { opacity: 0 }, { opacity: 1, duration: 0.8 }, 0.8);
  }

  /* ---------- PARALLAX ---------- */
  function initParallax() {
    if (REDUCED || !window.ScrollTrigger) return;
    var hero = $('#hero');
    if (hero) {
      gsap.to('.hero-inner', {
        y: 120, opacity: 0.25, ease: 'none',
        scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
      });
    }
    gsap.utils.toArray('.orb').forEach(function (orb, i) {
      gsap.to(orb, {
        yPercent: (i % 2 ? -14 : 14), ease: 'none',
        scrollTrigger: { trigger: document.body, start: 'top top', end: 'max', scrub: 1.2 }
      });
    });
  }

  /* ---------- SCROLL REVEALS ---------- */
  function initReveals() {
    var els = $$('[data-reveal]');
    if (!els.length) return;
    if (REDUCED || !window.ScrollTrigger) return;
    gsap.set(els, { opacity: 0, y: 44 });
    ScrollTrigger.batch(els, {
      start: 'top 88%',
      onEnter: function (batch) {
        gsap.to(batch, { opacity: 1, y: 0, duration: 0.95, stagger: 0.09, ease: 'power3.out', overwrite: true });
      }
    });
  }

  /* ---------- SCROLL PROGRESS + NAVBAR + TO TOP ---------- */
  function initScrollChrome() {
    var nav = $('#siteNav');
    var prog = $('#scrollProgress');
    var toTop = $('#toTop');
    var last = 0;

    function onScroll() {
      var top = window.scrollY || document.documentElement.scrollTop;
      if (nav) nav.classList.toggle('scrolled', top > 40);
      if (prog) {
        var h = document.documentElement;
        var p = h.scrollTop / (h.scrollHeight - h.clientHeight || 1);
        prog.style.transform = 'scaleX(' + Math.max(0, Math.min(p, 1)).toFixed(4) + ')';
      }
      if (toTop) toTop.classList.toggle('show', top > 620);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    if (lenis) lenis.on('scroll', onScroll);
    onScroll();

    if (toTop) toTop.addEventListener('click', function () {
      if (lenis) lenis.scrollTo(0, { duration: 1.4 }); else window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // anchor smooth scroll
    $$('a[href^="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        var id = a.getAttribute('href');
        if (id.length < 2) return;
        var target = $(id);
        if (!target) return;
        e.preventDefault();
        if (lenis) lenis.scrollTo(target, { duration: 1.4 }); else target.scrollIntoView({ behavior: 'smooth' });
      });
    });
  }

  /* ---------- CUSTOM CURSOR ---------- */
  function initCursor() {
    if (REDUCED || !FINE_POINTER) return;
    var dot = $('.cursor-dot');
    var ring = $('.cursor-ring');
    if (!dot || !ring) return;
    document.body.classList.add('cursor-on');
    var mx = -100, my = -100, rx = -100, ry = -100;

    document.addEventListener('mousemove', function (e) {
      mx = e.clientX; my = e.clientY;
      dot.style.transform = 'translate(' + (mx - 3.5) + 'px,' + (my - 3.5) + 'px)';
    }, { passive: true });

    gsap.ticker.add(function () {
      rx += (mx - rx) * 0.16;
      ry += (my - ry) * 0.16;
      ring.style.transform = 'translate(' + (rx - 19) + 'px,' + (ry - 19) + 'px)';
    });

    document.addEventListener('mouseover', function (e) {
      if (e.target.closest('a, button, .song-card, .video-card, input, textarea, .magnetic, .hoverable')) ring.classList.add('is-active');
    });
    document.addEventListener('mouseout', function (e) {
      if (e.target.closest('a, button, .song-card, .video-card, input, textarea, .magnetic, .hoverable')) ring.classList.remove('is-active');
    });
  }

  /* ---------- MAGNETIC BUTTONS ---------- */
  function initMagnetic() {
    if (REDUCED || !FINE_POINTER) return;
    $$('.magnetic').forEach(function (el) {
      el.addEventListener('mousemove', function (e) {
        var r = el.getBoundingClientRect();
        var x = e.clientX - r.left - r.width / 2;
        var y = e.clientY - r.top - r.height / 2;
        gsap.to(el, { x: x * 0.3, y: y * 0.3, duration: 0.45, ease: 'power2.out' });
      });
      el.addEventListener('mouseleave', function () {
        gsap.to(el, { x: 0, y: 0, duration: 0.7, ease: 'elastic.out(1, 0.35)' });
      });
    });
  }

  /* ---------- NAV OVERLAY ---------- */
  function initNavOverlay() {
    var burger = $('#navBurger');
    var overlay = $('#navOverlay');
    var closeBtn = $('#navClose');
    if (!burger || !overlay) return;

    var links = $$('.ov-link', overlay);
    var preview = $('.overlay-preview', overlay);
    var foot = $('.overlay-foot', overlay);

    gsap.set(links, { yPercent: 130, opacity: 0 });
    if (foot) gsap.set(foot, { opacity: 0, y: 20 });

    function open() {
      if (isMenuOpen) return;
      isMenuOpen = true;
      overlay.classList.add('open');
      lockScroll();
      gsap.to(links, { yPercent: 0, opacity: 1, duration: 0.95, stagger: 0.07, ease: 'power4.out', delay: 0.35 });
      if (foot) gsap.to(foot, { opacity: 1, y: 0, duration: 0.6, delay: 0.6, ease: 'power3.out' });
      burger.classList.add('active');
    }
    function close() {
      if (!isMenuOpen) return;
      isMenuOpen = false;
      gsap.to(links, { yPercent: 130, opacity: 0, duration: 0.5, stagger: 0.03, ease: 'power3.in' });
      if (foot) gsap.to(foot, { opacity: 0, y: 20, duration: 0.4 });
      setTimeout(function () {
        overlay.classList.remove('open');
        burger.classList.remove('active');
        unlockScroll();
      }, 500);
    }

    burger.addEventListener('click', open);
    if (closeBtn) closeBtn.addEventListener('click', close);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

    // image preview
    if (preview) {
      links.forEach(function (l) {
        var img = l.getAttribute('data-img');
        var txt = l.getAttribute('data-text') || '';
        l.addEventListener('mouseenter', function () {
          if (img) preview.style.backgroundImage = 'url(' + img + ')';
          preview.classList.add('show');
          var lbl = preview.querySelector('.pv-label');
          if (lbl) lbl.textContent = txt;
        });
        l.addEventListener('mouseleave', function () { preview.classList.remove('show'); });
      });
      overlay.addEventListener('mousemove', function (e) {
        if (!preview.classList.contains('show')) return;
        var cx = (e.clientX / window.innerWidth - 0.5);
        var cy = (e.clientY / window.innerHeight - 0.5);
        gsap.to(preview, { x: cx * 30, y: cy * 22, duration: 0.6, ease: 'power2.out' });
      });
    }
  }

  /* ---------- SONG PLAYER ---------- */
  function initSongPlayer() {
    var cards = $$('.song-card');
    if (!cards.length) return;

    function stopAll(except) {
      cards.forEach(function (c) {
        if (c === except) return;
        if (c._audio) { c._audio.pause(); }
        c.classList.remove('playing');
      });
    }

    cards.forEach(function (card) {
      var btn = card.querySelector('.song-play');
      if (!btn) return;
      var src = btn.getAttribute('data-audio');
      if (!src) return;
      var audio = new Audio(src);
      audio.preload = 'none';
      card._audio = audio;

      btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (audio.paused) {
          stopAll(card);
          card.classList.add('playing');
          audio.play().catch(function () { card.classList.remove('playing'); });
        } else {
          audio.pause();
          card.classList.remove('playing');
        }
      });

      audio.addEventListener('ended', function () { card.classList.remove('playing'); });
      audio.addEventListener('pause', function () {
        if (audio.currentTime === audio.duration) card.classList.remove('playing');
      });
    });
  }

  /* ---------- VIDEO SHOWCASE + LIGHTBOX ---------- */
  function initVideoShowcase() {
    var cards = $$('.video-card[data-video]');
    var lb = $('#lightbox');
    if (!cards.length || !lb) return;
    var lbVideo = $('#lightboxVideo');
    var lbTitle = $('#lbTitle');
    var lbSub = $('#lbSub');
    var closeBtn = lb.querySelector('.lightbox-close');

    function open(vc) {
      lbVideo.src = vc.getAttribute('data-video');
      lbVideo.play();
      lb.classList.add('open');
      if (lbTitle) lbTitle.textContent = vc.getAttribute('data-title') || 'Premium Video';
      if (lbSub) lbSub.textContent = (vc.getAttribute('data-artist') || 'YOUR VOICE ON THE MARK') + ' · Official Video';
      lockScroll();
    }
    function closeLb() {
      lb.classList.remove('open');
      lbVideo.pause();
      lbVideo.removeAttribute('src');
      lbVideo.load();
      unlockScroll();
    }

    cards.forEach(function (vc) {
      var video = vc.querySelector('video');
      var dur = vc.querySelector('.video-dur');

      if (video) {
        video.addEventListener('loadedmetadata', function () {
          if (dur && isFinite(video.duration)) {
            var m = Math.floor(video.duration / 60);
            var s = Math.floor(video.duration % 60);
            dur.textContent = m + ':' + (s < 10 ? '0' : '') + s;
          }
        });
        vc.addEventListener('mouseenter', function () {
          if (video.readyState >= 1) { video.currentTime = 0; video.play().catch(function () {}); }
        });
        vc.addEventListener('mouseleave', function () {
          if (!video.paused) { video.pause(); video.currentTime = 0; }
        });
      }

      vc.addEventListener('click', function () { open(vc); });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeLb);
    lb.addEventListener('click', function (e) { if (e.target === lb) closeLb(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && lb.classList.contains('open')) closeLb(); });
  }

  /* ---------- COUNTERS ---------- */
  function initCounters() {
    var stats = $$('.stat-num');
    if (!stats.length || REDUCED) return;
    stats.forEach(function (el) {
      var target = parseInt(el.getAttribute('data-count'), 10) || 0;
      var suffix = el.getAttribute('data-suffix') || '';
      var trigger = window.ScrollTrigger ? ScrollTrigger.create({
        trigger: el, start: 'top 90%', once: true,
        onEnter: function () {
          var o = { v: 0 };
          gsap.to(o, {
            v: target, duration: 2, ease: 'power2.out',
            onUpdate: function () { el.textContent = Math.round(o.v).toLocaleString('en-US') + suffix; }
          });
        }
      }) : null;
    });
  }

  /* ---------- TOAST ---------- */
  var toastTimer = null;
  function showToast(msg, isErr) {
    var t = $('#toast');
    if (!t) return;
    t.classList.toggle('err', !!isErr);
    var s = t.querySelector('.toast-msg');
    if (s) s.textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { t.classList.remove('show'); }, 4200);
  }

  /* ---------- CONTACT FORM ---------- */
  function initContactForm() {
    var form = $('#contactForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      var ok = true;
      $$('[data-validate]', form).forEach(function (input) {
        var field = input.closest('.field');
        var val = (input.value || '').trim();
        var valid = true;
        switch (input.getAttribute('data-validate')) {
          case 'name': valid = val.length >= 2; break;
          case 'email': valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val); break;
          case 'subject': valid = val.length >= 3; break;
          case 'message': valid = val.length >= 10; break;
        }
        field.classList.toggle('error', !valid);
        if (!valid) ok = false;
      });
      if (!ok) e.preventDefault();
    });

    $$('[data-validate]', form).forEach(function (input) {
      input.addEventListener('input', function () { input.closest('.field').classList.remove('error'); });
    });
  }

  function initNewsletter() {
    var nf = $('#newsletterForm');
    if (!nf) return;
    nf.addEventListener('submit', function (e) {
      var input = nf.querySelector('input[type="email"]');
      var val = (input && input.value || '').trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        e.preventDefault();
        showToast('Please enter a valid email address.', true);
      }
    });
  }

  /* ---------- STATUS PARAM TOAST ---------- */
  function readStatus() {
    var params = new URLSearchParams(window.location.search);
    var st = params.get('status');
    if (st === 'ok') showToast(params.get('msg') || 'Message sent successfully!');
    else if (st === 'err') showToast(params.get('msg') || 'Something went wrong. Please try again.', true);
  }

  /* ---------- BOOT ---------- */
  function boot() {
    initLenis();
    initPreloader(function () {
      if (window.gsap) initHero();
      initScrollChrome();
      if (window.ScrollTrigger) ScrollTrigger.refresh();
    });
    initParallax();
    initReveals();
    initCursor();
    initMagnetic();
    initNavOverlay();
    initSongPlayer();
    initVideoShowcase();
    initCounters();
    initContactForm();
    initNewsletter();
    readStatus();

    if (window.ScrollTrigger) ScrollTrigger.refresh();
    setTimeout(function () { if (window.ScrollTrigger) ScrollTrigger.refresh(); }, 600);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
