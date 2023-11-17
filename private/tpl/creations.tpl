<h1 class="fw-normal mb-4">Moje kreacje</h1>
<ul class="list-group mb-4" id="baskets"></ul>
<script>
	function loadMyBaskets() {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				document.getElementById('baskets').innerHTML = xhr.responseText;
				initTooltips();
			}
		};
		xhr.open("GET", "<?php print(Flight::getConfig('url')); ?>/ajax/loadMyBaskets", true);
		xhr.send();
	}
	loadMyBaskets();
	function deleteMyBasket(id) {
		if(confirm("Czy na pewno chcesz usunąć tę kreację?")) {
		  var xhr = new XMLHttpRequest();
		  var req = "<?php print(Flight::getConfig('url')); ?>/ajax/deleteMyBasket/";
		  xhr.open("POST", req+id, true);
		  xhr.setRequestHeader("Content-Type", "application/json");
		  xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
			  var response = JSON.parse(xhr.responseText);
			  if (response.success)
				loadMyBaskets();
			  else
				alert('Wystąpił błąd. Kreacja nie została usunięta.');
			}
		  };
		  xhr.send(JSON.stringify());
		}
	}
	function createBasket() {
		var name = document.getElementById('name').value;
		if(name != '') {
			var formData = new FormData();
			formData.append('name', name);
			var xhr = new XMLHttpRequest();
			var req = "<?php print(Flight::getConfig('url')); ?>/ajax/createBasket/";
			xhr.open('POST', req, true);
			xhr.onreadystatechange = function() {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					if (xhr.status === 200) {
						try {
							var response = JSON.parse(xhr.responseText);
							if (response.success)
								loadMyBaskets();
							else
								alert('Błąd systemu.');
						} catch (error) {
							alert('Błąd systemu.');
						}
					} else
						alert('Błąd systemu.');
				}
			};
			xhr.send(formData);
		}
	}
	function createBasket3(id) {
		var deduction_name = document.getElementById('payment_deduction_name_'+id).value;
		var deduction_value = document.getElementById('payment_deduction_value_'+id).value;
		var formData = new FormData();
		formData.append('deduction_name', deduction_name);
		formData.append('deduction_value', deduction_value);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'https://lkmnieruchomosci.pl/pm/ajax/createBasket/', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					try {
						var response = JSON.parse(xhr.responseText);
						if(response.success)
							table.ajax.reload( null, false );
						else
							alert('Błąd systemu.');
					} catch (error) {
						alert('Błąd systemu.');
					}
				} else
					alert('Błąd systemu.');
			}
		};
		xhr.send(formData);
	}
</script>
