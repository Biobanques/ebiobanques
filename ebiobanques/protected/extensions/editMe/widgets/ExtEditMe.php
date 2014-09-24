<?php
/**
 * ExtEditMe class file.
 *
 * @author Tobias Giacometti
 * @link http://bitbucket.org/limi7less/editme/
 * @copyright Copyright &copy; 2011-2013 Tobias Giacometti
 * @license http://bitbucket.org/limi7less/editme/wiki/License
 */

/**
 * ExtEditMe creates a WYSIWYG editor based on CKEditor.
 *
 * @author Tobias Giacometti
 * @package ext.editMe.widgets
 * @since 1.0
 */
class ExtEditMe extends CInputWidget {

	/**
	 * @var string If an ID of an HTML tag is passed to this property the editor will operate in inline
	 * mode. No text area is created and the editing is done directly on the final content. To activate
	 * the editing interface, simply click on the editable areas of the page.
	 * @since 2.1
	 */
	public $inlineId;

	/**
	 * @var string "class" attribute value that should be used in the HTML "body" tag of the editor
	 * editing area.
	 */
	public $bodyClass = '';

	/**
	 * @var string "id" attribute value that should be used in the HTML "body" tag of the editor
	 * editing area.
	 */
	public $bodyId = '';

	/**
	 * @var array URLs to the CSS files that should be applied to the editor editing area.
	 */
	public $contentsCss = array();

	/**
	 * @var string DOCTYPE that should be applied to the editor editing area. Defaults to "<!DOCTYPE html>".
	 */
	public $docType = '<!DOCTYPE html>';

	/**
	 * @var string URL to the file browser ("Link" dialog).
	 */
	public $filebrowserBrowseUrl = '';

	/**
	 * @var string URL to the file browser ("Flash Properties" dialog).
	 */
	public $filebrowserFlashBrowseUrl = '';

	/**
	 * @var string URL to the file browser ("Image Properties" dialog).
	 */
	public $filebrowserImageBrowseUrl = '';

	/**
	 * @var string URL to the file browser ("Link" tab in "Image Properties" dialog).
	 */
	public $filebrowserImageBrowseLinkUrl = '';

	/**
	 * @var string URL to the file uploader ("Link" dialog).
	 */
	public $filebrowserUploadUrl = '';

	/**
	 * @var string URL to the file uploader ("Flash Properties" dialog).
	 */
	public $filebrowserFlashUploadUrl = '';

	/**
	 * @var string URL to the file uploader ("Image Properties" dialog).
	 */
	public $filebrowserImageUploadUrl = '';

	/**
	 * @var boolean Whether to leave "html" and "head" tags in place. Setting this to false will strip
	 * the "html" and "head" tags from the editor content. Defaults to false.
	 */
	public $fullPage = false;

	/**
	 * @var mixed Height of the editor editing area. Following value formats are supported: 200, '200px', '25em'.
	 * Defaults to 200.
	 */
	public $height = 200;

	/**
	 * @var mixed Width of the editor. Following value formats are supported: 600, '600px', '75%', '25em'.
	 * Leave empty for automatic width.
	 */
	public $width = '';

	/**
	 * @var boolean Whether the editor should automatically determine the client's preferred language. If
	 * set to false, it will use CApplication::$language. If the language set in CApplication::$language
	 * isn't supported, English will be used. Defaults to true.
	 */
	public $autoLanguage = true;

	/**
	 * @var mixed Mode to use for editor resizing.
	 * <ul>
	 * <li>If set to 'both' (default), the user has the ability to resize the editor vertically and horizontally.</li>
	 * <li>If set to 'horizontal', the user has the ability to resize the editor horizontally but not vertically.</li>
	 * <li>If set to 'vertical', the user has the ability to resize the editor vertically but not horizontally.</li>
	 * <li>If set to false, the user cannot resize the editor.</li>
	 * </ul>
	 * @since 1.2.2
	 */
	public $resizeMode = 'both';

	/**
	 * @var array Editor toolbar items. Leave array empty for full toolbar or define custom items.
	 * <pre>
	 * // Array for a full toolbar. Slashes represent line breaks and dashes represent separators.
	 * array(
	 *		array(
	 *			'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates',
	 *		),
	 *		array(
	 *			'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo',
	 *		),
	 *		array(
	 *			'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
	 *		),
	 *		array(
	 *			'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'
	 *		),
	 *		'/',
	 *		array(
	 *			'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
	 *		),
	 *		array(
	 *			'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl',
	 *		),
	 *		array(
	 *			'Link', 'Unlink', 'Anchor',
	 *		),
	 *		array(
	 *			'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'
	 *		),
	 *		'/',
	 *		array(
	 *			'Styles', 'Format', 'Font', 'FontSize',
	 *		),
	 *		array(
	 *			'TextColor', 'BGColor',
	 *		),
	 *		array(
	 *			'Maximize', 'ShowBlocks',
	 *		),
	 *		array(
	 *			'About',
	 *		),
	 * )
	 * </pre>
	 */
	public $toolbar = array();

	/**
	 * @var boolean Whether to show advanced dialog tabs. Defaults to true.
	 */
	public $advancedTabs = true;

	/**
	 * @var string Color of the editor user interface. The color can be defined with a HEX color code.
	 */
	public $uiColor = '';

	/**
	 * @var string "href" attribute value that should be used in the HTML "base" tag of the editor
	 * editing area.
	 * @since 1.2
	 */
	public $baseHref = '';

	/**
	 * @var array Configure advanced CKEditor settings. All values in this property will be encoded with
	 * CJavaScript::encode(). Configuring following settings is discouraged since they are automatically
	 * configured by editMe:
	 * <ul>
	 * <li>toolbar</li>
	 * <li>forcePasteAsPlainText</li>
	 * <li>removeDialogTabs</li>
	 * <li>contentsCss</li>
	 * <li>resize_enabled</li>
	 * <li>resize_dir</li>
	 * <li>language</li>
	 * <li>baseHref</li>
	 * <li>bodyClass</li>
	 * <li>bodyId</li>
	 * <li>docType</li>
	 * <li>filebrowserBrowseUrl</li>
	 * <li>filebrowserFlashBrowseUrl</li>
	 * <li>filebrowserImageBrowseUrl</li>
	 * <li>filebrowserFlashUploadUrl</li>
	 * <li>filebrowserUploadUrl</li>
	 * <li>filebrowserImageBrowseLinkUrl</li>
	 * <li>filebrowserImageUploadUrl</li>
	 * <li>fullPage</li>
	 * <li>height</li>
	 * <li>width</li>
	 * <li>uiColor</li>
	 * <li>disableNativeSpellChecker</li>
	 * <li>autoUpdateElement</li>
	 * </ul>
	 * A list of settings can be found at http://docs.ckeditor.com/#!/api/CKEDITOR.config
	 * <pre>
	 * // Example: Configure the CKEditor "entities" config value.
	 * array('entities' => false)
	 * </pre>
	 * @since 2.0
	 */
	public $ckeConfig = array();

	/**
	 * @var string CKEditor extension path.
	 * @since 2.0
	 */
	protected $_ckeExtensionPath;

	/**
	 * @var string CKEditor asset URL.
	 * @since 2.0
	 */
	protected static $_ckeAssetUrl;

	/**
	 * @var array Available CKEditor languages.
	 */
	protected static $_languages = array();

	/**
	 * Initialize the editMe widget.
	 */
	public function init() {
		$this -> _ckeExtensionPath = dirname(dirname(__FILE__)) . '/vendors/CKEditor';
		// Start the publishing process if it has not been executed on the current page already
		if (empty(self::$_ckeAssetUrl)) {
			$excludeFiles = Yii::app() -> assetManager -> excludeFiles;
			array_push(Yii::app() -> assetManager -> excludeFiles, 'CHANGES.md', 'README.md', 'samples');
			self::$_ckeAssetUrl = Yii::app() -> assetManager -> publish($this -> _ckeExtensionPath);
			Yii::app() -> assetManager -> excludeFiles = $excludeFiles;
			$ckeAssetPath = str_replace(Yii::app() -> assetManager -> baseUrl, Yii::app() -> assetManager -> basePath, self::$_ckeAssetUrl);
			if (@is_file($ckeAssetPath . '/editMe.' . md5(self::$_ckeAssetUrl) . '.min.js') === false) {
				$scriptContents[] = 'var CKEDITOR_BASEPATH=' . CJavaScript::encode(self::$_ckeAssetUrl . '/') . ';';
				$scriptContents[] = @file_get_contents($ckeAssetPath . '/ckeditor.js');
				$scriptContents[] = @file_get_contents($ckeAssetPath . '/adapters/jquery.js');
				@file_put_contents($ckeAssetPath . '/editMe.' . md5(self::$_ckeAssetUrl) . '.min.js', implode("\n", $scriptContents), LOCK_EX);
			}
		}
	}

	/**
	 * Generate CKEditor config values.
	 * @throws CException if CKEditor language folder cannot be accessed.
	 * @return array CKEditor config values.
	 * @since 2.0
	 */
	protected function _ckeGenerateConfig() {
		// Generate "toolbar" config value
		foreach ((array)$this -> toolbar as $toolbarGroup) {
			if (is_array($toolbarGroup)) {
				foreach ($toolbarGroup as $toolbarItem) {
					if ($toolbarItem != '-') {
						$toolbarItems[] = $toolbarItem;
					}
				}
			}
		}
		$ckeConfig['toolbar'] = (empty($this -> toolbar)) ? null : $this -> toolbar;
		// Generate "forcePasteAsPlainText" config value
		$ckeConfig['forcePasteAsPlainText'] = (isset($toolbarItems['Paste']) || isset($toolbarItems['PasteFromWord'])) ? false : true;
		// Generate "removeDialogTabs" config value
		$ckeConfig['removeDialogTabs'] = ($this -> advancedTabs === false) ? 'imagebutton:advanced;creatediv:advanced;editdiv:advanced;link:advanced;image:advanced;table:advanced;tableProperties:advanced;flash:advanced;iframe:advanced;' : '';
		// Generate "contentsCss" config value
		$ckeConfig['contentsCss'] = array_merge(array(self::$_ckeAssetUrl . '/contents.css'), (array)$this -> contentsCss);
		// Generate "resize_enabled" and "resize_dir" config values
		if ($this -> resizeMode == 'both' || $this -> resizeMode == 'vertical' || $this -> resizeMode == 'horizontal') {
			$ckeConfig['resize_enabled'] = true;
			$ckeConfig['resize_dir'] = $this -> resizeMode;
		} elseif ($this -> resizeMode === false) {
			$ckeConfig['resize_enabled'] = false;
		}
		// Generate "language" config value
		$ckeConfig['language'] = '';
		if ($this -> autoLanguage === false) {
			if (empty(self::$_languages)) {
				$languages = glob($this -> _ckeExtensionPath . '/lang/*', GLOB_NOSORT);
				if (empty($languages)) {
					throw new CException('Cannot access CKEditor language folder "' . $this -> _ckeExtensionPath . '/lang".');
				}
				foreach ($languages as $language) {
					$language = str_replace($this -> _ckeExtensionPath . '/lang/', '', $language);
					self::$_languages[] = substr($language, 0, -3);
				}
			}
			$yiiLanguage = str_replace('_', '-', strtolower(Yii::app() -> language));
			if (in_array($yiiLanguage, self::$_languages)) {
				$ckeConfig['language'] = $yiiLanguage;
			} elseif (in_array(substr($yiiLanguage, 0, 2), self::$_languages)) {
				$ckeConfig['language'] = substr($yiiLanguage, 0, 2);
			} else {
				$ckeConfig['language'] = 'en';
			}
		}
		// Generate "baseHref" config value
		$ckeConfig['baseHref'] = $this -> baseHref;
		// Generate "bodyClass" config value
		$ckeConfig['bodyClass'] = $this -> bodyClass;
		// Generate "bodyId" config value
		$ckeConfig['bodyId'] = $this -> bodyId;
		// Generate "docType" config value
		$ckeConfig['docType'] = $this -> docType;
		// Generate "filebrowserBrowseUrl" config value
		$ckeConfig['filebrowserBrowseUrl'] = $this -> filebrowserBrowseUrl;
		// Generate "filebrowserFlashBrowseUrl" config value
		$ckeConfig['filebrowserFlashBrowseUrl'] = $this -> filebrowserFlashBrowseUrl;
		// Generate "filebrowserImageBrowseUrl" config value
		$ckeConfig['filebrowserImageBrowseUrl'] = $this -> filebrowserImageBrowseUrl;
		// Generate "filebrowserFlashUploadUrl" config value
		$ckeConfig['filebrowserFlashUploadUrl'] = $this -> filebrowserFlashUploadUrl;
		// Generate "filebrowserUploadUrl" config value
		$ckeConfig['filebrowserUploadUrl'] = $this -> filebrowserUploadUrl;
		// Generate "filebrowserImageBrowseLinkUrl" config value
		$ckeConfig['filebrowserImageBrowseLinkUrl'] = $this -> filebrowserImageBrowseLinkUrl;
		// Generate "filebrowserImageUploadUrl" config value
		$ckeConfig['filebrowserImageUploadUrl'] = $this -> filebrowserImageUploadUrl;
		// Generate "fullPage" config value
		$ckeConfig['fullPage'] = $this -> fullPage;
		// Generate "height" config value
		$ckeConfig['height'] = $this -> height;
		// Generate "width" config value
		$ckeConfig['width'] = $this -> width;
		// Generate "uiColor" config value
		$ckeConfig['uiColor'] = $this -> uiColor;
		// Generate "disableNativeSpellChecker" config value
		$ckeConfig['disableNativeSpellChecker'] = false;
		// Generate "autoUpdateElement" config value
		$ckeConfig['autoUpdateElement'] = true;
		// Generate config values which are defined in ExtEditMe::$ckeConfig
		foreach ($this -> ckeConfig as $ckeConfigName => $ckeConfigValue) {
			$ckeConfig[$ckeConfigName] = $ckeConfigValue;
		}
		// Return the CKEditor config values
		return $ckeConfig;
	}

	/**
	 * Run the editMe Widget.
	 */
	public function run() {
		// Register JavaScript files
		Yii::app() -> clientScript -> registerCoreScript('jquery');
		Yii::app() -> clientScript -> registerScriptFile(self::$_ckeAssetUrl . '/editMe.' . md5(self::$_ckeAssetUrl) . '.min.js');
		// Generate textarea if not in inline mode
		if (empty($this -> inlineId)) {
			$nameId = $this -> resolveNameID();
			$this -> htmlOptions['id'] = $nameId[1];
			if ($this -> hasModel()) {
				echo CHtml::activeTextArea($this -> model, $this -> attribute, $this -> htmlOptions);
			} else {
				echo CHtml::textArea($this -> name, $this -> value, $this -> htmlOptions);
			}
		}
		// Load CKEditor
		$ckeConfig = CJavaScript::encode($this -> _ckeGenerateConfig());
		if (empty($this -> inlineId)) {
			$jqSelector = CJavaScript::encode('#' . $this -> htmlOptions['id']);
			Yii::app() -> clientScript -> registerScript('editMe_' . $this -> htmlOptions['id'], 'jQuery(' . $jqSelector . ').ckeditor(' . $ckeConfig . ');', 2);
		} else {
			$selector = CJavaScript::encode($this -> inlineId);
			$jqSelector = CJavaScript::encode('#' . $this -> inlineId);
			Yii::app() -> clientScript -> registerScript('editMe_inline_' . $this -> inlineId, 'jQuery(' . $jqSelector . ').attr("contenteditable",true);CKEDITOR.disableAutoInline=true;CKEDITOR.inline(' . $selector . ',' . $ckeConfig . ');', 2);
		}
	}

}
