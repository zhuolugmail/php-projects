<?php
    $employees = [
        [
            'name' => 'John',
            'age' => 43,
            'salary' => 90000,
            'job_title' => 'developer',
        ], [
            'name' => 'Hannah',
            'age' => 32,
            'salary' => 110000,
            'job_title' => 'developer',  
        ], [
            'name' => 'Ralph',
            'age' => 22,
            'salary' => 35000,
            'job_title' => 'construction worker',
        ], [
            'name' => 'Rachel',
            'age' => 29,
            'salary' => 55000,
            'job_title' => 'digital marketing specialist',
        ]
    ];

    $developers = array_filter($employees, fn($x) => $x['job_title'] == 'developer');
    $developer_salaries = array_map(fn($x) => $x['salary'], $developers);
    $total_developer_salaries = array_reduce(
        $developer_salaries,
        fn($carry, $item) => $carry + $item,
    );
    $average_developer_salary = $total_developer_salaries / count($developer_salaries);

    $non_developers = array_filter($employees, fn($x) => $x['job_title'] != 'developer');
    $non_developer_salaries = array_map(fn($x) => $x['salary'], $non_developers);
    $total_non_developer_salaries = array_reduce(
        $non_developer_salaries,
        fn($carry, $item) => $carry + $item,
    );
    $average_non_developer_salary = $total_non_developer_salaries / count($non_developer_salaries);

    echo "The average developer salary is $average_developer_salary\n";
    echo "The average non-developer salary is $average_non_developer_salary\n";
?>