// Show profile modal when clicking "Profile" link
document.getElementById("profileLink").addEventListener("click", function () {
  document.getElementById("profileModal").style.display = "block";
});

// Close modal when clicking outside the modal content
window.onclick = function (event) {
  const modal = document.getElementById("profileModal");
  if (event.target === modal) {
      modal.style.display = "none";
  }
};
