# Blog CMS Dashboard

This project is a lightweight, custom-built Content Management System (CMS) for managing blog articles and user logins. It is designed to demonstrate clean backend web development, including CRUD operations (Create, Read, Update, Delete), input sanitization, and secure user session routing in a fast, portable framework.

## Live Demo & Recruiter Review Mode

* **Live Demo URL:** `https://sunnyandkate.byethost11.com`
* **Sandbox Username:** `code_reviewer`
* **Sandbox Password:** `sandbox_mode`

###  Database Architecture
To set up the database for this blog, import the `schema.sql` file or run the following query:

\`\`\`sql
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` text NOT NULL,
  `status` ENUM('draft','published') DEFAULT 'draft',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS  `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
\`\`\`
