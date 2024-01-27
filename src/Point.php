<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\QuadrantChart;

use BeastBytes\Mermaid\CommentTrait;
use InvalidArgumentException;

final class Point
{
    use CommentTrait;

    private const EXCEPTION_MESSAGE = 'Point co-ordinates must be between 0 and 1 (inclusive); %s given for %s in %s';

    public function __construct(
        private readonly string $name,
        private readonly float $x,
        private readonly float $y,
    )
    {
        foreach(['x', 'y'] as $param) {
            /** @var float $value */
            $value = $this->$param;

            if ($value < 0 || $value > 1) {
                throw new InvalidArgumentException(
                    sprintf(self::EXCEPTION_MESSAGE, $value, $param, $this->name)
                );
            }
        }
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation . $this->name . ': [' . $this->x . ', ' . $this->y . ']';

        return implode("\n", $output);
    }
}
