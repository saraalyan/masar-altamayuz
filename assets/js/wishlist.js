/* مسار التميز — قائمة الأمنيات (كوكي masar_wl) */
(function () {
	'use strict';
	var KEY = 'masar_wl';
	function read() {
		var m = document.cookie.match(new RegExp('(?:^|; )' + KEY + '=([^;]*)'));
		if (!m) { return []; }
		return decodeURIComponent(m[1]).split(',').map(function (x) { return parseInt(x, 10); }).filter(function (x) { return x > 0; });
	}
	function write(ids) {
		var secure = location.protocol === 'https:' ? '; Secure' : '';
		document.cookie = KEY + '=' + encodeURIComponent(ids.join(',')) + '; path=/; max-age=' + (180 * 86400) + '; SameSite=Lax' + secure;
	}
	function paint() {
		var ids = read();
		document.querySelectorAll('.wl-btn').forEach(function (b) {
			var on = ids.indexOf(parseInt(b.getAttribute('data-id'), 10)) > -1;
			b.classList.toggle('is-on', on);
			b.setAttribute('aria-pressed', on ? 'true' : 'false');
			b.setAttribute('aria-label', b.getAttribute(on ? 'data-remove' : 'data-add'));
		});
		document.querySelectorAll('.wl-count').forEach(function (c) {
			c.textContent = ids.length;
			c.hidden = ids.length === 0;
		});
	}
	document.addEventListener('click', function (e) {
		var b = e.target.closest ? e.target.closest('.wl-btn') : null;
		if (!b) { return; }
		e.preventDefault();
		e.stopPropagation();
		var id = parseInt(b.getAttribute('data-id'), 10);
		var ids = read();
		var i = ids.indexOf(id);
		if (i > -1) { ids.splice(i, 1); } else { ids.unshift(id); ids = ids.slice(0, 100); }
		write(ids);
		paint();
		var page = b.closest('.wl-page');
		if (page && i > -1) {
			var li = b.closest('li.product');
			if (li) { li.remove(); }
			if (!page.querySelector('li.product')) {
				var list = page.querySelector('ul.products');
				if (list) { list.remove(); }
				var p = document.createElement('p');
				p.className = 'wl-empty';
				p.textContent = (window.MasarWL && window.MasarWL.empty) || '';
				page.appendChild(p);
			}
		}
	});
	paint();
})();
