<?php
	Flight::map('renderRaport', function($month,$year,$flats = []) {
		if($month > 0 && $month <= 12) {
			if(checkdate($month,1,$year)) {
				if(is_array($flats)) {
					//load functions
					Flight::requireFunction('getRaportTpl');
					Flight::requireFunction('month');
					Flight::requireFunction('getLastDayOfMonth');
					Flight::requireFunction('formatDate');
					Flight::requireFunction('formatCurrency');
					
					
					//init template
					$tpl['raport'] = Flight::getRaportTpl('raport');
					if($tpl['raport'] === false)
						return false;
					
					$tpl['nieruchomosc'] = Flight::getRaportTpl('raport.Nieruchomosc');
					if($tpl['nieruchomosc'] === false)
						return false;
					
					$tpl['tabela_nieruchomosc'] = Flight::getRaportTpl('raport.Tabela.Nieruchomosc');
					if($tpl['tabela_nieruchomosc'] === false)
						return false;
					
					$tpl['tabela_platnosc'] = Flight::getRaportTpl('raport.Tabela.Platnosc');
					if($tpl['tabela_platnosc'] === false)
						return false;

					$tpl['tabela_platnosc2'] = Flight::getRaportTpl('raport.Tabela.Platnosc2');
					if($tpl['tabela_platnosc2'] === false)
						return false;
					
					$tpl['tabela_podsumowanie'] = Flight::getRaportTpl('raport.Tabela.Podsumowanie');
					if($tpl['tabela_podsumowanie'] === false)
						return false;
					
					
					//prepare data
					$Miesiac = Flight::month($month).' '.$year;
					$dataUtworzenia = date('d.m.Y');
					$ListaNieruchomosci='';
					$dataSumaPrzychodow = 0.00;
					$dataKosztyOplat = 0.00;
					$dataZysk = 0.00;
					$Tabela='';
					
					if($month < 10)
						$month = '0'.$month;
					$date_start = '01.'.$month.'.'.$year;
					$date_end = Flight::getLastDayOfMonth($date_start);
					
					
					//rendering
					foreach($flats as $flat) {
						$flatData = Flight::db()->get('flats', ['[>]cities'=>['city_id','city_id']], ['flat_id', 'city_name', 'address'], ['flat_id'=>$flat]);
						if($flatData) {
							$dataSumaPrzychodowN = 0.00;
							$dataKosztyOplatN = 0.00;
							$dataZyskN = 0.00;
							
							$ListaNieruchomosci .= str_replace('{raport.Tabela.AdresNieruchomosci}', $flatData['city_name'].', ul. '.$flatData['address'], $tpl['nieruchomosc']);
							$Tabela .= str_replace('{raport.Tabela.AdresNieruchomosci}', $flatData['city_name'].', ul. '.$flatData['address'], $tpl['tabela_nieruchomosc']);
							
							$payments = Flight::db()->select('payments', ['payment_id', 'name','price','payment_date','manager_commission'], ['date[>=]' => $date_start,'date[<=]' => $date_end, 'type'=>2, 'flat_id'=>$flatData['flat_id']]);
							if($payments) {
								foreach($payments as $payment) {
									$tpl_tabela_platnosc = 'tabela_platnosc';
									if(!empty($payment['payment_date'])) {
										$tpl_tabela_platnosc .= 2;
										$payment['payment_date'] = Flight::formatDate($payment['payment_date']);
									}
									
									$payment['price'] *= -1;
									$Tabela .= str_replace(
										[
											'{raport.Tabela.Platnosc.NazwaPlatnosci}',
											'{raport.Tabela.Platnosc.Kwota}',
											'{raport.Tabela.Platnosc.DataPlatnosci}'
											
										], [
											$payment['name'],
											($payment['price']>0 ? '+' : '').Flight::formatCurrency($payment['price']),
											$payment['payment_date'],
										], $tpl[$tpl_tabela_platnosc]);
									if($payment['price'] >= 0)
										$dataSumaPrzychodowN += abs($payment['price']);
									else
										$dataKosztyOplatN += abs($payment['price']);
									
									$payment['manager_commission'] *= -1;
									$Tabela .= str_replace(
										[
											'{raport.Tabela.Platnosc.NazwaPlatnosci}',
											'{raport.Tabela.Platnosc.Kwota}',
										], [
											'Obsługa nieruchomości',
											($payment['manager_commission']>0 ? '+' : '').Flight::formatCurrency($payment['manager_commission']),
										], $tpl['tabela_platnosc']);
									
									if($payment['manager_commission'] >= 0)
										$dataSumaPrzychodowN += $payment['manager_commission'];
									else
										$dataKosztyOplatN += abs($payment['manager_commission']);
									
									$payment_deductions = Flight::db()->select('payments_deductions', ['name', 'price'], ['payment_id'=>$payment['payment_id']]);
									if($payment_deductions) {
										foreach($payment_deductions as $payment_deduction) {
											$payment_deduction['price'] *= -1;
											$Tabela .= str_replace(
												[
													'{raport.Tabela.Platnosc.NazwaPlatnosci}',
													'{raport.Tabela.Platnosc.Kwota}',
												], [
													$payment_deduction['name'],
													($payment_deduction['price']>0 ? '+' : '').Flight::formatCurrency($payment_deduction['price']),
												], $tpl['tabela_platnosc']);
											if($payment_deduction['price'] >= 0)
												$dataSumaPrzychodowN += $payment_deduction['price'];
											else
												$dataKosztyOplatN += abs($payment_deduction['price']);
										}
									}
								}
							}
							$dataZyskN = $dataSumaPrzychodowN - $dataKosztyOplatN;
							$Tabela .= str_replace(
								[
									'{raport.Tabela.Podsumowanie.SumaPrzychodow}',
									'{raport.Tabela.Podsumowanie.KosztyOplat}',
									'{raport.Tabela.Podsumowanie.Zysk}',
								], [
									Flight::formatCurrency($dataSumaPrzychodowN),
									Flight::formatCurrency(-$dataKosztyOplatN),
									Flight::formatCurrency($dataZyskN)
								], $tpl['tabela_podsumowanie']);
							
							$dataZysk += $dataZyskN;
							$dataSumaPrzychodow += $dataSumaPrzychodowN;
							$dataKosztyOplat += $dataKosztyOplatN;
						}
						
					}
					
					
					//final render
					return str_replace(
						[
							'{raport.Miesiac}',
							'{raport.DataUtworzenia}',
							'{raport.ListaNieruchomosci}',
							'{raport.SumaPrzychodow}',
							'{raport.KosztyOplat}',
							'{raport.Zysk}',
							'{raport.Tabela}'
						], [
							$Miesiac,
							$dataUtworzenia,
							$ListaNieruchomosci,
							Flight::formatCurrency($dataSumaPrzychodow),
							Flight::formatCurrency(-$dataKosztyOplat),
							Flight::formatCurrency($dataZysk),
							$Tabela
						], $tpl['raport']);
				}
			}
		}
		return false;
	});