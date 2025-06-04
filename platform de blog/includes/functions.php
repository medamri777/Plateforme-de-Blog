<?php
/**
 * Clean user input data
 * 
 * @param string $data The input data to clean
 * @return string The cleaned data
 */
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Generate a URL-friendly slug from a string
 * 
 * @param string $string The string to convert to a slug
 * @return string The slug
 */
function create_slug($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/**
 * Check if user is logged in
 * 
 * @return bool True if user is logged in, false otherwise
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is an admin
 * 
 * @return bool True if user is an admin, false otherwise
 */
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Redirect to a specific page
 * 
 * @param string $location The URL to redirect to
 * @return void
 */
function redirect($location) {
    header("Location: {$location}");
    exit;
}

/**
 * Display error message
 * 
 * @param string $message The error message to display
 * @return string HTML for the error message
 */
function display_error($message) {
    return "<div class='alert alert-danger'>{$message}</div>";
}

/**
 * Display success message
 * 
 * @param string $message The success message to display
 * @return string HTML for the success message
 */
function display_success($message) {
    return "<div class='alert alert-success'>{$message}</div>";
}

/**
 * Format date in a human-readable format
 * 
 * @param string $date The date to format
 * @param string $format The format to use (default: 'd/m/Y H:i')
 * @return string The formatted date
 */
function format_date($date, $format = 'd/m/Y H:i') {
    return date($format, strtotime($date));
} 