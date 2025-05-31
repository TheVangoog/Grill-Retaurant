<?php

    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['description'])) {
        return "All fields are required.";
    }

    try {
        $clientDB = new UniversalDB('users');
        $clientDB->create(
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],
            $_POST['description']
        );
        return "User registered successfully.";
    } catch (Exception $e) {
        return "Registration failed: " . $e->getMessage();
    }
