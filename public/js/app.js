document.getElementById('menu-toggle').addEventListener('click', function() {
    var menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
});

// Toggle para o dropdown de usuário
document.getElementById('user-menu-button').addEventListener('click', function() {
    var dropdown = document.getElementById('dropdown-menu');
    dropdown.classList.toggle('hidden');
});