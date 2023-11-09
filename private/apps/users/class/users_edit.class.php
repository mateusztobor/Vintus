<?php
	class users_edit{
		private $vars, $view=true;
		function __construct($manager,$id) {
			$this->load($manager, $id);
		}
		public function view() {
			if($this->view)
				Flight::render('main', $this->vars);
		}
		private function load($manager, $id) {
			$table = 'users';
			$query_fields = [
				$table.'.first_name',
				$table.'.second_name',
				$table.'.email',
				$table.'.phone_number'
			];
			$user = Flight::db()->get($table, $query_fields, ['users.user_id'=>$id, 'manager'=>$manager, "LIMIT"=>1]);
			if($user) {
				$app_path = '/'.($manager ? 'zarzadcy' : 'najemcy');
				unset($table);
				unset($query_fields);
				if(isset(Flight::request()->data->save_post)) {
					if(
						isset(Flight::request()->data->first_name) && isset(Flight::request()->data->second_name) &&
						isset(Flight::request()->data->phone_number) && isset(Flight::request()->data->email)
					) {
						if(!empty(Flight::request()->data->first_name) && !empty(Flight::request()->data->second_name) && !empty(Flight::request()->data->email)) {
							if((int)Flight::request()->data->phone_number == Flight::request()->data->phone_number && mb_strlen(Flight::request()->data->phone_number) >= 11 && mb_strlen(Flight::request()->data->phone_number) <= 15) {
								if(filter_var(Flight::request()->data->email, FILTER_VALIDATE_EMAIL)) {
									Flight::request()->data->phone_number = htmlspecialchars(Flight::request()->data->phone_number);
									if($user['phone_number']==Flight::request()->data->phone_number || !Flight::db()->has('users', ['phone_number'=>Flight::request()->data->phone_number])) {
										Flight::request()->data->email = htmlspecialchars(Flight::request()->data->email);
										if($user['email']==Flight::request()->data->email || !Flight::db()->has('users', ['email'=>Flight::request()->data->email])) {
											$data = [
												'first_name'=>htmlspecialchars(Flight::request()->data->first_name),
												'second_name'=>htmlspecialchars(Flight::request()->data->second_name),
												'phone_number'=>Flight::request()->data->phone_number,
												'email'=>Flight::request()->data->email
											];
											$update = Flight::db()->update('users', $data, ['users.user_id'=>$id, 'manager'=>$manager, "LIMIT"=>1]);
											if($update) {
												Flight::msg_add('success', 'Dane zostały zapisane.');
												Flight::redirect('/'.($manager ? 'zarzadcy' : 'najemcy'));
												$this->view = false;
											} else
												Flight::msg_add('danger', 'Wystąpił błąd podczas edycji konta. Zmiany nie zostały zapisane.');
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
					'id'=>$id,
					'app_path'=>$app_path,
					'user'=>$user,
					'manager'=>$manager,
					'tpl' => 'users_edit',
				);
				unset($user);
			} else {
				$this->vars = array(
					'tpl' => "users_404"
				);
			}
		}
	}