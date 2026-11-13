/* استوديو مسار: اختيار الصور من مكتبة وسائط ووردبريس */
(function () {
	'use strict';

	function openFrame( multiple, done ) {
		if ( ! window.wp || ! wp.media ) {
			window.alert( 'مكتبة الوسائط مش متاحة في الصفحة دي. جرّبي تحدّثي الصفحة.' );
			return;
		}
		var frame = wp.media( {
			title: multiple ? 'اختيار صور' : 'اختيار صورة',
			button: { text: 'استخدام' },
			library: { type: 'image' },
			multiple: multiple
		} );
		frame.on( 'select', function () {
			var urls = frame.state().get( 'selection' ).toJSON().map( function ( a ) { return a.url; } );
			done( urls );
		} );
		frame.open();
	}

	function refreshPreview( wrap ) {
		var input = wrap.querySelector( '.masar-img-url' );
		var img = wrap.querySelector( '.masar-prev' );
		if ( ! input || ! img ) { return; }
		if ( input.value ) { img.src = input.value; img.hidden = false; }
		else { img.removeAttribute( 'src' ); img.hidden = true; }
	}

	document.addEventListener( 'click', function ( e ) {
		var t = e.target;
		if ( ! t.classList ) { return; }

		if ( t.classList.contains( 'masar-pick' ) ) {
			var wrap = t.closest( '.masar-img' );
			openFrame( false, function ( urls ) {
				wrap.querySelector( '.masar-img-url' ).value = urls[ 0 ] || '';
				refreshPreview( wrap );
			} );
		} else if ( t.classList.contains( 'masar-clear' ) ) {
			var w = t.closest( '.masar-img' );
			w.querySelector( '.masar-img-url' ).value = '';
			refreshPreview( w );
		} else if ( t.classList.contains( 'masar-pick-multi' ) ) {
			var ta = t.parentNode.querySelector( 'textarea' );
			openFrame( true, function ( urls ) {
				var cur = ta.value.trim();
				ta.value = ( cur ? cur + '\n' : '' ) + urls.join( '\n' );
			} );
		} else if ( t.classList.contains( 'masar-pick-ins' ) ) {
			var area = t.parentNode.querySelector( 'textarea' );
			var start = area.selectionStart || 0;
			var end = area.selectionEnd || 0;
			openFrame( false, function ( urls ) {
				if ( ! urls[ 0 ] ) { return; }
				area.value = area.value.slice( 0, start ) + urls[ 0 ] + area.value.slice( end );
				area.focus();
				area.selectionStart = area.selectionEnd = start + urls[ 0 ].length;
			} );
		}
	} );

	document.addEventListener( 'input', function ( e ) {
		if ( e.target.classList && e.target.classList.contains( 'masar-img-url' ) ) {
			refreshPreview( e.target.closest( '.masar-img' ) );
		}
	} );
}() );
