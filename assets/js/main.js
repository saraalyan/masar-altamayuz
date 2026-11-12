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
	function paint() { if (tbtn) { tbtn.textContent = isDark() ? '☀️' : '🌙'; } }
	if (tbtn) {
		tbtn.addEventListener('click', function () {
			var next = isDark() ? 'light' : 'dark';
			root.setAttribute('data-theme', next);
			try { localStorage.setItem('masar-theme', next); } catch (e) {}
			paint();
		});
		paint();
	}

	/* قائمة الموبايل */
	var nt = document.querySelector('.nav-toggle');
	var nav = document.querySelector('.main-nav');
	if (nt && nav) {
		nt.addEventListener('click', function () {
			var open = nav.classList.toggle('open');
			nt.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
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
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { sp.setAttribute('hidden', ''); } });
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
