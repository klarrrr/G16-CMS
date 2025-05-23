<?php
class ContactModel {
    private $first_name;
    private $last_name;
    private $email;
    private $phone;
    private $subject;
    private $message;
    private $created_at;
    private $status;

    public function __construct(array $data) {
        $this->setFirstName($data['first_name'] ?? '');
        $this->setLastName($data['last_name'] ?? '');
        $this->setEmail($data['email'] ?? '');
        $this->setPhone($data['phone'] ?? '');
        $this->setSubject($data['subject'] ?? '');
        $this->setMessage($data['message'] ?? '');
        $this->created_at = date('Y-m-d H:i:s');
        $this->status = 'pending'; // pending, read, replied, etc.
    }

    // Getters
    public function getFirstName(): string {
        return $this->first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function getFullName(): string {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function getSubject(): string {
        return $this->subject;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function getStatus(): string {
        return $this->status;
    }

    // Setters with validation
    public function setFirstName(string $name): void {
        $this->first_name = $this->sanitizeInput($name);
    }

    public function setLastName(string $name): void {
        $this->last_name = $this->sanitizeInput($name);
    }

    public function setEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format");
        }
        $this->email = $this->sanitizeInput($email);
    }

    public function setPhone(string $phone): void {
        // Basic phone number validation
        $cleaned = preg_replace('/[^0-9+]/', '', $phone);
        if (strlen($cleaned) < 8) {
            throw new InvalidArgumentException("Phone number too short");
        }
        $this->phone = $cleaned;
    }

    public function setSubject(string $subject): void {
        if (strlen($subject) > 100) {
            throw new InvalidArgumentException("Subject too long");
        }
        $this->subject = $this->sanitizeInput($subject);
    }

    public function setMessage(string $message): void {
        if (strlen($message) > 2000) {
            throw new InvalidArgumentException("Message too long");
        }
        $this->message = $this->sanitizeInput($message);
    }

    public function setStatus(string $status): void {
        $allowed = ['pending', 'read', 'replied', 'archived'];
        if (!in_array($status, $allowed)) {
            throw new InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }

    // Helper method for sanitization
    private function sanitizeInput(string $input): string {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
    // Convert to array for database insertion
    public function toArray(): array {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'status' => $this->status
        ];
    }
}