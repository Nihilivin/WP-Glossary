import { Editor } from 'tinymce';

import { camelCaseToDash, makeHtmlTag, ns, uuid } from '@ithoughts/tooltip-glossary/back/common';

import { ETipType, TipForm, TipFormOutput } from './forms';
import { isGlossarytip } from './forms/tip-form/glossarytip-section';
import { isTooltip } from './forms/tip-form/tooltip-section';

const openTipForm = ( editor: Editor, type: ETipType ) => {
	const form = TipForm.mount( {
		text: '',
		type,

		onClose: ( isSubmit: boolean, data?: TipFormOutput ) => {
			console.log( isSubmit, data );
			if ( isSubmit && data ) {
				editor.execCommand( ns( 'insert-tip' ), undefined, data, data );
			}
		},
	} );
};

const getSpecializedAttributes = ( tipDesc: TipFormOutput ) => {
	if ( isGlossarytip( tipDesc ) ) {
		return {
			href: `/term-${tipDesc.termId}`,
			termId: tipDesc.termId.toString(),
		} as const;
	} else if ( isTooltip( tipDesc ) ) {
		return {
			content: tipDesc.content,
		} as const;
	} else {
		throw new Error();
	}
};

export const registerCommands = ( editor: Editor ) => {
	editor.addCommand( ns( 'insert-tip' ), ( ( ui, tipDesc: TipFormOutput ) => {
		const typeName = ETipType[tipDesc.type];
		const attributes = {
			class: [ns( camelCaseToDash( typeName ), '-' ), ns( 'tip', '-' )].join( ' ' ),
			href: tipDesc.linkTarget,
			text: tipDesc.text,
			tipUuid: uuid( 'tip' ),
			type: typeName,

			...getSpecializedAttributes( tipDesc ),
		};

		// Could use editor.dom.createHTML, but our method is better ;)
		const tag = makeHtmlTag( { tag: 'a', content: tipDesc.text, attributes } );
		editor.execCommand( 'mceReplaceContent', false, tag.outerHTML );

		const newTip = editor.getBody().querySelector( `[data-tip-uuid="${attributes.tipUuid}"]` );
		// TODO: Init new tip

		return true;
	} ) as ( u?: boolean, v?: any ) => boolean );

	editor.addCommand( ns( 'open-tooltip-form' ), ( ui, value ) => {
		openTipForm( editor, ETipType.Tooltip );
		return true;
	} );
	editor.addCommand( ns( 'open-glossarytip-form' ), ( ui, value ) => {
		openTipForm( editor, ETipType.Glossarytip );
		return true;
	} );
};
