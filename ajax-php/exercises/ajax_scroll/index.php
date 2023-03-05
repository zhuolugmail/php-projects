<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Infinite Scroll</title>
  <style>
    #blog-posts {
      width: 700px;
    }

    .blog-post {
      border: 1px solid black;
      margin: 10px 10px 20px 10px;
      padding: 6px 10px;
    }

    #spinner {
      display: none;
    }
  </style>
</head>

<body>
  <div id="blog-posts" data-page="0">
  </div>

  <div id="spinner">
    <img src="spinner.gif" width="50" height="50" />
  </div>

  <div id="load-more-container">
    <button id="load-more">Load more</button>
  </div>

  <script>

    var container = document.getElementById('blog-posts');
    var load_more = document.getElementById('load-more');
    var currentPage = 1;
    var loading = false;

    function appendToDiv(div, new_html) {
      var tmp = document.createElement('div');

      tmp.innerHTML = new_html;

      className = tmp.firstElementChild.className;
      elements = tmp.getElementsByClassName(className);

      div.append(...elements);
    }

    function showSpinner() {
      var spinner = document.getElementById("spinner");
      spinner.style.display = 'block';
    }

    function hideSpinner() {
      var spinner = document.getElementById("spinner");
      spinner.style.display = 'none';
    }

    function scrollAction() {
      var containerHeight = container.offsetHeight;
      var currentY = window.innerHeight + window.pageYOffset;
      if (currentY >= containerHeight) loadMore();
    }

    function showLoadMore() {
      load_more.style.display = 'inline';
    }

    function hideLoadMore() {
      load_more.style.display = 'none';
    }

    function loadMore() {

      if (loading) return;
      loading = true;

      showSpinner();
      hideLoadMore();

      var xhr = new XMLHttpRequest();
      var currentPage = container.getAttribute('data-page');

      if (!currentPage) return;
      currentPage = parseInt(currentPage);

      currentPage = currentPage + 1;

      xhr.open('GET', `blog_posts.php?page=${currentPage}`, true);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var result = xhr.responseText;
          console.log('Result: ' + result);

          hideSpinner();

          // append results to end of blog posts
          appendToDiv(container, result);

          container.setAttribute('data-page', currentPage);
          loading = false;

          if ((window.innerHeight + window.pageYOffset) >= container.offsetHeight)
            loadMore();

          showLoadMore();

        }
      };
      xhr.send();
    }

    load_more.addEventListener("click", loadMore);
    window.onscroll = scrollAction;

    // Load even the first page with Ajax
    loadMore();
  </script>

</body>

</html>