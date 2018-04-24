 (function () {

  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCikJFYDEFeV9rSMGqf9cdAwPJMHtmnYDU",
    authDomain: "quickleads-club.firebaseapp.com",
    databaseURL: "https://quickleads-club.firebaseio.com",
    projectId: "quickleads-club",
    storageBucket: "quickleads-club.appspot.com",
    messagingSenderId: "1004777651446"
  };

  firebase.initializeApp(config);

  var quickStartButton = document.getElementById("quickstart"),
      seasonedProButton = document.getElementById("seasoned_pro");


  // Set up the payment flow
  var stripe = Stripe('pk_test_Xuzvq6PDu6SBsWFJDWIY4ypt');
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  var style = {
    base: {
      // Add your base input styles here. For example:
      border: '1px solid #D8D8D8',
      borderRadius: '4px',
      color: "#000",
    }
  };

      // Create an instance of the card Element
      var card = elements.create('card', {style: style});

      card.mount('#card_element');

  quickStartButton.addEventListener("click", function () {

    // do something with the stripe api here.

    console.log("quickStartCharges");
    chargeCard("quickStartCharges");

  });

  seasonedProButton.addEventListener("click", function () {

    // do something with the stripe api here.

    console.log("seasonedProCharges");

    chargeCard("seasonedProCharges");
  });

  function chargeCard(subscriptionType) {

    stripe.createToken(card).then(function(result) {

      console.log("createToken result", result);

      if (result.error) {

        console.log("result.error", result.error);

        // There was an error in the card processing.
        return;

      }

      if (result.token) {

        // Save the token into firebase.
        var chargesRef = firebase.database().ref("test_" + subscriptionType),
            chargePushItem = chargesRef.push();

        chargePushItem.set({
          "email": "harbind@remoteleads.io",
          "token": result.token,
        });

      }

    });

  }

})();
