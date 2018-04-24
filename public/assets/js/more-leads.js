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
var leadPreferencesRef = firebase.database().ref("leadPreferences"),
    leadPreferencesItem = leadPreferencesRef.push();
    leadPreferencesItemKey = undefined;

var data = urlParams;

leadPreferencesItem.set(data);

leadPreferencesItemKey = leadPreferencesItem.key;

if (typeof urlParams.email !== "undefined" && urlParams.email.length >= 1) {
  document.querySelector(".js-email").value = urlParams.email;
}

var updates = {};

data.leadTypes = [];
data.frequency = "";
data.moreInfo = "";

Array.prototype.forEach.call(document.querySelectorAll(".js-checkbox"), function (checkbox) {

  checkbox.addEventListener("change", function (event) {

    var leadType = event.target.value;

    if (event.target.checked) { // Add it to the array
      data.leadTypes.push(leadType);
    } else { // Remove it from the array
      data.leadTypes = data.leadTypes.filter(function (item) {
        return item !== leadType;
      });
    }

    updates['/leadPreferences/' + leadPreferencesItemKey] = data;

    firebase.database().ref().update(updates);

  });

});

document.querySelector(".js-frequency").addEventListener("change", function (event) {

  var select = event.target,
      selectedOption = select.options[select.selectedIndex].value;

  data.frequency = selectedOption;

  updates['/leadPreferences/' + leadPreferencesItemKey] = data;

  firebase.database().ref().update(updates);

});

document.querySelector(".js-submit").addEventListener("click", function (event) {

  var button = document.querySelector(".js-submit");
  var moreInfoValue = document.querySelector(".js-moreinfo").value;

  if (moreInfoValue !== "" && moreInfoValue.length >= 1) {

    data.moreInfo = moreInfoValue;
    updates['/leadPreferences/' + leadPreferencesItemKey] = data;
    firebase.database().ref().update(updates);
  }

  button.classList.remove("gradient");
  button.classList.add("green");
  button.innerHTML = "Thank you very much!";
  
});
