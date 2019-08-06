import { Editor } from 'tinymce';

import { Omit } from '@ithoughts/tooltip-glossary/back/common';
import { makeHtmlElement } from '@ithoughts/tooltip-glossary/common';
import { initTooltip } from '@ithoughts/tooltip-glossary/front';
import editorConfig from '~editor-config';

import { convertAllType } from '../../common/shortcode-transformers';
import { EShortcodeType } from '../../common/shortcode-type';
import { registerButtons } from './buttons';
import { registerCommands } from './commands';
import './tinymce-plugin.scss';
import { getEditorTip } from './utils';

type OverridableCss = Omit<CSSStyleDeclaration, 'length' | 'parentRule'>;

export let tipsContainer: HTMLElement | undefined;
export const plugin = async ( editor: Editor ) => {
	( window as any ).editor = editor;
	// Avoid issue with rollup-plugin-json-manifest
	const editorStylesheetUrl = editorConfig.manifest['back-editor-classic' + '.css'];
	if ( editorStylesheetUrl ) {
		editor.contentCSS.push( editorStylesheetUrl );
	}

	// tslint:disable-next-line: no-inferred-empty-object-type
	editor.on( 'init', ( ) => {
		tipsContainer = makeHtmlElement( { tag: 'div', content: '', attributes: { id: 'tips-container' }} );
		document.body.appendChild( tipsContainer );

		( Object.entries( {
			bottom: '0px',
			left: '0px',
			right: '0px',
			top: '0px',

			pointerEvents: 'none',
			position: 'absolute',
		} as OverridableCss ) as Array<[keyof OverridableCss, string]> ).forEach( ( [prop, val] ) => {
			tipsContainer!.style[prop] = val;
		} );

		// Init existing tips
		const tips = getEditorTip( editor );
		tips.forEach( tip => initTooltip( tip, tipsContainer, true ) );
	} );

	registerCommands( editor, () => {
		if ( !tipsContainer ) {
			throw new Error( 'Tips container not yet ready.' );
		}
		return tipsContainer;
	 } );
	const { addTooltip, addGlossarytip, removeTip } = await registerButtons( editor );

	removeTip.disabled( false );
	addTooltip.disabled( true );
	addGlossarytip.disabled( true );

	// replace from shortcode to displayable html content
	// tslint:disable-next-line: no-inferred-empty-object-type
	editor.on( 'BeforeSetcontent', event => {
		console.log( 'BeforeSetcontent' );
		event.content = convertAllType( EShortcodeType.QTags, EShortcodeType.TinyMCE, event.content );
		return event;
	} );

	// replace from displayable html content to shortcode
	// tslint:disable-next-line: no-inferred-empty-object-type
	editor.on( 'GetContent', event => {
		console.log( 'GetContent' );
		event.content = convertAllType( EShortcodeType.TinyMCE, EShortcodeType.QTags, event.content );
		return event;
	} );
};
