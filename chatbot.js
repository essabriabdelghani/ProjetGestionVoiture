const chatbotBody = document.getElementById("chatbot-body");
const chatbotInput = document.getElementById("chatbot-input");
const chatbotSelect = document.querySelector("select");

const responses = {
  "bonjour": "Bonjour ! Comment puis-je vous aider ?",
  "comment réserver": "Pour réserver une voiture, allez dans la page Réservation, choisissez une voiture et remplissez le formulaire.",
  "quels documents faut-il": "Vous devez fournir un permis de conduire valide et une carte d'identité.",
  "horaires d’ouverture": "Nous sommes ouverts tous les jours de 8h à 20h.",
  "merci": "Avec plaisir !"
};

// Lorsque l'utilisateur sélectionne une option, remplir l'input avec la question
chatbotSelect.addEventListener("change", function() {
  const selectedQuestion = chatbotSelect.value;
  chatbotInput.value = selectedQuestion; // Remplir l'input avec la question sélectionnée
});

// Afficher la réponse dans le body lorsque l'utilisateur appuie sur "Entrée"
chatbotInput.addEventListener("keypress", function(e) {
  if (e.key === "Enter") {
    const question = chatbotInput.value.toLowerCase(); // Récupérer la question de l'input
    const reply = responses[question] || "Désolé, je ne comprends pas cette question."; // Trouver la réponse

    // Ajouter la question et la réponse dans le chatbot body
    chatbotBody.innerHTML += `<div><strong>Vous :</strong> ${question}</div>`;
    chatbotBody.innerHTML += `<div><strong>Bot :</strong> ${reply}</div>`;
    
    chatbotBody.scrollTop = chatbotBody.scrollHeight; // Faire défiler vers le bas pour voir la dernière réponse
  }
});



  document.addEventListener("DOMContentLoaded", function () {
    const reservationLink = document.querySelector('a[href="voitures.html"]');
    
    reservationLink.addEventListener("click", function (e) {
      if (!isLoggedIn) {
        e.preventDefault(); // empêche la redirection
        alert("Veuillez vous connecter pour accéder à la réservation.");
      }
    });
  });

  function connexion() {
    let valide = true;
    const email = document.getElementById("email").value.trim();
    const passe = document.getElementById("password").value.trim();
  
    const emailE = document.getElementById("erreurEmail");
    const passE = document.getElementById("erreurPass");
  
    emailE.innerHTML = "";
    passE.innerHTML = "";
  
    if (email === "") {
      emailE.innerHTML = "* Champ email obligatoire";
      valide = false;
    }
  
    if (passe === "") {
      passE.innerHTML = "* Champ mot de passe obligatoire";
      valide = false;
    }
  
    return valide; // Annule la soumission si false
  }
  

  // Attendre que la page soit complètement chargée
  window.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const err = params.get("erreur");
    const errorDiv = document.getElementById("erreur-message");

    // Afficher seulement s'il y a une erreur spécifique
    if (err === "email") {
      errorDiv.textContent = "Utilisateur introuvable.";
    } else if (err === "motdepasse") {
      errorDiv.textContent = "Mot de passe incorrect.";
    }
  });

