<?php

namespace Backend\Logger;

class Log
{
  public function addError($error_msg)
  {
    error_log( $error_msg );
    return $_SESSION['error_msgs'][] = $error_msg;
  }

  public function flashSuccessMsg($msg)
  {
    return $_SESSION['success_msgs'][] = $msg;
  }

  public function hasErrors(): bool
  {
    return !empty($_SESSION['error_msgs']);
  }

  public function viewErrorMsgs()
  {
    if (isset($_SESSION['error_msgs'])) {
      echo '<div id="error_log" class="col-10 mx-auto text-white tracking-wider p-2 px-4 rounded text-capitalize fst-italic">';
      foreach ($_SESSION['error_msgs'] as $key => $value) {
        echo "<span display:block;'>$value</span>";
      }
      echo '</div>';

      $_SESSION['error_msgs'] = null;
      unset($_SESSION['error_msgs']);
    }
  }

  public function viewSuccessMsgs()
  {
    if (isset($_SESSION['success_msgs'])) {
      echo '<div id="success_log" class="col-10 mx-auto text-white tracking-wider p-2 px-4 rounded text-capitalize fst-italic">';
      foreach ($_SESSION['success_msgs'] as $key => $value) {
        echo "<span display:block;'>$value</span>";
      }
      echo '</div>';

      $_SESSION['success_msgs'] = null;
      unset($_SESSION['success_msgs']);
    }
  }
}
