<?php
	Flight::map('getLand', function($currencyCode) {
		switch ($currencyCode) {
			case 'USD':
				return 'Stany Zjednoczone';
			case 'EUR':
				return 'Unia Europejska';
			case 'JPY':
				return 'Japonia';
			case 'GBP':
				return 'Wielka Brytania';
			case 'AUD':
				return 'Australia';
			case 'CAD':
				return 'Kanada';
			case 'CHF':
				return 'Szwajcaria';
			case 'CNY':
				return 'Chiny';
			case 'SEK':
				return 'Szwecja';
			case 'NZD':
				return 'Nowa Zelandia';
			case 'MXN':
				return 'Meksyk';
			case 'SGD':
				return 'Singapur';
			case 'HKD':
				return 'Hongkong';
			case 'NOK':
				return 'Norwegia';
			case 'KRW':
				return 'Korea Południowa';
			case 'TRY':
				return 'Turcja';
			case 'INR':
				return 'Indie';
			case 'RUB':
				return 'Rosja';
			case 'BRL':
				return 'Brazylia';
			case 'ZAR':
				return 'Republika Południowej Afryki';
			case 'DKK':
				return 'Dania';
			case 'PLN':
				return 'Polska';
			case 'THB':
				return 'Tajlandia';
			case 'IDR':
				return 'Indonezja';
			case 'HUF':
				return 'Węgry';
			default:
				return 'B/D'; // Domyślna wartość, gdy nie ma dopasowania
		}
	});