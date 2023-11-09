<?php
	class users_add{
		private $vars, $view=true;
		function __construct($manager) {
			$this->load($manager);
		}
		public function view() {
			if($this->view)
				Flight::render('main', $this->vars);
		}
		private function load($manager) {
			if(isset(Flight::request()->data->save_post)) {
				if(
					isset(Flight::request()->data->first_name) && isset(Flight::request()->data->second_name) &&
					isset(Flight::request()->data->phone_number) && isset(Flight::request()->data->email)
				) {
					if(!empty(Flight::request()->data->first_name) && !empty(Flight::request()->data->second_name) && !empty(Flight::request()->data->email)) {
						if((int)Flight::request()->data->phone_number == Flight::request()->data->phone_number && mb_strlen(Flight::request()->data->phone_number) >= 11 && mb_strlen(Flight::request()->data->phone_number) <= 15) {
							if(filter_var(Flight::request()->data->email, FILTER_VALIDATE_EMAIL)) {
								Flight::request()->data->phone_number = htmlspecialchars(Flight::request()->data->phone_number);
								if(!Flight::db()->has('users', ['phone_number'=>Flight::request()->data->phone_number])) {
									Flight::request()->data->email = htmlspecialchars(Flight::request()->data->email);
									if(!Flight::db()->has('users', ['email'=>Flight::request()->data->email])) {
										$pass = $this->generatePassword();
										$pass2 = password_hash($pass.Flight::getConfig('password_hash'), PASSWORD_DEFAULT);
										$data = [
											'first_name'=>htmlspecialchars(Flight::request()->data->first_name),
											'second_name'=>htmlspecialchars(Flight::request()->data->second_name),
											'phone_number'=>Flight::request()->data->phone_number,
											'email'=>Flight::request()->data->email,
											'password'=>$pass2,
											'manager'=>$manager
										];
										$insert = Flight::db()->insert('users', $data);
										if($insert) {
											$getId = Flight::db()->get('users', ['user_id'], $data);
											unset($pass2);
											if($getId) {
												Flight::requireFunction('smsplanet_sendSMS');
												Flight::requireFunction('sendSMS');
												Flight::requireFunction('sendSMS_newAccount');
												if(Flight::sendSMS_newAccount($getId['user_id'], Flight::request()->data->phone_number, $pass)) {
													Flight::msg_add('success', 'Konto zostało utworzone.');
													$this->view = false;
													Flight::redirect('/'.($manager ? 'zarzadcy' : 'najemcy'));
												} else {
													Flight::msg_add('danger', 'Wystąpił błąd podczas dodawania konta. Wiadomość SMS z hasłem nie mogła zostać wysłana. Sprawdź API SMS.');
													Flight::db()->delete('users', ['user_id'=>$getId['user_id']]);
												}
												unset($pass);
											}
										} else
											Flight::msg_add('danger', 'Wystąpił błąd podczas dodawania konta.');
									} else
										Flight::msg_add('warning', 'Podany adres email jest już przypisany do istniejacego konta.');
								} else {
									Flight::msg_add('warning', 'Podany numer telefonu jest już przypisany do istniejacego konta.');
								}
							}
						}
					}
				}
			}
			$this->vars = array(
				'manager' => $manager,
				'tpl' => 'users_edit',
			);
		}
		private function generatePassword() {
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$specialChars = '!@#$%&*?';
			$specialChar = $specialChars[rand(0, strlen($specialChars) - 1)];
			$password = '';
			for($i = 0; $i < 7; $i++) {
				$password .= $chars[rand(0, strlen($chars) - 1)];
			}
			$randomPosition = rand(0, 7);
			$password = substr_replace($password, $specialChar, $randomPosition, 0);
			return $password;
		}
	}