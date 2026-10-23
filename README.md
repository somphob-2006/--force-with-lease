# PHP Login + Skills CRUD Starter

A small PHP/MySQL starter project for a class assignment.

## Included
- Login and logout using PHP sessions
- Password verification with `password_verify()`
- CSRF token on the login form
- Protected Skills CRUD pages
- Prepared statements for database queries
- SQL schema in `database.sql`

## Setup
1. Create a MySQL database (for example, `skills_crud`).
2. Import `database.sql` using phpMyAdmin or the MySQL command line.
3. Copy `config/db.example.php` to `config/db.php`.
4. Edit `config/db.php` with your own local/server database credentials.
5. Create a user password hash using PHP:
   ```php
   <?php echo password_hash('choose-a-new-password', PASSWORD_DEFAULT);
   ```
   Insert a user into `users` using that hash and your own email.
6. Put the project in your PHP server's web directory.
7. Open `login.php` in your browser.

## Important security notes
- `config/db.php` is ignored by Git. Do not commit database passwords.
- Do not use real passwords in screenshots, source code, or a public repository.
- This is a starter template. Adjust the database settings and verify it against your university server before submitting.
