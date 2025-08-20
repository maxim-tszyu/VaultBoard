<?php

namespace App\DTO;

use App\Enums\Priority;
use Carbon\Carbon;

class CategoryCreateDTO
{
    public function __construct(
        public string $title,
    ) {
    }

    public static function fromRequest($request): self
    {
        return new self(
            title: $request->title,
        );
    }
}
