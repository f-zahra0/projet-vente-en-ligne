<?php

require_once "User.php";

class UserManager {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function authenticate(string $username, string $password): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User($data['username'], $data['password'], $data['id'] ?? null);
        }
        return null;
    }
}
