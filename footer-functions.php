<?php
require_once 'php-backend/connect.php';

function getContactInfo() {
    global $conn;
    
    $contactInfo = [
        'address' => '',
        'open_time' => '',
        'phone' => '',
        'email' => '', // Make sure this exists
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
                    case 'email': // This case was likely missing
                        $contactInfo['email'] = $row['setting_value'];
                        break;
                }
            }
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