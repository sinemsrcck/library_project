const books = (typeof booksFromDB !== "undefined") ? booksFromDB : [];

const searchInput = document.getElementById("searchInput");
const categorySelect = document.getElementById("categorySelect");
const bookList = document.getElementById("bookList");

function displayBooks() {
  bookList.innerHTML = "";

  const q = (searchInput.value || "").toLowerCase().trim();
  const cat = (categorySelect.value || "all").toLowerCase();

  const filteredBooks = books.filter(book => {
    const title = (book.title || "").toLowerCase();
    const category = (book.category || "").toLowerCase();

    const searchMatch = title.includes(q);
    const categoryMatch = (cat === "all") || (category === cat);

    return searchMatch && categoryMatch;
  });
console.log(book.cover_url);

  filteredBooks.forEach(book => {
    const statusText = (parseInt(book.is_available) === 1) ? "Available" : "Not available";

    const img = book.cover_url
      ? `<img src="${book.cover_url}" alt="Book cover" style="width:100%;border-radius:10px;margin-bottom:8px;">`
      : "";

    bookList.innerHTML += `
      <div class="book-card">
        ${img}
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
