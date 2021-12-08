<?php declare(strict_types=1);

namespace SwagExample\Exception;

use Exception;

class CompanyNotValidException extends Exception
{
    public function __construct()
    {
        $message = "Company is not valid.";

        parent::__construct($message, 400, null);
    }
}
