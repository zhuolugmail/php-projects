<?php
session_start();

if (!isset($_SESSION['favorites'])) {
  $_SESSION['favorites'] = [];
}

function is_favorite($id)
{
  return in_array($id, $_SESSION['favorites']);
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Asynchronous Button</title>
  <style>
    #blog-posts {
      width: 700px;
    }

    .blog-post {
      border: 1px solid black;
      margin: 10px 10px 20px 10px;
      padding: 6px 10px;
    }

    button.favorite-button {
      background: #0000FF;
      color: white;
      text-align: center;
      width: 70px;
    }

    button.favorite-button:hover {
      background: #000099;
    }

    .favorite-div span.favorite-heart {
      display: block;
    }

    span.favorite-heart {
      color: red;
      float: right;
      display: none;
    }

    span.favorite-heart:hover {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <?php
  var_dump($_SESSION['favorites']);
  echo is_favorite('blog-post-101');
  ?>
  <div id="blog-posts">
    <div id="blog-post-101" class="blog-post <?php if (is_favorite('blog-post-101'))
      echo 'favorite-div'; ?>">
      <span class="favorite-heart">&hearts;</span>
      <h3>Blog Post 101</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed scelerisque nunc malesuada mauris fermentum
        commodo. Integer non pellentesque augue, vitae pellentesque tortor. Ut gravida ullamcorper dolor, ac fringilla
        mauris interdum id. Nulla porta egestas nisi, et eleifend nisl tincidunt suscipit. Suspendisse massa ex,
        fringilla quis orci a, rhoncus porta nulla. Aliquam diam velit, bibendum sit amet suscipit eget, mollis in
        purus. Sed mattis ultricies scelerisque. Integer ligula magna, feugiat non purus eget, pharetra volutpat orci.
        Duis gravida neque erat, nec venenatis dui dictum vel. Maecenas molestie tortor nec justo porttitor, in sagittis
        libero consequat. Maecenas finibus porttitor nisl vitae tincidunt.</p>
      <button class="favorite-button">Favorite</button>
    </div>
    <div id="blog-post-102" class="blog-post <?php if (is_favorite('blog-post-102'))
      echo 'favorite-div'; ?>">
      <span class="favorite-heart">&hearts;</span>
      <h3>Blog Post 102</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed scelerisque nunc malesuada mauris fermentum
        commodo. Integer non pellentesque augue, vitae pellentesque tortor. Ut gravida ullamcorper dolor, ac fringilla
        mauris interdum id. Nulla porta egestas nisi, et eleifend nisl tincidunt suscipit. Suspendisse massa ex,
        fringilla quis orci a, rhoncus porta nulla. Aliquam diam velit, bibendum sit amet suscipit eget, mollis in
        purus. Sed mattis ultricies scelerisque. Integer ligula magna, feugiat non purus eget, pharetra volutpat orci.
        Duis gravida neque erat, nec venenatis dui dictum vel. Maecenas molestie tortor nec justo porttitor, in sagittis
        libero consequat. Maecenas finibus porttitor nisl vitae tincidunt.</p>
      <button class="favorite-button">Favorite</button>
    </div>
    <div id="blog-post-103" class="blog-post <?php if (is_favorite('blog-post-103'))
      echo 'favorite-div'; ?>">
      <span class="favorite-heart">&hearts;</span>
      <h3>Blog Post 103</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed scelerisque nunc malesuada mauris fermentum
        commodo. Integer non pellentesque augue, vitae pellentesque tortor. Ut gravida ullamcorper dolor, ac fringilla
        mauris interdum id. Nulla porta egestas nisi, et eleifend nisl tincidunt suscipit. Suspendisse massa ex,
        fringilla quis orci a, rhoncus porta nulla. Aliquam diam velit, bibendum sit amet suscipit eget, mollis in
        purus. Sed mattis ultricies scelerisque. Integer ligula magna, feugiat non purus eget, pharetra volutpat orci.
        Duis gravida neque erat, nec venenatis dui dictum vel. Maecenas molestie tortor nec justo porttitor, in sagittis
        libero consequat. Maecenas finibus porttitor nisl vitae tincidunt.</p>
      <button class="favorite-button">Favorite</button>
    </div>
  </div>

  <script>

    favorite = (isFavored) => function () {
      id = this.parentElement.id;
      parentClasses = this.parentElement.classList;

      console.log(id);

      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'favorite.php', true);

      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var result = xhr.responseText;
          console.log('Result: ' + result);

          if (result === 'true')
            parentClasses.add('favorite-div');
          if (result === 'false')
            parentClasses.remove('favorite-div');
        }
      };

      xhr.send('id=' + id + '&value=' + `${isFavored ? 1 : 0}`);
    }

    var buttons = document.getElementsByClassName("favorite-button");

    for (i = 0; i < buttons.length; i++) {
      buttons.item(i).addEventListener("click", favorite(1).bind(buttons[i]));
    }

    favoriteSpans = document.getElementsByClassName("favorite-heart");
    console.log(favoriteSpans);
    Array.from(favoriteSpans)
      .forEach((x, i) => x.addEventListener('click', favorite(0).bind(x)));
  </script>

</body>

</html>