<?php
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    
   
        public $category;
      public $id;
    
        

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT  p.id,  p.category
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
        $query = 'SELECT  p.id,  p.category
                                  FROM ' . $this->table . ' p
                                  LEFT JOIN
                                    categories c ON p.category_id = c.id
                                  WHERE
                                    p.id = ?
                                    p.category = ?
                                  LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        
        $this->author = $row['category'];
       
  }


  public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . '
                          SET category = :category
                          WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    
    $this->category = htmlspecialchars(strip_tags($this->category));
    
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    
    $stmt->bindParam(':author', $this->category);
   
    $stmt->bindParam(':id', $this->id);

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
    
    $this->author = htmlspecialchars(strip_tags($this->category));
    

    // Bind data
   
    $stmt->bindParam(':category', $this->category);
    

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

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}



}