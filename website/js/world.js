/* ==========================================================================
   YOUR VOICE ON THE MARK — Cinematic 3D World (Three.js)
   Atmospheric sound-universe: glass audio sphere, particle dust, stars,
   light trails, volumetric fog, orbiting shards and a hero sound visualizer.
   Reads live amplitude from window.AudioCore (set up by index.js).
   ========================================================================== */
(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (REDUCED || !window.THREE) { document.body.classList.add('hero-no-webgl'); return; }

  var container = document.getElementById('worldCanvas');
  if (!container) return;

  var PAGE = (document.body.getAttribute('data-page') || 'home');
  var IS_HOME = PAGE === 'home';
  var isMobile = window.innerWidth < 768;
  var fine = window.matchMedia('(pointer: fine)').matches;

  var THREE = window.THREE;

  var renderer = new THREE.WebGLRenderer({ antialias: !isMobile, alpha: true, powerPreference: 'high-performance' });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, isMobile ? 1.25 : 1.75));
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setClearColor(0x000000, 0);
  renderer.outputEncoding = THREE.sRGBEncoding;
  container.appendChild(renderer.domElement);

  var scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x0b1020, isMobile ? 0.02 : 0.022);

  var camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 100);
  camera.position.set(0, 0, 8);

  /* ---------- LIGHTS ---------- */
  var hemi = new THREE.HemisphereLight(0x3d5a8c, 0x0a0a12, 0.5);
  scene.add(hemi);
  var key = new THREE.DirectionalLight(0x4d8dff, 1.15);
  key.position.set(4, 6, 5);
  scene.add(key);
  var violet = new THREE.PointLight(0x8b5cf6, 1.0, 22);
  violet.position.set(-6, 2, -3);
  scene.add(violet);
  var magenta = new THREE.PointLight(0xe879f9, 0.7, 20);
  magenta.position.set(6, -3, 2);
  scene.add(magenta);

  /* ---------- HELPERS ---------- */
  function radialTexture(stops) {
    var c = document.createElement('canvas');
    c.width = c.height = 256;
    var ctx = c.getContext('2d');
    var g = ctx.createRadialGradient(128, 128, 0, 128, 128, 128);
    for (var i = 0; i < stops.length; i++) g.addColorStop(stops[i][0], stops[i][1]);
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, 256, 256);
    var t = new THREE.CanvasTexture(c);
    return t;
  }

  function starTexture() {
    var c = document.createElement('canvas');
    c.width = c.height = 128;
    var ctx = c.getContext('2d');
    var g = ctx.createRadialGradient(64, 64, 0, 64, 64, 64);
    g.addColorStop(0, 'rgba(255,255,255,0.9)');
    g.addColorStop(0.25, 'rgba(190,205,255,0.5)');
    g.addColorStop(1, 'rgba(0,0,0,0)');
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, 128, 128);
    ctx.strokeStyle = 'rgba(190,210,255,0.55)';
    ctx.lineWidth = 1.5;
    for (var a = 0; a < 4; a++) {
      var ang = (a / 4) * Math.PI;
      ctx.beginPath();
      ctx.moveTo(64 - Math.cos(ang) * 18, 64 - Math.sin(ang) * 18);
      ctx.lineTo(64 + Math.cos(ang) * 18, 64 + Math.sin(ang) * 18);
      ctx.stroke();
    }
    return new THREE.CanvasTexture(c);
  }

  /* ---------- PARTICLE DUST ---------- */
  var dustCount = isMobile ? 260 : 900;
  var dustGeo = new THREE.BufferGeometry();
  var dustPos = new Float32Array(dustCount * 3);
  var dustSpd = new Float32Array(dustCount);
  var dustScale = new Float32Array(dustCount);
  for (var i = 0; i < dustCount; i++) {
    dustPos[i * 3] = (Math.random() - 0.5) * 46;
    dustPos[i * 3 + 1] = (Math.random() - 0.5) * 26;
    dustPos[i * 3 + 2] = -4 - Math.random() * 22;
    dustSpd[i] = 0.2 + Math.random() * 0.8;
    dustScale[i] = 0.5 + Math.random() * 1.2;
  }
  dustGeo.setAttribute('position', new THREE.BufferAttribute(dustPos, 3));
  var dustMat = new THREE.PointsMaterial({
    color: 0x7fa8ff, size: isMobile ? 0.05 : 0.055, transparent: true, opacity: 0.5,
    blending: THREE.AdditiveBlending, depthWrite: false, sizeAttenuation: true
  });
  var dust = new THREE.Points(dustGeo, dustMat);
  scene.add(dust);

  var dust2Geo = new THREE.BufferGeometry();
  var d2 = Math.floor(dustCount * 0.4);
  var dust2Pos = new Float32Array(d2 * 3);
  for (i = 0; i < d2; i++) {
    dust2Pos[i * 3] = (Math.random() - 0.5) * 40;
    dust2Pos[i * 3 + 1] = (Math.random() - 0.5) * 22;
    dust2Pos[i * 3 + 2] = -3 - Math.random() * 18;
  }
  dust2Geo.setAttribute('position', new THREE.BufferAttribute(dust2Pos, 3));
  var dust2Mat = new THREE.PointsMaterial({
    color: 0xa78bfa, size: isMobile ? 0.04 : 0.045, transparent: true, opacity: 0.4,
    blending: THREE.AdditiveBlending, depthWrite: false, sizeAttenuation: true
  });
  var dust2 = new THREE.Points(dust2Geo, dust2Mat);
  scene.add(dust2);

  /* ---------- STARS ---------- */
  var starCount = isMobile ? 160 : 380;
  var starGeo = new THREE.BufferGeometry();
  var starPos = new Float32Array(starCount * 3);
  var starTw = new Float32Array(starCount);
  for (i = 0; i < starCount; i++) {
    var r = 26 + Math.random() * 20;
    var th = Math.random() * Math.PI * 2;
    var ph = Math.acos(2 * Math.random() - 1);
    starPos[i * 3] = r * Math.sin(ph) * Math.cos(th);
    starPos[i * 3 + 1] = r * Math.sin(ph) * Math.sin(th);
    starPos[i * 3 + 2] = -r * Math.cos(ph) - 8;
    starTw[i] = Math.random() * Math.PI * 2;
  }
  starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
  var starMat = new THREE.PointsMaterial({
    color: 0xdce7ff, size: isMobile ? 0.09 : 0.1, transparent: true, opacity: 0.55,
    blending: THREE.AdditiveBlending, depthWrite: false, sizeAttenuation: true
  });
  var stars = new THREE.Points(starGeo, starMat);
  scene.add(stars);

  /* ---------- GLASS SHARDS ---------- */
  var shardGeo = new THREE.IcosahedronGeometry(0.16, 1);
  var shards = [];
  var shardN = isMobile ? 10 : 22;
  for (i = 0; i < shardN; i++) {
    var m = new THREE.MeshPhysicalMaterial({
      color: 0x8fa9ff, metalness: 0.55, roughness: 0.18, clearcoat: 1,
      transparent: true, opacity: 0.28, depthWrite: false
    });
    var sh = new THREE.Mesh(shardGeo, m);
    sh.position.set((Math.random() - 0.5) * 30, (Math.random() - 0.5) * 16, -6 - Math.random() * 14);
    sh.scale.setScalar(0.6 + Math.random() * 2.2);
    sh.rotation.set(Math.random() * 6, Math.random() * 6, 0);
    sh.userData.phase = Math.random() * 6.28;
    sh.userData.spd = 0.3 + Math.random() * 0.6;
    shards.push(sh);
    scene.add(sh);
  }

  /* ---------- LIGHT TRAILS ---------- */
  var trails = [];
  for (i = 0; i < 3; i++) {
    var pts = [];
    for (var j = 0; j < 5; j++) pts.push(new THREE.Vector3((Math.random() - 0.5) * 26, (Math.random() - 0.5) * 12, -7 - Math.random() * 8));
    var curve = new THREE.CatmullRomCurve3(pts);
    var lineMat = new THREE.LineBasicMaterial({
      color: i === 1 ? 0xa78bfa : (i === 2 ? 0xe879f9 : 0x7fa8ff),
      transparent: true, opacity: 0.28, blending: THREE.AdditiveBlending, depthWrite: false
    });
    var line = new THREE.Line(new THREE.BufferGeometry().setFromPoints(curve.getPoints(40)), lineMat);
    line.userData.ctrl = pts;
    line.userData.phase = Math.random() * 6.28;
    line.userData.spd = 0.25 + Math.random() * 0.4;
    trails.push(line);
    scene.add(line);
  }

  /* ---------- VOLUMETRIC FOG SPRITES ---------- */
  var glowTex = radialTexture([[0, 'rgba(160,185,255,0.35)'], [0.5, 'rgba(100,120,220,0.12)'], [1, 'rgba(0,0,0,0)']]);
  var fogSprites = [];
  for (i = 0; i < 3; i++) {
    var spMat = new THREE.SpriteMaterial({
      map: glowTex, transparent: true, opacity: 0.10,
      blending: THREE.AdditiveBlending, depthWrite: false
    });
    var sp = new THREE.Sprite(spMat);
    sp.position.set((Math.random() - 0.5) * 22, (Math.random() - 0.5) * 10, -10 - Math.random() * 8);
    sp.scale.set(26 + Math.random() * 12, 16 + Math.random() * 8, 1);
    sp.userData.phase = Math.random() * 6.28;
    sp.userData.spd = 0.12 + Math.random() * 0.2;
    fogSprites.push(sp);
    scene.add(sp);
  }

  /* ---------- LENS FLARE ---------- */
  var flareMat = new THREE.SpriteMaterial({
    map: starTexture(), transparent: true, opacity: 0.14, depthWrite: false,
    blending: THREE.AdditiveBlending
  });
  var flare = new THREE.Sprite(flareMat);
  flare.position.set(3.4, 1.8, -2.4);
  flare.scale.set(2.4, 2.4, 1);
  if (!IS_HOME) flare.visible = false;
  scene.add(flare);

  /* ---------- SOUND SPHERE (home only) ---------- */
  var sphereGroup = null;
  var floorGlow = null;
  var floorShadow = null;

  if (IS_HOME) {
    sphereGroup = new THREE.Group();
    sphereGroup.position.set(isMobile ? 0 : 2.6, -0.35, -1.2);

    var glassFront = new THREE.Mesh(
      new THREE.SphereGeometry(2.0, 48, 48),
      new THREE.MeshPhysicalMaterial({
        color: 0x9fc2ff, transparent: true, opacity: 0.07, metalness: 0, roughness: 0.08,
        clearcoat: 1, clearcoatRoughness: 0.06, depthWrite: false
      })
    );
    sphereGroup.add(glassFront);

    var glassBack = new THREE.Mesh(
      new THREE.SphereGeometry(1.96, 48, 48),
      new THREE.MeshPhysicalMaterial({
        color: 0x6a8cff, transparent: true, opacity: 0.1, metalness: 0.4, roughness: 0.12,
        side: THREE.BackSide, depthWrite: false
      })
    );
    sphereGroup.add(glassBack);

    var lattice = new THREE.Mesh(
      new THREE.SphereGeometry(2.05, 22, 22),
      new THREE.MeshBasicMaterial({
        color: 0x4d8dff, wireframe: true, transparent: true, opacity: 0.05, depthWrite: false
      })
    );
    sphereGroup.add(lattice);

    var core = new THREE.Mesh(
      new THREE.IcosahedronGeometry(0.95, 2),
      new THREE.MeshPhysicalMaterial({
        color: 0x24407a, metalness: 0.9, roughness: 0.22, clearcoat: 0.8,
        emissive: 0x1a3f7f, emissiveIntensity: 0.4
      })
    );
    core.position.y = 0;
    sphereGroup.add(core);

    var coreWire = new THREE.Mesh(
      new THREE.IcosahedronGeometry(1.1, 1),
      new THREE.MeshBasicMaterial({ color: 0x7fa8ff, wireframe: true, transparent: true, opacity: 0.12 })
    );
    sphereGroup.add(coreWire);

    var innerLight = new THREE.PointLight(0x5b8cff, 1.4, 9);
    sphereGroup.add(innerLight);

    var ringPts = isMobile ? 70 : 120;
    var ringGeo = new THREE.BufferGeometry();
    var ringPos = new Float32Array(ringPts * 3);
    var ringBase = new Float32Array(ringPts * 3);
    for (i = 0; i < ringPts; i++) {
      var a = (i / ringPts) * Math.PI * 2;
      var px = Math.cos(a) * 1.72;
      var pz = Math.sin(a) * 1.72;
      ringPos[i * 3] = px;
      ringPos[i * 3 + 1] = 0;
      ringPos[i * 3 + 2] = pz;
      ringBase[i * 3] = px;
      ringBase[i * 3 + 1] = 0;
      ringBase[i * 3 + 2] = pz;
    }
    ringGeo.setAttribute('position', new THREE.BufferAttribute(ringPos, 3));
    var ringMat = new THREE.PointsMaterial({
      color: 0x8fb2ff, size: isMobile ? 0.05 : 0.055, transparent: true, opacity: 0.85,
      blending: THREE.AdditiveBlending, depthWrite: false
    });
    var ring = new THREE.Points(ringGeo, ringMat);
    sphereGroup.add(ring);

    var ring2Geo = new THREE.BufferGeometry();
    var ring2Pos = new Float32Array(ringPts * 3);
    var ring2Base = new Float32Array(ringPts * 3);
    for (i = 0; i < ringPts; i++) {
      var a2 = (i / ringPts) * Math.PI * 2;
      var px2 = Math.cos(a2) * 1.85;
      var py2 = Math.sin(a2) * 1.85;
      ring2Pos[i * 3] = px2;
      ring2Pos[i * 3 + 1] = py2;
      ring2Pos[i * 3 + 2] = 0;
      ring2Base[i * 3] = px2;
      ring2Base[i * 3 + 1] = py2;
      ring2Base[i * 3 + 2] = 0;
    }
    ring2Geo.setAttribute('position', new THREE.BufferAttribute(ring2Pos, 3));
    var ring2Mat = new THREE.PointsMaterial({
      color: 0xa78bfa, size: isMobile ? 0.045 : 0.05, transparent: true, opacity: 0.6,
      blending: THREE.AdditiveBlending, depthWrite: false
    });
    var ring2 = new THREE.Points(ring2Geo, ring2Mat);
    sphereGroup.add(ring2);

    var orbitN = isMobile ? 30 : 56;
    var orbitGeo = new THREE.BufferGeometry();
    var orbitPos = new Float32Array(orbitN * 3);
    for (i = 0; i < orbitN; i++) {
      var ao = Math.random() * Math.PI * 2;
      var ro = 2.55 + Math.random() * 0.5;
      orbitPos[i * 3] = Math.cos(ao) * ro;
      orbitPos[i * 3 + 1] = (Math.random() - 0.5) * 0.9;
      orbitPos[i * 3 + 2] = Math.sin(ao) * ro;
    }
    orbitGeo.setAttribute('position', new THREE.BufferAttribute(orbitPos, 3));
    var orbitMat = new THREE.PointsMaterial({
      color: 0xe879f9, size: isMobile ? 0.035 : 0.04, transparent: true, opacity: 0.5,
      blending: THREE.AdditiveBlending, depthWrite: false
    });
    var orbit = new THREE.Points(orbitGeo, orbitMat);
    sphereGroup.add(orbit);

    floorGlow = new THREE.Sprite(new THREE.SpriteMaterial({
      map: glowTex, transparent: true, opacity: 0.16, depthWrite: false, blending: THREE.AdditiveBlending
    }));
    floorGlow.position.set(0, -2.35, 0);
    floorGlow.scale.set(9, 4.5, 1);
    sphereGroup.add(floorGlow);

    var shadowTex = radialTexture([[0, 'rgba(0,0,0,0.85)'], [0.6, 'rgba(0,0,0,0.4)'], [1, 'rgba(0,0,0,0)']]);
    floorShadow = new THREE.Mesh(
      new THREE.CircleGeometry(2.5, 40),
      new THREE.MeshBasicMaterial({ map: shadowTex, transparent: true, opacity: 0.5, depthWrite: false })
    );
    floorShadow.rotation.x = -Math.PI / 2;
    floorShadow.position.y = -2.34;
    sphereGroup.add(floorShadow);

    scene.add(sphereGroup);
  }

  /* ---------- HERO SOUND VISUALIZER (home only) ---------- */
  var bars = null;
  if (IS_HOME) {
    var barN = isMobile ? 18 : 30;
    bars = [];
    var barGeo = new THREE.BoxGeometry(0.09, 1, 0.09);
    for (i = 0; i < barN; i++) {
      var t = i / (barN - 1);
      var xx = -8.4 + t * 16.8;
      var col = new THREE.Color();
      col.setHSL(0.62 + t * 0.16, 0.75, 0.62);
      var barMat = new THREE.MeshBasicMaterial({ color: col, transparent: true, opacity: 0.4 });
      var bar = new THREE.Mesh(barGeo, barMat);
      bar.position.set(xx, -3.15, 1.4);
      bar.scale.set(1, 0.3, 1);
      bar.userData.phase = Math.random() * 6.28;
      bars.push(bar);
      scene.add(bar);
    }
  }

  /* ---------- INTERACTION STATE ---------- */
  var mouse = { x: 0, y: 0 };
  var tMouse = { x: 0, y: 0 };
  var scrollP = 0;
  var amp = 0;

  if (fine) {
    window.addEventListener('mousemove', function (e) {
      tMouse.x = (e.clientX / window.innerWidth) * 2 - 1;
      tMouse.y = (e.clientY / window.innerHeight) * 2 - 1;
    }, { passive: true });
  }

  var body = document.body;

  /* ---------- SECTION TINTS ---------- */
  var stops = [
    { p: 0.0, c: new THREE.Color(0x10182f) },
    { p: 0.24, c: new THREE.Color(0x221040) },
    { p: 0.5, c: new THREE.Color(0x2c1140) },
    { p: 0.76, c: new THREE.Color(0x221040) },
    { p: 1.0, c: new THREE.Color(0x10182f) }
  ];
  function tintColor(p) {
    p = Math.max(0, Math.min(1, p));
    var a = stops[0], b = stops[stops.length - 1], t = 0;
    for (var i = 0; i < stops.length - 1; i++) {
      if (p >= stops[i].p && p <= stops[i + 1].p) {
        a = stops[i]; b = stops[i + 1];
        t = (p - a.p) / (b.p - a.p || 1);
        break;
      }
    }
    return { r: a.c.r + (b.c.r - a.c.r) * t, g: a.c.g + (b.c.g - a.c.g) * t, b: a.c.b + (b.c.b - a.c.b) * t };
  }

  function onScroll() {
    var max = Math.max(1, (document.documentElement.scrollHeight || body.scrollHeight) - window.innerHeight);
    scrollP = window.scrollY / max;
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  function onResize() {
    var w = window.innerWidth, h = window.innerHeight;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
    isMobile = w < 768;
    if (sphereGroup) sphereGroup.position.x = isMobile ? 0 : 2.6;
    if (bars) {
      for (var i = 0; i < bars.length; i++) {
        var t = i / (bars.length - 1);
        bars[i].position.x = -8.4 + t * 16.8;
      }
    }
  }
  window.addEventListener('resize', onResize, { passive: true });

  /* ---------- RENDER LOOP ---------- */
  var clock = new THREE.Clock();
  var acc = 0;

  function render() {
    requestAnimationFrame(render);
    if (document.hidden) return;

    var dt = Math.min(clock.getDelta(), 0.05);
    var t = clock.elapsedTime;
    acc += dt;

    mouse.x += (tMouse.x - mouse.x) * 0.05;
    mouse.y += (tMouse.y - mouse.y) * 0.05;

    var live = (window.AudioCore && window.AudioCore.amplitude) ? window.AudioCore.amplitude() : 0;
    amp += (live - amp) * 0.18;

    /* camera + sphere cinematic motion */
    var camX = mouse.x * 0.5;
    var camY = scrollP * 1.7 + mouse.y * 0.3;
    var camZ = 8 + scrollP * 1.7;
    camera.position.x += (camX - camera.position.x) * 0.05;
    camera.position.y += (camY - camera.position.y) * 0.05;
    camera.position.z += (camZ - camera.position.z) * 0.05;
    camera.lookAt(0, scrollP * 1.0, -2 - scrollP * 1.5);

    /* dust drift + parallax */
    dust.rotation.y += dt * 0.006;
    dust2.rotation.y -= dt * 0.004;
    dust.position.x = mouse.x * 0.6;
    dust.position.y = mouse.y * 0.35;
    dust2.position.x = -mouse.x * 0.4;
    dust2.position.y = -mouse.y * 0.25;
    stars.rotation.y += dt * 0.003;
    stars.position.x = mouse.x * 0.3;
    stars.position.y = mouse.y * 0.2;

    /* shards */
    for (var si = 0; si < shards.length; si++) {
      var sh = shards[si];
      sh.rotation.x += dt * 0.12;
      sh.rotation.y += dt * 0.18;
      sh.position.y += Math.sin(t * sh.userData.spd + sh.userData.phase) * 0.002;
    }

    /* light trails */
    for (var li = 0; li < trails.length; li++) {
      var line = trails[li];
      var ctr = line.userData.ctrl;
      var pts2 = [];
      for (var p = 0; p < ctr.length; p++) {
        var baseY = ctr[p].y;
        pts2.push(new THREE.Vector3(
          ctr[p].x + Math.sin(t * line.userData.spd + p * 1.3 + line.userData.phase) * 0.6,
          baseY + Math.sin(t * line.userData.spd * 1.7 + p + line.userData.phase) * 0.8,
          ctr[p].z
        ));
      }
      line.geometry.setFromPoints(new THREE.CatmullRomCurve3(pts2).getPoints(40));
    }

    /* fog sprites */
    for (var fi = 0; fi < fogSprites.length; fi++) {
      var fs = fogSprites[fi];
      fs.position.x += Math.sin(t * fs.userData.spd + fs.userData.phase) * 0.003;
      fs.position.y += Math.cos(t * fs.userData.spd * 0.8 + fs.userData.phase) * 0.002;
    }

    /* flare pulse */
    flareMat.opacity = 0.1 + Math.sin(t * 1.4) * 0.04 + amp * 0.1;

    /* audio sphere */
    if (sphereGroup) {
      var baseX = isMobile ? 0 : 2.6;
      sphereGroup.position.x += ((baseX + mouse.x * 0.45) - sphereGroup.position.x) * 0.05;
      sphereGroup.position.y += ((-0.35 + mouse.y * 0.3 - scrollP * 1.1) - sphereGroup.position.y) * 0.05;
      sphereGroup.position.z = -1.2 - scrollP * 2.2;
      var sc = 1 - scrollP * 0.16;
      sphereGroup.scale.setScalar(sc + (sphereGroup.scale.x - sc) * 0.05);
      sphereGroup.rotation.y += dt * 0.12;
      sphereGroup.rotation.z += dt * 0.015;

      core.rotation.y -= dt * 0.22;
      core.rotation.x += dt * 0.06;
      coreWire.rotation.y += dt * 0.3;
      coreWire.rotation.z -= dt * 0.12;
      core.material.emissiveIntensity = 0.4 + amp * 1.1;
      innerLight.intensity = 1.4 + amp * 1.6;
      glassFront.material.opacity = 0.07 + amp * 0.035;
      glassBack.material.opacity = 0.1 + amp * 0.05;

      var rp = ring.geometry.attributes.position.array;
      var rp2 = ring2.geometry.attributes.position.array;
      var n = ringPts;
      for (var r = 0; r < n; r++) {
        var w1 = Math.sin(t * 3 + r * 0.38) * (0.12 + amp * 0.55);
        var w2 = Math.cos(t * 2.4 + r * 0.47) * (0.1 + amp * 0.4);
        rp[r * 3 + 1] = ringBase[r * 3 + 1] + w1;
        rp[r * 3 + 2] = ringBase[r * 3 + 2] + w1 * 0.5;
        rp2[r * 3] = ring2Base[r * 3] + w2 * 0.7;
        rp2[r * 3 + 2] = ring2Base[r * 3 + 2] + w2;
      }
      ring.geometry.attributes.position.needsUpdate = true;
      ring2.geometry.attributes.position.needsUpdate = true;

      if (floorGlow) floorGlow.material.opacity = 0.14 + amp * 0.1;
    }

    /* hero visualizer bars */
    if (bars) {
      for (var b = 0; b < bars.length; b++) {
        var bar = bars[b];
        var h = 0.25 + Math.max(0, amp) * 1.6 * (0.35 + Math.abs(Math.sin(t * 2 + bar.userData.phase + b * 0.4)) * 0.65);
        bar.scale.y += (h - bar.scale.y) * 0.25;
        bar.material.opacity = 0.25 + amp * 0.3;
      }
    }

    /* section tint on fog + particles */
    var tcol = tintColor(scrollP);
    scene.fog.color.setRGB(tcol.r, tcol.g, tcol.b);
    var dustT = new THREE.Color(0x7fa8ff);
    var dust2T = new THREE.Color(0xa78bfa);
    var starT = new THREE.Color(0xdce7ff);
    dustT.lerp(new THREE.Color(0x4d8dff), 0.3);
    dustMat.color.lerp(dustT, 0.02);
    dust2Mat.color.lerp(dust2T, 0.02);
    starMat.color.lerp(starT, 0.02);

    renderer.render(scene, camera);
  }

  /* ---------- START ---------- */
  if (IS_HOME && !isMobile) {
    var intro = document.createElement('div');
    intro.style.cssText = 'position:fixed;inset:0;z-index:-1;background:#050507;pointer-events:none;';
    document.body.appendChild(intro);
    setTimeout(function () {
      if (intro.parentNode) intro.parentNode.removeChild(intro);
    }, 1300);
  }

  render();
})();