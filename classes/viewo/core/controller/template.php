<?php defined('SYSPATH') or die('No direct script access.');

class ViewO_Core_Controller_Template extends Kohana_Controller_Template {

	public $view;

	public function before() {
		parent::before();
		$defaults = $this->request->route()->defaults();
		$action   = $this->request->param('action', $defaults['action']);

		$view_class_class = str_replace('Controller', 'ViewO', get_class($this));
		$view_class_file  = 'viewo/' . strtolower(str_replace('_', '/', str_replace('ViewO_', '', $view_class_class)));
		
		$view_method_class  = $view_class_class . '_' . $action;
		$view_method_file   = $view_class_file . '/' . $action;

		if (Kohana::find_file('classes', $view_method_file)) {
			$this->view = new $view_method_class($this->template);
		} elseif (Kohana::find_file('classes', $view_class_file)) {
			$this->view = new $view_class_class($this->template, $action);
		} else {
			$this->view = new stdClass;
		}
	}

	public function after() {
		if ($this->view instanceof ViewO) $this->view->_configure();
		parent::after();
	}

}