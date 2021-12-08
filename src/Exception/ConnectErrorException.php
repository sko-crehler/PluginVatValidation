<?php declare(strict_types=1);

namespace SwagExample\Exception;

use Exception;

class ConnectErrorException extends Exception
{
    public function __construct($errorMessage = null)
    {
        $message = "Connect error. $errorMessage";

        parent::__construct($message, 500, null);
    }
}
