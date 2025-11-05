
  // Function for Add Event
  function openAddModal() {
    //document.getElementById('modalTitle').innerText = 'Add New Event';
    //document.getElementById('actionButton').innerText = 'Add Event';
    //document.getElementById('actionButton').classList.remove('btn-warning');
    ///document.getElementById('actionButton').classList.add('btn-primary');


     ['title','description','location','eventTime','peopleLimit','budget','status'].forEach(id => {
    // Clear all form fields
    document.getElementById('AddForm').reset();
  });
  }

  // Function for Edit Event
  function openEditModal(id, title, description, location, event_time, people_limit, budget) {
    console.log("Edit Modal Values:", { id, title, description, location, event_time, people_limit, budget });
    
    // Set values in the edit form
    document.getElementById('edit_event_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_location').value = location;
    document.getElementById('edit_event_time').value = formatDateTime(event_time);
    document.getElementById('edit_people_limit').value = people_limit;
    document.getElementById('edit_budget').value = budget;
}

// Helper function to format datetime
function formatDateTime(mysqlDateTime) {
    if (!mysqlDateTime) return '';
    return mysqlDateTime.replace(' ', 'T');
}
// Function for Delete Modal
function setDeleteModal(id) {
  document.getElementById('delete_event_id').value = id;
}
