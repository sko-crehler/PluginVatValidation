<?php

namespace Plugin\VatValidation\Service;

use Plugin\VatValidation\Dto\TraderDataRequestDto;
use Plugin\VatValidation\Dto\TraderDataResponseDto;

interface VatDataProviderInterface
{
    public function check(TraderDataRequestDto $traderDataRequestDto): ?TraderDataResponseDto;
}