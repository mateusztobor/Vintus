<?php
	class tenant{
		private $vars;
		function __construct($user_id) {
			$this->load($user_id);
		}
		public function view() {
			Flight::render('main', $this->vars);
		}
		private function load($user_id) {
			$app_path = 'najemca/'.$user_id;
			Flight::requireFunction('formatPhoneNumber');
			Flight::requireFunction('month');
			$user = Flight::db()->get('users', ['phone_number', 'email', 'first_name', 'second_name'], ['user_id'=>$user_id, 'manager'=>0]);
			if($user) {
				$this->vars = array(
					'need_datables'=>true,
					'user_id'=>$user_id,
					'user'=>$user,
					'app_path'=>$app_path,
					'tpl' => 'tenant'
				);
			}
			else
				$this->vars = ['tpl' => "tenant_404"];
		}
	}