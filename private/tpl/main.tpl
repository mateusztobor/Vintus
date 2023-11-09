<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>VintUŚ</title>
		<link href="<?php print(Flight::getConfig('url')); ?>/public/css/bootstrap.min.css?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
		<link href="<?php print(Flight::getConfig('url')); ?>/public/css/theme.css?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>" rel="stylesheet">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php print(Flight::getConfig('url')); ?>/public/img/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php print(Flight::getConfig('url')); ?>/public/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php print(Flight::getConfig('url')); ?>/public/img/favicon-16x16.png">
		<!--
			<link rel="manifest" href="<?php print(Flight::getConfig('url')); ?>/manifest.json?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>">
		-->
		<link rel="mask-icon" href="<?php print(Flight::getConfig('url')); ?>/public/img/safari-pinned-tab.svg" color="#000000">
		<link rel="shortcut icon" href="<?php print(Flight::getConfig('url')); ?>/favicon.ico">
		<meta name="apple-mobile-web-app-title" content="Portal Mieszkańca">
		<meta name="application-name" content="Portal Mieszkańca">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-config" content="<?php print(Flight::getConfig('url')); ?>/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<meta name="robots" content="none">
		<meta name="AdsBot-Google" content="none">
		<!-- preloader -->
		<link href="<?php print(Flight::getConfig('url')); ?>/public/css/preloader.min.css" rel="preload" as="style" onload="this.rel='stylesheet'">
		<noscript><link href="<?php print(Flight::getConfig('url')); ?>/public/css/preloader.min.css" rel="stylesheet"></noscript>
	</head>
	<body class="d-flex flex-column h-100">
		<div id="preloader"><div><div><img src="<?php print(Flight::getConfig('url')); ?>/public/img/logo.png" alt="LKM Nieruchomości" style="height:128px;"></div><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div></div>
		<script src="<?php print(Flight::getConfig('url')); ?>/public/js/preloader.min.js"></script>
		<header>
			<nav id="mainNav" class="navbar bg-light navbar-expand-xl fixed-top">
				<div class="container">
					<a class="navbar-brand" href="<?php print(Flight::getConfig('url')); ?>/"><img src="<?php print(Flight::getConfig('url')); ?>/public/img/logo.png" alt="LKM Nieruchomości" style="height:32px;"></a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Nawigacja">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarCollapse">
						
							<ul class="navbar-nav me-auto mb-2 mb-md-0 text-center">
								<li class="nav-item">
									<a class="nav-link<?php Flight::checkCurrentApp('/start',' active'); ?>" aria-current="page" href="<?php print(Flight::getConfig('url')); ?>/"><i class="fa-solid fa-magnifying-glass"></i> Szukaj produktów</a>
								</li>
								<li class="nav-item">
									<a class="nav-link<?php Flight::checkCurrentApp('/start2',' active'); ?>" aria-current="page" href="<?php print(Flight::getConfig('url')); ?>/"><i class="fa-solid fa-heart"></i> Moje ulubione</a>
								</li>
								<?php if(Flight::isAuthorized('logged')) { ?>
								
								<?php } ?>
							</ul>
							<div class="navbar-text d-flex justify-content-center">
								<?php if(Flight::isAuthorized('logged')) { ?>
									<div class="dropdown d-block d-lg-inline-block">
										<button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa-regular fa-circle-user"></i> <?php print(Flight::user('mail')); ?>
										</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="<?php print(Flight::getConfig('url')); ?>/zmien-haslo"><i class="fa-solid fa-key"></i> Zmień hasło</a></li>
											<li><a class="dropdown-item" href="<?php print(Flight::getConfig('url')); ?>/wyloguj"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj</a></li>
										</ul>
									</div>
								<?php } else { ?>
									<div class="btn-group">
									<a class="btn btn-outline-info" aria-current="page" href="<?php print(Flight::getConfig('url')); ?>/"><i class="fa-solid fa-right-to-bracket"></i> Logowanie</a>
									<a class="btn btn-info" aria-current="page" href="<?php print(Flight::getConfig('url')); ?>/"><i class="fa-solid fa-user-plus"></i> Stwórz konto</a>
									</div>
								<?php } ?>
							</div>
					</div>
				</div>
			</nav>
		</header>
		<main class="flex-shrink-0">
			<div class="container mt-4">
				<?php
					print(Flight::msgs());
					if(isset($content)) print($content);
					if(isset($tpl)) Flight::render($tpl);
				?>
			</div>
		</main>
		<footer class="footer mt-auto py-3 bg-body-tertiary">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 text-lg-start text-center text-body-secondary">
						© VintUŚ
					</div>
				</div>
			</div>
		</footer>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="<?php print(Flight::getConfig('url')); ?>/public/js/bootstrap.bundle.min.js?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>"></script>
		<script src="<?php print(Flight::getConfig('url')); ?>/public/js/form-validation.js?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>"></script>
		<script src="<?php print(Flight::getConfig('url')); ?>/public/js/tooltips.js?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>"></script>
		<script src="<?php print(Flight::getConfig('url')); ?>/public/js/toasts.js?v=<?php print(Flight::getEnabledApps()['core'][0]['ver']); ?>"></script>
	</body>
</html>
