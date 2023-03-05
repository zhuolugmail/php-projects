<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Asynchronous Form</title>
  <style>
    #result {
      display: none;
    }

    .error {
      border: 1pt solid red;
    }

    #spinner.hide {
      display: none;
    }

    #spinner {
      display: block;
    }
  </style>
</head>

<body>

  <div id="measurements">
    <p>Enter measurements below to determine the total volume.</p>
    <form id="measurement-form" action="process_measurements.php" method="POST">
      Length: <input type="text" name="length" /><br />
      <br />
      Width: <input type="text" name="width" /><br />
      <br />
      Height: <input type="text" name="height" /><br />
      <br />
      <input id="html-submit" type="submit" value="Submit" />
      <input id="ajax-submit" type="button" value="Ajax Submit" />
    </form>
  </div>

  <div id="spinner" class="hide">
    <img src="spinner.gif" alt="spinner" width="250" height="250" />
  </div>
  <div id="result">
    <p>The total volume is: <span id="volume"></span></p>
  </div>

  <script>

    var result_div = document.getElementById("result");
    var volume = document.getElementById("volume");
    var button = document.getElementById("ajax-submit");

    function postResult(value) {
      volume.innerHTML = value;
      result_div.style.display = 'block';
    }

    function clearResult() {
      volume.innerHTML = '';
      result_div.style.display = 'none';
    }

    function gatherFormData(form) {
      var inputs = form.getElementsByTagName('input');
      var array = [];
      for (i = 0; i < inputs.length; i++) {
        var inputNameValue = inputs[i].name + '=' + inputs[i].value;
        array.push(inputNameValue);
      }
      return array.join('&');
    }

    function displayErrors(errors) {
      var inputs = document.getElementsByTagName('input');
      for (i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        if (errors.indexOf(input.name) >= 0) {
          input.classList.add('error');
        }
      }
    }
    function clearErrors() {
      var inputs = document.getElementsByTagName('input');
      for (i = 0; i < inputs.length; i++) {
        var input = inputs[i];

        input.classList.remove('error');

      }
    }
    function calculateMeasurements() {
      clearResult();

      var form = document.getElementById("measurement-form");

      var action = form.getAttribute('action');

      var form_data = gatherFormData(form);

      var xhr = new XMLHttpRequest();
      xhr.open('POST', action, true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      clearErrors();

      var spinner = document.getElementById("spinner");
      spinner.classList.remove('hide');
      button.disabled = true;

      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

          spinner.classList.add('hide');
          button.disabled = false;

          var result = xhr.responseText;
          console.log('Result: ' + result);

          json = JSON.parse(result);

          if (json.hasOwnProperty('errors') && json.errors.length > 0)
            displayErrors(json.errors);
          else {
            postResult(json.volume);
          }
        }
      };
      xhr.send(form_data);
    }

    button.addEventListener("click", calculateMeasurements);

  </script>

</body>

</html>