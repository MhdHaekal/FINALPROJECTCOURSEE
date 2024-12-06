<?php
// Menggunakan jalur absolut untuk menghindari masalah path relatif
include $_SERVER['DOCUMENT_ROOT'] . '../FINAL/config/db.php';

class CourseController {

    // Method untuk mengambil semua kursus
    public function getAllCourses() {
        global $conn;

        $query = "SELECT * FROM courses";
        $result = $conn->query($query);

        $courses = [];
        if ($result->num_rows > 0) {
            while ($course = $result->fetch_assoc()) {
                $courses[] = $course;
            }
        }

        return $courses;
    }

    // Method untuk mengambil kursus berdasarkan ID
    public function getCourseById($course_id) {
        global $conn;

        // Pastikan ID yang diberikan valid
        $course_id = intval($course_id); // Mengkonversi ID menjadi integer (untuk keamanan)

        // Query untuk mengambil data kursus berdasarkan ID
        $query = "SELECT * FROM courses WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $course_id); // Menggunakan prepared statement untuk mencegah SQL injection
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika kursus ditemukan, kembalikan data kursus
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Jika kursus tidak ditemukan
        }
    }
}
?>
