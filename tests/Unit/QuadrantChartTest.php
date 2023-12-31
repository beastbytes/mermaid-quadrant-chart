<?php

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\QuadrantChart\Point;
use BeastBytes\Mermaid\QuadrantChart\QuadrantChart;

test('Quadrant Chart', function () {
    $chart = new QuadrantChart(
        'Reach and engagement of campaigns',
        ['x' => ['Low Reach', 'High Reach'], 'y' => ['Low Engagement', 'High Engagement']],
        ['We should expand', 'Need to promote', 'Re-evaluate', 'May be improved']
    );

    foreach ([
        ['Campaign A', 0.3, 0.6],
        ['Campaign B', 0.45, 0.23],
        ['Campaign C', 0.57, 0.69],
        ['Campaign D', 0.78, 0.34],
        ['Campaign E', 0.4, 0.34],
        ['Campaign F', 0.35, 0.78]
    ] as $point) {
        $chart = $chart->addPoint(new Point(...$point));
    }

    expect($chart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "quadrantChart\n"
            . "  title Reach and engagement of campaigns\n"
            . "  x-axis Low Reach --&gt; High Reach\n"
            . "  y-axis Low Engagement --&gt; High Engagement\n"
            . "  quadrant-1 We should expand\n"
            . "  quadrant-2 Need to promote\n"
            . "  quadrant-3 Re-evaluate\n"
            . "  quadrant-4 May be improved\n"
            . "  Campaign A: [0.3, 0.6]\n"
            . "  Campaign B: [0.45, 0.23]\n"
            . "  Campaign C: [0.57, 0.69]\n"
            . "  Campaign D: [0.78, 0.34]\n"
            . "  Campaign E: [0.4, 0.34]\n"
            . "  Campaign F: [0.35, 0.78]\n"
            . "</pre>"
        )
    ;
});
