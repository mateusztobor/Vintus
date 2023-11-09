<!doctype html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="robots" content="noindex">
		<meta name="AdsBot-Google" content="noindex">

		<title>Błąd 500</title>
		<style type="text/css">
			body {
				background: #eee;
				margin:0;
				padding:0;
			}
			h1,h2 {
				font-weight: normal;
				font-size: 1.7em;
				padding: 0;
				margin: 0 0 10px 0;
			}
			.d {
				margin: 10px;
				border: 1px solid rgba(0,0,0,0.2);
				padding: 10px;
				text-align: center;
			}
			
			.error-page {
				background: #f8d7da;
			}
			
			.debug {
				background: #ddd;
			}
		</style>

	</head>
	<body class="text-center">
		<main class="form-signin w-100 m-auto">
			<div class="text-align:center;">
				<img class="mb-4" src="{{url}}/public/img/logo.png" alt="LKM Nieruchomości" width="192" height="192" style="display:block;margin:0 auto;">
			</div>
			
			<div class="d error-page">
				<h1>Błąd 500</h1>
				<p style="color:brown;font-weight:bold;">Kod systemowy: {{code}}</p>
				<p>Wystąpił nieoczekiwany błąd w działaniu strony.<br>
				Administrator został poinformowany o wystąpieniu błędu.</p>
				<p style="color:brown;">Kontakt z administratorem strony: 
				<script>document.write("<a href=mailto:{{contact}}>{{contact}}</a>");</script></p>
				
				
			</div>
			{{debug}}
		</main>
	</body>
</html>
