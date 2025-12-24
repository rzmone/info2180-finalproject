document.addEventListener("DOMContentLoaded", () => {
  const notesArea = document.getElementById("notesArea");
  const addBtn = document.getElementById("addNoteBtn");
  const assignBtn = document.getElementById("assignBtn");
  const switchBtn = document.getElementById("switchBtn");
  const noteText = document.getElementById("noteText");

  const assignedToText = document.getElementById("assignedToText");
  const updatedAt = document.getElementById("updatedAt");
  const switchText = document.getElementById("switchText");

  const contactId = addBtn.dataset.id;

  function escapeHtml(s) {
    return String(s ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function loadNotes() {
    notesArea.textContent = "Loading notes...";

    fetch(`notes.php?contact_id=${encodeURIComponent(contactId)}`)
      .then(res => res.json())
      .then(data => {
        if (!data || data.length === 0) {
          notesArea.innerHTML = `<p class="muted">No notes yet.</p>`;
          return;
        }

        notesArea.innerHTML = data.map(n => `
          <div class="note">
            <div class="note-name">${escapeHtml(n.firstname)} ${escapeHtml(n.lastname)}</div>
            <div class="note-comment">${escapeHtml(n.comment)}</div>
            <div class="note-date">${escapeHtml(n.created_at)}</div>
          </div>
        `).join("");
      })
      .catch(() => {
        notesArea.innerHTML = `<p class="muted">Error loading notes.</p>`;
      });
  }

  addBtn.addEventListener("click", () => {
    const comment = noteText.value.trim();
    if (!comment) return;

    const fd = new FormData();
    fd.append("contact_id", contactId);
    fd.append("comment", comment);

    fetch("add-note.php", { method: "POST", body: fd })
      .then(res => res.json())
      .then(r => {
        if (r.success) {
          noteText.value = "";
          loadNotes();
          if (updatedAt && r.updated_at) updatedAt.textContent = r.updated_at;
        }
      });
  });

  assignBtn.addEventListener("click", () => {
    const fd = new FormData();
    fd.append("contact_id", contactId);
    fd.append("action", "assign");

    fetch("update-contact.php", { method: "POST", body: fd })
      .then(res => res.json())
      .then(r => {
        if (r.success) {
          if (assignedToText && r.assigned_name) assignedToText.textContent = r.assigned_name;
          if (updatedAt && r.updated_at) updatedAt.textContent = r.updated_at;
        }
      });
  });

  switchBtn.addEventListener("click", () => {
    const fd = new FormData();
    fd.append("contact_id", contactId);
    fd.append("action", "switch");

    fetch("update-contact.php", { method: "POST", body: fd })
      .then(res => res.json())
      .then(r => {
        if (r.success) {
          if (switchText && r.switch_text) switchText.textContent = r.switch_text;
          if (updatedAt && r.updated_at) updatedAt.textContent = r.updated_at;
        }
      });
  });

  loadNotes();
});
