document.addEventListener('DOMContentLoaded', function () {
  const circleInfractions = document.querySelectorAll('.circleInfraction');
  const modals = document.querySelectorAll('.modal');
  const closeBtns = document.querySelectorAll('.close');

  circleInfractions.forEach(function (circleInfraction) {
    circleInfraction.addEventListener('click', function () {
      const popupId = this.getAttribute('data-popup');
      const popup = document.querySelector('#' + popupId);
      popup.style.display = "block";
    });
  });

  closeBtns.forEach(function (closeBtn) {
    closeBtn.addEventListener('click', function () {
      const popup = this.parentElement.parentElement;
      popup.style.display = "none";
    });
  });

  window.addEventListener('click', function (event) {
    modals.forEach(function (modal) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  });

});


function showPopupSolde(event) {
  event.preventDefault(); // prevent the form from submitting

  // create the popup element
  const popup = document.createElement("div");
  const numeroP = document.getElementById("numeroP").value;
  popup.className = "popup";

  // make an AJAX request to fetch data from the server
  const xhr = new XMLHttpRequest();
  const url = "get_data.php?numeroP=" + numeroP;
  xhr.open("GET", url, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // parse the JSON response and extract the nbPoints value
      const response = JSON.parse(xhr.responseText);
      const nbPoints = response.data[0].nbPoints;
      const nom = response.data[0].nom;
      const prenom = response.data[0].prenom;

      // update the popup's content with the nbPoints value
      popup.innerHTML = prenom + " " + nom + " " + " a " + nbPoints + " point(s) sur son permis.";

      // append the popup element to the page
      document.body.appendChild(popup);

      // remove the popup element after 3 seconds
      setTimeout(function () {
        popup.remove();
      }, 3000);
    }
    else{
      popup.innerHTML = "Ce numéro de permis n'est pas dans nos régistres";
      document.body.appendChild(popup);
    }
  };
  xhr.send();
}


function showPopupInfraction($nom,$prenom, $infractionCommise ,$nbPoints,$newNbPoints) {
  // create the popup element
  const popup = document.createElement("div");
  popup.className = "popup";


      // update the popup's content with the nbPoints value
      popup.innerHTML = "Infraction commise: " +$infractionCommise + "==>"+ $nbPoints +<br/> +
      $nom+ " " +$prenom + " a maintenant " + $newNbPoints + " point(s) sur son permis.";

      // append the popup element to the page
      document.body.appendChild(popup);

      // remove the popup element after 3 seconds
      setTimeout(function () {
        popup.remove();
      }, 5000);
  xhr.send();
}

