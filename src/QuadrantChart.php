<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\QuadrantChart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use Stringable;

final class QuadrantChart implements MermaidInterface, Stringable
{
    use CommentTrait;
    use RenderItemsTrait;

    private const AXIS_CONNECTOR = ' --> ';
    private const TYPE = 'quadrantChart';

    /** @var Point[] */
    private array $points = [];

    /** @psalm-param array{x: string|array{0: string, 1?: string}, y: string|array{0: string, 1?: string}} $axes */
    /** @psalm-param array{0: string, 1: string, 2: string, 3: string} $quadrants */
    public function __construct(
        private readonly string $title,
        private readonly array $axes,
        private readonly array $quadrants
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function addPoint(Point ...$point): self
    {
        $new = clone $this;
        $new->points = array_merge($this->points, $point);
        return $new;
    }

    public function withPoint(Point ...$point): self
    {
        $new = clone $this;
        $new->points = $point;
        return $new;
    }

    public function render(array $attributes = []): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        $this->renderComment('', $output);
        $output[] = self::TYPE;
        $output[] = Mermaid::INDENTATION . 'title ' . $this->title;

        foreach ($this->axes as $c => $axis) {
            $output[] = Mermaid::INDENTATION
                . $c . '-axis '
                . (is_string($axis) ? $axis : implode(self::AXIS_CONNECTOR, $axis))
            ;
        }

        foreach ($this->quadrants as $i => $quadrant) {
            $output[] = Mermaid::INDENTATION
                . 'quadrant-' . ($i + 1)
                . ' '
                . $quadrant
            ;
        }

        $this->renderItems($this->points, '', $output);

        return Mermaid::render($output, $attributes);
    }
}
