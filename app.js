document.addEventListener("DOMContentLoaded", () => {
  const tbody = document.getElementById("contactsTbody");
  const buttons = document.querySelectorAll(".filterBtn");

  function setActive(btn) {
    buttons.forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
  }

  function badge(type) {
    const t = String(type || "").toLowerCase();
    if (t.includes("sales")) return `<span class="badge badge-sales">SALES LEAD</span>`;
    return `<span class="badge badge-support">SUPPORT</span>`;
  }

  function escapeHtml(s) {
    return String(s ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function loadContacts(filter = "all") {
    tbody.innerHTML = `<tr><td colspan="5" class="muted">Loading...</td></tr>`;

    fetch(`contacts.php?filter=${encodeURIComponent(filter)}`)
      .then(res => res.json())
      .then(data => {
        if (!data || data.length === 0) {
          tbody.innerHTML = `<tr><td colspan="5" class="muted">No contacts found.</td></tr>`;
          return;
        }

        tbody.innerHTML = data.map(c => {
          const name = `${c.title ? c.title + ". " : ""}${c.firstname} ${c.lastname}`;
          return `
            <tr>
              <td class="name-cell">${escapeHtml(name)}</td>
              <td>${escapeHtml(c.email)}</td>
              <td>${escapeHtml(c.company)}</td>
              <td>${badge(c.type)}</td>
              <td class="right"><a class="view-link" href="contact.php?id=${c.id}">View</a></td>
            </tr>
          `;
        }).join("");
      })
      .catch(() => {
        tbody.innerHTML = `<tr><td colspan="5" class="muted">Error loading contacts.</td></tr>`;
      });
  }

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      setActive(btn);
      loadContacts(btn.dataset.filter);
    });
  });

  loadContacts("all");
});
