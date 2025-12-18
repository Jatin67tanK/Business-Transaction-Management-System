   const hamburger = document.getElementById('hamburger');
        const logo = document.querySelector('.logo'); 
        const head = document.querySelector('.head'); 
const sidebar = document.getElementById('sidebar');

hamburger.addEventListener('click', () => {
  sidebar.classList.toggle('hidden');
  logo.classList.toggle('hide');
  head.classList.toggle('hide');
});
window.onpageshow = function(event) { 
    if (event.persisted) {
      window.location.reload();
    }
  };