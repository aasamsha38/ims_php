$(document).ready(function(){
    //jquery for toggle sub menus
  $('.sub-btn').click(function(){
    $(this).next('.sub-menu').slideToggle();
    $(this).find('.dropdown').toggleClass('rotate');
  });
});

  //jquery for toggle profile menus
let profileDropdownList = document.querySelector(".profile-dropdown-list");
let btn = document.querySelector(".profile-dropdown-btn");

let classList = profileDropdownList.classList;

const toggle = () => classList.toggle("active");

window.addEventListener("click", function (e) {
  if (!btn.contains(e.target)) classList.remove("active");
});

  //jquery for search menus
  const searchInput = document.getElementById('search-input');
  const suggestionsBox = document.getElementById('suggestions');

  searchInput.addEventListener('input', () => {
    const query = searchInput.value;

    if (query.length > 0) {
      fetch(`suggest.php?query=${encodeURIComponent(query)}`)
      .then(response => response.json())
      .then(data => {
        suggestionsBox.innerHTML = '';
        data.forEach(item => {
          const suggestionItem = document.createElement('li');
          suggestionItem.textContent = item;
          suggestionItem.className = 'list-group-item';
          suggestionItem.style.cursor = 'pointer';

          suggestionItem.addEventListener('click', () => {
            searchInput.value = item;
            suggestionsBox.innerHTML = '';
          });

          suggestionsBox.appendChild(suggestionItem);
        });
      });
    } else {
      suggestionsBox.innerHTML = '';
    }
  });

  document.addEventListener('click', (event) => {
    if (!searchInput.contains(event.target)) {
      suggestionsBox.innerHTML = '';
    }
  });


//   $(document).ready(function() {
//     // Attach event listener to the search input
//     $('#search-input').on('input', function() {
//         var search_query = $(this).val(); // Get the input value

//         // If the search query is not empty
//         if (search_query.length > 0) {
//             $.ajax({
//                 url: 'search_suggestions.php',  // URL to your backend PHP script
//                 method: 'POST',
//                 data: { query: search_query },
//                 success: function(data) {
//                     // Populate the dropdown with suggestions
//                     $('#suggestions').html(data).show();
//                 }
//             });
//         } else {
//             // If input is empty, hide the suggestions
//             $('#suggestions').hide();
//         }
//     });

//     // Optional: Hide the suggestions when clicking outside of the search box
//     $(document).on('click', function(e) {
//         if (!$(e.target).closest('#sug-form').length) {
//             $('#suggestions').hide();
//         }
//     });
// });
