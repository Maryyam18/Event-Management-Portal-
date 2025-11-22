function openAddModal() {
    document.getElementById('AddForm').reset();
}

function openEditModal(id, title, description, location, event_time, people_limit, budget, speakers) {
    console.log("Edit Modal Values:", { id, title, description, location, event_time, people_limit, budget, speakers });
    document.getElementById('edit_event_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_location').value = location;
    document.getElementById('edit_event_time').value = formatDateTime(event_time);
    document.getElementById('edit_people_limit').value = people_limit;
    document.getElementById('edit_budget').value = budget;
    document.getElementById('edit_speakers').value = speakers;
}

function formatDateTime(mysqlDateTime) {
    if (!mysqlDateTime) return '';
    return mysqlDateTime.replace(' ', 'T');
}

function setDeleteModal(id) {
    document.getElementById('delete_event_id').value = id;
}