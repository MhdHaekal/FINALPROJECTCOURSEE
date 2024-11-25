<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Course - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../FP2/assets/css/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Online Courses</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

 <!-- Hero Section -->
 <section class="hero-section">
        <div class="container">
            <h1>Welcome to Online Courses</h1>
            <p>Explore the best courses to enhance your skills and knowledge.</p>
            <a href="#" class="btn btn-custom">Get Started</a>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Courses</h2>
            <div class="row">
                <!-- Course Card -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/course1.jpg" class="card-img-top" alt="Course 1">
                        <div class="card-body">
                            <h5 class="card-title">Web Development</h5>
                            <p class="card-text">Learn HTML, CSS, JavaScript, and more to build stunning websites.</p>
                            <a href="#" class="btn btn-primary">Enroll Now</a>
                        </div>
                    </div>
                </div>
                <!-- Repeat for other courses -->
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">About Us</h2>
            <p class="text-center">We are committed to providing the best online learning experience. Our courses are designed by industry professionals to help you achieve your goals.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Contact Us</h2>
            <form action="contact.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </section>

   <!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Section: Contact Info -->
            <div class="col-md-4 mb-3">
                <h5>Contact Us</h5>
                <p>Email: support@onlinecourse.com</p>
                <p>Phone: +1 234 567 890</p>
                <p>Address: 123 Learning Street, Education City</p>
            </div>

            <!-- Section: Quick Links -->
            <div class="col-md-4 mb-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>

            <!-- Section: Social Media -->
            <div class="col-md-4 mb-3">
                <h5>Follow Us</h5>
                <div class="d-flex">
                    <a href="#" class="me-3"><i class="bi bi-facebook" style="font-size: 1.5rem;"></i></a>
                    <a href="#" class="me-3"><i class="bi bi-twitter" style="font-size: 1.5rem;"></i></a>
                    <a href="#" class="me-3"><i class="bi bi-instagram" style="font-size: 1.5rem;"></i></a>
                    <a href="#"><i class="bi bi-linkedin" style="font-size: 1.5rem;"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <p class="text-center">&copy; 2024 Online Course. All rights reserved.</p>
    </div>
</footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
