<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class UuidController
{
    public function generate()
    {
        $uuid = Uuid::uuid4();
        echo json_encode(['uuid' => $uuid->toString()]);
    }
}
