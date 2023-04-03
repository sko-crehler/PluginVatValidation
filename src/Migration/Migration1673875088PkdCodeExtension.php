<?php declare(strict_types=1);

namespace Plugin\VatValidation\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1673875088PkdCodeExtension extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1673875088;
    }

    public function update(Connection $connection): void
    {
        $query = '
            CREATE TABLE IF NOT EXISTS trader_pkd (
                id BINARY(16) NOT NULL,
                customer_id BINARY(16) NOT NULL,
                pkd_code VARCHAR(255) NOT NULL,
                created_at DATETIME(3) NOT NULL,
                updated_at DATETIME(3) NULL,
                PRIMARY KEY (id),
                FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $connection->executeStatement($query);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}