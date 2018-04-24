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

  var UTILS = {

    getURLParams: function () {

        function transformToAssocArray(url) {
          var params = {},
            prmarr = url.split("&");

          for (var i = 0; i < prmarr.length; i++) {
            var tmparr = prmarr[i].split("=");
            params[tmparr[0]] = tmparr[1];
          }

          return params;
        }

        var parameters = window.location.search.substr(1);

        return parameters != null && parameters != "" ? transformToAssocArray(parameters) : {};
      }
  };

  var userObj = {};
      userObj.tags = [],
      carousel = document.querySelector('.js-carousel'),
      form = document.querySelector('.js-form'),
      submitButton = document.querySelector('.js-submit'),
      text = document.querySelector('.js-text'),
      checkboxes = document.querySelectorAll(".js-checkbox"),
      thankYou = document.querySelector(".js-thankyou"),
      thankYouName = document.querySelector(".js-thankyou-name"),
      closeButton = document.querySelector(".js-close"),
      proFlowEl = document.getElementById("PROFLOW"),
      cardErrors = document.getElementById("card-errors");


  var DRIP = {
    identifyUser: function (userData) {
      _dcq.push(["identify", userData]);
    },

    subscribeToCampaign: function (userData) {
      var obj = {};
      obj.campaign_id = '964017088';
      obj.fields = userData;

      _dcq.push(["subscribe", obj]);
    }
  };

  if ( document.body.contains(form)) {
    form.addEventListener('submit', function (event) {

      var emailsRef = firebase.database().ref("emails");

      event.preventDefault();
      submitButton.blur();

      userObj.email = document.getElementById("email").value;
      userObj.first_name = document.getElementById("first_name").value;
      userObj.prospect = true;

      thankYouName.innerHTML = userObj.first_name;
      thankYou.className += ' show';

      DRIP.identifyUser(userObj);
      DRIP.subscribeToCampaign(userObj);

      emailsRef.push().set({
        "email": userObj.email,
        "first_name": userObj.first_name
      });

    });

  }

  if ( document.body.contains(closeButton)) {
    closeButton.addEventListener("click", function () {
      thankYou.parentElement.removeChild(thankYou);
    });
  }

}());
