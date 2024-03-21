<?php
class Quote {
    // DB stuff
    private $conn;
    private $table = 'quotes';

    
   
        public $id;
      public $quote;
      public $author_id;
      public $category_id;
      
    
        

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT  p.id,  p.quote, p.author_id, p.category_id
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function read_single() {
        // Create query
        $query = 'SELECT  p.id,   p.quote, p.author_id, p.category_id
                                  FROM ' . $this->table . ' p
                                  LEFT JOIN
                                    categories c ON p.category_id = c.id
                                  WHERE
                                    p.id = ?
                                    p.quote = ?
                                  LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->quote);
        $stmt->bindParam(3, $this->author_id);
        $stmt->bindParam(4, $this->category_id);
        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        
        $this->quote = $row['quote'];
       
  }


  public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . '
                          SET quote = :quote
                          WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author = htmlspecialchars(strip_tags($this->author_id));
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->category = htmlspecialchars(strip_tags($this->category_id));

    // Bind data
    
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':author', $this->author_id);
    $stmt->bindParam(':category', $this->category_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}

public function create() {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET  category = :category';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    
    $this->author = htmlspecialchars(strip_tags($this->quote));
    

    // Bind data
   
    $stmt->bindParam(':category', $this->quote);
    

    // Execute query
    if($stmt->execute()) {
      return true;
}

// Print error if something goes wrong
printf("Error: %s.\n", $stmt->error);

return false;
}



public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);
  $stmt->bindParam('author_id', $this->author_id);
  $stmt->bindParam('category_id', $this->category_id);
  $stmt->bindParam('quote', $this->quote);
    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}



}