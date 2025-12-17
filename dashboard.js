async function loadDashboard() {
  // !!! burada dosya adın neyse onu yazmalı
  const r = await fetch("dashboard_data.php");
  if (!r.ok) return;

  const data = await r.json();
  const activeBooks = data.activeBooks || [];
  const dueDates = data.dueDates || [];

  const activeBooksDiv = document.getElementById("activeBooksList");
  const dueDatesDiv = document.getElementById("dueDatesList");

  activeBooksDiv.innerHTML = "";
  dueDatesDiv.innerHTML = "";

  activeBooks.forEach(book => {
    activeBooksDiv.innerHTML += `
      <p><strong>${escapeHtml(book.title)}</strong><br>
      Borrowed on: ${escapeHtml(book.borrowed_on)}</p><hr>
    `;
  });

  // Due dates with countdown
  dueDates.forEach(item => {
    const dueStr = item.due_date; // "YYYY-MM-DD"
    const due = new Date(dueStr + "T23:59:59"); // due day end
    const now = new Date();

    const ms = due - now;
    const overdue = ms < 0;

    const abs = Math.abs(ms);
    const days = Math.floor(abs / (1000 * 60 * 60 * 24));
    const hours = Math.floor((abs / (1000 * 60 * 60)) % 24);
    const mins = Math.floor((abs / (1000 * 60)) % 60);

    let countdownText = "";
let color = "#27ae60"; // green (default)

if (overdue) {
  countdownText = `Overdue by ${days}d ${hours}h ${mins}m`;
  color = "#e74c3c"; // red
} else if (days <= 2) {
  countdownText = `⚠ Due in ${days} day(s)`;
  color = "#f39c12"; // orange
} else {
  countdownText = `Time left: ${days}d ${hours}h ${mins}m`;
}


    dueDatesDiv.innerHTML += `
      <p>
        <strong>${escapeHtml(item.title)}</strong><br>
        Due: ${escapeHtml(dueStr)}<br>
       <span style="font-weight:600; color:${color};">
       ${countdownText}
      </span>

      </p>
      <hr>
    `;
  });
}

// basit güvenlik
function escapeHtml(str) {
  return String(str ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

loadDashboard();
// her 1 dakikada yenile
setInterval(loadDashboard, 60_000);
