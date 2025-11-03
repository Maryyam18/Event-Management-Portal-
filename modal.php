<!-- Event Addition Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- larger modal for better spacing -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <h4 id="modalTitle"></h2></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form action="" class="row g-4 p-2">

          <!-- Title Field -->
          <div class="col-12">
            <label for="title" class="form-label fw-semibold">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Enter event title">
          </div>

          <!-- Description Field -->
          <div class="col-12">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea class="form-control" id="description" rows="4" placeholder="Enter event description"></textarea>
          </div>

          <!-- Event Details -->
          <div class="col-md-4">
            <label for="eventTime" class="form-label fw-semibold">Event Time</label>
            <input type="text" class="form-control" id="eventTime" placeholder="e.g. 5:00 PM">
          </div>

          <div class="col-md-4">
            <label for="peopleLimit" class="form-label fw-semibold">People Limit</label>
            <input type="number" class="form-control" id="peopleLimit" placeholder="e.g. 100">
          </div>

          <div class="col-md-4">
            <label for="budget" class="form-label fw-semibold">Budget</label>
            <input type="number" class="form-control" id="budget" placeholder="e.g. $5000">
          </div>

        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="actionButton"></button>
      </div>

    </div>
  </div>
</div>

<!-- dialog box for deleting the Events -->

<div class="modal " tabindex="-1"    id="delmodal" aria-labelledby="delModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header no-border">
        <h5 class="modal-title small-text">Are you sure you want to delete this event?</h5>
      </div>
      <div class="modal-footer no-border">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">no</button>
      </div>
    </div>
  </div>
</div>
