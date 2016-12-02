<?php
if (!isset($_SESSION['uname']))
  $_SESSION['uname'] = "";
if (!isset($_SESSION['error_signin']))
  $_SESSION['error_signin'] = false;
if (!isset($_SESSION['admin']))
  $_SESSION['admin'] = false;
if (!isset($_SESSION['admin_edit_success']))
  $_SESSION['admin_edit_success'] = 0;
if (!isset($_SESSION['email']))
  $_SESSION['email'] = '';
if (!isset($_SESSION['update_success']))
  $_SESSION['update_success'] = 0;
if (!isset($_SESSION['error_signup']))
  $_SESSION['error_signup'] = false;
if(!isset($_SESSION['reserve_success']))
  $_SESSION['reserve_success'] = 0;
if(!isset($_SESSION['booking_cancel_success']))
  $_SESSION['booking_cancel_success'] = 0;
 ?>
