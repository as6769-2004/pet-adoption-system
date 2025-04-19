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

function showPetDetails(data) {
  const modal = document.getElementById('petDetailModal');
  const details = `
      <h2>${data.pet_name}</h2>
      <img src="${data.pet_image_url}" alt="Pet Image">
      <p><strong>Breed:</strong> ${data.pet_breed}</p>
      <p><strong>Gender:</strong> ${data.pet_gender}</p>
      <p><strong>Age:</strong> ${data.pet_age}</p>
      <hr>
      <p><strong>Pet ID:</strong> ${data.pet_id}</p>
      <p><strong>Adoption ID:</strong> ${data.adoption_id}</p>
      <p><strong>Reason:</strong> ${data.reason_of_adoption}</p>
      <p><strong>Adoption Date:</strong> ${data.adoption_date}</p>
      <p><strong>Household:</strong> ${data.house_hold}</p>
      <p><strong>Donation ID:</strong> ${data.donation_id ?? '-'}</p>
      <p><strong>Donation Amount:</strong> ${data.donation_amount ?? '-'}</p>
      <p><strong>Donation Date:</strong> ${data.donation_date ?? '-'}</p>
      <p><strong>Buyer Info:</strong> ${data.buyer_info ?? '-'}</p>
  `;
  document.getElementById('modalDetails').innerHTML = details;
  modal.style.display = 'block';
}

function closeModal() {
  document.getElementById('petDetailModal').style.display = 'none';
}

window.onclick = function(event) {
  let modals = [document.getElementById('petDetailModal'), document.getElementById('profileModal')];
  modals.forEach(modal => {
      if (event.target === modal) {
          modal.style.display = "none";
      }
  });
}