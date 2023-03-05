// note: IE8 doesn't support DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {

  var suggestions = document.getElementById("suggestions");
  var form = document.getElementById("search-form");
  var search = document.getElementById("search");

  function showSuggestions(json) {
    html = json.map(x => `<li><a href='search.php?q=${x}'>${x}</a></li>`).join('\n');
    suggestions.innerHTML = html;
    suggestions.style.display = 'block';
  }

  function hideSuggestions() {
    suggestions.style.display = 'none';
  }

  function getSuggestions() {
    var q = search.value;

    if (q.length < 3) {
      hideSuggestions();
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'autosuggest.php?q=' + q, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
        console.log('Result: ' + result);

        var json = JSON.parse(result);
        showSuggestions(json);
      }
    };
    xhr.send();
  }

  search.addEventListener("input", getSuggestions, false);
  hideSuggestions();
});
