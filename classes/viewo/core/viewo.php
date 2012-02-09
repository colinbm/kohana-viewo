<?php defined('SYSPATH') or die('No direct script access.');

class ViewO_Core_ViewO {

	protected $_template;

	protected $_action;

	public function __construct(&$template, $action=null) {
		$this->_template = $template;
		if ($action) $this->_action = $action;
	}

	protected function _setup() {}

	public function _configure($template=null) {
		$this->_setup();

		$methods = get_class_methods($this);
		$keys = get_object_vars($this);

		foreach($methods as $method) {
			if (substr($method, 0, 1) != '_' && !isset($keys[$method])) {
				$this->_template->$method = $this->$method();
			}
		}

		foreach($keys as $key => $value) {
			if (substr($key, 0, 1) != '_') {
				$this->_template->$key = $value;
			}
		}

	}

}
