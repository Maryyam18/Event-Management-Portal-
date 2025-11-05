<!-- Event Addition Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- larger modal for better spacing -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Event <h4 id="modalTitle"></h2></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="AddForm" method="POST" action="addEvent.php" class="row g-4 p-2">
 <input type="hidden" name="event_id" id="event_id">
        
      <div class="row g-4 p-2">
        <div class="col-12">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        
        <div class="col-md-4">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <div class="col-md-4">
            <label for="event_time" class="form-label">Event Time</label>
            <input type="datetime-local" class="form-control" id="event_time" name="event_time" required>
        </div>

        <div class="col-md-4">
            <label for="people_limit" class="form-label">People Limit</label>
            <input type="number" class="form-control" id="people_limit" name="people_limit" required>
        </div>

        <div class="col-md-4">
            <label for="budget" class="form-label">Budget</label>
            <input type="number" class="form-control" id="budget" name="budget" required>
        </div>
    </div>  
     <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">save</button>
      </div>    
    </form>
      </div>

     

    </div>
  </div>
</div> 


<!-- 
EDIT MODAL -->

<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="EditForm" method="POST" action="editEvent.php">
                    <input type="hidden" name="event_id" id="edit_event_id">
                    <input type="hidden" name="action" value="edit">
                    
                    <div class="mb-3">
                        <label for="edit_title">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_location">Location</label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_event_time">Event Time</label>
                        <input type="datetime-local" class="form-control" id="edit_event_time" name="event_time" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_people_limit">People Limit</label>
                        <input type="number" class="form-control" id="edit_people_limit" name="people_limit" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_budget">Budget</label>
                        <input type="number" class="form-control" id="edit_budget" name="budget" required>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- dialog box for deleting the Events -->

<div class="modal " tabindex="-1"  id="delmodal" aria-labelledby="delModalLabel" >
  <div class="modal-dialog">
     <form id="deleteForm" method="POST" action="deleteEvent.php">   
    <div class="modal-content">
      <div class="modal-header no-border">
        <h5 class="modal-title small-text">Are you sure you want to delete this event?</h5>
         <input type="hidden" name="id" id="delete_event_id">
            <input type="hidden" name="action" value="delete">
      </div>
      <div class="modal-footer no-border">
        <button type="submit" class="btn btn-danger">Yes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">no</button>
      </div>
    </div>
    </form>
  </div>
</div>
