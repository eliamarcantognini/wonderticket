<?php

class Cart extends Model {  
  public function __construct() {
      parent::__construct();
  }

  public function getCartTickets() {
    $userId = $_SESSION['user_id'];

    $stmt = $this->mysqli->prepare(
        "SELECT e.date, e.title, t.price, t.ticket_id, t.available, t.seat, v.name as place, v.city
          FROM   Event e, Cart c, Ticket t, Venue v
          WHERE  t.ticket_id = c.ticket_id
          AND    e.event_id  = t.event_id
          AND    e.venue_id  = v.venue_id
          AND    t.available = 1
          AND    c.user_id   =  ?
          ORDER BY e.date");

    $stmt->bind_param('i',$userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

  public function removeTicketFromCart($ticketId) {
      $userId = $_SESSION['user_id'];
      $stmt = $this->mysqli->prepare("DELETE FROM Cart WHERE ticket_id = ? AND user_id = ?");
      $stmt->bind_param('ii', $ticketId, $userId); 
      $stmt->execute();
      return $stmt;
  }

  public function addTicketToCart($eventId) {
    $userId = $_SESSION['user_id'];
    $insert_stmt = $this->mysqli->prepare("INSERT INTO Cart (ticket_id, user_id) VALUES (?, ?)");
    $insert_stmt->bind_param('ii', $this->getFirstAvailableTicket($eventId, $userId), $userId); 
    $insert_stmt->execute();
  }

  public function purchase() {
    $userId = $_SESSION['user_id'];

    $stmt = $this->mysqli->prepare(
        "UPDATE Cart c, Ticket t
        SET t.purchase_date = NOW(), t.available = 0, t.user_id = ?
        WHERE  t.ticket_id = c.ticket_id
        AND    t.available = 1
        AND    c.user_id   =  ?");

    $stmt->bind_param('ii', $userId, $userId);
    $stmt->execute();

    $stmt = $this->mysqli->prepare("DELETE FROM Cart WHERE user_id=? ");

    $stmt->bind_param('i', $userId);
    $stmt->execute();
  }

  public function getFirstAvailableTicket($eventId, $userId) {
    $stmt = $this->mysqli->prepare(
      "SELECT  ticket_id
        FROM   Ticket
        WHERE  available = 1
        AND    event_id   =  ?
        AND    ticket_id NOT IN (SELECT ticket_id FROM Cart WHERE user_id = ?)
        ORDER BY seat LIMIT 1");

    $stmt->bind_param('ii',$eventId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc()['ticket_id'];
  }

  public function getCatItemsCount() {
    $userId = $_SESSION['user_id'];
    $stmt = $this->mysqli->prepare(
      "SELECT  COUNT(*) as tot
        FROM   Cart
        WHERE  user_id = ?");

    $stmt->bind_param('i',$userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc()['tot'];
  }
}

?>