<?php
require_once 'php-backend/connect.php';

function getContactInfo() {
    global $conn;
    
    $contactInfo = [
        'address' => '',
        'open_time' => '',
        'phone' => '',
        'email' => '', 
        'socials' => []
    ];

    try {
        // Get contact info
        $contactQuery = $conn->query("
            SELECT setting_name, setting_value 
            FROM site_settings 
            WHERE setting_group = 'contact'
        ");
        
        if ($contactQuery) {
            while ($row = $contactQuery->fetch_assoc()) {
                switch ($row['setting_name']) {
                    case 'address':
                        $contactInfo['address'] = $row['setting_value'];
                        break;
                    case 'open_time_start':
                        $contactInfo['open_time_start'] = $row['setting_value'];
                        break;
                    case 'open_time_end':
                        $contactInfo['open_time_end'] = $row['setting_value'];
                        break;
                    case 'phone':
                        $contactInfo['phone'] = $row['setting_value'];
                        break;
                }
            }
        }

        // Get email from mail group
        $emailQuery = $conn->query("
            SELECT setting_value 
            FROM site_settings 
            WHERE setting_group = 'mail' AND setting_name = 'email'
            LIMIT 1
        ");
        
        if ($emailQuery && $emailRow = $emailQuery->fetch_assoc()) {
            $contactInfo['email'] = $emailRow['setting_value'];
        }

        // Format open time
        if (!empty($contactInfo['open_time_start']) && !empty($contactInfo['open_time_end'])) {
            $contactInfo['open_time'] = date('H:i', strtotime($contactInfo['open_time_start'])) . ' - ' . 
                                       date('H:i', strtotime($contactInfo['open_time_end']));
        }

        // Get social media links
        $socialQuery = $conn->query("
            SELECT setting_name, setting_value 
            FROM site_settings 
            WHERE setting_group = 'social'
        ");
        
        if ($socialQuery) {
            while ($row = $socialQuery->fetch_assoc()) {
                $contactInfo['socials'][$row['setting_name']] = $row['setting_value'];
            }
        }

    } catch (Exception $e) {
        error_log("Footer Error: " . $e->getMessage());
    }

    return $contactInfo;
}
?>