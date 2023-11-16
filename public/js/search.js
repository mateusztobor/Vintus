var search_page = 1;
var search_end = false;
var search_loadingPosts = false;  // Dodaj zmienną do śledzenia, czy już trwa ładowanie
var searchParams2 = '';
var noE=false;
search();
function reloadSearch() {
	if(!noE) {
		document.getElementById("search_loading").classList.remove("d-none");
		document.getElementById("zac").classList.add("d-none");
		noE=true;
	}
	window.scrollTo({top: 0, behavior: 'smooth'});
	search_loadingPosts = false;
	search_end = false;
	search_page = 1; // Resetuj wartość search_page
	document.getElementById("search_loading").innerHTML = '<div class="spinner-border" style="width: 3rem;height: 3rem;" role="status"><span class="visually-hidden">Wczytywanie...</span></div>'; // Wyczyść wyniki wyszukiwania przed ponownym ładowaniem
	document.getElementById("search").innerHTML = ''; // Wyczyść wyniki wyszukiwania przed ponownym ładowaniem
	search();
}

function addParam(searchParams, fieldId, paramName) {
	if(document.getElementById(fieldId)) {
		var fieldValue = document.getElementById(fieldId).value;
		if(fieldValue.trim() !== "")
			searchParams.append(paramName, fieldValue);
	}
	return searchParams;
}

function addParam2(searchParams2, fieldId, paramName) {
	if(document.getElementById(fieldId)) {
		var field = document.getElementById(fieldId);
		if(field.checked == true) {
			searchParams2 = searchParams2 + '&' + paramName + '=' + field.value;
		}
	}
	return searchParams2;
}

function addFilterCollection(searchParams2, className, paramName) {
	const collection = document.getElementsByClassName(className);
	for (let i = 0; i < collection.length; i++) {
		if(collection[i].checked == true) {
			searchParams2 = searchParams2 + '&' + paramName + '=' + collection[i].value;
		}
	}
	return searchParams2;
}

/*
const collection = document.getElementsByClassName("example");
for (let i = 0; i < collection.length; i++) {
  collection[i].style.backgroundColor = "red";
}
*/

function search() {
    if(search_loadingPosts)
        return;  // Jeśli już trwa ładowanie, nie rób nic
    search_loadingPosts = true;  // Ustaw, że teraz zaczyna się ładowanie
	
	// Pobierz wartości z pól formularza
	//var search_text = document.getElementById("search_text").value;
	document.activeElement.blur();
	//var category = document.getElementById("inputCategory").value;
	// Pobierz inne wartości z innych pól formularza

	// Utwórz obiekt URLSearchParams
	var searchParams = new URLSearchParams();
	
	searchParams = addParam(searchParams, 'search_text', 'search_text');
	searchParams = addParam(searchParams, 'price_from', 'price_from');
	searchParams = addParam(searchParams, 'price_to', 'price_to');
	searchParams = addParam(searchParams, 'order', 'order');
	searchParams.append("p", search_page);
	searchParams2 = searchParams.toString();
	searchParams2 = addFilterCollection(searchParams2, 'filter_colors', 'color_ids[]');
	searchParams2 = addFilterCollection(searchParams2, 'filter_materials', 'material_ids[]');
	//tutaj 3ba dodać kolejne klasy fitrowania
	
	//alert(searchParams2);
	
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200) {
            if(xhr.responseText.length > 0) {
				document.getElementById("search").insertAdjacentHTML('beforeend', xhr.responseText);
				initTooltips();
				search_page += 1;
            } else {
                search_end = true;
                document.getElementById("search_loading").innerHTML = 'Wszystkie oferty zostały wyświetlone 😞';
				if(document.getElementById("search").innerHTML == '') {
					document.getElementById("zac").classList.remove("d-none");
					document.getElementById("search_loading").classList.add("d-none");
					noE=false;
				}
            }
            search_loadingPosts = false;  // Ładowanie się zakończyło
        }
    };
    xhr.open("GET", search_url + searchParams2, true);
    xhr.send();
}

window.onscroll = function(ev) {
    if(!search_end) {
        if(window.innerHeight + window.scrollY + 1 >= document.documentElement.scrollHeight) {
            setTimeout(function() {
                search();
            }, 500);
        }
    }
};
