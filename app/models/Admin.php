<?php

class Admin extends Model {
  
  public function __construct() {
      parent::__construct();
  }

  public function getAllUsers() {
    $stmt = $this->mysqli->prepare("SELECT * FROM User s WHERE s.approved = 1 ORDER BY s.name");
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getUsersToBeApproved() {
    $stmt = $this->mysqli->prepare("SELECT * FROM User s WHERE s.approved = 0 ORDER BY s.name");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getUserByName($name) {
    $stmt = $this->mysqli->prepare("SELECT * FROM User s WHERE s.approved = 1 AND s.name = ?");
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function enableUser($user_id) {
    $insert_stmt = $this->mysqli->prepare("UPDATE User SET approved = 1 WHERE user_id = ?");
    $insert_stmt->bind_param('s', $user_id);
    $insert_stmt->execute();
  }

  public function disableUser($user_id) {
    $insert_stmt = $this->mysqli->prepare("UPDATE User SET approved = 0 WHERE user_id = ?");
    $insert_stmt->bind_param('s', $user_id);
    $insert_stmt->execute();
  }

  public function getGoingEvents() {
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date, e.description, v.city 
       FROM   Event e, Venue v
       WHERE  e.venue_id = v.venue_id
       AND e.cancelled = 0
       AND e.disabled = 0
       ORDER BY e.date");
     $stmt->execute();
     $result = $stmt->get_result();

     return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getDisabledEvents() {
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date, e.description, v.city 
       FROM   Event e, Venue v
       WHERE  e.venue_id = v.venue_id
       AND e.disabled = 1
       ORDER BY e.date");
     $stmt->execute();
     $result = $stmt->get_result();

     return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getCancelledEvents() {
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date, e.description, v.city 
       FROM   Event e, Venue v
       WHERE  e.venue_id = v.venue_id
       AND e.cancelled = 1
       ORDER BY e.date");
     $stmt->execute();
     $result = $stmt->get_result();

     return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function enableEvent($event_id) {
    $insert_stmt = $this->mysqli->prepare("UPDATE Event SET disabled = 0 WHERE event_id = ?");
    $insert_stmt->bind_param('s', $event_id);
    $insert_stmt->execute();
  }

  public function disableEvent($event_id) {
    $insert_stmt = $this->mysqli->prepare( "UPDATE Event SET disabled = 1 WHERE  event_id = ?");
    $insert_stmt->bind_param('i', $event_id);
    $insert_stmt->execute();
  }

  public function getCharts() {
    // First chart
    $stmt = $this->mysqli->prepare(
      "SELECT DISTINCT purchase_date
      FROM Ticket
      WHERE purchase_date IS NOT NULL
      ORDER BY purchase_date");
    $stmt->execute();
    $ticketChartX = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $stmt = $this->mysqli->prepare(
    "SELECT COUNT(*)
    FROM Ticket
    GROUP BY purchase_date
    HAVING purchase_date IS NOT NULL");
    $stmt->execute();
    $ticketChartY = $stmt->get_result()->fetch_all(MYSQLI_NUM);
    
    // Second chart

    $stmt = $this->mysqli->prepare(
      "SELECT DISTINCT date
      FROM Event
      ORDER BY date");
      $stmt->execute();
    $eventChartX = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $stmt = $this->mysqli->prepare(
      "SELECT COUNT(*)
      FROM Event
      GROUP BY date");
      $stmt->execute();
    $eventChartY = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    // Third chart
    $stmt = $this->mysqli->prepare(
      "SELECT DISTINCT signup_date
      FROM User
      ORDER BY signup_date");
    $stmt->execute();
    $userChartX = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $stmt = $this->mysqli->prepare(
      "SELECT COUNT(*)
      FROM User
      GROUP BY signup_date");
    $stmt->execute();
    $userChartY = $stmt->get_result()->fetch_all(MYSQLI_NUM);
    
    // Fourth chart

    // $stmt = $this->mysqli->prepare(
    //   "SELECT DISTINCT DATE(date)
    //   FROM Alert
    //   ORDER BY date");
    // $stmt->execute();
    // $alertChartX = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $stmt = $this->mysqli->prepare(
    "SELECT COUNT(*)
    FROM Alert");
    $stmt->execute();
    $alertChartY = $stmt->get_result()->fetch_all(MYSQLI_NUM);
    
    // $stmt = $this->mysqli->prepare(
    //   "SELECT DISTINCT DATE(date)
    //   FROM Broadcast
    //   ORDER BY date");
    // $stmt->execute();
    // $broadcastChartX = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $stmt = $this->mysqli->prepare(
    "SELECT COUNT(*)
    FROM Broadcast");
    $stmt->execute();
    $broadCastChartY = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    // Send charts data
    $charts = [ 'tickets' => ['x' => $ticketChartX, 'y' => $ticketChartY],
                'events' => ['x' => $eventChartX, 'y' => $eventChartY],
                'users' => ['x' => $userChartX, 'y' => $userChartY],
                'notifications' => ['alerts' => [
                  // 'x' => $alertChartX, 
                'y' => $alertChartY],
                                    'broadcasts' => [
                                      // 'x' => $broadcastChartX, 
                                      'y' => $broadCastChartY]
                                  ]
              ];
    return $charts;
  }

  public function sendBroadcast($text) {
    $users = $this->getAllUsers();
    foreach ($users as $user) {
      $user_id = $user['user_id'];
      $insert_stmt = $this->mysqli->prepare( "INSERT Into Broadcast(`user_id`, `text`) VALUES (?, ?)");
      $insert_stmt->bind_param('is', $user_id, $text);
      $insert_stmt->execute();
    }
  }

  public function sendNotify($user_id, $text) {
    $insert_stmt = $this->mysqli->prepare( "INSERT Into Broadcast(`user_id`, `text`) VALUES (?, ?)");
    $insert_stmt->bind_param('is', $user_id, $text);
    $insert_stmt->execute();
  }
}
?>