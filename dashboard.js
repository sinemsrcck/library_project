// Dummy data (backend gelene kadar)
const activeBooks = [
    { title: "The Great Gatsby", borrowed_on: "2025-12-01" },
    { title: "1984", borrowed_on: "2025-12-03" }
];

const dueDates = [
    { title: "The Great Gatsby", due_date: "2025-12-15" },
    { title: "1984", due_date: "2025-12-17" }
];

// Ekrana yazdırma
let activeBooksDiv = document.getElementById("activeBooksList");
let dueDatesDiv = document.getElementById("dueDatesList");

activeBooks.forEach(book => {
    activeBooksDiv.innerHTML += `
        <p><strong>${book.title}</strong><br>Borrowed on: ${book.borrowed_on}</p>
        <hr>
    `;
});

dueDates.forEach(item => {
    dueDatesDiv.innerHTML += `
        <p><strong>${item.title}</strong><br>Due: ${item.due_date}</p>
        <hr>
    `;
});
