<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class UuidController
{
    // this method is used to generate a UUID
    public function generate()
    {
        $uuid = Uuid::uuid4();
        echo json_encode(['uuid' => $uuid->toString()]);
    }
}
