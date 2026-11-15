/* مسار التميز — مقارنة المنتجات (كوكي masar_cmp، حد أقصى 4) */
(function () {
	'use strict';
	var KEY = 'masar_cmp', C = window.MasarCmp || {}, MAX = C.max || 4;
	function read() {
		var m = document.cookie.match(new RegExp('(?:^|; )' + KEY + '=([^;]*)'));
		if (!m) { return []; }
		return decodeURIComponent(m[1]).split(',').map(function (x) { return parseInt(x, 10); }).filter(function (x) { return x > 0; });
	}
	function write(ids) {
		var secure = location.protocol === 'https:' ? '; Secure' : '';
		document.cookie = KEY + '=' + encodeURIComponent(ids.join(',')) + '; path=/; max-age=' + (30 * 86400) + '; SameSite=Lax' + secure;
	}
	function say(msg) {
		var el = document.querySelector('.masar-toast');
		if (!el) { el = document.createElement('div'); el.className = 'masar-toast'; el.setAttribute('role', 'status'); document.body.appendChild(el); }
		el.textContent = msg; el.classList.add('on');
		clearTimeout(el._t); el._t = setTimeout(function () { el.classList.remove('on'); }, 3000);
	}
	function paint() {
		var ids = read();
		document.querySelectorAll('.cmp-btn:not(.cmp-x)').forEach(function (b) {
			var on = ids.indexOf(parseInt(b.getAttribute('data-id'), 10)) > -1;
			b.classList.toggle('is-on', on);
			b.setAttribute('aria-pressed', on ? 'true' : 'false');
			b.textContent = b.getAttribute(on ? 'data-remove' : 'data-add');
		});
		var tray = document.querySelector('.cmp-tray');
		if (tray) {
			tray.hidden = ids.length === 0;
			tray.querySelector('.cmp-n').textContent = ids.length;
		}
	}
	document.addEventListener('click', function (e) {
		var t = e.target.closest ? e.target : null;
		if (!t) { return; }
		var clr = t.closest('.cmp-clear');
		if (clr) { write([]); paint(); return; }
		var b = t.closest('.cmp-btn');
		if (!b) { return; }
		e.preventDefault();
		var id = parseInt(b.getAttribute('data-id'), 10), ids = read(), i = ids.indexOf(id);
		if (i > -1) { ids.splice(i, 1); }
		else if (ids.length >= MAX) { say(C.full || ''); return; }
		else { ids.push(id); }
		write(ids);
		if (b.closest('.cmp-page')) { location.reload(); return; }
		paint();
	});
	paint();
})();
