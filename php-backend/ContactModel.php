<?php
class ContactModel {
    public $first_name, $last_name, $email, $phone, $subject, $message;

    public function __construct($data) {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->subject = $data['subject'];
        $this->message = $data['message'];
    }
}
