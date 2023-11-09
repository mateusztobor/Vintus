var search_page = 1;
var search_end = false;
var search_loadingPosts = false;  // Dodaj zmienną do śledzenia, czy już trwa ładowanie
search(search_page);
function search(postId) {
    if(search_loadingPosts)
        return;  // Jeśli już trwa ładowanie, nie rób nic
    search_loadingPosts = true;  // Ustaw, że teraz zaczyna się ładowanie
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200) {
            if(xhr.responseText.length > 0) {
				document.getElementById("search").insertAdjacentHTML('beforeend', xhr.responseText);
				initTooltips();
				search_page += 1;
            } else {
                search_end = true;
                document.getElementById("search_loading").innerHTML = 'Brak dalszych wpisów 😞';
            }
            search_loadingPosts = false;  // Ładowanie się zakończyło
        }
    };
    xhr.open("GET", search_url + search_page, true);
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
