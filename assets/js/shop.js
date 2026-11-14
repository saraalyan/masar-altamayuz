/* مسار التميز — المتجر: نظرة سريعة + إضافة للسلة بدون تحميل + شريط إضافة ثابت */
(function () {
	'use strict';
	var C = window.MasarShop || {};
	var T = C.i18n || {};

	/* ---------- أدوات ---------- */
	function toast(msg, withCart) {
		var el = document.querySelector('.masar-toast');
		if (!el) {
			el = document.createElement('div');
			el.className = 'masar-toast';
			el.setAttribute('role', 'status');
			document.body.appendChild(el);
		}
		el.textContent = msg + ' ';
		if (withCart && C.cartUrl) {
			var a = document.createElement('a');
			a.href = C.cartUrl;
			a.textContent = T.viewCart || '';
			el.appendChild(a);
		}
		el.classList.add('on');
		clearTimeout(el._t);
		el._t = setTimeout(function () { el.classList.remove('on'); }, 3500);
	}

	function applyFragments(fr) {
		if (!fr) { return; }
		Object.keys(fr).forEach(function (sel) {
			document.querySelectorAll(sel).forEach(function (node) {
				var tmp = document.createElement('div');
				tmp.innerHTML = fr[sel];
				if (tmp.firstElementChild) { node.replaceWith(tmp.firstElementChild); }
			});
		});
	}

	/** إضافة منتج بسيط للسلة عبر wc-ajax. done(ok, data) */
	function addToCart(id, qty, done) {
		if (!C.wcAjax) { done(false); return; }
		var body = new URLSearchParams();
		body.set('product_id', id);
		body.set('quantity', qty || 1);
		fetch(C.wcAjax.replace('%%endpoint%%', 'add_to_cart'), {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString()
		}).then(function (r) { return r.json(); }).then(function (d) {
			if (d && d.error) { done(false, d); return; }
			applyFragments(d && d.fragments);
			done(true, d);
		}).catch(function () { done(false); });
	}

	/* ---------- النظرة السريعة ---------- */
	var modal, lastFocus;
	function closeModal() {
		if (!modal) { return; }
		modal.hidden = true;
		document.documentElement.classList.remove('qv-lock');
		if (lastFocus && lastFocus.focus) { lastFocus.focus(); }
	}
	function ensureModal() {
		if (modal) { return modal; }
		modal = document.createElement('div');
		modal.className = 'qv';
		modal.hidden = true;
		modal.innerHTML = '<div class="qv-back"></div><div class="qv-box" role="dialog" aria-modal="true" aria-labelledby="qv-title" tabindex="-1"><button type="button" class="qv-x" aria-label="' + (T.close || '') + '">&times;</button><div class="qv-body"></div></div>';
		document.body.appendChild(modal);
		modal.querySelector('.qv-back').addEventListener('click', closeModal);
		modal.querySelector('.qv-x').addEventListener('click', closeModal);
		return modal;
	}
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && modal && !modal.hidden) { closeModal(); }
		if (e.key === 'Tab' && modal && !modal.hidden) {
			var f = modal.querySelectorAll('button,a[href]');
			if (!f.length) { return; }
			var first = f[0], last = f[f.length - 1];
			if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
			else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
		}
	});

	function openQuickView(id, opener) {
		var m = ensureModal();
		var body = m.querySelector('.qv-body');
		lastFocus = opener;
		body.innerHTML = '<p class="qv-load">' + (T.loading || '') + '</p>';
		m.hidden = false;
		document.documentElement.classList.add('qv-lock');
		m.querySelector('.qv-box').focus();
		fetch(C.ajax + '?action=masar_quickview&id=' + encodeURIComponent(id), { credentials: 'same-origin' })
			.then(function (r) { return r.json(); })
			.then(function (d) {
				if (d && d.success) { body.innerHTML = d.data.html; }
				else { body.innerHTML = '<p class="qv-load">' + (T.error || '') + '</p>'; }
			})
			.catch(function () { body.innerHTML = '<p class="qv-load">' + (T.error || '') + '</p>'; });
	}

	document.addEventListener('click', function (e) {
		var open = e.target.closest && e.target.closest('.qv-open');
		if (open && C.quickView) {
			e.preventDefault();
			openQuickView(open.getAttribute('data-product-id'), open);
			return;
		}
		var add = e.target.closest && e.target.closest('.qv-add');
		if (add) {
			var label = add.textContent;
			add.disabled = true;
			add.textContent = T.adding || '';
			addToCart(add.getAttribute('data-product-id'), 1, function (ok) {
				add.disabled = false;
				if (ok) { add.textContent = T.added || label; toast(T.added || '', true); }
				else { add.textContent = label; toast(T.error || ''); }
			});
		}
	});

	/* ---------- إضافة للسلة بدون تحميل في صفحة المنتج (المنتج البسيط بس) ---------- */
	var form = document.querySelector('form.cart');
	var mainBtn = form && form.querySelector('button.single_add_to_cart_button');
	var simpleForm = form && mainBtn && mainBtn.name === 'add-to-cart' && !form.querySelector('input[name="variation_id"]') && !form.classList.contains('grouped_form') && !form.classList.contains('variations_form');

	if (C.ajaxSingle && simpleForm) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			if (mainBtn.disabled) { return; }
			var qtyEl = form.querySelector('input.qty');
			var label = mainBtn.textContent;
			mainBtn.disabled = true;
			mainBtn.textContent = T.adding || '';
			addToCart(mainBtn.value, qtyEl ? qtyEl.value : 1, function (ok) {
				mainBtn.disabled = false;
				mainBtn.textContent = label;
				toast(ok ? (T.added || '') : (T.error || ''), ok);
			});
		});
	}

	/* ---------- شريط الإضافة الثابت ---------- */
	var bar = document.querySelector('.sticky-atc');
	if (bar && form && mainBtn && 'IntersectionObserver' in window) {
		new IntersectionObserver(function (en) {
			var r = en[0];
			bar.hidden = !(!r.isIntersecting && r.boundingClientRect.top < 0);
			document.body.classList.toggle('has-sticky-atc', !bar.hidden);
		}).observe(mainBtn);
		bar.querySelector('.sticky-atc-b').addEventListener('click', function () {
			if (bar.getAttribute('data-simple') === '1' && simpleForm) { mainBtn.click(); }
			else { form.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
		});
	}
}());
