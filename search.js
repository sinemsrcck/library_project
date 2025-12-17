const books = (typeof booksFromDB !== "undefined") ? booksFromDB : [];

const searchInput = document.getElementById("searchInput");
const categorySelect = document.getElementById("categorySelect");
const bookList = document.getElementById("bookList");

function displayBooks() {
  bookList.innerHTML = "";

  const filteredBooks = books.filter(book => {
    const searchMatch = (book.title || "").toLowerCase().includes(searchInput.value.toLowerCase());
    const categoryMatch =
      categorySelect.value === "all" ||
      (book.category || "").toLowerCase() === categorySelect.value.toLowerCase();
    return searchMatch && categoryMatch;
  });

  filteredBooks.forEach(book => {
    const statusText = (parseInt(book.is_available) === 1) ? "Available" : "Not available";

    bookList.innerHTML += `
      <div class="book-card">
        <h4>${book.title}</h4>
        <p>${book.category}</p>
        <p>${statusText}</p>
        <a href="book_detail.php?id=${book.id}" class="btn btn-primary">Details</a>
      </div>
    `;
  });
}

searchInput.addEventListener("input", displayBooks);
categorySelect.addEventListener("change", displayBooks);
displayBooks();
