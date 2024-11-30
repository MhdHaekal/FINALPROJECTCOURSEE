<?php
class AuthClass {
    private $conn;
    private $user_id;
    private $username;
    private $role;

    // Konstruktor untuk menghubungkan ke database
    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    // Fungsi login
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $this->user_id = $user['id'];
                $this->username = $user['username'];
                $this->role = $user['role'];
                $this->startSession();
                return true;
            }
        }
        return false;
    }

    // Fungsi untuk memulai session
    private function startSession() {
        session_start();
        $_SESSION['user_id'] = $this->user_id;
        $_SESSION['username'] = $this->username;
        $_SESSION['role'] = $this->role;
    }

    // Fungsi untuk mengecek apakah pengguna sudah login
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Fungsi untuk mendapatkan informasi pengguna yang sedang login
    public function getUserRole() {
        return $_SESSION['role'] ?? null;
    }

    // Fungsi untuk logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
?>
