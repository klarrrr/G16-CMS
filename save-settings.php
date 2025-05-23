<?php
session_start();
require_once 'php-backend/connect.php';
require_once 'php-backend/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group = $_GET['group'] ?? '';
    $adminId = $_SESSION['admin_id'];
    
    try {
        $conn->begin_transaction();
        
        // Prepare the statement
        $stmt = $conn->prepare("
            INSERT INTO site_settings (setting_group, setting_name, setting_value, updated_by) 
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                setting_value = VALUES(setting_value),
                updated_by = VALUES(updated_by)
        ");
        
        // Process each group differently
        switch ($group) {
            case 'mail':
                $settings = [
                    ['mail', 'email', $_POST['mail-email']],
                    ['mail', 'password', $_POST['mail-password']],
                    ['mail', 'sender_name', $_POST['mail-name']]
                ];
                break;
                
            case 'social':
                $settings = [
                    ['social', 'facebook_url', $_POST['facebook']],
                    ['social', 'instagram_url', $_POST['instagram']],
                    ['social', 'pinterest_url', $_POST['pinterest']]
                ];
                break;
                
            case 'contact':
                $settings = [
                    ['contact', 'address', $_POST['address']],
                    ['contact', 'open_time_start', $_POST['open_time_start'] . ':00'],
                    ['contact', 'open_time_end', $_POST['open_time_end'] . ':00'],
                    ['contact', 'phone', $_POST['phone']]
                ];
                break;
                
            default:
                throw new Exception("Invalid settings group");
        }
        
        // Save all settings in the group
        foreach ($settings as $setting) {
            $stmt->bind_param("sssi", $setting[0], $setting[1], $setting[2], $adminId);
            $stmt->execute();
        }
        
        $conn->commit();
        $_SESSION['success'] = ucfirst($group) . ' settings updated successfully!';
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = 'Error updating settings: ' . $e->getMessage();
    }
    
    header("Location: admin-settings.php");
    exit;
}