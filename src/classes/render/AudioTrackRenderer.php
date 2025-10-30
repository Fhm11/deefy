<?php
declare(strict_types=1);

namespace iutnc\deefy\render;



abstract class AudioTrackRenderer implements \iutnc\deefy\render\Renderer {
    public function render(int $selector): string {
        switch ($selector) {
            case self::COMPACT:
                return $this->renderCompact();
            case self::LONG:
                return $this->renderLong();
            default:
                return '';
        }
    }
    abstract protected function renderCompact(): string;
    abstract protected function renderLong(): string;
}
