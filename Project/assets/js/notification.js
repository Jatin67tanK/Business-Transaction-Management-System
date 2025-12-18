// Hide notification after 2 seconds on any page
window.addEventListener('DOMContentLoaded', function() {
  const notify = document.getElementById('notifyBox');
  if (notify) {
    setTimeout(() => {
      notify.classList.add('hide');
    }, 2000);
  }
});
