const books = (typeof booksFromDB !== "undefined") ? booksFromDB : [];//kitaplar nerden?

const searchInput = document.getElementById("searchInput");//Arama 
const categorySelect = document.getElementById("categorySelect");//Kategori
const bookList = document.getElementById("bookList");//Lİste

function displayBooks() {
  bookList.innerHTML = "";

  const q = (searchInput.value || "").toLowerCase().trim();//Büyük küçük önemsiz.
  const cat = (categorySelect.value || "all").toLowerCase();

  const filteredBooks = books.filter(book => { // Her kitap için filtreleme.
    const title = (book.title || "").toLowerCase();
    const category = (book.category || "").toLowerCase();

    const searchMatch = title.includes(q);
    const categoryMatch = (cat === "all") || (category === cat);//cat=seçilen kategori.

    return searchMatch && categoryMatch;
  });


  filteredBooks.forEach(book => { // Filtrenenleri bastır.
    const statusText = (parseInt(book.available_copies) > 0) ? "Available" : "Not available";

   
    console.log(book.cover_url);
    const img = book.cover_url
  ? `<img class="book-cover" src="${book.cover_url}" alt="Book cover"
      onerror="this.style.display='none'">`
  : "";// resim varsa göster yoksa boş bırak.


    bookList.innerHTML += `
      <div class="book-card">
        ${img}
        <h4>${book.title}</h4>
        <p>${book.category}</p>
        <p>${statusText}</p>
        <p> Available: ${book.available_copies} / ${book.total_copies}</p>

        <a href="book_detail.php?id=${book.id}" class="btn btn-primary">Details</a>
      </div>
    `;
  });
}


searchInput.addEventListener("input", displayBooks); // Canlı değişim,arama.
categorySelect.addEventListener("change", displayBooks); //Kategori değişiminde.
displayBooks();//Sayfa açıldığında hepsinin gösterimi.
