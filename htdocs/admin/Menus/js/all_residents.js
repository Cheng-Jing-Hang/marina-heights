function initResidentActions() {
  const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmResidentDeleteModal'));
  const successModal = new bootstrap.Modal(document.getElementById('successModal'));
  let deleteRow = null;

  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', () => {
      deleteRow = button.closest('tr');
      const id = deleteRow.dataset.id;
      if (!id) return;

      confirmDeleteModal.show();
      document.getElementById('confirmDeleteResidentBtn').onclick = () => {
        fetch('delete_resident.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            deleteRow.remove();
            confirmDeleteModal.hide();
            document.getElementById('successModalMsg').textContent = 'Resident Deleted';
            successModal.show();
          } else {
            alert(data.error || 'Delete failed.');
          }
        });
      };
    });
  });

  document.querySelectorAll('.btn-approve').forEach(button => {
    button.addEventListener('click', () => {
      const row = button.closest('tr');
      const id = row.dataset.id;
      if (!id) return;

      fetch('approve_resident.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + encodeURIComponent(id)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          row.remove();
          document.getElementById('successModalMsg').textContent = 'Resident Approved';
          successModal.show();
        } else {
          alert(data.error || 'Approval failed.');
        }
      });
    });
  });

  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.closest('tr').dataset.id;
      if (id) loadPage('edit_resident.php?id=' + id);
    });
  });
}
