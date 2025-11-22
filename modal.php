<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
        <h2 class="text-2xl font-bold text-blue-800 mb-4">Add New Event</h2>
        <form id="AddForm" method="POST" action="addevent.php">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-blue-800">Title</label>
                    <input type="text" name="title" class="form-input" required>
                </div>
                <div>
                    <label class="block font-medium text-blue-800">Location</label>
                    <input type="text" name="location" class="form-input" required>
                </div>
                <div>
                    <label class="block font-medium text-blue-800">Event Time</label>
                    <input type="datetime-local" name="event_time" class="form-input" required>
                </div>
                <div>
                    <label class="block font-medium text-blue-800">People Limit</label>
                    <input type="number" name="people_limit" class="form-input" required>
                </div>
                <div>
                    <label class="block font-medium text-blue-800">Budget</label>
                    <input type="number" step="0.01" name="budget" class="form-input" required>
                </div>
                <div>
                    <label class="block font-medium text-blue-800">Speakers</label>
                    <input type="text" name="speakers" class="form-input">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-medium text-blue-800">Description</label>
                    <textarea name="description" rows="4" class="form-input" required></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal('addModal')" class="px-6 py-3 bg-gray-500 text-white rounded-lg">Cancel</button>
                <button type="submit" class="btn-primary">Save Event</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
        <h2 class="text-2xl font-bold text-blue-800 mb-4">Edit Event</h2>
        <form id="EditForm" method="POST" action="editEvent.php">
            <input type="hidden" name="event_id" id="edit_event_id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block font-medium text-blue-800">Title</label><input type="text" name="title" id="edit_title" class="form-input" required></div>
                <div><label class="block font-medium text-blue-800">Location</label><input type="text" name="location" id="edit_location" class="form-input" required></div>
                <div><label class="block font-medium text-blue-800">Event Time</label><input type="datetime-local" name="event_time" id="edit_event_time" class="form-input" required></div>
                <div><label class="block font-medium text-blue-800">People Limit</label><input type="number" name="people_limit" id="edit_people_limit" class="form-input" required></div>
                <div><label class="block font-medium text-blue-800">Budget</label><input type="number" step="0.01" name="budget" id="edit_budget" class="form-input" required></div>
                <div><label class="block font-medium text-blue-800">Speakers</label><input type="text" name="speakers" id="edit_speakers" class="form-input"></div>
                <div class="md:col-span-2"><label class="block font-medium text-blue-800">Description</label><textarea name="description" rows="4" id="edit_description" class="form-input" required></textarea></div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal('editModal')" class="px-6 py-3 bg-gray-500 text-white rounded-lg">Cancel</button>
                <button type="submit" class="btn-primary">Update Event</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('deleteModal')">&times;</span>
        <h2 class="text-2xl font-bold text-red-600 mb-4">Delete Event?</h2>
        <p class="text-blue-800 mb-6">This action cannot be undone.</p>
        <form method="POST" action="deleteEvent.php">
            <input type="hidden" name="id" id="delete_event_id">
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('deleteModal')" class="px-6 py-3 bg-gray-500 text-white rounded-lg">Cancel</button>
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.add('active');
        document.getElementById('AddForm').reset();
    }
    function openEditModal(id, title, desc, loc, time, limit, budget, speakers) {
        document.getElementById('edit_event_id').value = id;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_description').value = desc;
        document.getElementById('edit_location').value = loc;
        document.getElementById('edit_event_time').value = time.replace(' ', 'T');
        document.getElementById('edit_people_limit').value = limit || '';
        document.getElementById('edit_budget').value = budget || '';
        document.getElementById('edit_speakers').value = speakers || '';
        document.getElementById('editModal').classList.add('active');
    }
    function setDeleteId(id) {
        document.getElementById('delete_event_id').value = id;
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
</script>