<?php

// Errors
$lang['auth_incorrect_password'] =          "<div class='alert alert-danger'><p>Incorrect password.</p></div>";
$lang['auth_incorrect_login'] =             "<div class='alert alert-danger'><p>Incorrect email.</p></div>";
$lang['auth_incorrect_email_or_username'] = "<div class='alert alert-danger'><p>Email doesn\'t exist.</p></div>";
$lang['auth_email_in_use'] =                "<div class='alert alert-danger'><p>Email is already used by another user. Please choose another email.</p></div>";
$lang['auth_username_in_use'] =             "<div class='alert alert-danger'><p>Username already exists. Please choose another username.</p></div>";
$lang['auth_invalid_role'] =                "<div class='alert alert-danger'><p>Please choose a role.</p></div>";
$lang['auth_current_email'] =               "<div class='alert alert-danger'><p>This is your current email.</p></div>";
$lang['auth_incorrect_captcha'] =           "<div class='alert alert-danger'><p>Your confirmation code does not match the one in the image.</p></div>";
$lang['auth_captcha_expired'] =             "<div class='alert alert-danger'><p>Your confirmation code has expired. Please try again.</p></div>";
$lang['auth_login_attempts_exceeded'] =     "You have tried to log in too many times. Try again later.";

// Notifications
$lang['auth_message_logged_out'] = 'You have been successfully logged out.';
$lang['auth_message_registration_disabled'] = 'Registration is disabled.';
$lang['auth_message_registration_completed_1'] = "You have successfully registered. Check your email address to activate your account. Check your spam filter if you can\'t find the activation email.";
$lang['auth_message_registration_completed_2'] = 'You have successfully registered.';
$lang['auth_message_activation_email_sent'] = 'A new activation email has been sent to %s. Follow the instructions in the email to activate your account.';
$lang['auth_message_activation_completed'] = 'Your account has been successfully activated.';
$lang['auth_message_activation_failed'] = 'The activation code you entered is incorrect or expired.';
$lang['auth_message_password_changed'] = 'Your password has been successfully changed.';
$lang['auth_message_new_password_sent'] = 'An email with instructions for creating a new password has been sent to you.';
$lang['auth_message_new_password_activated'] = 'You have successfully reset your password.';
$lang['auth_message_new_password_failed'] = 'Your activation key is incorrect or expired. Please check your email again and follow the instructions.';
$lang['auth_message_new_email_sent'] = 'A confirmation email has been sent to %s. Follow the instructions in the email to complete this change of email address.';
$lang['auth_message_new_email_activated'] = 'You have successfully changed your email';
$lang['auth_message_new_email_failed'] = 'Your activation key is incorrect or expired. Please check your email again and follow the instructions.';
$lang['auth_message_banned'] = 'You are banned.';
$lang['auth_message_unregistered'] = 'Your account has been deleted...';

// Email subjects
$lang['auth_subject_welcome'] = 'Welcome to %s!';
$lang['auth_subject_activate'] = 'Welcome to %s!';
$lang['auth_subject_forgot_password'] = 'Forgot your password on %s?';
$lang['auth_subject_reset_password'] = 'Your new password on %s';
$lang['auth_subject_change_email'] = 'Your new email address on %s';


/* End of file tank_auth_lang.php */
/* Location: ./application/language/english/tank_auth_lang.php */