// profile-modal.js
document.addEventListener('DOMContentLoaded', function() {
  // Get the modal
  const modal = document.getElementById('profileModal');
  
  // Get the button that opens the modal
  const profileLink = document.getElementById('profileLink');
  
  // Get the <span> element that closes the modal
  const closeBtn = document.querySelector('.close');
  
  // When the user clicks on the profile link, open the modal
  profileLink.addEventListener('click', function() {
      modal.style.display = 'block';
  });
  
  // When the user clicks on <span> (x), close the modal
  closeBtn.addEventListener('click', function() {
      modal.style.display = 'none';
  });
  
  // When the user clicks anywhere outside of the modal, close it
  window.addEventListener('click', function(event) {
      if (event.target === modal) {
          modal.style.display = 'none';
      }
  });
});