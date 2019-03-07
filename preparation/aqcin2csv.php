<?php

$data = json_decode(file_get_contents(__DIR__ . '/../data/air.json'), true);

$lines = [];

function getLabel(int $index): string {
    if($index <= 50) {
        return 'good';
    } elseif($index <= 100) {
        return 'moderate';
    } elseif ($index <= 150) {
        return 'unhealthy for sensitive';
    }  elseif ($index <= 200) {
        return 'unhealthy';
    } elseif ($index <= 300) {
        return 'very unhealthy';
    }
    return 'hazardous';
}

foreach ($data['data'] as $row) {
    $lines[] = sprintf('%s;%s;%s',
        $row['lat'],
        $row['lon'],
        getLabel((int) $row['aqi'])
    );
}

file_put_contents(__DIR__ . '/../data/air.csv', implode(PHP_EOL, $lines));
