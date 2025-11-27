<?php
$pageTitle = 'Contact Us';
require_once 'inc/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        alert('error', 'Please fill in all fields.');
    } else {
        $query = "INSERT INTO contact_messages (name, email, subject, message) 
                  VALUES ('$name', '$email', '$subject', '$message')";

        if (execute($query)) {
            alert('success', 'Thank you for your message! We will get back to you soon.');
        } else {
            alert('error', 'Failed to send message. Please try again.');
        }
    }
}
?>

<div class="container py-5">
    <h1 class="section-title text-center">Contact Us</h1>
    <p class="text-center text-muted mb-5">Have questions? We'd love to hear from you.</p>

    <?php showAlert(); ?>

    <div class="row g-4">
        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Get in Touch</h5>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-geo-alt text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Address</h6>
                            <p class="text-muted mb-0">123 Hotel Street, City, Country 12345</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-telephone text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Phone</h6>
                            <p class="text-muted mb-0"><?php echo $settings['site_phone']; ?></p>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-envelope text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Email</h6>
                            <p class="text-muted mb-0"><?php echo $settings['site_email']; ?></p>
                        </div>
                    </div>

                    <hr>

                    <h6>Follow Us</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Send us a Message</h5>

                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Subject *</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<section class="py-0">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.30596073366!2d-74.25986548248684!3d40.69714941932609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1635000000000!5m2!1sen!2s"
        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>

<?php require_once 'inc/footer.php'; ?>