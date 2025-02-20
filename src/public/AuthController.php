<?php

class AuthController
{

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];
        $password = $data['password'];

        if ($username === 'admin' && $password === 'admin') {
            echo json_encode(['token' => '1234567890']);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
        }
    }


    public function protectedData()
    {
        $headers = getallheaders();
        $token = $headers['Authorization'];

        if ($token === 'Bearer 1234567890') {
            echo json_encode(['message' => 'Protected data']);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
        }
    }
}
