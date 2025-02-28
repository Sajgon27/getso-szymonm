document.addEventListener('DOMContentLoaded', function () {
    // SELECTING DOM ELEMENTS
    const fetchBooksButton = document.getElementById('fetch-books-btn');
    const bookListContainer = document.getElementById('book-list');

    if (fetchBooksButton) {
        // CLICK EVENT LISTENER
        fetchBooksButton.addEventListener('click', function () {
           
            // AJAX
            jQuery.ajax({
                url: ajax_object.ajax_url, 
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'fetch_books', // Action matching the one declared in PHP file
                    nonce: ajax_object.nonce, // SECURITY
                },
                success: function (response) {

                    if (response.success) {
                       
                        response.data.forEach(function (book) {
                            // DISPLAYING DATA TO FRONT-END
                            // After clicking the button in web tools, "Network" tab, we can see JSON response from this ajax call

                            const bookItem = document.createElement('div');
                            bookItem.classList.add('book-item');
                            bookItem.innerHTML = `
                                <h3>${book.name}</h3>
                                <p><strong>Date:</strong> ${book.date}</p>
                                <p><strong>Genre:</strong> ${book.genre}</p>
                                <p>Excerpt would be here: ${book.excerpt}</p>
                                <hr>
                            `;
                            bookListContainer.appendChild(bookItem);
                        });
                    } else {
                        bookListContainer.innerHTML = '<p>No books found.</p>';
                    }
                },
                error: function () {
                    bookListContainer.innerHTML = '<p>Error fetching books. Try again.</p>';
                }
            });
        });
    }
});
