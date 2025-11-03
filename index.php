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
    <tr>
  <th scope="row">1</th>
  <td>Tech Innovators Summit</td>
  <td>A gathering of tech leaders to discuss future innovations.</td>
  <td>Lahore Expo Center</td>
  <td>2025-12-10 10:00 AM</td>
  <td>250</td>
  <td>$5,000</td>
  <td>Approved</td>
  <td>2025-10-20</td>
   <td>
        <a data-bs-toggle="modal" data-bs-target="#exampleModal"   onclick="openEditModal('Tech Conference', 'Innovation and AI', 'Lahore', '10:00 AM', '200', 5000)" class="text-primary me-2"><i class="bi bi-pencil-square"></i></a>
        <a href="#" class="text-danger"  data-bs-toggle="modal" data-bs-target="#delmodal" ><i class="bi bi-trash"></i></a>
      </td>
</tr>

<tr>
  <th scope="row">2</th>
  <td>Startup Pitch Night</td>
  <td>Entrepreneurs pitch their startups to investors and mentors.</td>
  <td>Karachi Innovation Hub</td>
  <td>2025-11-25 06:00 PM</td>
  <td>100</td>
  <td>$2,000</td>
  <td>Pending</td>
  <td>2025-10-28</td>
   <td>
        <a href="#" class="text-primary me-2"><i class="bi bi-pencil-square"></i></a>
        <a href="#" class="text-danger"><i class="bi bi-trash"></i></a>
      </td>
</tr>

<tr>
  <th scope="row">3</th>
  <td>AI in Healthcare Conference</td>
  <td>Exploring the role of AI and data in transforming healthcare systems.</td>
  <td>Islamabad Tech Park</td>
  <td>2026-01-15 09:30 AM</td>
  <td>300</td>
  <td>$7,500</td>
  <td>Approved</td>
  <td>2025-10-30</td>
   <td>
        <a href="#" class="text-primary me-2"><i class="bi bi-pencil-square"></i></a>
        <a href="#" class="text-danger"><i class="bi bi-trash"></i></a>
      </td>
</tr>
  </tbody>
</table>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
      <script src="functions.js">
 
</script>

</body>
</html>

<?php include 'modal.php'; ?>