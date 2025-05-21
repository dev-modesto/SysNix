<?php
namespace App\Helpers;
use App\Config\Connection;
use PDO;

class UuidHelper {

    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function enviaIdBuscaUuid(string $tabela, string $uuid): ?int {
        $query = "SELECT id FROM {$tabela} WHERE uuid = :uuid LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':uuid', $uuid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'] ?? null;
    }
}
