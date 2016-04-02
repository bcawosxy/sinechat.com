
/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// var lib_root = "http://ccckaass.tk/lib/";
// var lib_root = "http://pindelta.net/lib/";
var lib_root = 'http://'+location.hostname+'/lib/';
var lib_root = 'http://'+location.hostname+'/assets/js/';
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#108199';


  config.toolbar = 'Full';

  config.toolbar_Full =
  [
    ['Source','Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    '/',
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    '/',
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
  ];

  config.toolbar_Basic =
  [
    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
  ];

config.filebrowserBrowseUrl = lib_root + 'ckfinder/ckfinder.html';
config.filebrowserImageBrowseUrl = lib_root + 'ckfinder/ckfinder.html?Type=Images';
config.filebrowserFlashBrowseUrl = lib_root + 'ckfinder/ckfinder.html?Type=Flash';
config.filebrowserImageUploadUrl = lib_root + 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';//可上傳圖檔
config.extraPlugins = 'bootstrapVisibility';
// config.filebrowserUploadUrl = 'http://ccckaass.tk/lib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'; //可上傳一般檔案
// config.filebrowserFlashUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';//可上傳Flash檔案

};