<?php
	class users{
		private $vars;
		function __construct($manager) {
			$this->load($manager);
		}
		public function view() {
			Flight::render('main', $this->vars);
		}
		private function load($manager) {
			$app_path = '/'.($manager ? 'zarzadcy' : 'najemcy');
			Flight::setCurrentApp($app_path);
			Flight::requireFunction('formatPhoneNumber');
			$table = 'users';
			$query_options['manager']=$manager;
			$query_options['ORDER'] = ['user_id'=>'DESC'];
			
			//load results
			$query_fields = [
				$table.'.user_id',
				$table.'.first_name',
				$table.'.second_name',
				$table.'.email',
				$table.'.phone_number'
			];
			$users = Flight::db()->select($table, $query_fields, $query_options);
			if($users) {
				if(!$manager) {
					Flight::requireFunction('formatCurrency');
					Flight::requireFunction('formatDate');
					for($i=0; $i<count($users); $i++) {
						$users[$i]['results'] = Flight::db()->sum('payments', 'result', ['user_id'=>$users[$i]['user_id'], 'deferred'=>0]);
						if(!$users[$i]['results'])
							$users[$i]['results']=0.00;
						$users[$i]['results'] = Flight::formatCurrency($users[$i]['results']);
						$users[$i]['agreement'] = Flight::db()->get('agreements', ['date_end', 'indefinite'], ['user_id'=>$users[$i]['user_id'], 'inactive'=>0]);
						if($users[$i]['agreement']) {
							if($users[$i]['agreement']['indefinite'])
								$users[$i]['agreement'] = '<span class="text-success">Umowa na czas nieokreślony</span>';
							else 
								$users[$i]['agreement'] = Flight::formatDate($users[$i]['agreement']['date_end']);
						} else
							$users[$i]['agreement']='<span class="text-danger">Brak umowy</span>';
						
						$users[$i]['compensation'] = false;
						if(Flight::db()->has('payments', ['result[<]' => 0, 'user_id'=>$users[$i]['user_id']]) && Flight::db()->has('payments', ['result[>]' => 0, 'user_id'=>$users[$i]['user_id'], 'deferred'=>0]))
							$users[$i]['compensation'] = true;
					}
				}
			} else $posts=[];
				
			
			unset($query_fields);
			unset($query_options);
			//--------------------------
			
			$this->vars = array(
				'app_path' => $app_path,
				'manager' => $manager,
				'need_datables' => true,
				'users' => $users,
				'tpl' => 'users'
			);
			unset($table);
			unset($app_path);
			unset($users);
			//--------------------------
		}
	}