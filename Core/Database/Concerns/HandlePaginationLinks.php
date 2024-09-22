<?php

declare(strict_types = 1);

namespace Core\Database\Concerns;

use Illuminate\Support\Arr;

trait HandlePaginationLinks
{
    public function getPaginationLinks(): array
    {
        $onEachSide = $this->onEachSide;

        $slider = ($this->lastPage() < ($onEachSide * 2) + 8)
            ? $this->getSmallSlider()
            : $this->getUrlSlider();

        return array_filter([
            $slider['first'],
            is_array($slider['slider']) ? '...' : null,
            $slider['slider'],
            is_array($slider['last']) ? '...' : null,
            $slider['last'],
        ]);
    }

    public function url(int $page): string
    {
        if ($page <= 0) {
            $page = 1;
        }

        $parameters = [$this->pageName => $page];

        if (count($this->query) > 0) {
            $parameters = array_merge($this->query, $parameters);
        }

        return $this->path
            . (str_contains($this->path, '?') ? '&' : '?')
            . Arr::query($parameters);
    }

    public function nextPageUrl()
    {
        if ($this->hasMorePages()) {
            return $this->url($this->currentPage() + 1);
        }
    }

    public function previousPageUrl()
    {
        if ($this->currentPage() > 1) {
            return $this->url($this->currentPage() - 1);
        }
    }

    public function getUrlRange($start, $end): array
    {
        return collect(range($start, $end))
            ->mapWithKeys(
                fn($page) => [$page => $this->url($page)]
            )->all();
    }

    protected function getSmallSlider(): array
    {
        return [
            'first'  => $this->getUrlRange(1, $this->lastPage()),
            'slider' => null,
            'last'   => null,
        ];
    }

    protected function getUrlSlider(): array
    {
        $window = $this->onEachSide + 4;

        if (!$this->hasMorePages()) {
            return ['first' => null, 'slider' => null, 'last' => null];
        }

        if ($this->currentPage() <= $window) {
            return $this->getSliderTooCloseToBeginning($window);
        } else if ($this->currentPage() > ($this->lastPage() - $window)) {
            return $this->getSliderTooCloseToEnding($window);
        }

        return $this->getFullSlider();
    }

    protected function getSliderTooCloseToBeginning(int $window): array
    {
        return [
            'first'  => $this->getUrlRange(1, $window + $this->onEachSide),
            'slider' => null,
            'last'   => $this->getFinish(),
        ];
    }

    protected function getSliderTooCloseToEnding(int $window): array
    {
        $last = $this->getUrlRange(
            $this->lastPage() - ($window + ($this->onEachSide - 1)),
            $this->lastPage()
        );

        return [
            'first'  => $this->getStart(),
            'slider' => null,
            'last'   => $last,
        ];
    }

    protected function getFullSlider(): array
    {
        return [
            'first'  => $this->getStart(),
            'slider' => $this->getAdjacentUrlRange(),
            'last'   => $this->getFinish(),
        ];
    }

    protected function getStart(): array
    {
        return $this->getUrlRange(1, 2);
    }

    protected function getFinish(): array
    {
        return $this->getUrlRange(
            $this->lastPage() - 1,
            $this->lastPage()
        );
    }

    protected function getAdjacentUrlRange(): array
    {
        return $this->getUrlRange(
            $this->currentPage() - $this->onEachSide,
            $this->currentPage() + $this->onEachSide
        );
    }
}
