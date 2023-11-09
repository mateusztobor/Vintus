<?php
	if(Flight::isAuthorized('logged') && Flight::isAuthorized('manager')) {
		Flight::route('/zarzadcy', function(){
			require  __DIR__.'/class/users.class.php';
			$controller = new users(1);
			$controller->view();
		});
		Flight::route('/najemcy', function(){
			require  __DIR__.'/class/users.class.php';
			$controller = new users(0);
			$controller->view();
		});
		Flight::route('/najemcy/edytuj/@id:[0-9]+', function($id){
			require __DIR__.'/class/users_edit.class.php';
			$controller = new users_edit(0,$id);
			$controller->view();
		});
		Flight::route('/zarzadcy/edytuj/@id:[0-9]+', function($id){
			require __DIR__.'/class/users_edit.class.php';
			$controller = new users_edit(1,$id);
			$controller->view();
		});
		Flight::route('/najemcy/dodaj', function(){
			require __DIR__.'/class/users_add.class.php';
			$controller = new users_add(0);
			$controller->view();
		});
		Flight::route('/zarzadcy/dodaj', function(){
			require __DIR__.'/class/users_add.class.php';
			$controller = new users_add(1);
			$controller->view();
		});
		Flight::route('/najemcy/usun/@user_id:[0-9]+', function($user_id){
			$has = Flight::db()->has('users', ['user_id'=>$user_id, 'manager'=>0]);
			if($has) {
				Flight::db()->delete('users', ['user_id'=>$user_id, 'manager'=>0]);
				Flight::msg_add('success', 'Konto najemcy zostało usuniete.');
				Flight::redirect('/najemcy');
			} else {
				Flight::msg_add('danger', 'Wystąpił błąd systemu. Konto najemcy nie zostało usuniete.');
				Flight::redirect('/najemcy/edytuj/'.$user_id);
			}
		});
		Flight::route('/zarzadcy/usun/@user_id:[0-9]+', function($user_id){
			$has = Flight::db()->has('users', ['user_id'=>$user_id, 'manager'=>1]);
			if($has) {
				Flight::db()->delete('users', ['user_id'=>$user_id, 'manager'=>1]);
				Flight::msg_add('success', 'Konto zarządcy zostało usuniete.');
				Flight::redirect('/zarzadcy');
			} else {
				Flight::msg_add('danger', 'Wystąpił błąd systemu. Konto zarządcy nie zostało usuniete.');
				Flight::redirect('/najemcy/edytuj/'.$user_id);
			}
		});
		Flight::route('/najemcy/@id:[0-9]+', function($id){
			require __DIR__.'/class/tenant.class.php';
			$controller = new tenant($id);
			$controller->view();
		});
		Flight::route('/ajax/getTenantPayments/@user_id:[0-9]+/deferred=@deferred/accounted=@accounted', function($user_id,$deferred,$accounted){
			Flight::requireFunction('formatDate');
			Flight::requireFunction('formatBankAccount');
			Flight::requireFunction('formatPhoneNumber');
			Flight::requireFunction('formatCurrency2');
			Flight::requireFunction('formatCurrency3');
			Flight::requireFunction('month');
			Flight::requireFunction('checkPaymentPDF');
			$data = [];
			$query_table = 'payments';
			$query_fields = [
				$query_table.'.payment_id',
				$query_table.'.type',
				$query_table.'.name',
				$query_table.'.description',
				$query_table.'.date',
				$query_table.'.price',
				$query_table.'.payment',
				$query_table.'.payment_date',
				$query_table.'.result',
				$query_table.'.status1',
				$query_table.'.status2',
				$query_table.'.manager_commission',
				$query_table.'.bank_commission',
				$query_table.'.deferred',
				'flats.flat_id',
				'flats.address',
				'cities.city_name'
			];
			$query_options['user_id'] = $user_id;
			if($deferred == 2)
				$query_options['deferred'] = 0;
			elseif($deferred == 3)
				$query_options['deferred'] = 1;
			if($accounted == 2)
				$query_options['result[!]'] = '0.00';
			elseif($accounted == 3)
				$query_options['result'] = '0.00';
			$payments = Flight::db()->select($query_table, ['[>]flats' => ['payments.flat_id'=>'flat_id'], '[>]cities'=>['flats.city_id'=>'city_id']], $query_fields, $query_options);
			$key=0;
			foreach($payments as $payment) {
				$data[$key]['data'] = Flight::formatDate($payment['date']).'<br>('.Flight::month(date('n', strtotime($payment['date']))).' '.date('Y', strtotime($payment['date'])).')';
				$data[$key]['typ'] = match($payment['type']) {
					0 => 'Pozostałe',
					1 => 'Czynsz',
					2 => 'Odstępne',
					3 => 'Prąd',
					4 => 'Gaz',
					5 => 'Woda',
					default => "Pozostałe"
				};
				$data[$key]['platnosc'] = '
					<div class="h6 fw-bold">'.$payment['name'].'</div>
					
					<div class="text-secondary">'.$payment['description'].'</div>
					<div>';
				if(!empty($payment['address']))
					$data[$key]['platnosc'] .= '
						<a href="'.Flight::getConfig('url').'/nieruchomosci/'.$payment['flat_id'].'/rozliczenia" class="text-body-secondary"><i class="fa-solid fa-building"></i> '.$payment['city_name'].', ul. '.$payment['address'].'</a>';
				else
					$data[$key]['platnosc'] .= '
						<span class="text-danger"><i class="fa-solid fa-building"></i> Brak przypisania</span>';
				$data[$key]['platnosc'] .= '
					</div>
					<div class="d-grid mt-3">
						<div class="btn-group btn-group-sm" role="group">
							<button type="button" class="btn btn-sm btn-'.($payment['deferred'] ? 'secondary' : 'info').'" id="payment_deferred_'.$payment['payment_id'].'" onclick="deferPayment('.$payment['payment_id'].');"><i class="fa-solid fa-eye-slash"></i> '.($payment['deferred'] ? 'Cofnij odroczenie płatności' : 'Odrocz płatność').'</button>
							<button type="button" class="btn btn-sm btn-danger" id="payment_remove_'.$payment['payment_id'].'" onclick="deletePayment('.$payment['payment_id'].');"><i class="fa-solid fa-trash"></i> Usuń płatność z systemu</button>
						</div>
					</div>';
					if(Flight::checkPaymentPDF($payment['payment_id'])) {
						$data[$key]['platnosc'] .= '<div class="d-grid mt-3">
							<div class="btn-group btn-group-sm">
								<a href="'.Flight::getConfig('url').'/faktury/platnosc-'.$payment['payment_id'].'" class="btn btn-light">
									<i class="fa-solid fa-download"></i> Pobierz fakturę
								</a>
								<button type="button" class="btn btn-light" onclick="deletePDF('.$payment['payment_id'].');">
									<i class="fa-solid fa-trash"></i> Usuń fakturę
								</button
							</div>
						</div>';
					} else {
						$data[$key]['platnosc'] .= '<div class="d-grid mt-3">
							<div class="input-group input-group-sm">
								<input type="file" class="form-control" accept="application/pdf" id="payment_pdf_'.$payment['payment_id'].'">
								<button type="button" class="btn btn-light" onclick="uploadPDF('.$payment['payment_id'].');">
									<i class="fa-solid fa-upload"></i> Prześlij fakturę
								</button>
							</div>
						</div>';
					}
					$data[$key]['platnosc'] .= '<hr>';
					
				$data[$key]['platnosc'] .= '
						<div class="input-group mb-2">
							<span class="input-group-text">Opłata (zł)</span>
							<span class="input-group-text text-'.($payment['price'] < 0 ? 'danger' : 'success').' fw-bold">'.($payment['price'] < 0 ? 'obciążenie' : 'uznanie').'</span>
							<input type="number" class="form-control" value="'.($payment['price'] < 0 ? $payment['price']*(-1) : $payment['price']).'" disabled>
						</div>

						<div class="input-group mb-2">
							<span class="input-group-text">Wpłata najemcy (zł)</span>
							<span class="input-group-text py-0 px-1"><button type="button" class="btn btn-sm btn-light text-success" onclick="tagPayment('.$payment['payment_id'].')"><i class="fa-solid fa-circle-check"></i></button></span>
							
							<input type="number" class="form-control" id="payment_value_'.$payment['payment_id'].'" value="'.$payment['payment'].'" step="0.01" min="-99999.99" max="99999.99">
							<button type="button" class="btn btn-success" onclick="updatePayment('.$payment['payment_id'].')"><i class="fa-solid fa-check-double"></i></button>
						</div>
						
						<div class="input-group mb-2">
							<span class="input-group-text">Data wpłaty</span>
							<span class="input-group-text py-0 px-1"><button type="button" class="btn btn-sm btn-light text-success" onclick="nowPaymentDate('.$payment['payment_id'].')"><i class="fa-solid fa-calendar-day"></i></button></span>
							<span class="input-group-text py-0 px-1"><button type="button" class="btn btn-sm btn-light text-danger" onclick="resetPaymentDate('.$payment['payment_id'].')"'. (empty($payment['payment_date']) ? ' disabled' : '').'><i class="fa-solid fa-xmark"></i></button></span>
							
							<input type="date" class="form-control'. (empty($payment['payment_date']) ? ' border-1 border-danger' : '').'" id="payment_date_'.$payment['payment_id'].'" value="'.$payment['payment_date'].'">
							<button type="button" class="btn btn-success" onclick="updatePaymentDate('.$payment['payment_id'].')"><i class="fa-solid fa-check-double"></i></button>
						</div>
					
					<hr>';
				
				if($payment['type'] == 2) {
					$data[$key]['platnosc'] .= '
						<div class="input-group mb-2">
							<span class="input-group-text">Potrącenie banku (zł)</span>
							<input type="number" class="form-control" value="'.$payment['bank_commission'].'" id="payment_bank_commission_'.$payment['payment_id'].'" step="0.01" min="-99999.99" max="99999.99">
							<button type="button" class="btn btn-success" onclick="updateBankCommission('.$payment['payment_id'].');"><i class="fa-solid fa-check-double"></i></button>
						</div>
						<div class="input-group mb-2">
							<input type="text" class="form-control" value="" placeholder="Nazwa potrącenia" id="payment_deduction_name_'.$payment['payment_id'].'">
							<input type="number" class="form-control" value="" placeholder="Wartość potrącenia" id="payment_deduction_value_'.$payment['payment_id'].'" step="0.01" min="-99999.99" max="99999.99">
							<button type="button" class="btn btn-success" onclick="addDeduction('.$payment['payment_id'].');"><i class="fa-solid fa-plus"></i></button>
						</div>';
					$deductions = Flight::db()->select('payments_deductions', ['deduction_id', 'name', 'price'], ['payment_id'=>$payment['payment_id']]);
					foreach($deductions as $deduction) {
						//addNewDeduction
						$data[$key]['platnosc'] .= '<div class="input-group mb-2">
							<span class="input-group-text">'.$deduction['name'].'</span>
							<input type="number" class="form-control" value="-'.$deduction['price'].'" disabled>
							<button type="button" class="btn btn-danger" onclick="deleteDeduction('.$deduction['deduction_id'].');"><i class="fa-solid fa-minus"></i></button>
						</div>';
					}	
					$data[$key]['platnosc'] .= '<hr>';
					$sumOfDeductions = (float)Flight::db()->sum('payments_deductions', 'price', ['payment_id'=>$payment['payment_id']]);
					if(!$payment['status1'])
						$data[$key]['platnosc'] .= '
							<div class="input-group mb-2">
								<span class="input-group-text">Przelew właściciel</span>
								<input type="number" class="form-control" value="'.abs($payment['price'])-$payment['manager_commission']-$sumOfDeductions.'" disabled>
							</div>';
					
					if(!$payment['status2'])
						$data[$key]['platnosc'] .= '
							<div class="input-group mb-2">
								<span class="input-group-text">Przelew LKM</span>
								<input type="number" class="form-control" value="'.number_format((abs($payment['manager_commission'])-$payment['bank_commission']),2).'" disabled>
								
							</div>';
					if(!$payment['status1'] || !$payment['status2'])
						$data[$key]['platnosc'] .= '<hr>';
				}
				switch ($payment['type']) {
					case 1:
						$data[$key]['platnosc'] .= '
							<div class="d-grid">
								<button type="button" class="btn btn-light text-center mb-2" onclick="updateStatus(1,'.$payment['payment_id'].');">Administracja: <i class="fa-solid fa-square-'.($payment['status1'] ? 'check' : 'xmark').' text-'.($payment['status1'] ? 'success' : 'danger').'" id="payment_status1_'.$payment['payment_id'].'"></i></button>
							</div>';
						break;
					case 2:
						$data[$key]['platnosc'] .= '
							<div class="d-grid">
								<button type="button" class="btn btn-light text-center mb-2" onclick="updateStatus(1,'.$payment['payment_id'].');">Właściciel: <i class="fa-solid fa-square-'.($payment['status1'] ? 'check' : 'xmark').' text-'.($payment['status1'] ? 'success' : 'danger').'" id="payment_status1_'.$payment['payment_id'].'"></i></button>
							</div>';
						$data[$key]['platnosc'] .= '
							<div class="d-grid">
								<button type="button" class="btn btn-light text-center mb-2" onclick="updateStatus(2,'.$payment['payment_id'].');">LKM: <i class="fa-solid fa-square-'.($payment['status2'] ? 'check' : 'xmark').' text-'.($payment['status2'] ? 'success' : 'danger').'" id="payment_status2_'.$payment['payment_id'].'"></i></button>
							</div>';
						break;
					case 5:
						$data[$key]['platnosc'] .= '
							<div class="d-grid">
								<button type="button" class="btn btn-light text-center mb-2" onclick="updateStatus(1,'.$payment['payment_id'].');">Administracja: <i class="fa-solid fa-square-'.($payment['status1'] ? 'check' : 'xmark').' text-'.($payment['status1'] ? 'success' : 'danger').'" id="payment_status1_'.$payment['payment_id'].'"></i></button>
							</div>';
						break;
					default:
						$data[$key]['platnosc'] .= '
							<div class="d-grid">
								<button type="button" class="btn btn-light text-center mb-2" onclick="updateStatus(1,'.$payment['payment_id'].');">Usługodawca: <i class="fa-solid fa-square-'.($payment['status1'] ? 'check' : 'xmark').' text-'.($payment['status1'] ? 'success' : 'danger').'" id="payment_status1_'.$payment['payment_id'].'"></i></button>
							</div>';
						break;
				}
				$data[$key]['saldo'] = ($payment['result']>0 ? '+' : '').$payment['result'].' zł<script>initTooltips();</script>';
				$key++;
			}

			echo json_encode($data);
		});
		Flight::route('/ajax/getTenantResults/@flat_id', function($user_id){
			Flight::requireFunction('formatCurrency');
			$sumCzynsz = Flight::db()->sum('payments', 'result', ['user_id'=>$user_id, 'type'=>1, 'deferred'=>0]);
			if(!$sumCzynsz) $sumCzynsz=0.00;
			$sumOdstepne = Flight::db()->sum('payments', 'result', ['user_id'=>$user_id, 'type'=>2, 'deferred'=>0]);
			if(!$sumOdstepne) $sumOdstepne=0.00;
			$sumPrad = Flight::db()->sum('payments', 'result', ['user_id'=>$user_id, 'type'=>3, 'deferred'=>0]);
			if(!$sumPrad) $sumPrad=0.00;
			$sumWoda = Flight::db()->sum('payments', 'result', ['user_id'=>$user_id, 'type'=>4, 'deferred'=>0]);
			if(!$sumWoda) $sumWoda=0.00;
			$sumGaz = Flight::db()->sum('payments', 'result', ['user_id'=>$user_id, 'type'=>5, 'deferred'=>0]);
			if(!$sumGaz) $sumGaz=0.00;
			$sumPoz = Flight::db()->sum('payments', 'result', ['user_id'=>$user_id, 'type'=>0, 'deferred'=>0]);
			if(!$sumPoz) $sumPoz=0.00;
			$sum = (float)$sumCzynsz + (float)$sumOdstepne + (float)$sumPrad + (float)$sumWoda + (float)$sumGaz + (float)$sumPoz;
			Flight::render('flat_payments_result', ['name'=>'Czynsz', 'price'=>($sumCzynsz>0 ? '+' : '').$sumCzynsz]);
			Flight::render('flat_payments_result', ['name'=>'Odstępne', 'price'=>($sumOdstepne>0 ? '+' : '').$sumOdstepne]);
			Flight::render('flat_payments_result', ['name'=>'Prąd', 'price'=>($sumPrad>0 ? '+' : '').$sumPrad]);
			Flight::render('flat_payments_result', ['name'=>'Woda', 'price'=>($sumWoda>0 ? '+' : '').$sumWoda]);
			Flight::render('flat_payments_result', ['name'=>'Gaz', 'price'=>($sumGaz>0 ? '+' : '').$sumGaz]);
			Flight::render('flat_payments_result', ['name'=>'Pozostałe', 'price'=>($sumPoz>0 ? '+' : '').$sumPoz]);
			Flight::render('flat_payments_result', ['name'=>'<strong>SUMA</strong>', 'price'=>($sum>0 ? '+' : '').$sum]);
		});
	}