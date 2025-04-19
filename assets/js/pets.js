// Get modal element and close button
var modal = document.getElementById("profileModal");
var profileLink = document.getElementById("profileLink");
var closeBtn = document.getElementsByClassName("close")[0];

// Open the modal when clicking on Profile link
profileLink.onclick = function () {
  // Use AJAX to load the profile.php content into the modal
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "profile.php", true);
  xhr.onload = function () {
    if (xhr.status == 200) {
      document.getElementById("profileContent").innerHTML = xhr.responseText;
      modal.style.display = "block";
    }
  };
  xhr.send();
};

// Close the modal when clicking on the close button
closeBtn.onclick = function () {
  modal.style.display = "none";
};

// Close the modal when clicking anywhere outside the modal content
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};


document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("adoptionModal");
  const closeBtn = document.getElementById("closeAdoptionModalBtn");

  // Function to open the modal
  window.openAdoptionForm = function (petId, petName) {
      document.getElementById("adoptPetName").textContent = petName;
      document.getElementById("modalPetId").value = petId;
      modal.style.display = "block";
  };

  // Function to close the modal
  window.closeAdoptionForm = function () {
      modal.style.display = "none";
  };

  // Close when X is clicked
  closeBtn.addEventListener("click", () => {
      closeAdoptionForm();
  });

  // Close when clicking outside modal content
  window.addEventListener("click", (event) => {
      if (event.target === modal) {
          closeAdoptionForm();
      }
  });
});
