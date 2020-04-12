<?php

class Notify extends Model {  
  public function __construct() {
      parent::__construct();
  }

  public function getUserNotifies($userId) {
      $stmt = $this->mysqli->prepare(
         "(SELECT  text, title, date,event_id ,`read`, broadcast_id as alert_id
         FROM `Broadcast`b
         WHERE b.user_id = ?
         UNION SELECT n.text, e.title, e.date, e.event_id, a.read, a.alert_id 
           FROM Submit s, Alert a, Notify n, Event e 
           WHERE s.user_id = ?
           AND s.user_id = a.user_id 
           AND s.event_id = a.event_id 
           AND a.notify_id = n.notify_id 
           AND e.event_id = s.event_id )
           ORDER BY date DESC");

      $stmt->bind_param('ii',$userId,$userId);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getUnreadCount($notifies) {
      $count = 0;
      foreach($notifies as &$notify) {
          if($notify['read'] == 0) {
              $count++;
          }
      }
      return $count;
  }

  public function readNotification($alert_id) {
      $query = "UPDATE Alert a
        SET  a.read = 1
        WHERE  a.alert_id = ?";
      $stmt = $this->mysqli->prepare($query);
      $stmt->bind_param('i', $alert_id);
      $stmt->execute();
  }

  public function readBroadcast($alert_id) {
    $query = "UPDATE Broadcast a
      SET  a.read = 1
      WHERE a.broadcast_id = ?";
    $stmt = $this->mysqli->prepare($query);
    $stmt->bind_param('i', $alert_id);
    $stmt->execute();
  }

  public function readAllNotifications($user_id) {
      $query = "UPDATE Alert a
        SET    a.read = 1
        WHERE  a.user_id = ?";
      $stmt = $this->mysqli->prepare($query);
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      $query = "UPDATE Broadcast a
        SET    a.read = 1
        WHERE  a.user_id = ?";
      $stmt = $this->mysqli->prepare($query);
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
  }
}

?>