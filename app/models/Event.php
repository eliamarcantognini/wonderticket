<?php

class Event extends Model {
  private $eventImages = ["bg1.jpg", "bg2.jpg", "bg3.jpg", "bg4.jpg"];
  private $periodsQuery = [
    "e.date = CURRENT_DATE",
    "e.date = CURRENT_DATE + INTERVAL 1 DAY",
    "WEEK(e.date) = WEEK(CURRENT_DATE)",
    "WEEK(e.date) = WEEK(CURRENT_DATE + INTERVAL 1 WEEk)",
    "MONTH(e.date) = MONTH(CURRENT_DATE)"
  ];
  
  public function __construct() {
      parent::__construct();
  }

  public function getAllEvents($n = 6) {

      $stmt = $this->mysqli->prepare(
       "SELECT e.*, s.company, v.name as venue, v.city
        FROM   Event e, Venue v, User s, Category c 
        WHERE  e.user_id = s.user_id
        AND    e.venue_id = v.venue_id
        ORDER BY e.date LIMIT ?");

      $stmt->bind_param('i',$n);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getRandEvents() {

    $stmt = $this->mysqli->prepare(
     "SELECT e.*, v.name as venue, v.city
      FROM   Event e, Venue v
      WHERE  e.venue_id = v.venue_id
      AND e.cancelled = 0
      AND e.disabled = 0
      ORDER BY RAND() LIMIT 3");
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

  public function getFilteredEvents($category_id, $venue_id, $period_id, $limit, $offset) {
      $condition = "";
      $union = "";
      if(strcmp($category_id, "undefined")) { 
        $condition = "e.category_id = ".$category_id;
        $union = " AND ";   
      };
      if(strcmp($venue_id, "undefined")) { 
        $condition = $condition.$union."e.venue_id = ".$venue_id;   
        $union = " AND ";   
      };
      if(strcmp($period_id, "undefined")) {
        $condition = $condition.$union.$this->periodsQuery[$period_id];
      }

      if(!empty($condition)) {
        $condition = " AND ".$condition;
      }

      $query = "SELECT e.*, v.name as venue, v.city
                FROM   Event e, Venue v
                WHERE  e.venue_id = v.venue_id
                AND    e.disabled = 0"
               .$condition.
                " ORDER BY e.date, e.time, e.title DESC LIMIT ".$offset.",".$limit;

      $query_count = "SELECT COUNT(*) as c
                FROM   Event e, Venue v
                WHERE  e.venue_id = v.venue_id
                AND    e.disabled = 0"
                .$condition.
                " ORDER BY e.date, e.time, e.title DESC";
      
      $first = $this->mysqli->query($query);
      $result['events'] = $first->fetch_all(MYSQLI_ASSOC);
      $second = $this->mysqli->query($query_count);
      $result['tot_events'] = $second->fetch_assoc()['c'];
      return $result;
  }

  public function getEvent($id) {
      $stmt = $this->mysqli->prepare(
       "SELECT e.*, c.name as category_name, s.company, v.name as venue, v.seats as seats, v.city 
        FROM   Event e, Venue v, User s, Category as c
        WHERE  e.user_id = s.user_id
        AND    e.venue_id = v.venue_id
        AND    e.category_id = c.category_id
        AND    e.event_id = ?
        ORDER BY e.date");

      $stmt->bind_param('i',$id);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getAvailableTickets($id) {
      $stmt = $this->mysqli->prepare(
        "SELECT COUNT(ticket_id) as tickets 
         FROM Ticket 
         WHERE event_id = ? 
         AND available = 1 
      ");
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc()['tickets'];
  }

  public function getPurchasedTickets($id) {
      $stmt = $this->mysqli->prepare(
       "SELECT COUNT(ticket_id) as purchased 
        FROM Ticket
        WHERE event_id = ?
        AND available = 0
        AND user_id IS NOT NULL
      ");
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc()['purchased'];
  }

  public function getCategories() {
      $stmt = $this->mysqli->prepare(
       "SELECT category_id as id, name
        FROM   Category
        ORDER BY name");

      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getVenues() {
      $stmt = $this->mysqli->prepare(
      "SELECT venue_id as id, name
       FROM   Venue
       ORDER BY name");
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function createEvent($event, $user_id) {
      $query = "INSERT INTO Event (title, artist, date, time, description, category_id, user_id, venue_id, event_img, tickets) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $insert_stmt = $this->mysqli->prepare($query);
      $insert_stmt->bind_param('sssssiiisi', $event['title'], $event['artist'], $event['date'], 
              $event['time'], $event['description'], $event['category_id'], $user_id, $event['venue_id'], $this->getRandomImage(), $event['seats']); 
      $insert_stmt->execute();
      $eventId = $this->mysqli->insert_id;

      $available_seats = $this->getTotalVenueSeats($event['venue_id']);
      if($event['seats'] < $available_seats) {
        $available_seats = $event['seats'];
      }
      $this->createTickets($event['price'], $eventId, $available_seats);
      return $eventId;
  }

  public function updateEvent($event) {
      $query = "UPDATE Event 
                SET    title = ?, date = ?, time = ?, artist = ?, description = ?, category_id = ?, venue_id = ?
                WHERE  event_id = ?";
      $insert_stmt = $this->mysqli->prepare($query);
      $insert_stmt->bind_param('sssssiii', $event['title'], $event['date'], $event['time'], $event['artist'], 
              $event['description'], $event['category_id'], $event['venue_id'], $event['event_id']);
      $insert_stmt->execute();
      $this->updateTicketsPrice($event['price'], $event['event_id']);
  }

  public function cancelEvent($id) {
      $query = "UPDATE Event 
        SET    cancelled = 1
        WHERE  event_id = ?";
      $insert_stmt = $this->mysqli->prepare($query);
      $insert_stmt->bind_param('i', $id);
      $insert_stmt->execute();
  }

  public function getCurrentEventPrice($eventId) {
      $stmt = $this->mysqli->prepare(
        "SELECT  price 
          FROM   Ticket 
          WHERE  event_id = ? 
          AND    available = 1
          LIMIT  1
      ");
      $stmt->bind_param('i',$eventId);
      $stmt->execute();
      $result = $stmt->get_result();

      $result = $result->fetch_assoc()['price'];
      return $result != NULL ? $result : "nd";
  }

  public function getInterestedCustomers($eventId) {
      $stmt = $this->mysqli->prepare(
        "SELECT  COUNT(*) as interested
          FROM   Submit  
          WHERE  event_id = ?
        ");
      $stmt->bind_param('i',$eventId);
      $stmt->execute();
      $result = $stmt->get_result();
      $result = $result->fetch_assoc()['interested'];
      return $result != NULL ? $result : 0;
  }

  public function isOnAlertList($eventId, $userId) {
      $stmt = $this->mysqli->prepare(
        "SELECT  COUNT(*) as c
          FROM   Submit  
          WHERE  event_id = ?
          AND    user_id = ?");
      $stmt->bind_param('ii',$eventId, $userId);
      $stmt->execute();
      $result = $stmt->get_result();
      $result = $result->fetch_assoc()['c'];
    
      return $result != NULL;
  }

  public function subscribeForTicketAllerts($eventId, $userId) {
      $insert_stmt = $this->mysqli->prepare("INSERT INTO Submit (event_id, user_id) VALUES (?, ?)");
      $insert_stmt->bind_param('ii', $eventId, $userId); 
      $insert_stmt->execute();
  }

  public function unsubscribeFromTicketAllerts($eventId, $userId) {
      $stmt = $this->mysqli->prepare("DELETE FROM Submit WHERE event_id = ? AND user_id = ?");
      $stmt->bind_param('ii', $eventId, $userId); 
      $stmt->execute();
      return $stmt;
  }

  public function getEventFromTitle($title) {
      $stmt = $this->mysqli->prepare(
        "SELECT e.title, e.date, v.name as venue_name, e.event_id 
         FROM Event e, Venue v
         WHERE title LIKE '%$title%'
         AND   v.venue_id = e.venue_id 
         AND   e.disabled = 0
         LIMIT 5");
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  /* private functions */
  
  private function createTickets($price, $eventId, $seats) {
      $query = "INSERT INTO Ticket (price, seat, event_id) VALUES (?, ?, ?)";
      $insert_stmt = $this->mysqli->prepare($query);

      for($seat=1; $seat<=$seats; $seat++) {
        $insert_stmt->bind_param('iii', $price, $seat, $eventId);
        $insert_stmt->execute();
      } 
  }

  private function updateTicketsPrice($price, $eventId) {
      $query = "UPDATE Ticket 
      SET    price = ?
      WHERE  event_id = ?
      AND    available = 1";
      $insert_stmt = $this->mysqli->prepare($query);
      $insert_stmt->bind_param('ii', $price, $eventId);
      $insert_stmt->execute();
  }

  private function getTotalVenueSeats($venue_id) {
      $stmt = $this->mysqli->prepare(
        "SELECT seats 
         FROM   Venue 
         WHERE  venue_id = ? 
      ");
      $stmt->bind_param('i',$venue_id);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc()['seats'];
  }

  private function getRandomImage() {
      return $this->eventImages[array_rand($this->eventImages)];
  } 
}

?>