# 👨‍💻 Weihao Lee - Software Engineering Portfolio

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
![Cursor](https://img.shields.io/badge/Cursor_IDE-000000?style=for-the-badge&logo=cursor&logoColor=white)

## 📖 Project Overview
This repository contains the source code for my personal portfolio website. It serves as a central hub for my software engineering projects, demonstrating my ability to build responsive frontends and secure, functional PHP backends.

Rather than using a drag-and-drop website builder, I developed this site from scratch utilizing the **Cursor AI IDE** to accelerate boilerplate generation, allowing me to focus heavily on secure backend routing, dependency management, and UI/UX accessibility.

## 🚀 Featured Projects
* **[Juju Connect]((https://github.com/LeeWeiHao0624/JuJuConnect)):** A comprehensive carpooling application built with PHP and MySQL, featuring a 12-table normalized database and 4 distinct user roles.
* **[Automated Production Calculator]((https://github.com/LeeWeiHao0624/Automated-Production-Calculator)):** A Python/Selenium web-scraping tool that automates complex daily factory math and production planning.

## 🛠️ Technical Highlights & Architecture

While the frontend utilizes **Bootstrap 5** and custom CSS variables for a modern dark theme, the core engineering focus of this project is the backend infrastructure:

* **Secure Contact Form:** Engineered a custom PHP contact form with strict server-side validation to sanitize inputs and prevent HTML/SQL injection.
* **Dependency Management:** Utilized **Composer** to integrate `PHPMailer` for reliable, authenticated SMTP email delivery.
* **Credential Security:** Implemented an environment variable system (`password.env`) parsed by a custom `mail.php` configuration file to ensure sensitive SMTP credentials are never exposed to the client or committed to version control.
* **Accessibility (a11y):** Integrated semantic HTML5 and `prefers-reduced-motion` media queries to ensure inclusive navigation.

## 💻 Local Setup & Installation

To run this portfolio locally and enable the contact form functionality:

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/LeeWeiHao0624/portfolio.git](https://github.com/LeeWeiHao0624/portfolio.git)
   cd portfolio
