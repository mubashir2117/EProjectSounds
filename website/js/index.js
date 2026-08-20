/* ==========================================================================
   YOUR VOICE ON THE MARK — Interaction Engine
   Smooth scroll, GSAP reveals, cursor, preloader, nav, audio player, dock,
   3D card tilt, cinematic video background, page transitions, counters.
   ========================================================================== */
(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var FINE_POINTER = window.matchMedia('(pointer: fine)').matches;
  var lenis = null;
  var isMenuOpen = false;

  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); }

  /* ---------- WEB AUDIO CORE (analyser for the 3D world) ---------- */
  var AudioCore = {
    ctx: null, analyser: null, dataArray: null, sourceNode: null,
    connect: function (el) {
      if (!el) return;
      try {
        var AC = window.AudioContext || window.webkitAudioContext;
        if (!AC) return;
        this.ctx = this.ctx || new AC();
        if (this.ctx.state === 'suspended') this.ctx.resume();
        if (!this.sourceNode || this.sourceNode.mediaElement !== el) {
          if (this.sourceNode) { try { this.sourceNode.disconnect(); } catch (e) {} }
          this.sourceNode = this.ctx.createMediaElementSource(el);
          this.analyser = this.ctx.createAnalyser();
          this.analyser.fftSize = 128;
          this.analyser.smoothingTimeConstant = 0.82;
          this.sourceNode.connect(this.analyser);
          this.analyser.connect(this.ctx.destination);
          this.dataArray = new Uint8Array(this.analyser.frequencyBinCount);
        }
      } catch (e) {}
    },
    amplitude: function () {
      if (this.analyser && this.dataArray) {
        this.analyser.getByteFrequencyData(this.dataArray);
        var sum = 0;
        for (var i = 0; i < this.dataArray.length; i++) sum += this.dataArray[i];
        return sum / (this.dataArray.length * 255);
      }
      return 0;
    }
  };
  window.AudioCore = AudioCore;

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

    var lines = $$('.hero-title .line-inner');
    if (lines.length) {
      gsap.set(lines, { yPercent: 118 });
      var intro = gsap.timeline({ defaults: { ease: 'power4.out' } });
      intro
        .to(lines, { yPercent: 0, duration: 1.1, stagger: 0.14 }, 0.1)
        .fromTo('.hero-eyebrow', { y: 26, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7 }, 0.15)
        .fromTo('.hero-sub', { y: 34, opacity: 0 }, { y: 0, opacity: 1, duration: 0.85 }, 0.45)
        .fromTo('.hero-cta', { y: 34, opacity: 0 }, { y: 0, opacity: 1, duration: 0.85 }, 0.62)
        .fromTo('.hero-equalizer', { opacity: 0 }, { opacity: 0.85, duration: 1 }, 0.82)
        .fromTo('.hero-scroll', { opacity: 0 }, { opacity: 1, duration: 0.8 }, 0.92);
    } else {
      var intro2 = gsap.timeline({ defaults: { ease: 'power4.out' } });
      intro2
        .fromTo('.page-eyebrow', { y: 24, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7 })
        .fromTo('.page-hero h1', { y: 50, opacity: 0 }, { y: 0, opacity: 1, duration: 1 }, 0.15)
        .fromTo('.page-hero p', { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 }, 0.35);
    }
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
    gsap.utils.toArray('.about-panel').forEach(function (panel) {
      gsap.to(panel, {
        y: 40, ease: 'none',
        scrollTrigger: { trigger: panel, start: 'top bottom', end: 'bottom top', scrub: 1 }
      });
    });
  }

  /* ---------- SCROLL REVEALS ---------- */
  function initReveals() {
    var els = $$('[data-reveal]');
    if (!els.length) return;
    if (REDUCED || !window.ScrollTrigger) return;
    gsap.set(els, { opacity: 0, y: 44, scale: 0.96 });
    ScrollTrigger.batch(els, {
      start: 'top 88%',
      onEnter: function (batch) {
        gsap.to(batch, { opacity: 1, y: 0, scale: 1, duration: 0.95, stagger: 0.09, ease: 'power3.out', overwrite: true });
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
    var label = $('.cursor-label');
    if (!dot || !ring) return;
    document.body.classList.add('cursor-on');
    var mx = -100, my = -100, rx = -100, ry = -100, lx = -100, ly = -100;

    document.addEventListener('mousemove', function (e) {
      mx = e.clientX; my = e.clientY;
      dot.style.transform = 'translate(' + (mx - 3) + 'px,' + (my - 3) + 'px)';
    }, { passive: true });

    gsap.ticker.add(function () {
      rx += (mx - rx) * 0.16;
      ry += (my - ry) * 0.16;
      lx += (mx - lx) * 0.14;
      ly += (my - ly) * 0.14;
      ring.style.transform = 'translate(' + (rx - 20) + 'px,' + (ry - 20) + 'px)';
      if (label) label.style.transform = 'translate(' + lx + 'px,' + (ly - 46) + 'px)';
    });

    function setHint(text, interactive) {
      if (interactive) ring.classList.add('is-active'); else ring.classList.remove('is-active');
      if (label) {
        if (text) { label.textContent = text; label.classList.add('is-active'); }
        else label.classList.remove('is-active');
      }
    }

    document.addEventListener('mouseover', function (e) {
      var sc = e.target.closest('.song-card');
      var vc = e.target.closest('.video-card');
      var interactive = e.target.closest('a, button, input, textarea, select, .magnetic, .hoverable');
      setHint(sc ? 'PLAY' : (vc ? 'WATCH' : null), !!interactive);
    });
    document.addEventListener('mouseout', function (e) {
      var sc = e.target.closest('.song-card');
      var vc = e.target.closest('.video-card');
      var interactive = e.target.closest('a, button, input, textarea, select, .magnetic, .hoverable');
      var el = sc || vc || interactive;
      if (!el) return;
      var rel = e.relatedTarget;
      if (rel && el.contains(rel)) return;
      setHint(null, false);
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

  /* ---------- 3D CARD TILT ---------- */
  function initCardTilt() {
    if (REDUCED || !FINE_POINTER) return;
    $$('.song-card, .video-card').forEach(function (card) {
      var wrap = document.createElement('div');
      wrap.className = 'tilt-wrap';
      card.parentNode.insertBefore(wrap, card);
      wrap.appendChild(card);

      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        var px = (e.clientX - r.left) / r.width - 0.5;
        var py = (e.clientY - r.top) / r.height - 0.5;
        card.style.setProperty('--rx', (-py * 8).toFixed(2) + 'deg');
        card.style.setProperty('--ry', (px * 10).toFixed(2) + 'deg');
      });
      card.addEventListener('mouseleave', function () {
        card.style.setProperty('--rx', '0deg');
        card.style.setProperty('--ry', '0deg');
      });
    });
  }

  /* ---------- GLOBAL PLAYER ---------- */
  var MarkPlayer = {
    tracks: [],
    idx: -1,
    audio: null,
    vol: 1,
    subs: [],
    onChange: function (cb) { this.subs.push(cb); return cb; },
    emit: function () { for (var i = 0; i < this.subs.length; i++) this.subs[i](this); },
    play: function (i) {
      var t = this.tracks[i];
      if (!t) return;
      for (var k = 0; k < this.tracks.length; k++) {
        if (k !== i && this.tracks[k].audio && !this.tracks[k].audio.paused) this.tracks[k].audio.pause();
        this.tracks[k].card.classList.remove('playing');
      }
      this.idx = i;
      this.audio = t.audio;
      this.audio.volume = this.vol;
      AudioCore.connect(this.audio);
      t.card.classList.add('playing');
      if (this.audio.paused) {
        this.audio.play().catch(function () { t.card.classList.remove('playing'); });
      }
      this.emit();
    },
    toggle: function (i) {
      if (this.idx === i && this.audio && !this.audio.paused) this.pause();
      else this.play(i);
    },
    pause: function () {
      if (this.audio) this.audio.pause();
      if (this.tracks[this.idx]) this.tracks[this.idx].card.classList.remove('playing');
      this.emit();
    },
    next: function () { if (this.tracks.length) this.play((this.idx + 1) % this.tracks.length); },
    prev: function () { if (this.tracks.length) this.play((this.idx - 1 + this.tracks.length) % this.tracks.length); },
    seek: function (f) { if (this.audio && isFinite(this.audio.duration)) this.audio.currentTime = f * this.audio.duration; },
    setVolume: function (v) {
      this.vol = v;
      this.tracks.forEach(function (t) { t.audio.volume = v; });
    }
  };
  window.MarkPlayer = MarkPlayer;

  /* ---------- SONG PLAYER ---------- */
  function initSongPlayer() {
    var cards = $$('.song-card');
    if (!cards.length) return;

    var trackIdx = 0;
    cards.forEach(function (card) {
      var btn = card.querySelector('.song-play');
      if (!btn) return;
      var src = btn.getAttribute('data-audio');
      if (!src) return;
      var idx = trackIdx++;
      var audio = new Audio(src);
      audio.preload = 'none';
      audio.volume = MarkPlayer.vol;
      card._audio = audio;
      MarkPlayer.tracks.push({ card: card, btn: btn, audio: audio, src: src });

      btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        MarkPlayer.toggle(idx);
      });

      audio.addEventListener('ended', function () {
        card.classList.remove('playing');
        if (MarkPlayer.idx === idx) MarkPlayer.next();
      });
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

    var section = cards[0].closest('.showcase') || cards[0].closest('.section');
    var bg = section ? section.querySelector('.showcase-bg') : null;
    var bgVideo = bg ? bg.querySelector('video') : null;
    var bgTimer = null;
    if (section && !bg) {
      bg = document.createElement('div');
      bg.className = 'showcase-bg';
      bg.innerHTML = '<video muted loop playsinline preload="none"></video>';
      section.insertBefore(bg, section.firstChild);
      bgVideo = bg.querySelector('video');
    }

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
          if (bgVideo) {
            clearTimeout(bgTimer);
            if (bgVideo.getAttribute('src') !== vc.getAttribute('data-video')) {
              bgVideo.src = vc.getAttribute('data-video');
            }
            bgVideo.currentTime = 0;
            bgVideo.play().catch(function () {});
            if (bg) bg.classList.add('show');
          }
        });
        vc.addEventListener('mouseleave', function () {
          if (!video.paused) { video.pause(); video.currentTime = 0; }
          if (bgVideo) bgVideo.pause();
          if (bg) bgTimer = setTimeout(function () { bg.classList.remove('show'); }, 350);
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
    if (!stats.length || REDUCED || !window.ScrollTrigger) return;
    stats.forEach(function (el) {
      var target = parseInt(el.getAttribute('data-count'), 10) || 0;
      var suffix = el.getAttribute('data-suffix') || '';
      ScrollTrigger.create({
        trigger: el, start: 'top 90%', once: true,
        onEnter: function () {
          var o = { v: 0 };
          gsap.to(o, {
            v: target, duration: 2, ease: 'power2.out',
            onUpdate: function () { el.textContent = Math.round(o.v).toLocaleString('en-US') + suffix; }
          });
        }
      });
    });
  }

  /* ---------- STAT SPARKS ---------- */
  function initStatSparks() {
    $$('.stat').forEach(function (stat) {
      if (stat.querySelector('.stat-spark')) return;
      var a = document.createElement('i');
      a.className = 'stat-spark';
      var b = document.createElement('i');
      b.className = 'stat-spark b';
      stat.appendChild(a);
      stat.appendChild(b);
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

  /* ---------- PAGE TRANSITIONS ---------- */
  function initPageTransitions() {
    var overlay = $('#pageTransition');
    if (!overlay || REDUCED) return;
    var curtain = overlay.querySelector('.pt-curtain');
    var stage = overlay.querySelector('.pt-stage');
    var bars = $$('.pt-stage i', overlay);
    var streak = overlay.querySelector('.pt-streak');

    function go(href) {
      if (stage) gsap.set(stage, { opacity: 1 });
      if (bars.length) gsap.fromTo(bars, { height: 4 }, { height: 34, duration: 0.5, stagger: 0.05, ease: 'power2.inOut' });
      if (streak) gsap.to(streak, { left: '130%', duration: 0.75, ease: 'power2.inOut', onStart: function () { streak.style.opacity = 1; } });
      if (curtain) curtain.classList.add('on');
      setTimeout(function () { window.location.href = href; }, 640);
    }

    document.addEventListener('click', function (e) {
      var a = e.target.closest('a[href]');
      if (!a) return;
      var href = a.getAttribute('href') || '';
      if (!href || href.charAt(0) === '#') return;
      if (href.indexOf('.php') === -1) return;
      if (href.indexOf('://') !== -1 || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return;
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
      e.preventDefault();
      if (lenis) lenis.stop();
      go(href);
    });
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
    initCardTilt();
    initSongPlayer();
    initVideoShowcase();
    initCounters();
    initStatSparks();
    initContactForm();
    initNewsletter();
    initPageTransitions();
    readStatus();

    if (window.ScrollTrigger) ScrollTrigger.refresh();
    setTimeout(function () { if (window.ScrollTrigger) ScrollTrigger.refresh(); }, 600);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();