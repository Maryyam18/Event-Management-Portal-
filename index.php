 
<?php include 'modal.php'; ?>
<?php include 'dbconnection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Portal</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
       <link href="style.css" rel="stylesheet">
       <!-- for the icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">  
</head>
<body>
   
         <tr class="table-info">
             <p> Events  <p>
  <button type="button" class="btn btn-success position-absolute top-0 end-0"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openAddModal()" >Add</button>
         </tr>
    <table class="table table-primary small-text">
  <thead>
    <tr class="table-info">
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Location</th>
        <th scope="col">Event time </th>
      <th scope="col">People-limit</th>
      <th scope="col">Budget</th>
       <th scope="col">status</th>
        <th scope="col">created at</th>
        <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

   <?php 
    $query = "SELECT * FROM events ORDER BY event_id DESC;";
     $stmt = $conn->prepare($query);
          $stmt->execute();
          $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $i = 1;
          foreach ($events as $row) {
              echo "<tr>
                  <td>{$i}</td>
                  <td>" . htmlspecialchars($row['title']) . "</td>
                  <td>" . htmlspecialchars($row['description']) . "</td>
                  <td>" . htmlspecialchars($row['location']) . "</td>
                  <td>" . htmlspecialchars($row['event_time']) . "</td>
                  <td>" . htmlspecialchars($row['people_limit']) . "</td>
                  <td>" . htmlspecialchars($row['budget']) . "</td>
                  <td>" . htmlspecialchars($row['status']) . "</td>
                  <td>" . htmlspecialchars($row['created_at']) . "</td>
                  <td>
                      <a href='#' class='text-primary me-2' data-bs-toggle='modal' data-bs-target='#EditModal'
                          onclick=\"openEditModal(
                              {$row['event_id']},
                              '" . addslashes($row['title']) . "',
                              '" . addslashes($row['description']) . "',
                              '" . addslashes($row['location']) . "',
                              '" . addslashes($row['event_time']) . "',
                              '" . addslashes($row['people_limit']) . "',
                              '" . addslashes($row['budget']) . "',
                          )\">
                          <i class='bi bi-pencil-square'></i></a>
                      <a href='#' class='text-danger' data-bs-toggle='modal' data-bs-target='#delmodal'  onclick='setDeleteModal(".$row['event_id'].")'><i class='bi bi-trash'></i></a>
                  </td>
              </tr>";
              $i++;

             /// 
          }

          
      ?>
  </tbody>
</table>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
      <script src="functions.js">
 
</script>

</body>
</html>
