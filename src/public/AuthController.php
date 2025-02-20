<?php

class AuthController
{

    // this method is used to login the user
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

    // this method is used to get protected data
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
