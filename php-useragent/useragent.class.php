<?php
/**
 * Useragent Class
 * @package php-useragent
 * @author zsx <zsx@zsxsoft.com>
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

Class UserAgentFactory {
/**
 * analyze
 * @static
 * @param  string $string         UserAgent String]
 * @param  string $imageSize      Image Size(16 / 24)
 * @param  string $imagePath      Image Path
 * @param  string $imageExtension Image Description
 * @return UserAgent
 */
	public static function analyze($string, $imageSize = null, $imagePath = null, $imageExtension = null) {
		$class = new UserAgent();
		$imageSize === null || $class->imageSize = $imageSize;
		$imagePath === null || $class->imagePath = $imagePath;
		$imageExtension === null || $class->imageExtension = $imageExtension;
		$class->analyze($string);
		return $class;
	}
}

class UserAgent {
	private $_imagePath = "";
	private $_imageSize = 16;
	private $_imageExtension = ".png";

	private $_data = array();

	public function __get($param) {
		$privateParam = '_' . $param;
		switch ($param) {
		case 'imagePath':
			return $this->_imagePath . $this->_imageSize . '/';
			break;
		default:
			if (isset($this->$privateParam)) {
				return $this->$privateParam;
			} else if (isset($this->_data[$param])) {
				return $this->_data[$param];
			}
			break;
		}
		return null;
	}

	public function __set($name, $value) {
		$trueName = '_' . $name;
		if (isset($this->$trueName)) {
			$this->$trueName = $value;
		}
	}

	public function __construct() {
		$this->_imagePath = 'img/';
	}

	private function _makeImage($dir, $code) {
		return $this->imagePath . $dir . '/' . $code . $this->imageExtension;
	}

	private function _makePlatform() {

		$this->_data['platform'] = &$this->_data['device'];
		if ($this->_data['device']['title'] != '') {
			$this->_data['platform'] = &$this->_data['device'];
		} else if ($this->_data['os']['title'] != '') {
			$this->_data['platform'] = &$this->_data['os'];
		} else {
			$this->_data['platform'] = array(
				"link" => "#",
				"title" => "Unknown",
				"code" => "null",
				"dir" => "browser",
				"type" => "os",
				"image" => $this->_makeImage('browser', 'null'),
			);
			$this->_data['platform']['img_16'] = $this->_data['platform']['image'];
			$this->_data['platform']['all_16'] = '<img src="' . $this->_data['platform']['image'] . '" alt="' . $this->_data['platform']['title'] . '" width="16" height="16" />' . $this->_data['platform']['title'];

			$this->imageSize = 24;
			$this->_data['platform']['img_24'] = $this->_makeImage('browser', 'null');
			$this->_data['platform']['all_24'] = '<img src="' . $this->_data['platform']['img_24'] . '" alt="' . $this->_data['platform']['title'] . '" width="24" height="24" />' . $this->_data['platform']['title'];

			$this->imageSize = 16;
		}

	}

	public function analyze($string) {
		$this->_data['useragent'] = $string;
		$classList = array("device", "os", "browser");
		foreach ($classList as $value) {
			$class = "useragent_detect_" . $value;
			require_once COMMENTUA_PATH . 'php-useragent/lib/' . $class . '.php';
			// Not support in PHP 5.2
			//$this->_data[$value] = $class::analyze($string);
			$this->_data[$value] = call_user_func($class . '::analyze', $string);
			$this->_data[$value]['image'] = $this->_makeImage($value, $this->_data[$value]['code']);

			$this->imageSize = 16;
			$this->_data[$value]['img_16'] = $this->_data[$value]['image'];
			$this->_data[$value]['all_16'] = '<img src="' . $this->_data[$value]['image'] . '" alt="' . $this->_data[$value]['title'] . '" width="16" height="16" />' . $this->_data[$value]['title'];

			$this->imageSize = 24;
			$this->_data[$value]['img_24'] = $this->_makeImage($value, $this->_data[$value]['code']);
			$this->_data[$value]['all_24'] = '<img src="' . $this->_data[$value]['img_24'] . '" alt="' . $this->_data[$value]['title'] . '" width="24" height="24" />' . $this->_data[$value]['title'];

			$this->imageSize = 16;
		}

		// platform
		$this->_makePlatform();
		$this->_data['useragent'] = htmlspecialchars($this->_data['useragent']);
	}

}
//spl_autoload_register(array('UserAgent', '__autoload'));