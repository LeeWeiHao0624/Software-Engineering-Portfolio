<?php
/**
 * Portfolio Website - Weihao Lee
 * Software Engineering Student | Backend Developer | Automotive Photographer
 *
 * Tech Stack: PHP, HTML5, CSS3, Bootstrap 5
 * Purpose: Professional portfolio to support software engineering internship applications.
 *
 * @author Weihao Lee
 * @version 1.1
 */

// =============================================================================
// DEPENDENCIES: PHPMailer (installed via Composer)
// =============================================================================
//
// This site uses PHPMailer for secure, reliable contact form delivery.
// Make sure you have installed PHPMailer with Composer in your project root:
//   composer require phpmailer/phpmailer
//
// The Composer autoloader will make the PHPMailer classes available.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Attempt to load Composer's autoloader for PHPMailer.
// If it is not present yet, the site will still render and the contact form
// will fail gracefully with a clear error message instead of a fatal error.
$mailerAvailable = false;
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (is_file($autoloadPath)) {
    require $autoloadPath;
    $mailerAvailable = true;
}

// Central mail configuration (host, username, password, etc.)
// Sensitive values are read from password.env via config/mail.php
$mailConfig = require __DIR__ . '/config/mail.php';

// =============================================================================
// CONTACT FORM PROCESSING (Server-side validation, security, and PHPMailer)
// =============================================================================

$form_submitted = false;
$form_errors = [];
$form_success = false;

// Initialise form values to avoid undefined variable notices on first load
$name = '';
$email = '';
$message = '';

// Process form only on POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {

    // Sanitize inputs to prevent HTML injection and trim whitespace
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Server-side validation (kept intentionally strict for production use)
    if (empty($name)) {
        $form_errors['name'] = 'Please enter your name.';
    } elseif (strlen($name) > 100) {
        $form_errors['name'] = 'Name must be 100 characters or less.';
    }

    if (empty($email)) {
        $form_errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_errors['email'] = 'Please enter a valid email address.';
    } elseif (strlen($email) > 254) {
        $form_errors['email'] = 'Email address is too long.';
    }

    if (empty($message)) {
        $form_errors['message'] = 'Please enter your message.';
    } elseif (strlen($message) > 5000) {
        $form_errors['message'] = 'Message must be 5000 characters or less.';
    }

    // Only attempt to send once validation has passed
    if (empty($form_errors)) {
        // If PHPMailer is not available (Composer not installed yet), fail
        // gracefully and prompt for configuration instead of crashing.
        if (!$mailerAvailable) {
            $form_errors['general'] = 'Email sending is not configured on this server yet. Please try again later or reach out via direct email.';
            $form_submitted = true;
        } else {
        // ---------------------------------------------------------------------
        // PHPMailer configuration
        // ---------------------------------------------------------------------
        // Replace the placeholder SMTP settings below with your real credentials.
        // It is recommended to store sensitive values (username/password) in
        // environment variables or a separate configuration file, not committed
        // to version control.

        $smtpHost     = $mailConfig['host']       ?? 'smtp.gmail.com';
        $smtpUsername = $mailConfig['username']   ?? 'weihao.lee.works@gmail.com';
        $smtpPassword = $mailConfig['password']   ?? null;
        $smtpPort     = $mailConfig['port']       ?? 587;

        // Create a new PHPMailer instance with exceptions enabled
        $mailer = new PHPMailer(true);

        try {
            // Server settings
            $mailer->isSMTP();
            $mailer->Host       = $smtpHost;
            $mailer->SMTPAuth   = true;
            $mailer->Username   = $smtpUsername;
            $mailer->Password   = $smtpPassword;
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailer->Port       = $smtpPort;

            // Character encoding and language settings
            $mailer->CharSet = 'UTF-8';
            $mailer->isHTML(true);

            // From address: use your authenticated sender, but honour the user's
            // email via "reply-to" to avoid spoofing and improve deliverability.
            $mailer->setFrom($smtpUsername, 'Weihao Lee | Portfolio');
            $mailer->addAddress('weihao.lee.works@gmail.com', 'Weihao Lee');
            $mailer->addReplyTo($email, $name ?: 'Portfolio Visitor');

            // Safe, escaped content for email body
            $safeName    = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $safeEmail   = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

            $mailer->Subject = 'New portfolio contact from ' . ($safeName ?: 'Website Visitor');
            $mailer->Body    = "
                <h2>New Contact Form Submission</h2>
                <p><strong>Name:</strong> {$safeName}</p>
                <p><strong>Email:</strong> {$safeEmail}</p>
                <p><strong>Message:</strong></p>
                <p>{$safeMessage}</p>
            ";

            // Provide a plain-text fallback for email clients that do not render HTML
            $mailer->AltBody = "New contact form submission\n\n"
                . "Name: {$name}\n"
                . "Email: {$email}\n\n"
                . "Message:\n{$message}\n";

            // Attempt to send the email
            $mailer->send();

            $form_success = true;
            $form_submitted = true;

            // Clear the form fields on successful submission
            $name = $email = $message = '';
        } catch (Exception $e) {
            // Log $e->getMessage() to a secure server log if needed
            $form_errors['general'] = 'Sorry, something went wrong while sending your message. Please try again later or email me directly.';
            $form_submitted = true;
        }
        }
    } else {
        $form_submitted = true;
    }
}

// Escape output for safe display in HTML (defence in depth)
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Weihao Lee - Software Engineering Student and Aspiring Backend Developer. Specialized in PHP, database management, and building scalable web applications. Explore my technical projects and coding expertise.">
    <meta name="author" content="Weihao Lee">
    <meta name="keywords" content="Weihao Lee, Software Engineering, Backend Developer, PHP, MySQL, Web Development, Portfolio, APU Student, Automotive Photographer">
    <title>Weihao Lee | Software Engineering Student & Backend Developer</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom styles (override Bootstrap, dark theme, sections) -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap Icons (optional, for CTAs and contact) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- ===================================================================== -->
    <!-- NAVIGATION (optional sticky bar for quick section access) -->
    <!-- ===================================================================== -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3" id="mainNav" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#hero">Weihao Lee</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===================================================================== -->
    <!-- HERO SECTION - Full-height landing -->
    <!-- ===================================================================== -->
    <section id="hero" class="hero-section d-flex align-items-center justify-content-center min-vh-100" aria-labelledby="hero-heading">
        <div class="hero-overlay"></div>
        <div class="container position-relative text-center text-white">
            <h1 id="hero-heading" class="display-2 fw-bold mb-3 animate-fade-in">Weihao Lee</h1>
            <p class="lead mb-4 hero-subheadline">Software Engineering Student | Backend Development | Web Applications | MySQL & PHP</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="#projects" class="btn btn-primary btn-lg px-4 rounded-pill cta-primary">View Projects</a>
                <a href="assets/Lee Wei Hao CV.pdf" class="btn btn-outline-light btn-lg px-4 rounded-pill cta-secondary" download="Lee-Wei-Hao-CV.pdf">Download CV</a>
            </div>
            <!-- Developer social links (hero) -->
            <div class="hero-social mt-4">
                <div class="social-links d-inline-flex align-items-center justify-content-center gap-3">
                    <a href="https://github.com/LeeWeiHao0624" class="social-link" target="_blank" rel="noopener" aria-label="GitHub profile">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/wei-hao-lee-691ba83ab" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn profile">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <a href="#about" class="hero-scroll-indicator" aria-label="Scroll to About section">
            <i class="bi bi-chevron-double-down"></i>
        </a>
    </section>

    <!-- ===================================================================== -->
    <!-- ABOUT ME -->
    <!-- ===================================================================== -->
    <section id="about" class="py-5 py-lg-6 about-section">
        <div class="container">
            <h2 class="section-title text-center mb-5">About Me</h2>
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto">
                    <div class="about-card p-4 p-lg-5 rounded-4 shadow-sm">
                        <p class="lead mb-4" style="text-align: justify;">
                        Motivated IT Diploma student specializing in Software Engineering and Web Development. Proficient in <strong>PHP</strong>, <strong>Python</strong>, and <strong>MySQL</strong>, with a strong foundation in database design and business logic (SPM Top Accounting Student). Passionate about building practical automation tools and responsive web solutions. Seeking an internship to contribute to development cycles and optimizing workflows.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- TECHNICAL PROJECTS - Bootstrap cards with hover effects -->
    <!-- ===================================================================== -->
    <section id="projects" class="py-5 py-lg-6 projects-section">
        <div class="container">
            <h2 class="section-title text-center mb-5">Technical Projects</h2>
            <div class="row g-4 justify-content-center">
                <!-- Project 1: Juju Connect -->
                <div class="col-md-10 col-lg-6">
                    <div class="card project-card h-100 border-0 rounded-4 overflow-hidden shadow-sm d-flex flex-column">
                        <!-- Cover image (stored under assets/) -->
                        <div class="project-card-img">
                            <img src="assets/juju-main.png"
                                 class="project-cover-img"
                                 alt="Juju Connect carpooling application overview"
                                 loading="lazy">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h3 class="card-title h4 mb-3">Juju Connect</h3>
                            <p style="text-align: justify;" class="text-white-50 mb-3">
                            A comprehensive carpooling platform that connects passengers and drivers through a custom-built backend, focusing on safety, route tracking, and a seamless ride browsing and booking experience.
                            </p>
                            <p class="card-text small text-primary mb-4">
                                <i class="bi bi-code-slash me-1"></i> Engineered with a custom <strong>PHP</strong> backend and data models to handle ride scheduling, direct bookings, and multi-tier user management.
                            </p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                                    <i class="bi bi-server me-1"></i> Full-Stack PHP
                                </span>
                                <button type="button"
                                        class="btn btn-outline-light btn-sm rounded-pill project-view-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#jujuModal">
                                    <i class="bi bi-images me-1"></i> View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Project 2: Tamago Calculator -->
                <div class="col-md-10 col-lg-6">
                    <div class="card project-card h-100 border-0 rounded-4 overflow-hidden shadow-sm d-flex flex-column">
                        <!-- Cover image (stored under assets/) -->
                        <div class="project-card-img">
                            <img src="assets/tamago-main.png"
                                 class="project-cover-img"
                                 alt="Tamago Calculator application main interface"
                                 loading="lazy">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h3 class="card-title h4 mb-3">Tamago Calculator</h3>
                            <p style="text-align: justify;" class="text-white-50 mb-3">
                            Developed a Python and Selenium automation tool that seamlessly synchronizes external factory data to calculate daily production requirements and eliminate manual entry errors.
                            </p>
                            <p class="card-text small text-primary mb-4">
                                <i class="bi bi-cpu me-1"></i> Built with a focus on precise arithmetic logic, maintainable code structure, and a minimal UI for distraction-free use.
                            </p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                                    <i class="bi bi-calculator me-1"></i> Python Automation
                                </span>
                                <button type="button"
                                        class="btn btn-outline-light btn-sm rounded-pill project-view-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#tamagoModal">
                                    <i class="bi bi-images me-1"></i> View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- PROJECT MODALS & CAROUSELS -->
    <!-- ===================================================================== -->

    <!-- Juju Connect Modal -->
    <div class="modal fade" id="jujuModal" tabindex="-1" aria-labelledby="jujuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-project">
                <div class="modal-header">
                    <h5 class="modal-title" id="jujuModalLabel">Juju Connect &mdash; Project Gallery</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="jujuCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#jujuCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Passenger View slide"></button>
                            <button type="button" data-bs-target="#jujuCarousel" data-bs-slide-to="1" aria-label="Driver view slide"></button>
                            <button type="button" data-bs-target="#jujuCarousel" data-bs-slide-to="2" aria-label="Admin view slide"></button>
                            <button type="button" data-bs-target="#jujuCarousel" data-bs-slide-to="3" aria-label="Moderator view slide"></button>
                            <button type="button" data-bs-target="#jujuCarousel" data-bs-slide-to="4" aria-label="Mobile view slide"></button>
                        </div>
                        <div class="carousel-inner">
                            <!-- Slide 1: Passenger interface -->
                            <div class="carousel-item active">
                                <img src="assets/juju-passenger.png?v=2"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Juju Connect passenger interface mock-up"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Passenger Dashboard</h6>
                                    <p class="small">Track personal carbon footprint savings, review past journey details, and easily find new rides from a dedicated user profile.</p>
                                </div>
                            </div>
                            <!-- Slide 2: Desktop driver dashboard -->
                            <div class="carousel-item">
                                <img src="assets/juju-driver.png?v=2"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Juju Connect driver and admin dashboard mock-up"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Driver Dashboard</h6>
                                    <p class="small">Seamlessly offer rides, manage incoming passenger requests, and track earned eco-points from a comprehensive driver hub.</p>
                                </div>
                            </div>
                            <!-- Slide 3: Desktop Admin dashboard -->
                            <div class="carousel-item">
                                <img src="assets/juju-admin.png"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Juju Connect driver and admin dashboard mock-up"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Admin Dashboard</h6>
                                    <p class="small">Oversee system performance, track overall environmental impact, and monitor real-time user activity logs through a centralized administrative hub.</p>
                                </div>
                            </div>
                            <!-- Slide 4: Desktop Moderator dashboard -->
                            <div class="carousel-item">
                                <img src="assets/juju-moderator.png"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Juju Connect driver and admin dashboard mock-up"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Moderator Dashboard</h6>
                                    <p class="small">Maintain platform safety by efficiently reviewing flagged rides, managing user reports, and monitoring overall system health.</p>
                                </div>
                            </div>
                            <!-- Slide 5: Mobile layout -->
                            <div class="carousel-item">
                                <img src="assets/juju-mobile.png"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Juju Connect mobile-responsive view mock-up"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Mobile View</h6>
                                    <p class="small">Optimized for smaller screens, the mobile layout guarantees frictionless navigation and usability, empowering users to easily manage their carpooling needs on the go.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#jujuCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#jujuCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tamago Calculator Modal -->
    <div class="modal fade" id="tamagoModal" tabindex="-1" aria-labelledby="tamagoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-project">
                <div class="modal-header">
                    <h5 class="modal-title" id="tamagoModalLabel">Tamago Calculator &mdash; Project Gallery</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="tamagoCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#tamagoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Standard calculator view slide"></button>
                            <button type="button" data-bs-target="#tamagoCarousel" data-bs-slide-to="1" aria-label="Manual entry view slide"></button>
                            <button type="button" data-bs-target="#tamagoCarousel" data-bs-slide-to="2" aria-label="Responsive mobile layout slide"></button>
                        </div>
                        <div class="carousel-inner">
                            <!-- Slide 1: Standard calculator view -->
                            <div class="carousel-item active">
                                <img src="assets/tamago-standard.png"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Tamago Calculator standard production planning interface"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Standard View</h6>
                                    <p class="small">Streamline daily workflows by automatically syncing data from external systems to instantly generate accurate, error-free production plans without manual entry.</p>
                                </div>
                            </div>
                            <!-- Slide 2: Manual entry / advanced controls -->
                            <div class="carousel-item">
                                <img src="assets/tamago-manual.png"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Tamago Calculator manual entry interface"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Manual Entry View</h6>
                                    <p class="small">Empower users to quickly calculate required ingredient blocks by manually inputting daily production targets through an intuitive, easy-to-read interface.</p>
                                </div>
                            </div>
                            <!-- Slide 3: Mobile layout -->
                            <div class="carousel-item">
                                <img src="assets/tamago-mobile.png"
                                     class="d-block w-100 project-carousel-image"
                                     alt="Tamago Calculator responsive mobile layout mock-up"
                                     loading="lazy">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Mobile Layout</h6>
                                    <p class="small">A mobile-optimized interface streamlines the user experience, allowing staff to perform complex data synchronization tasks effortlessly from any device.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#tamagoCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tamagoCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- CONTACT SECTION - Email + PHP contact form -->
    <!-- ===================================================================== -->
    <section id="contact" class="py-5 py-lg-6 contact-section">
        <div class="container">
            <h2 class="section-title text-center mb-5">Contact</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <p class="text-center mb-4">
                        <a href="mailto:weihao.lee.works@gmail.com" class="contact-email link-light"><i class="bi bi-envelope-fill me-2"></i>weihao.lee.works@gmail.com</a>
                    </p>
                    <?php if ($form_success): ?>
                    <div class="alert alert-success rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>Thank you! Your message has been sent. I will get back to you soon.
                    </div>
                    <?php elseif ($form_submitted && !empty($form_errors['general'])): ?>
                    <div class="alert alert-danger rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e($form_errors['general']); ?>
                    </div>
                    <?php endif; ?>
                    <div class="contact-form-card p-4 p-lg-5 rounded-4 shadow-sm">
                        <form method="post" action="#contact" novalidate>
                            <input type="hidden" name="contact_submit" value="1">
                            <div class="mb-4">
                                <label for="contact-name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg rounded-3 <?php echo !empty($form_errors['name']) ? 'is-invalid' : ''; ?>" id="contact-name" name="name" value="<?php echo e($name ?? ''); ?>" required maxlength="100" autocomplete="name">
                                <?php if (!empty($form_errors['name'])): ?>
                                <div class="invalid-feedback"><?php echo e($form_errors['name']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-4">
                                <label for="contact-email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg rounded-3 <?php echo !empty($form_errors['email']) ? 'is-invalid' : ''; ?>" id="contact-email" name="email" value="<?php echo e($email ?? ''); ?>" required maxlength="254" autocomplete="email">
                                <?php if (!empty($form_errors['email'])): ?>
                                <div class="invalid-feedback"><?php echo e($form_errors['email']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-4">
                                <label for="contact-message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg rounded-3 <?php echo !empty($form_errors['message']) ? 'is-invalid' : ''; ?>" id="contact-message" name="message" rows="4" required maxlength="5000"><?php echo e($message ?? ''); ?></textarea>
                                <?php if (!empty($form_errors['message'])): ?>
                                <div class="invalid-feedback"><?php echo e($form_errors['message']); ?></div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- FOOTER -->
    <!-- ===================================================================== -->
    <footer class="py-4 mt-auto text-center text-muted small">
        <div class="container">
            <!-- Developer social links (footer) -->
            <div class="mb-3">
                <div class="social-links d-inline-flex align-items-center justify-content-center gap-3">
                    <a href="https://github.com/LeeWeiHao0624" class="social-link" target="_blank" rel="noopener" aria-label="GitHub profile">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/wei-hao-lee-691ba83ab" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn profile">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Weihao Lee. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS (required for navbar toggler and modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Navbar: add .scrolled class on scroll for solid background -->
    <script>
    (function() {
        var nav = document.getElementById('mainNav');
        if (nav) {
            function onScroll() {
                nav.classList.toggle('scrolled', window.scrollY > 50);
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        }
    })();
    </script>
</body>
</html>
