<?php
    function my_function() {
        echo "Hello!\n";
    };

    $my_function = function($name) {
        echo "Hello $name!\n";
    };

    $my_function_2 = $my_function;
    $my_function_2("Shaun");

    $environment = 'prod';
    
    $fetch_data_real = function() {
        echo "Fetching data...\n";
    };

    $fetch_data_fake = function() {
        return [
            'name' => 'Jane Doe',
            'age' => 35,
            'job' => 'programmer',
        ];
    };

    $fetch_data = ($environment === 'dev'
        ? $fetch_data_fake
        : $fetch_data_real);

    $fetch_data();
?>