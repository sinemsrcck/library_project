const books = [
  { title: "Harry Potter", category: "novel" },
  { title: "Clean Code", category: "science" },
  { title: "The Hobbit", category: "novel" },
  { title: "Algorithms", category: "science" }
];

const searchInput = document.getElementById("searchInput");
const categorySelect = document.getElementById("categorySelect");
const bookList = document.getElementById("bookList");

function displayBooks() {
  bookList.innerHTML = "";

  const filteredBooks = books.filter(book => {
    const searchMatch = book.title.toLowerCase().includes(searchInput.value.toLowerCase());
    const categoryMatch = categorySelect.value === "all" || book.category === categorySelect.value;
    return searchMatch && categoryMatch;
  });

  filteredBooks.forEach(book => {
    bookList.innerHTML += `
      <div class="book-card">
        <h4>${book.title}</h4>
        <p>${book.category}</p>
      </div>
    `;
  });
}

searchInput.addEventListener("input", displayBooks);
categorySelect.addEventListener("change", displayBooks);

displayBooks();

