<?php

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\QuadrantChart\Point;

test('Point', function (string $name, float $x, float $y) {
    $point = new Point($name, $x, $y);
    expect($point->render(Mermaid::INDENTATION))
        ->toBe("  $name: [$x, $y]")
    ;
})
    ->with('points')
;

test('Invalid points', function (string $name, float $x, float $y) {
    expect(fn() => new Point($name, $x, $y))
        ->toThrow(
            InvalidArgumentException::class,
            sprintf(
                'Point co-ordinates must be between 0 and 1 (inclusive); %s given for %s in %s',
                ($x < 0 || $x > 1) ? $x : $y,
                ($x < 0 || $x > 1) ? 'x' : 'y',
                $name
            )
        )
    ;
})
    ->with('invalidPoints')
;

dataset('points', [
    ['Point1', 0.2, 0.8],
    ['Point2', 0.75, 0.8],
    ['Point3', 0.4, 0.4],
    ['Point4', 0.39, 0.2],
    ['Point 5', 0.6, 0.7],
    ['Point 6', 0.7, 0.41],
    ['Point 7', 0.84, 0.35],
    ['Point 8', 0, 0],
    ['Point 9', 0, 1],
    ['Point 10', 1, 0],
    ['Point 11', 1, 1],
]);

dataset('invalidPoints', [
    ['Point 1', 1.2, 0.8],
    ['Point 2', 0.75, 1.8],
    ['Point 3', 1.75, 1.8],
]);
