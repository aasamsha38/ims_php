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