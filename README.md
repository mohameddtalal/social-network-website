# Social Network Platform

A full-stack, interactive Social Network web application built with PHP, MySQL, JavaScript, HTML, and CSS. This project provides core social networking features including user registration, dynamic profile pages, a real-time newsfeed, friend requests, and direct messaging.

## 🚀 Features

*   **User Authentication:** Secure registration and login system.
*   **Dynamic Profiles:** Individual user profile pages displaying posts, friend counts, and profile pictures.
*   **Newsfeed:** A dynamic feed where users can post updates, view posts from friends, and interact.
*   **Interactions:** Users can like and comment on posts dynamically without page reloads (using AJAX).
*   **Messaging System:** Direct private messaging between friends.
*   **Friend Management:** Send, accept, or decline friend requests.
*   **Search Functionality:** Find and connect with other users on the platform.
*   **Profile Customization:** Upload and crop profile pictures, and update account settings.
*   **Account Management:** Options to update settings or close/deactivate the account.

## 🛠️ Tech Stack

*   **Backend:** PHP (Object-Oriented)
*   **Database:** MySQL (phpMyAdmin)
*   **Frontend:** HTML5, CSS3, JavaScript (Vanilla & jQuery/AJAX)
*   **Server:** XAMPP (Apache)

## 📁 Project Structure

*   `index.php` - The main newsfeed page.
*   `profile.php` - Displays user profiles and their specific posts.
*   `register.php` - Handles user sign-up and login forms.
*   `messages.php` - The direct messaging interface.
*   `search.php` - Search engine to find users.
*   `requests.php` - Manage incoming friend requests.
*   `settings.php` & `close_account.php` - User account configuration.
*   `includes/` - Contains core PHP classes (`User.php`, `Post.php`, `Message.php`), header layout, and form handlers.
*   `assets/` - Contains CSS stylesheets, JavaScript files, and images.
*   `config/` - Database connection settings.

## ⚙️ Installation & Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mohameddtalal/social-network-website.git
    ```
2.  **Move to local server:**
    Place the project folder inside your local web server's root directory (e.g., `htdocs` for XAMPP or `www` for WAMP).
3.  **Database Setup:**
    *   Open phpMyAdmin.
    *   Create a new database (e.g., `social_network`).
    *   Import the provided `.sql` database file (if available in the repo) to set up the necessary tables (`users`, `posts`, `comments`, `likes`, `messages`, etc.).
4.  **Configure Database Connection:**
    *   Navigate to `config/config.php` (or wherever your DB connection is stored).
    *   Update the connection variables (host, username, password, database name) to match your local setup.
5.  **Run the application:**
    *   Start Apache and MySQL modules in your XAMPP/WAMP control panel.
    *   Open your browser and navigate to `http://localhost/Demo` (or the folder name you used).

## 💡 Future Enhancements

*   Implement real-time WebSocket messaging for instant chat.
*   Add notification dropdowns for likes and comments.
*   Enhance mobile responsiveness and UI aesthetics.

---
*Developed by Mohamed Talal*
