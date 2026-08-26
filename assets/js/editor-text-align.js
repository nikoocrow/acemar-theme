/**
 * Añade "Justificar" a la alineación de texto de todos los bloques que la soportan.
 *
 * WordPress fija los valores válidos a left|center|right dentro del editor, así
 * que su control de 3 opciones se oculta desde inc/block-alignment.php y aquí se
 * pinta uno equivalente con las 4, escribiendo en el mismo atributo:
 * `attributes.style.typography.textAlign`.
 */
( function ( wp ) {
	'use strict';

	var el                        = wp.element.createElement;
	var Fragment                  = wp.element.Fragment;
	var SVG                       = wp.primitives.SVG;
	var Path                      = wp.primitives.Path;
	var hasBlockSupport           = wp.blocks.hasBlockSupport;
	var BlockControls             = wp.blockEditor.BlockControls;
	var AlignmentControl          = wp.blockEditor.AlignmentControl;
	var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
	var addFilter                 = wp.hooks.addFilter;
	var __                        = wp.i18n.__;

	var SUPPORT = 'typography.textAlign';
	var CLASE_JUSTIFY = 'has-text-align-justify';

	function icono( d ) {
		return el(
			SVG,
			{ xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'currentColor' },
			el( Path, { d: d } )
		);
	}

	// Los tres primeros paths son los mismos que usa core; el de justificar está
	// dibujado con la misma métrica para que el desplegable se vea homogéneo.
	var CONTROLES = [
		{
			align: 'left',
			title: __( 'Alinear texto a la izquierda', 'acemar' ),
			icon: icono( 'M13 5.5H4V4h9v1.5Zm7 7H4V11h16v1.5Zm-7 7H4V18h9v1.5Z' )
		},
		{
			align: 'center',
			title: __( 'Centrar texto', 'acemar' ),
			icon: icono( 'M7.5 5.5h9V4h-9v1.5Zm-3.5 7h16V11H4v1.5Zm3.5 7h9V18h-9v1.5Z' )
		},
		{
			align: 'right',
			title: __( 'Alinear texto a la derecha', 'acemar' ),
			icon: icono( 'M11.111 5.5H20V4h-8.889v1.5ZM4 12.5h16V11H4v1.5Zm7.111 7H20V18h-8.889v1.5Z' )
		},
		{
			align: 'justify',
			title: __( 'Justificar texto', 'acemar' ),
			icon: icono( 'M20 5.5H4V4h16v1.5Zm0 7H4V11h16v1.5Zm0 7H4V18h16v1.5Z' )
		}
	];

	function leerAlineacion( attributes ) {
		var style = attributes && attributes.style;
		return ( style && style.typography && style.typography.textAlign ) || undefined;
	}

	/**
	 * Escribe (o limpia) la alineación sin dejar objetos vacíos colgando en los
	 * atributos, que es como lo hace core.
	 */
	function escribirAlineacion( attributes, setAttributes, valor ) {
		var style      = Object.assign( {}, attributes.style );
		var typography = Object.assign( {}, style.typography );

		if ( valor ) {
			typography.textAlign = valor;
		} else {
			delete typography.textAlign;
		}

		if ( Object.keys( typography ).length ) {
			style.typography = typography;
		} else {
			delete style.typography;
		}

		setAttributes( { style: Object.keys( style ).length ? style : undefined } );
	}

	var conJustificar = createHigherOrderComponent( function ( BlockEdit ) {
		return function ( props ) {
			if ( ! props.isSelected || ! hasBlockSupport( props.name, SUPPORT, false ) ) {
				return el( BlockEdit, props );
			}

			return el(
				Fragment,
				null,
				el( BlockEdit, props ),
				el(
					BlockControls,
					{ group: 'block' },
					el( AlignmentControl, {
						value: leerAlineacion( props.attributes ),
						onChange: function ( valor ) {
							escribirAlineacion( props.attributes, props.setAttributes, valor );
						},
						alignmentControls: CONTROLES
					} )
				)
			);
		};
	}, 'acemarConJustificar' );

	addFilter( 'editor.BlockEdit', 'acemar/text-align/control', conJustificar );

	/**
	 * Core descarta cualquier valor fuera de left|center|right al guardar, así que
	 * la clase de justificado hay que añadirla aparte. Las otras tres las sigue
	 * escribiendo core: aquí no se tocan.
	 *
	 * Los bloques dinámicos (post-title, post-excerpt…) no pasan por aquí, pero
	 * tampoco lo necesitan: el soporte en PHP no filtra el valor.
	 */
	addFilter(
		'blocks.getSaveContent.extraProps',
		'acemar/text-align/save',
		function ( extraProps, blockType, attributes ) {
			if (
				leerAlineacion( attributes ) !== 'justify' ||
				! hasBlockSupport( blockType, SUPPORT, false )
			) {
				return extraProps;
			}

			var clases = ( extraProps.className || '' ).split( ' ' ).filter( Boolean );

			if ( clases.indexOf( CLASE_JUSTIFY ) === -1 ) {
				clases.push( CLASE_JUSTIFY );
			}

			extraProps.className = clases.join( ' ' );

			return extraProps;
		}
	);
} )( window.wp );
