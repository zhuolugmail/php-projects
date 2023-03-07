<?php
    $all_votes = [
        'Harold', 'Jane', 'Harold', 'Ben', 'Jane', 'Jim',
        'Arnold', 'Arnold', 'Harold', 'Jane', 'Harold',
        'Ben', 'Arnold', 'Ben', 'Jane', 'Jane', 'Ben',
        'Harold', 'Harold', 'Ben', 'Steve',
    ];

    $tally_votes = function($votes) {
        # Your code goes here
    };

    print_r($tally_votes($all_votes));

    # Should print something like this:
    # [
    #   [Harold] => 6
    #   [Jane] => 5
    #   [Ben] => 5
    #   [Jim] => 1
    #   [Arnold] => 3
    #   [Steve] => 1
    # ]
?>