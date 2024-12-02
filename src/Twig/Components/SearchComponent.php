<?php

namespace App\Twig\Components;

use App\Repository\AdRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $search = '';

    public function __construct(private AdRepository $adRepository) {}

    public function searchAd(): array
    {
        return mb_strlen($this->search) ? $this->adRepository->findLikeName($this->search, null) : [];
    }
}
