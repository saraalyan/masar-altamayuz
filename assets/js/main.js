(function () {
	'use strict';
	var cfg = window.MasarCfg || {};
	var root = document.documentElement;

	/* الوضع الليلي */
	var tbtn = document.querySelector('.theme-toggle');
	function isDark() {
		var t = root.getAttribute('data-theme');
		return t === 'dark';
	}
	function paint() { if (tbtn) { tbtn.setAttribute('aria-pressed', isDark() ? 'true' : 'false'); } }
	if (tbtn) {
		tbtn.addEventListener('click', function () {
			var next = isDark() ? 'light' : 'dark';
			root.setAttribute('data-theme', next);
			try { localStorage.setItem('masar-theme', next); } catch (e) {}
			paint();
		});
		paint();
	}

	/* قائمة الموبايل (منسدلة أو جانبية) */
	var nt = document.querySelector('.nav-toggle');
	var nav = document.querySelector('.main-nav');
	var ov = document.querySelector('.nav-overlay');
	var side = document.body.classList.contains('mnav-side');
	function setNav(open) {
		nav.classList.toggle('open', open);
		nt.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (side) {
			document.body.classList.toggle('nav-locked', open);
			if (ov) { if (open) { ov.removeAttribute('hidden'); } else { ov.setAttribute('hidden', ''); } }
		}
	}
	if (nt && nav) {
		nt.addEventListener('click', function () { setNav(!nav.classList.contains('open')); });
		var nc = nav.querySelector('.nav-close');
		if (nc) { nc.addEventListener('click', function () { setNav(false); nt.focus(); }); }
		if (ov) { ov.addEventListener('click', function () { setNav(false); }); }
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('open')) { setNav(false); nt.focus(); }
		});
	}

	/* ترقيم المدونة: تحميل المزيد / تلقائي */
	var pg = document.querySelector('.pager[data-mode]');
	var grid = document.querySelector('.content .posts');
	if (pg && grid && window.fetch && window.DOMParser) {
		var nextLink = function (root) { var a = root.querySelector('.pager a.next'); return a ? a.href : ''; };
		var url = nextLink(document);
		pg.classList.add('is-enhanced');
		var live = document.createElement('p');
		live.className = 'load-status';
		live.setAttribute('role', 'status');
		live.setAttribute('aria-live', 'polite');
		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'btn load-more';
		btn.textContent = pg.getAttribute('data-more');
		pg.appendChild(btn);
		pg.appendChild(live);
		var busy = false, io = null;
		var finish = function () {
			btn.hidden = true;
			if (io) { io.disconnect(); }
			live.textContent = pg.getAttribute('data-done');
		};
		var load = function () {
			if (busy || !url) { return; }
			busy = true;
			btn.disabled = true;
			btn.textContent = pg.getAttribute('data-loading');
			fetch(url, { credentials: 'same-origin' }).then(function (r) {
				if (!r.ok) { throw new Error('http'); }
				return r.text();
			}).then(function (html) {
				var doc = new DOMParser().parseFromString(html, 'text/html');
				var items = doc.querySelectorAll('.content .posts > *');
				var first = null;
				items.forEach(function (it) {
					var n = document.importNode(it, true);
					if (!first) { first = n; }
					grid.appendChild(n);
				});
				url = nextLink(doc);
				busy = false;
				btn.disabled = false;
				btn.textContent = pg.getAttribute('data-more');
				if (!url) { finish(); }
			}).catch(function () {
				busy = false;
				btn.disabled = false;
				btn.textContent = pg.getAttribute('data-more');
				live.textContent = pg.getAttribute('data-error');
			});
		};
		if (!url) { btn.hidden = true; }
		btn.addEventListener('click', load);
		if (pg.getAttribute('data-mode') === 'infinite' && 'IntersectionObserver' in window && url) {
			io = new IntersectionObserver(function (en) { if (en[0].isIntersecting) { load(); } }, { rootMargin: '300px' });
			io.observe(btn);
		}
	}

	/* تثبيت الهيدر: يصغر / يختفي */
	var hd = document.querySelector('.site-header.is-sticky');
	if (hd && (hd.classList.contains('sticky-shrink') || hd.classList.contains('sticky-hide'))) {
		var lastY = window.pageYOffset, tick = false;
		var onScroll = function () {
			var y = window.pageYOffset;
			if (hd.classList.contains('sticky-shrink')) { hd.classList.toggle('is-shrunk', y > 60); }
			if (hd.classList.contains('sticky-hide')) {
				var busy = (nav && nav.classList.contains('open')) || hd.querySelector('.search-panel:not([hidden])');
				if (y > lastY + 4 && y > 160 && !busy) { hd.classList.add('is-hidden'); }
				else if (y < lastY - 4 || y <= 160) { hd.classList.remove('is-hidden'); }
			}
			lastY = y; tick = false;
		};
		window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(onScroll); } }, { passive: true });
		onScroll();
	}

	/* لوحة البحث */
	var sb = document.querySelector('.search-toggle');
	var sp = document.querySelector('.search-panel');
	if (sb && sp) {
		sb.addEventListener('click', function () {
			var show = sp.hasAttribute('hidden');
			if (show) { sp.removeAttribute('hidden'); var i = sp.querySelector('input'); if (i) { i.focus(); } } else { sp.setAttribute('hidden', ''); }
			sb.setAttribute('aria-expanded', show ? 'true' : 'false');
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !sp.hasAttribute('hidden')) {
				sp.setAttribute('hidden', '');
				sb.setAttribute('aria-expanded', 'false');
				sb.focus();
			}
		});
	}

	/* النشرة البريدية: لو مفيش رابط معالجة نعرض شكراً بدون إرسال */
	document.querySelectorAll('.js-newsletter').forEach(function (f) {
		var a = f.getAttribute('action');
		if (!a || a === '#' || a.slice(-1) === '#') {
			f.addEventListener('submit', function (e) {
				e.preventDefault();
				f.innerHTML = '<strong>' + (cfg.thanks || '') + '</strong>';
			});
		}
	});

	/* نسخ رابط المقال */
	document.querySelectorAll('.share-copy').forEach(function (b) {
		b.addEventListener('click', function () {
			var url = b.getAttribute('data-url'), old = b.textContent;
			function done() { b.textContent = b.getAttribute('data-done') || old; setTimeout(function () { b.textContent = old; }, 2000); }
			if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(url).then(done, function () { window.prompt('', url); }); }
			else { window.prompt('', url); }
		});
	});

	/* زر للأعلى */
	var up = document.querySelector('.to-top');
	if (up) {
		window.addEventListener('scroll', function () { up.hidden = window.scrollY < 500; }, { passive: true });
		up.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
	}

	/* بتلات */
	var box = document.querySelector('.petals');
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (box && parseInt(cfg.petals, 10) === 1 && !reduce) {
		var n = Math.min(Math.max(parseInt(cfg.petalCnt, 10) || 14, 4), 40);
		for (var i = 0; i < n; i++) {
			var p = document.createElement('span');
			var s = 0.6 + Math.random();
			p.className = 'petal';
			p.style.left = Math.random() * 100 + '%';
			p.style.transform = 'scale(' + s + ')';
			p.style.setProperty('--dx', (Math.random() * 160 - 80) + 'px');
			p.style.animationDuration = (9 + Math.random() * 10) + 's';
			p.style.animationDelay = (-Math.random() * 18) + 's';
			box.appendChild(p);
		}
	}
})();
