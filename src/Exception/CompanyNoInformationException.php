<?php declare(strict_types=1);

namespace SwagExample\Exception;

use Exception;

class CompanyNoInformationException extends Exception
{
    public function __construct()
    {
        $message = "Company no information.";

        parent::__construct($message, 400, null);
    }
}
