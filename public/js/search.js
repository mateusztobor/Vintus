var search_page = 1;
var search_end = false;
var search_loadingPosts = false;  // Dodaj zmienną do śledzenia, czy już trwa ładowanie
search();
function reloadSearch() {
	document.body.scrollTop = 0; // For Safari
	document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	search_loadingPosts = false;
	search_end = false;
	search_page = 1; // Resetuj wartość search_page
	document.getElementById("search_loading").innerHTML = '<div class="spinner-border" style="width: 3rem;height: 3rem;" role="status"><span class="visually-hidden">Wczytywanie...</span></div>'; // Wyczyść wyniki wyszukiwania przed ponownym ładowaniem
	document.getElementById("search").innerHTML = ''; // Wyczyść wyniki wyszukiwania przed ponownym ładowaniem
	search();
}

function search() {
    if(search_loadingPosts)
        return;  // Jeśli już trwa ładowanie, nie rób nic
    search_loadingPosts = true;  // Ustaw, że teraz zaczyna się ładowanie
	
	// Pobierz wartości z pól formularza
	var search_text = document.getElementById("search_text").value;
	//var category = document.getElementById("inputCategory").value;
	// Pobierz inne wartości z innych pól formularza

	// Utwórz obiekt URLSearchParams
	var searchParams = new URLSearchParams();

	// Dodaj parametry do obiektu URLSearchParams
	if (search_text.trim() !== "") {
		searchParams.append("search_text", search_text);
	}
	searchParams.append("p", search_page);

/*
	if (category !== "") {
		searchParams.append("category", category);
	}*/
	
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
            }
            search_loadingPosts = false;  // Ładowanie się zakończyło
        }
    };
    xhr.open("GET", search_url + searchParams.toString() + '&p=' + search_page, true);
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
