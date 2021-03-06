/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.language = 'ru';

	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
	];
	
	config.removePlugins = 'elementspath';

	config.extraPlugins = 'wordcount';

	config.wordcount = {

		// Whether or not you want to show the Paragraphs Count
		showParagraphs: false,
	
		// Whether or not you want to show the Word Count
		showWordCount: false,
	
		// Whether or not you want to show the Char Count
		showCharCount: true,
	
		// Whether or not you want to count Spaces as Chars
		countSpacesAsChars: true,
	
		// Whether or not to include Html chars in the Char Count
		countHTML: false,
		
		// Maximum allowed Word Count, -1 is default for unlimited
		maxWordCount: -1,
	
		// Maximum allowed Char Count, -1 is default for unlimited
		maxCharCount: 50,
	
	};
	
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
