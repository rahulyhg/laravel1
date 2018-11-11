<?php

return array (
  'menu' => 'Contact',
  'model' => 'Contact',
  'models' => 'Contact',
  'edit' => 'View contact',
  'tables' => 
  array (
    'phone' => 'Phone',
    'email' => 'Email',
    'fullname' => 'Fullname',
    'address' => 'Address',
    'subject' => 'Subject',
    'content' => 'Content',
  ),
  'form' => 
  array (
    'is_read' => 'Read?',
    'status' => 'Status',
  ),
  'notices' => 
  array (
    'no_select' => 'Please select at least one contact to take this action!',
    'update_success_message' => 'Update successfully',
  ),
  'cannot_delete' => 'Contact could not be deleted',
  'deleted' => 'Contact deleted',
  'contact_information' => 'Contact information',
  'email' => 
  array (
    'header' => 'Email',
    'title' => 'New contact from your site',
    'success' => 'Send message successfully!',
    'failed' => 'Can\'t send message on this time, please try again later!',
    'required' => 'Email is required',
    'email' => 'The email address is not valid',
  ),
  'name' => 
  array (
    'required' => 'Name is required',
  ),
  'content' => 
  array (
    'required' => 'Content is required',
  ),
  'g-recaptcha-response' => 
  array (
    'required' => 'Please confirm you are not a robot before send message.',
    'captcha' => 'You are not confirm robot yet.',
  ),
  'contact_sent_from' => 'This contact information sent from',
  'sender' => 'Sender',
  'sender_email' => 'Email',
  'sender_address' => 'Address',
  'sender_phone' => 'Phone',
  'message_content' => 'Message content',
  'sent_from' => 'Email sent from',
  'form_name' => 'Name',
  'form_email' => 'Email',
  'form_address' => 'Address',
  'form_subject' => 'Subject',
  'form_phone' => 'Phone',
  'form_message' => 'Message',
  'confirm_not_robot' => 'Please confirm you are not robot',
  'required_field' => 'The field with (<span style="color: red">*</span>) is required.',
  'send_btn' => 'Send message',
  'mark_as_read' => 'Mark as read',
  'mark_as_unread' => 'Mark as unread',
  'new_msg_notice' => 'You have <span class="bold">:count</span> New Messages',
  'view_all' => 'View all',
  'read' => 'Read',
  'unread' => 'UnRead',
  'phone' => 'Phone',
  'address' => 'Address',
  'message' => 'Message',
  'settings' => 
  array (
    'email' => 
    array (
      'title' => 'Contact',
      'description' => 'Contact email configuration',
      'templates' => 
      array (
        'notice_title' => 'Send notice to administrator',
        'notice_description' => 'Email template to send notice to administrator when system get new contact',
      ),
    ),
  ),
  'list' => 'List',
  'form_content' => 'Content',
  'form_title' => 'Contact Form',
);
