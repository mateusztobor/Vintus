<?php
	class register{
		private $vars, $view=true;
		function __construct() {
			$this->load();
		}
		public function view() {
			if($this->view)
				Flight::render('main', $this->vars);
		}
		private function load() {
			$app_path = '/zmien-haslo';
			
			Flight::setCurrentApp($app_path);
			if(isset(Flight::request()->data->createNewAccount)) {
				if(isset(Flight::request()->data->nick) && isset(Flight::request()->data->email) && isset(Flight::request()->data->password) && isset(Flight::request()->data->password2)) {
					if (filter_var(Flight::request()->data->email, FILTER_VALIDATE_EMAIL)) {
						if(!Flight::db()->has('users', ['email' => htmlspecialchars(Flight::request()->data->email)])) {
							if(!Flight::db()->has('users', ['nick' => htmlspecialchars(Flight::request()->data->nick)])) {
								if($this->isPasswordValid(Flight::request()->data->password)) {
									if(Flight::request()->data->password == Flight::request()->data->password2) {
										$insert = Flight::db()->insert('users', [
											'nick'=>htmlspecialchars(Flight::request()->data->nick),
											'email'=>htmlspecialchars(Flight::request()->data->email),
											'password'=>password_hash(Flight::request()->data->password.Flight::getConfig('password_hash'), PASSWORD_DEFAULT)
										]);
										if($insert) {
											$this->view=false;
											Flight::msg_add('success', 'Konto zostało utworzone.');
											Flight::msg_add('success', 'Zalogowano Cię na nowo utworzone konto.');
											Flight::requireFunction('session_register');
											Flight::session_register(Flight::db()->id());
											Flight::redirect('/');
										} else Flight::msg_add('danger', 'Błąd systemu. Spróbuj ponownie później.');
									} else Flight::msg_add('danger', 'Wprowadzone hasła różnią się.');	
								} else Flight::msg_add('danger', 'Wprowadzone hasło nie spełnia norm bezpieczeństwa.');
							} else Flight::msg_add('danger', 'Wprowadzony nick jest już zajęty.');	
						} else Flight::msg_add('danger', 'Wprowadzony adres email jest już zajęty.');	
					} else Flight::msg_add('danger', 'Wprowadzony adres email jest nieprawidłowy.');	
				} else Flight::msg_add('danger', 'Nie wszystkie wymagane pola zostały wypełnione.');
			}
			
			//--------------------------
			$this->vars = array(
				'app_path' => $app_path,
				'tpl' => 'register'
			);
			unset($app_path);
			//--------------------------
		}
		private function isPasswordValid($password) {
			$pattern = '/^(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/';
			return preg_match($pattern, $password) === 1;
		}
	}