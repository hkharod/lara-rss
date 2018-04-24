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

  function guid() {

    function s4() {
      return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }

    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
  }

  // Find a way to safely and automatically get the keys in the future for all pro members
  var proKeys = ['GaNnF4ANMecOgSozYwK5FVmBqUsGNGgq', 'ZjrqcUKaFwMwSGV4ah6ayy5vUxtfIwzq'];

  var jobHTML = document.getElementById("job-html-container").innerHTML;
  var fileName = guid();
  // Find a way to name the file in the script.

  var updates = {};

  for (var i = 0; i < proKeys.length; i += 1) {
    var proKey = proKeys[i];
    updates['/proJobs/' + proKey + '/' + fileName] = jobHTML;
  }

  console.log("fileName", fileName);

  firebase.database().ref().update(updates);

}());
