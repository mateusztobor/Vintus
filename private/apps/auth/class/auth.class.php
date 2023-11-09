<?php
	class auth{
		private $view=true;
		public function view() {
			$this->form();
			if($this->view)
				Flight::render('main', ['tpl'=>'login']);
		}
		private function form() {
			//$c='tester';
			//$c= password_hash($c.Flight::getConfig('password_hash'), PASSWORD_DEFAULT);
			//exit($c);
			$warning=false;
			if(Flight::request()->data->login_password) {
				if(Flight::request()->data->login_phone) {
					if(Flight::request()->data->login_code) {
						$key = 'phone_number';
						$value = htmlspecialchars(Flight::request()->data->login_code.Flight::request()->data->login_phone);
					}
				}
				elseif(Flight::request()->data->login_email) {
					$key = 'email';
					$value = htmlspecialchars(Flight::request()->data->login_email);
				}
				else $warning = true;
				if(!$warning) {
					$user = Flight::db()->select('users', ['user_id','password'], [$key => $value]);
					unset($key); unset($value);
					if($user) {
						$user=$user[0];
						if(password_verify((Flight::request()->data->login_password.Flight::getConfig('password_hash')),$user['password'])) {
							Flight::msg_add('success', 'Zalogowano pomyślnie.');
							Flight::session_register($user['user_id']);
							$this->view=false;
						}
						else
							$warning=true;
					} else $warning=true;
				} else $warning=true;
			}
			if($warning)
				Flight::msg_add('danger', 'Wprowadzono niepoprawne dane logowania.');
		}
	}