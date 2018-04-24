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

var urlParams = UTILS.getURLParams();


// Save the user's lead preferences into firebase.
var leadPreferencesRef = firebase.database().ref("proUpgradesUsers"),
    leadPreferencesItem = leadPreferencesRef.push();
    leadPreferencesItemKey = undefined;

var data = urlParams;

var quickStart = document.getElementById("quickstart-container");
var seasonedPro = document.getElementById("seasonedpro-container");

var quickStartButton = document.getElementById("quickstart-button");
var seasonedProButton = document.getElementById("seasonedpro-button");

leadPreferencesItemKey = leadPreferencesItem.key;

if (typeof urlParams.u !== "undefined" && urlParams.u.length >= 1) {
  leadPreferencesItem.set(data);

  var quickStartURL = quickStartButton.getAttribute('href'),
      seasonedProURL = seasonedProButton.getAttribute('href');

  quickStartButton.setAttribute('href', quickStartURL + "?u=" + urlParams.u);
  seasonedProButton.setAttribute('href', seasonedProURL + "?u=" + urlParams.u);
}

quickStart.addEventListener("mousedown", function (event) {

  if (typeof urlParams.u !== "undefined" && urlParams.u.length >= 1) {

    leadPreferencesRef.push().set({
      email: urlParams.u,
      "mousedown": "Quick Start"
    });

  }
});

seasonedPro.addEventListener("mousedown", function (event) {

  if (typeof urlParams.u !== "undefined" && urlParams.u.length >= 1) {

    leadPreferencesRef.push().set({
      email: urlParams.u,
      "mousedown": "Seasoned Pro"
    });

  }

});
