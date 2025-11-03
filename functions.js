
  // Function for Add Event
  function openAddModal() {
    document.getElementById('modalTitle').innerText = 'Add New Event';
    document.getElementById('actionButton').innerText = 'Add Event';
    document.getElementById('actionButton').classList.remove('btn-warning');
    document.getElementById('actionButton').classList.add('btn-primary');
  }

  // Function for Edit Event
  function openEditModal(title, description, location, time, people, budget) {
    document.getElementById('modalTitle').innerText = 'Edit Event';
    document.getElementById('actionButton').innerText = 'Edit Event';
    document.getElementById('actionButton').classList.remove('btn-primary');
    document.getElementById('actionButton').classList.add('btn-warning');

    // Optional: Fill in the existing values into the form fields
    document.getElementById('title').value = title;
    document.getElementById('description').value = description;
    document.getElementById('eventTime').value = time;
    document.getElementById('peopleLimit').value = people;
    document.getElementById('budget').value = budget;
  }
